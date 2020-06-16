<?php

include 'libraries/dj.class.php';
$djObj = new dj();

$formErrors = null;
$data = array();

// nustatome privalomus formos laukus
$required = array('Asmens_kodas', 'Dirba_nuo', 'Dirba_iki');

// maksimalūs leidžiami laukų ilgiai
$maxLengths = array(
    'Asmens_kodas'=>11,
);



// vartotojas paspaudė išsaugojimo mygtuką
if(!empty($_POST['submit'])) {
    include 'utils/validator.class.php';

    // nustatome laukų validatorių tipus
    $validations = array (
        'Asmens_kodas' => 'int',
        'Dirba_nuo'=>'date',
        'Dirba_iki'=>'date',
        'Vardas' => 'alfanum',
        'Pavarde' => 'alfanum',
        'Amzius'=>'int',
        'Patirtis_nuo'=>'date');
    // sukuriame laukų validatoriaus objektą
    $validator = new validator($validations, $required, $maxLengths);

    // laukai įvesti be klaidų
    if($validator->validate($_POST)) {
        // suformuojame laukų reikšmių masyvą SQL užklausai
        $dataPrepared = $validator->preparePostFieldsForSQL();
                
        // įrašome naują klientą
        //insert person
        $djObj->insertPerson($dataPrepared);
        //insertt djs
        $djObj->insertDJs($dataPrepared);

        // nukreipiame vartotoją į klientų puslapį
        header("Location: index.php?module={$module}&action=list");
        //php is pain
        //Why even try
        //I guess I'll just
        die();
    }
    else {
        // gauname klaidų pranešimą
        $formErrors = $validator->getErrorHTML();
        // laukų reikšmių kintamajam priskiriame įvestų laukų reikšmes
        $data = $_POST;
    }
}

// įtraukiame šabloną
include 'templates/dj_form.tpl.php';

?>