<?php

namespace Src\Support\Routing;

use Src\Routing\Routes as R;
use Src\Support\Facades;

class Routes extends Facades
{
    protected static function getAccessor()
    {
        return R::class;
    }
}
