<?php

include 'libraries/participant.class.php';
$participantObj = new participant();

if(!empty($id)) {
    // patikriname, ar darbuotojas neturi sudarytų sutarčių
    //todo: find if the primary key is foreign key to something
    //$count = $employeesObj->getContractCountOfEmployee($id);

    $removeErrorParameter = '';
    $participantObj->deleteParticipant($id);
    //if($count == 0) {
    // šaliname darbuotoją
    //  $employeesObj->deleteEmployee($id);
    //} else {
    // nepašalinome, nes darbuotojas sudaręs bent vieną sutartį, rodome klaidos pranešimą
    //  $removeErrorParameter = '&remove_error=1';
    //}

    // nukreipiame į darbuotojų puslapį
    header("Location: index.php?module={$module}&action=list{$removeErrorParameter}");
    die();
}

?>