<?php

// sukuriame darbuotojų klasės objektą
include 'libraries/person.class.php';
$personObj = new person();

// suskaičiuojame bendrą įrašų kiekį
$elementCount = $personObj->getPersonCount();

// sukuriame puslapiavimo klasės objektą
include 'utils/paging.class.php';
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

// suformuojame sąrašo puslapius
$paging->process($elementCount, $pageId);

// išrenkame nurodyto puslapio darbuotojus
$data = $personObj->getPersonList($paging->size, $paging->first);

// įtraukiame šabloną
include 'templates/person_list.tpl.php';

?>