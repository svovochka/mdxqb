<?php

require_once '../vendor/autoload.php';

use Mdxqb\Query;

$query = (new Query())
    ->selectOnColumns('[Measures].[Amount]')
    ->addSelectOnRows('[Product].[Product].[Name]')
    ->from('[Sales]');

echo $query->getMdx();