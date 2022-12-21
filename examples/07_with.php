<?php

require_once '../vendor/autoload.php';

use Mdxqb\Query;

$query = (new Query())
    ->with('SET MySetName AS {[Measures].[Amount], [Measures].[Rest]}')
    ->selectOnColumns('MySetName')
    ->selectOnRows('[Product].[Product].[Name]')
    ->from('[Sales]');

echo $query->getMdx();