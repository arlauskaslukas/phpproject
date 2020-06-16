<ul id="pagePath">
    <li><a href="index.php">Pradžia</a></li>
    <li>Didžėjai</li>
</ul>
<div id="actions">
    <a href='index.php?module=<?php echo $module; ?>&action=create'>Naujas didžėjus</a>
</div>
<div class="float-clear"></div>

<?php if(isset($_GET['error-list'])) { ?>
    <div class="errorBox">
        Nepridėtas, nes kontrakto pabaiga negali būti anksčiau už kontrakto pradžią.
    </div>
<?php } ?>

<table class="listTable">
    <tr>
        <th>Scenos vardas</th>
        <th>Vardas</th>
        <th>Pavardė</th>
        <th>Kontrakto pradžia</th>
        <th>Kontrakto pabaiga</th>
        <th>Kaina</th>
        <th>Veiksmai</th>
    </tr>
    <?php
    // suformuojame lentelę
    foreach($data as $key => $val) {
        echo
            "<tr>"
            . "<td>{$val['Scenos_vardas']}</td>"
            . "<td>{$val['Vardas']}</td>"
            . "<td>{$val['Pavarde']}</td>"
            . "<td>{$val['Dirba_nuo']}</td>"
            . "<td>{$val['Dirba_iki']}</td>"
            . "<td>{$val['Kaina']}</td>"
            . "<td>"
            . "<a href='#' onclick='showConfirmHDialog(\"{$module}\", \"{$val['Asmens_kodas']}\", \"{$val['Dirba_nuo']}\", \"{$val['Dirba_iki']}\"); return false;' title=''>šalinti</a>&nbsp;"
            . "<a href='index.php?module={$module}&action=edit&id={$val['Asmens_kodas']}' title=''>redaguoti susietą asmenį</a>"
            . "</td>"
            . "</tr>";
    }
    ?>
</table>

<?php
// įtraukiame puslapių šabloną
include 'templates/paging.tpl.php';
?>