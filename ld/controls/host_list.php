<?php

// sukuriame darbuotojų klasės objektą
include 'libraries/host.class.php';
$hostObj = new host();

// suskaičiuojame bendrą įrašų kiekį
$elementCount = $hostObj->getHostCount();

// sukuriame puslapiavimo klasės objektą
include 'utils/paging.class.php';
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

// suformuojame sąrašo puslapius
$paging->process($elementCount, $pageId);

// išrenkame nurodyto puslapio darbuotojus
$data = $hostObj->getHostList($paging->size, $paging->first);


// įtraukiame šabloną
include 'templates/host_list.tpl.php';

?>