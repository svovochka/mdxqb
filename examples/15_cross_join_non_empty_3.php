<?php

require_once '../vendor/autoload.php';

use Mdxqb\Expression\Set;
use Mdxqb\Functions\CrossJoin;
use Mdxqb\Functions\NonEmpty;
use Mdxqb\Operator\Range;
use Mdxqb\Query;

$query = (new Query())
    ->with('SET MySetName AS {[Measures].[Amount], [Measures].[Rest]}')
    ->selectOnColumns((new CrossJoin(
        new NonEmpty(
            new CrossJoin(
                '[Address].[Town]',
                new NonEmpty(
                    new CrossJoin(
                        '[Branch].[Name]',
                        new NonEmpty(
                            '[SaleType].[Name]',
                            'MySetName'
                        )
                    ),
                    'MySetName'
                )
            ),
            'MySetName'
        ),
        'MySetName'
    )))
    ->selectOnRows(new NonEmpty(
        new CrossJoin(
            '[Product].[Product].[Name]',
            new NonEmpty(
                '[Date].[Date].[Day]',
                'MySetName'
            )
        ),
        'MySetName'))
    ->from((new Query())
        ->selectOnColumns(
            new CrossJoin(
                new Set(
                    '[Product].[Product].&[134947954]',
                    '[Product].[Product].&[134947981]',
                    '[Product].[Product].&[11145970]',
                    '[Product].[Product].&[101362503]'
                ),
                new Set (
                    '[Address].[Region].&[77]',
                    '[Address].[Region].&[54]'
                ),
                new Set(
                    '[Branch].[Name].&[6332]',
                    '[Branch].[Name].&[295]'
                )
            )
        )
        ->from((new Query())
            ->selectOnColumns(new Range(
                '[Date].[Date].[Month].&[202101]',
                '[Date].[Date].[Month].&[202112]'
            ))
            ->from('[Sales]'))
    );

echo $query->getMdx();
