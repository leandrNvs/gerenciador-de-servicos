<?php

namespace Src\Views;

final class Template
{
    private static $utilities = [
        '@php' => '<?php',
        '@endphp' => '?>',
        '{{' => '<?= ',
        '}}' => ' ?>',
    ];

    public static function parse($template)
    {
        $template = str_replace(array_keys(self::$utilities), self::$utilities, $template); 

        $template = preg_replace('/@(delete|patch|put)/', '<input type="hidden" name="_method" value="$1" />', $template);
        $template = preg_replace('/@hasError\((.*),\s*(.*)\)/', '<?= ($template_error && isset($template_messages[$1]))? $2 : null ?>', $template);
        $template = preg_replace('/@bag\((.*)\)/', '<?= isset($template_bag[$1])? $template_bag[$1] : null ?>', $template);
        $template = preg_replace('/@errorFirst\((.*)\)/', '<?php if(isset($template_messages[$1][0])): echo array_pop($template_messages[$1]); endif; ?>', $template);
        $template = preg_replace('/@([\w]+\(.*\))/', '<?php $1: ?>', $template);
        $template = preg_replace('/@([\w]+)/', '<?php $1; ?>', $template);

        return $template;
    }
}