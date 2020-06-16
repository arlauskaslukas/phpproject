<?php

include 'libraries/person.class.php';
$personObj = new person();

if(!empty($id)) {

    $removeErrorParameter = '';
    if($personObj->checkIfRemovable($id))
    {
        $personObj->deletePerson($id);
    }
    else
    {
        $removeErrorParameter = '&remove_error=1';
    }

    // nukreipiame į darbuotojų puslapį
    header("Location: index.php?module={$module}&action=list{$removeErrorParameter}");
    die();
}

?>