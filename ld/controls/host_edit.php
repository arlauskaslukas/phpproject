<?php

include 'libraries/host.class.php';
$hostObj = new host();

$formErrors = null;
$data = array();

// nustatome privalomus formos laukus
$required = array('Vedejo_ID', 'Dirba_nuo', 'Dirba_iki');

// maksimalūs leidžiami laukų ilgiai
$maxLengths = array(
    'Vedejo_ID'=>11,
    'Paslaugos_kaina'=>10,
);

// vartotojas paspaudė išsaugojimo mygtuką
if(!empty($_POST['submit'])) {
    include 'utils/validator.class.php';

    // nustatome laukų validatorių tipus
    $validations = array (
        'Vedejo_ID'=>'positivenumber',
        'Paslaugos_kaina'=>'price',
        'Dirba_nuo'=>'date',
        'Dirba_iki'=>'date',
        'Patirtis_nuo'=>'date');

    // sukuriame laukų validatoriaus objektą
    $validator = new validator($validations, $required, $maxLengths);

    // laukai įvesti be klaidų
    if($validator->validate($_POST)) {
        // suformuojame laukų reikšmių masyvą SQL užklausai
        $dataPrepared = $validator->preparePostFieldsForSQL();

        // redaguojame klientą
        $hostObj->updateHost($dataPrepared);

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
    $data = $hostObj->getHost($id, $from, $until);
    //print_r($data);
}
//print_r($hostObj->getHost($id, $from, $until));
// nustatome požymį, kad įrašas redaguojamas norint išjungti ID redagavimą šablone
$data['editing'] = 1;
// įtraukiame šabloną
include 'templates/host_form.tpl.php';

?>