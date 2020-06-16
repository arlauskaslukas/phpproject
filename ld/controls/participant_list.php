<?php

// sukuriame darbuotojų klasės objektą
include 'libraries/participant.class.php';
$participantObj = new participant();

// suskaičiuojame bendrą įrašų kiekį
$elementCount = $participantObj->getParticipantCount();

// sukuriame puslapiavimo klasės objektą
include 'utils/paging.class.php';
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

// suformuojame sąrašo puslapius
$paging->process($elementCount, $pageId);

// išrenkame nurodyto puslapio darbuotojus
$data = $participantObj->getParticipantList($paging->size, $paging->first);

// įtraukiame šabloną
include 'templates/participant_list.tpl.php';

?>