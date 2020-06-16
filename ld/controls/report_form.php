<?php

include 'libraries/report.class.php';
$reportObj = new report();

$formErrors = null;
$fields = [];
$formSubmitted = false;

$data = [];
if (empty($_POST['submit'])) {
    // rodome ataskaitos parametrų įvedimo formą
    include 'templates/report_form.tpl.php';
} else {
    $formSubmitted = true;

    // nustatome laukų validatorių tipus
    $validations = [
        'dataNuo' => 'date',
        'dataIki' => 'date',
    ];

    // sukuriame validatoriaus objektą
    include 'utils/validator.class.php';
    $validator = new validator($validations);
    //$reportObj->getEmployees(1);
    if ($validator->validate($_POST)) {
        // suformuojame laukų reikšmių masyvą SQL užklausai
        $data = $validator->preparePostFieldsForSQL();

        // išrenkame ataskaitos duomenis
        $resData = $reportObj->getReport(
            $data['Tipas'],
            $data['dataNuo'],
            $data['dataIki']
        );
        //       print_r($resData);
        //     die();

        // rodome ataskaitą
        include 'templates/report_show.tpl.php';
    }
}
