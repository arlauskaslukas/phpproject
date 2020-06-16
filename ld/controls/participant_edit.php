<?php

include 'libraries/participant.class.php';
$participantObj = new participant();

$formErrors = null;
$data = array();

// nustatome privalomus formos laukus
$required = array();

// maksimalūs leidžiami laukų ilgiai
$maxLengths = array(
    
);

// vartotojas paspaudė išsaugojimo mygtuką
if(!empty($_POST['submit'])) {
    include 'utils/validator.class.php';

    // nustatome laukų validatorių tipus
    $validations = array (
        'Asmens_kodas' => 'alfanum',
        'Lytis'=>'alfanum',
        'Vardas' => 'alfanum',
        'Pavarde' => 'alfanum',
        'Amzius'=>'int');

    // sukuriame laukų validatoriaus objektą
    $validator = new validator($validations, $required, $maxLengths);

    // laukai įvesti be klaidų
    if($validator->validate($_POST)) {
        // suformuojame laukų reikšmių masyvą SQL užklausai
        $dataPrepared = $validator->preparePostFieldsForSQL();

        // redaguojame klientą
        $participantObj->updateParticipant($dataPrepared);

        // nukreipiame vartotoją į klientų puslapį
        header("Location: index.php?module={$module}&action=list");
        die();

    }
    else {
        // gauname klaidų pranešimą
        $formErrors = $validator->getErrorHTML();

        // laukų reikšmių kintamajam priskiriame įvestų laukų reikšmes
        $data = $_POST;
    }
} else {
    // išrenkame klientą
    $data = $participantObj->getParticipant($id);
}

// nustatome požymį, kad įrašas redaguojamas norint išjungti ID redagavimą šablone
$data['editing'] = 1;
// įtraukiame šabloną
include 'templates/participant_edit_form.tpl.php';

?>