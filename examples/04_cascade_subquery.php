<?php

require_once '../vendor/autoload.php';

use Mdxqb\Expression\Tuple;
use Mdxqb\Query;

$query = (new Query())
    ->selectOnColumns('[Measures].[Amount]')
    ->addSelectOnRows((new Tuple())
        ->addMember('[Product].[Product].[Name].&[Носок]')
        ->addMember('[Product].[Product].[Name].&[Валенок]')
    )
    ->from((new Query())
        ->selectOnColumns('[Date].[Date].[Month].&[202101]')
        ->from((new Query())
            ->selectOnColumns('[Product].[Category].[Id].&[10]')
            ->from('[Sales]')
        )
    );

echo $query->getMdx();