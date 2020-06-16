<ul id="pagePath">
    <li><a href="index.php">Pradžia</a></li>
    <li>Vietos</li>
</ul>
<div id="actions">
    <a href='index.php?module=<?php echo $module; ?>&action=create'>Nauja vieta</a>
</div>
<div class="float-clear"></div>
<table class="listTable">
    <tr>
        <th>Vietos ID</th>
        <th>Pavadinimas</th>
        <th>Vietos tipas</th>
        <th>Įkūrimo laikas</th>
        <th>Reitingai</th>
        <th>Darbo pradžia</th>
        <th>Darbo pabaiga</th>
        <th>Veiksmai</th>
    </tr>
    <?php
    // suformuojame lentelę
    foreach($data as $key => $val) {
        echo
            "<tr>"
            . "<td>{$val['ID']}</td>"
            . "<td>{$val['Pavadinimas']}</td>"
            . "<td>{$val['Tipas']}</td>"
            . "<td>{$val['Ikurimo_laikas']}</td>"
            . "<td>{$val['Reitingai']}</td>"
            . "<td>{$val['Darbo_pradzia']}</td>"
            . "<td>{$val['Darbo_pabaiga']}</td>"
            . "<td>"
            . "<a href='#' onclick='showConfirmDialog(\"{$module}\", \"{$val['ID']}\"); return false;' title=''>šalinti</a>&nbsp;"
            . "<a href='index.php?module={$module}&action=edit&id={$val['ID']}' title=''>redaguoti</a>"
            . "</td>"
            . "</tr>";
    }
    ?>
</table>

<?php
// įtraukiame puslapių šabloną
include 'templates/paging.tpl.php';
?>