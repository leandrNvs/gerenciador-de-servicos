<?php

namespace Src\Support\Database;

use Src\Database\QueryBuilder as DatabaseQueryBuilder;
use Src\Support\Facades;

final class QueryBuilder extends Facades
{
    protected static function getAccessor()
    {
        return DatabaseQueryBuilder::class;
    }
}