<?php

include 'libraries/participant.class.php';
$participantObj = new participant();

$formErrors = null;
$data = array();

// nustatome privalomus laukus
$required = array('ID', 'fkVietaID', 'vedejas', 'ids', 'asmkodai');

// maksimalūs leidžiami laukų ilgiai
$maxLengths = array (
    'ID' => 10
);
$places = $participantObj->getPlacesList();
//var_dump($places);

// paspaustas išsaugojimo mygtukas
if(!empty($_POST['submit'])) {
    // nustatome laukų validatorių tipus
    $validations = array (
        'ID' => 'positivenumber',
        'ids' => 'positivenumber',
        'fkVietaID' => 'anything',
        'vedejas' => 'anything',
        'asmkodai' => 'anything'
        );

    // sukuriame validatoriaus objektą
    include 'utils/validator.class.php';
    $validator = new validator($validations, $required, $maxLengths);

    // laukai įvesti be klaidų
    if($validator->validate($_POST)) {
        // suformuojame laukų reikšmių masyvą SQL užklausai
        $dataPrepared = $validator->preparePostFieldsForSQL();
        // insert event
        $participantObj->insertEvent($dataPrepared);
        // insert every person
        $participantObj->insertParticipants($dataPrepared);
        // connect them all
        $participantObj->insertParticipated($dataPrepared);

        // nukreipiame į modelių puslapį
        header("Location: index.php?module={$module}&action=list");
        die();
    } else {
        // gauname klaidų pranešimą
        $formErrors = $validator->getErrorHTML();
        // gauname įvestus laukus
        $data = $_POST;
    }
} else {
    // tikriname, ar nurodytas elemento id. Jeigu taip, išrenkame elemento duomenis ir jais užpildome formos laukus.
    if(!empty($id)) {
        $data = $participantObj->getParticipant($id);
    }
}

// įtraukiame šabloną
include 'templates/participants_form.tpl.php';

?>