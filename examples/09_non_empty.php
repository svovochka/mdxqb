<?php

require_once '../vendor/autoload.php';

use Mdxqb\Functions\NonEmpty;
use Mdxqb\Operator\Range;
use Mdxqb\Query;

$query = (new Query())
    ->with('SET MySetName AS {[Measures].[Amount], [Measures].[Rest]}')
    ->selectOnColumns('MySetName')
    ->selectOnRows(new NonEmpty(
        '[Product].[Product].[Name]',
        'MySetName'))
    ->from((new Query())
        ->selectOnColumns(new Range(
            '[Date].[Date].[Month].&[202101]',
            '[Date].[Date].[Month].&[202112]'
        ))
        ->from('[Sales]')
    );

echo $query->getMdx();