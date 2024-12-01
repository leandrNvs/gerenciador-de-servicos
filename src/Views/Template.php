<?php

namespace Src\Views;

final class Template
{
    private static $utilities = [
        '@php' => '<?php',
        '@endphp' => '?>',
        '{{' => '<?= htmlspecialchars(',
        '}}' => ') ?>',
    ];

    public static function parse($template)
    {
        $template = str_replace(array_keys(self::$utilities), self::$utilities, $template); 

        $template = preg_replace('/@(delete|patch|put)/', '<input type="hidden" name="_method" value="$1" />', $template);
        $template = preg_replace('/@([\w]+\(.*\))/', '<?php $1: ?>', $template);
        $template = preg_replace('/@([\w]+)/', '<?php $1; ?>', $template);

        return $template;
    }
}