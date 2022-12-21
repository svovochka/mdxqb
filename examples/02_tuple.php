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
    ->from('[Sales]');

echo $query->getMdx();