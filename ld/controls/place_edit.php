<?php

include 'libraries/place.class.php';
$placeObj = new place();

$formErrors = null;
$data = array();

// nustatome privalomus formos laukus
$required = array('ID', 'Adresas', 'Tipas', 'Ikurimo_laikas', 'Reitingai', 'Darbo_pradzia', 'Darbo_pabaiga');

// maksimalūs leidžiami laukų ilgiai
$maxLengths = array(
    'ID'=>11,
    'Adresas'=>20,
    'Tipas'=>20
);

// vartotojas paspaudė išsaugojimo mygtuką
if(!empty($_POST['submit'])) {
    include 'utils/validator.class.php';

    // nustatome laukų validatorių tipus
    $validations = array (
        'ID'=>'int',
        'Adresas'=>'alfanum',
        'Tipas'=>'alfanum',
        'Ikurimo_laikas'=>'date',
        'Reitingai'=>'int',
        'Darbo_pradzia'=>'not_empty',
        'Darbo_pabaiga'=>'not_empty');

    // sukuriame laukų validatoriaus objektą
    $validator = new validator($validations, $required, $maxLengths);

    // laukai įvesti be klaidų
    if($validator->validate($_POST)) {
        // suformuojame laukų reikšmių masyvą SQL užklausai
        $dataPrepared = $validator->preparePostFieldsForSQL();

        // redaguojame klientą
        $placeObj->updatePlace($dataPrepared);

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
    $data = $placeObj->getPlace($id);
}

// nustatome požymį, kad įrašas redaguojamas norint išjungti ID redagavimą šablone
$data['editing'] = 1;
// įtraukiame šabloną
include 'templates/place_form.tpl.php';

?>