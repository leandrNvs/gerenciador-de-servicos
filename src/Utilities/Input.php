<?php

namespace Src\Utilities;

final class Input
{
    public function __construct(private $data) {
    }

    public function clear($pattern, $new)
    {
        $this->data = preg_replace($pattern, $new, $this->data);

        return $this;
    }

    public function get()
    {
        return $this->data;
    }
}