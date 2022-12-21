<?php

require_once '../vendor/autoload.php';

use Mdxqb\Expression\Set;
use Mdxqb\Query;

$query = (new Query())
    ->selectOnColumns('[Measures].[Amount]')
    ->addSelectOnRows(new Set(
        '[Product].[Product].[Name]',
        '[Date].[Year]'
    ))
    ->from('[Sales]');

echo $query->getMdx();