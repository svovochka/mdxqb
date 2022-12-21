<?php

require_once '../vendor/autoload.php';

use Mdxqb\Expression\Set;
use Mdxqb\Query;

$query = (new Query())
    ->selectOnColumns(
        (new Set())
            ->addTuple('[Measures].[Amount]')
            ->addTuple('[Measures].[Rest]')
    )
    ->addSelectOnRows(
        (new Set(
            '[Product].[Product].[Name]',
            '[Date].[Year]'
        ))
    )
    ->from('[Sales]');

echo $query->getMdx();