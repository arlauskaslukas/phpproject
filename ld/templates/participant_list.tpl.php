<ul id="pagePath">
    <li><a href="index.php">Pradžia</a></li>
    <li>Dalyviai</li>
</ul>
<div id="actions">
    <a href='index.php?module=<?php echo $module; ?>&action=create'>Registruoti dalyvius į naują renginį</a>
</div>
<div class="float-clear"></div>
<table class="listTable">
    <tr>
        <th>Asmens kodas</th>
        <th>Dalyvio ID</th>
        <th>Vardas</th>
        <th>Pavardė</th>
        <th>Renginys</th>
        <th>Vieta</th>
        <th>Veiksmai</th>
    </tr>
    <?php
    // suformuojame lentelę
    foreach($data as $key => $val) {
        echo
            "<tr>"
            . "<td>{$val['Asmens_kodas']}</td>"
            . "<td>{$val['id_Dalyvis']}</td>"
            . "<td>{$val['Vardas']}</td>"
            . "<td>{$val['Pavarde']}</td>"
            . "<td>{$val['Pavadinimas']}</td>"
            . "<td>{$val['Vieta']}</td>"
            . "<td>"
            . "<a href='#' onclick='showConfirmDialog(\"{$module}\", \"{$val['id_Dalyvis']}\"); return false;' title=''>šalinti</a>&nbsp;"
            . "<a href='index.php?module={$module}&action=edit&id={$val['id_Dalyvis']}' title=''>redaguoti</a>"
            . "</td>"
            . "</tr>";
    }
    ?>
</table>

<?php
// įtraukiame puslapių šabloną
include 'templates/paging.tpl.php';
?>