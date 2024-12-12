<?php

namespace Src\Support\View;

use Src\Support\Facades;
use Src\View\View as ViewView;

class View extends Facades
{
    protected static function getAccessor()
    {
        return ViewView::class;
    }
}
