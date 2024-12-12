<?php

namespace Src\View;

use Src\Filesystem\Filesystem;
use Src\Foundation\Application;

class Template
{
    const HELPERS_NAMESPACE = 'use function Src\Helpers\\';

    const HELPERS = [
        'route',
        'request',
        'hasError',
        'err',
        'bag',
    ];

    public function __construct(
        private Filesystem $filesystem,
        private Application $app
    ) {}

    public function parse($view)
    {
        $view = $this->template($view);
        $view = $this->reusables($view);
        $view = $this->php($view);
        $view = $this->utilities($view);
        $view = $this->helpers($view);

        preg_replace('/(@partial\(.+?\)|@endpartial)/', '', $view);

        return $view;
    }

    protected function reusables($view)
    {
        if(preg_match_all("/@reusable\('(.+)'\)((.|\s)*?)@endreusable/", $view, $matches)) {
            $cleaner = $matches[0];
            $reusable = array_combine($matches[1], $matches[2]);

            preg_match_all("/@use\('(.+)',\s*\[((.|\s)*?)\]\)/", $view, $matches);

            $useToReplace = $matches[0];
            $useKeys = $matches[1];

            $useDatas = array_map(function($i) {
                $i = trim($i);
                $i = preg_replace("/\n|\s{2,}|(?<=',)\s/", '', $i);

                preg_match_all("/'(.*?)'\s*=\>\s*'(.*?)'/", $i, $match);

                $match[1] = array_map(fn($j) => "$$j", $match[1]);

                return array_combine($match[1], $match[2]);
            }, $matches[2]);

            foreach($useKeys as $key => $value):
                $data = str_replace(array_keys($useDatas[$key]), $useDatas[$key], $reusable[$value]);
                $view = str_replace($useToReplace[$key], $data, $view);
            endforeach;

            return trim(str_replace($cleaner, '', $view));
        }
        
        return $view;
    }

    protected function template($view)
    {
        if(preg_match("/@template\('(.+?)'\)/", $view, $match)) {
            $template = $this->filesystem->readFile(
                $this->app['views.base'] . $match[1] . '.html'
            );

            $view = str_replace('{{body}}', $view, $template);

            $view = preg_replace("/@template\(.+?\)/", '', $view);
        }

        return $view;
    }

    protected function php($view)
    {
        $replacement = [
            "/@(if|foreach|for|switch)\((.+)\)/" => "<?php $1($2): ?>",
            "/@end(if|foreach|for|switch)/" => "<?php end$1; ?>",
            "/\{\{\!/" => '<?=',
            "/\!\}\}/" => "?>",
            "/\{\{/"   => "<?=htmlspecialchars(",
            "/\}\}/"   => ")?>",
            "/@php/"   => '<?php',
            '/@endphp/'  => '?>'
        ];

        $view = preg_replace(array_keys($replacement), $replacement, $view);

        return $view;
    } 

    protected function utilities($view)
    {
        $replacement = [
            '/@(delete|patch|put)/' => '<input type="hidden" name="_method" value="$1" />',
        ];        

        $view = preg_replace(array_keys($replacement), $replacement, $view);

        return $view;
    }

    protected function helpers($view)
    {
        $str = array_map(function($i) {
            return static::HELPERS_NAMESPACE . $i;
        }, static::HELPERS);

        $str = '<?php ' . implode('; ', $str) . "; ?>\n";

        return $str . $view;
    }
}
