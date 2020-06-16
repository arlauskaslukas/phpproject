<?php

// sukuriame darbuotojų klasės objektą
include 'libraries/place.class.php';
$placeObj = new place();

// suskaičiuojame bendrą įrašų kiekį
$elementCount = $placeObj->getPlaceCount();

// sukuriame puslapiavimo klasės objektą
include 'utils/paging.class.php';
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

// suformuojame sąrašo puslapius
$paging->process($elementCount, $pageId);

// išrenkame nurodyto puslapio darbuotojus
$data = $placeObj->getPlacesList($paging->size, $paging->first);

// įtraukiame šabloną
include 'templates/place_list.tpl.php';

?>