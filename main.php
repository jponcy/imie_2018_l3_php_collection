<?php
require_once('Collection.php');

$c = Collection::build(1, 2, 3, 4, 5);

$c
    ->map(function ($e) {
        return $e ** 2;
    })
    ->forEach(function ($e, $i, $list) {
        echo $i . '/' . $list->size() . ' => ' . $e;
    })
;
