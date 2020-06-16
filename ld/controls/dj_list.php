<?php

// sukuriame darbuotojų klasės objektą
include 'libraries/dj.class.php';
$djObj = new dj();

// suskaičiuojame bendrą įrašų kiekį
$elementCount = $djObj->getDJCount();

// sukuriame puslapiavimo klasės objektą
include 'utils/paging.class.php';
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

// suformuojame sąrašo puslapius
$paging->process($elementCount, $pageId);

// išrenkame nurodyto puslapio darbuotojus
$data = $djObj->getDJList($paging->size, $paging->first);


// įtraukiame šabloną
include 'templates/dj_list.tpl.php';

?>