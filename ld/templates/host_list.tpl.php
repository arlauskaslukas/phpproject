<ul id="pagePath">
    <li><a href="index.php">Pradžia</a></li>
    <li>Vedėjai</li>
</ul>
<div id="actions">
    <a href='index.php?module=<?php echo $module; ?>&action=create'>Naujas vedėjas</a>
</div>
<div class="float-clear"></div>
<?php if(isset($_GET['error-list'])) { ?>
    <div class="errorBox">
        Nepridėtas, nes kontrakto pabaiga negali būti anksčiau už kontrakto pradžią.
    </div>
<?php } ?>
<table class="listTable">
    <tr>
        <th>Asmens kodas</th>
        <th>Vedėjo ID</th>
        <th>Vardas</th>
        <th>Pavardė</th>
        <th>Paslaugos kaina</th>
        <th>Dirba nuo</th>
        <th>Dirba iki</th>
        <th>Patirtis nuo</th>
        <th>Veiksmai</th>
    </tr>
    <?php
    // suformuojame lentelę
    foreach($data as $key => $val) {
        echo
            "<tr>"
            . "<td>{$val['Asmens_kodas']}</td>"
            . "<td>{$val['Vedejo_ID']}</td>"
            . "<td>{$val['Vardas']}</td>"
            . "<td>{$val['Pavarde']}</td>"
            . "<td>{$val['Paslaugos_kaina']}</td>"
            . "<td>{$val['Dirba_nuo']}</td>"
            . "<td>{$val['Dirba_iki']}</td>"
            . "<td>{$val['Patirtis_nuo']}</td>"
            . "<td>"
            . "<a href='#' onclick='showConfirmHDialog(\"{$module}\", \"{$val['Vedejo_ID']}\", \"{$val['Dirba_nuo']}\", \"{$val['Dirba_iki']}\"); return false;' title=''>šalinti</a>&nbsp;"
            . "<a href='index.php?module={$module}&action=edit&id={$val['Vedejo_ID']}&from={$val['Dirba_nuo']}&until={$val['Dirba_iki']}' title=''>redaguoti</a>"
            . "</td>"
            . "</tr>";
    }
    ?>
</table>

<?php
// įtraukiame puslapių šabloną
include 'templates/paging.tpl.php';
?>