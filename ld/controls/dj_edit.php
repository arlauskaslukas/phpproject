<?php

include 'libraries/dj.class.php';
$djObj = new dj();

$formErrors = null;
$data = array();

// nustatome privalomus formos laukus
$required = array('Asmens_kodas', 'Dirba_nuo', 'Dirba_iki');

// maksimalūs leidžiami laukų ilgiai
$maxLengths = array(
    'Asmens_kodas'=>20,
    'Amzius' => 3
);

// vartotojas paspaudė išsaugojimo mygtuką
if(!empty($_POST['submit'])) {
    include 'utils/validator.class.php';

    // nustatome laukų validatorių tipus
    $validations = array (
        'Asmens_kodas'=>'int',
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
        $djObj->updateDJs($dataPrepared);

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
    $data = $djObj->getDJs($id);
    //print_r($data);

}

// nustatome požymį, kad įrašas redaguojamas norint išjungti ID redagavimą šablone
$data[0]['editing'] = 1;
// įtraukiame šabloną
include 'templates/dj_form.tpl.php';

?>