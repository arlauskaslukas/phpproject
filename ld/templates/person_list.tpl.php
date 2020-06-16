<ul id="pagePath">
	<li><a href="index.php">Pradžia</a></li>
	<li>Asmenys</li>
</ul>
<div id="actions">
	<a href='index.php?module=<?php echo $module; ?>&action=create'>Naujas asmuo</a>
</div>
<div class="float-clear"></div>
<?php if(isset($_GET['remove_error'])) { ?>
    <div class="errorBox">
        Neištrintas, nes asmuo turi ryšių sistemoje. Ištrinkite juos pirmiau.
    </div>
<?php } ?>
<table class="listTable">
    <tr>
        <th>Asmens kodas</th>
        <th>Lytis</th>
        <th>Vardas</th>
        <th>Pavardė</th>
        <th>Amžius</th>
        <th></th>
    </tr>
    <?php
    // suformuojame lentelę
    foreach($data as $key => $val) {
        echo
            "<tr>"
            . "<td>{$val['Asmens_kodas']}</td>"
            . "<td>{$val['Lytis']}</td>"
            . "<td>{$val['Vardas']}</td>"
            . "<td>{$val['Pavarde']}</td>"
            . "<td>{$val['Amzius']}</td>"
            . "<td>"
            . "<a href='#' onclick='showConfirmDialog(\"{$module}\", \"{$val['Asmens_kodas']}\"); return false;' title=''>šalinti</a>&nbsp;"
            . "<a href='index.php?module={$module}&action=edit&id={$val['Asmens_kodas']}' title=''>redaguoti</a>"
            . "</td>"
            . "</tr>";
    }
    ?>
</table>

<?php
// įtraukiame puslapių šabloną
include 'templates/paging.tpl.php';
?>