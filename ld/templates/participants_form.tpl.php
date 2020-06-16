<ul id="pagePath">
    <li><a href="index.php">Pradžia</a></li>
    <li><a href="index.php?module=<?php echo $module; ?>&action=list">Dalyviai</a></li>
    <li><?php if(!empty($id)) echo "Renginio redagavimas"; else echo "Naujų dalyvių pridėjimas į naują renginį"; ?></li>
</ul>
<div class="float-clear"></div>
<div id="formContainer">
    <?php if($formErrors != null) { ?>
        <div class="errorBox">
            Neįvesti arba neteisingai įvesti šie laukai:
            <?php
            echo $formErrors;
            ?>
        </div>
    <?php } ?>
    <form action="" method="post">
        <fieldset>
            <legend>Renginio informacija</legend>
            <p>
                <label class="field" for="ID">Renginio unikalus ID<?php echo in_array('ID', $required) ? '<span> *</span>' : ''; ?></label>
                <?php if(!isset($data['editing'])) { ?>
                    <input type="text" id="ID" name="ID" class="textbox textbox-150" value="<?php echo isset($data['ID']) ? $data['ID'] : ''; ?>" />
                    <?php if(key_exists('ID', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['ID']} simb.)</span>"; ?>
                <?php } else { ?>
                    <span class="input-value"><?php echo isset($data['ID']) ? $data['ID'] : ''; ?></span>
                    <input type="hidden" name="editing" value="1" />
                    <input type="hidden" name="ID" value="<?php echo $data['ID']; ?>" />
                <?php } ?>
            </p>
            <p>
                <label class="field" for="Pavadinimas">Pavadinimas<?php echo in_array('Pavadinimas', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="text" id="Pavadinimas" name="Pavadinimas" class="textbox textbox-150" value="<?php echo isset($data['Pavadinimas']) ? $data['Pavadinimas'] : ''; ?>" />
                <?php if(key_exists('Pavadinimas', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['Pavadinimas']} simb.)</span>"; ?>
            </p>
            <p>
                <label class="field" for="Amziaus_limitas">Amžiaus limitas<?php echo in_array('Amziaus_limitas', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="text" id="Amziaus_limitas" name="Amziaus_limitas" class="textbox textbox-150" value="<?php echo isset($data['Amziaus_limitas']) ? $data['Amziaus_limitas'] : ''; ?>" />
                <?php if(key_exists('Amziaus_limitas', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['Amziaus_limitas']} simb.)</span>"; ?>
            </p>
            <p>
                <label class="field" for="Data">Data<?php echo in_array('Data', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="date" id="Data" name="Data" class="textbox textbox-150" value="<?php echo isset($data['Data']) ? $data['Data'] : ''; ?>" />
                <?php if(key_exists('Data', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['Data']} simb.)</span>"; ?>
            </p>
            <p>
                <label class="field" for="Pradzios_laikas">Pradzios laikas<?php echo in_array('Pradzios_laikas', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="time" id="Pradzios_laikas" name="Pradzios_laikas" class="textbox textbox-150" value="<?php echo isset($data['Pradzios_laikas']) ? $data['Pradzios_laikas'] : ''; ?>">
                <?php if(key_exists('Pradzios_laikas', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['Pradzios_laikas']} simb.)</span>"; ?>
            </p>
            <p>
                <label class="field" for="Pabaigos_laikas">Pabaigos laikas<?php echo in_array('Pabaigos_laikas', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="time" id="Pabaigos_laikas" name="Pabaigos_laikas" class="textbox textbox-150" value="<?php echo isset($data['Pabaigos_laikas']) ? $data['Pabaigos_laikas'] : ''; ?>">
                <?php if(key_exists('Pabaigos_laikas', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['Pabaigos_laikas']} simb.)</span>"; ?>
            </p>
            <p>
                <label class="field" for="fkVietaID">Renginio vieta<?php echo in_array('fkVietaID', $required) ? '<span> *</span>' : ''; ?></label>
                <select id="fkVietaID" name="fkVietaID">
                    <option value="-1">Pasirinkite vieta</option>
                    <?php
                    // išrenkame visas markes
                    foreach($places as $key => $val) {
                        $selected = "";
                        if(isset($data['fkVietaID']) && $data['fkVietaID'] == $val["ID"]) {
                            $selected = " selected='selected'";
                        }
                        echo "<option{$selected} value={$val["ID"]}>{$val["ID"]}, {$val['Pavadinimas']} </option>";
                    }
                    ?>
                </select>
            </p>
            <p>
                <label class="field" for="vedejas">Vedejas kuris ves<?php echo in_array('vedejas', $required) ? '<span> *</span>' : ''; ?></label>
                <select id="vedejas" name="vedejas">
                    <option value="-1">Pasirinkite vedeja</option>
                    <?php
                    // išrenkame visas markes
                    $codes = $participantObj->getHostList();
                    foreach($codes as $key => $val) {
                        $selected = "";
                        if(isset($data['vedejoID']) && $data['vedejoID'] == $val["Vedejo_ID"]) {
                            $selected = " selected='selected'";
                        }
                        echo "<option{$selected} value='{$val["Vedejo_ID"]},{$val["Dirba_nuo"]},{$val["Dirba_iki"]}'>{$val["Vardas"]} {$val['Pavarde']}, Kontrakto terminas: {$val["Dirba_nuo"]} - {$val["Dirba_iki"]}</option>";
                    }
                    ?>
                </select>
            </p>
        </fieldset>
        <fieldset>
            <legend>Dalyvių informacija</legend>
            <div class="childRowContainer">
                <div class="labelLeft<?php if(empty($data['dalyviai']) || sizeof($data['dalyviai']) == 0) echo ' hidden'; ?>">Dalyvio ID</div>
                <div class="labelRight<?php if(empty($data['dalyviai']) || sizeof($data['dalyviai']) == 0) echo ' hidden'; ?>">Mėgst. vieta</div>
                <div class="labelRight wide<?php if(empty($data['dalyviai']) || sizeof($data['dalyviai']) == 0) echo ' hidden'; ?>">Prisijungimas</div>
                <div class="labelRight<?php if(empty($data['dalyviai']) || sizeof($data['dalyviai']) == 0) echo ' hidden'; ?>">Gėrimas</div>
                <div class="labelRight<?php if(empty($data['dalyviai']) || sizeof($data['dalyviai']) == 0) echo ' hidden'; ?>">Asmuo</div>
                <div class="float-clear"></div>
                <?php
                if(empty($data['dalyviai']) || sizeof($data['dalyviai']) == 0) {
                    ?>

                    <div class="childRow hidden">
                        <input type="text" name="ids[]" value="" class="textbox textbox-70" disabled="disabled" />
                        <input type="text" name="vietos[]" value="" class="textbox textbox-70" disabled="disabled" />
                        <input type="date" name="datos[]" value="" class="textbox textbox-150" />
                        <input type="text" name="gerimai[]" value="" class="textbox textbox-70" disabled="disabled" />
                        <select id="asmkodai[]" name="asmkodai[]" disabled="disabled">
                            <option value="-1">Pasirinkite asmens koda</option>
                            <?php
                            // išrenkame visas markes
                            $codes = $participantObj->getPersonList();
                            $i = 0;
                            foreach($codes as $key => $val) {
                                $selected = "";
                                if(isset($data['fk_AsmuoAsmens_kodas'][$i]) && $data['fk_AsmuoAsmens_kodas'][$i] == $val["Asmens_kodas"]) {
                                    $selected = " selected='selected'";
                                }
                                echo "<option{$selected} value='{$val["Asmens_kodas"]}'>{$val["Asmens_kodas"]}, {$val['Vardas']} {$val['Pavarde']}</option>";
                            }
                            ?>
                        </select>
                        <input type="hidden" class="isDisabledForEditing" name="neaktyvus[]" value="0" />
                        <a href="#" title="" class="removeChild">šalinti</a>
                    </div>
                    <div class="float-clear"></div>

                    <?php
                } else {
                    foreach($data['dalyviai'] as $key => $val) {
                        ?>
                        <div class="childRow">
                            <input type="text" name="ids[]" value="<?php echo $val['kaina']; ?>" class="textbox textbox-70<?php if(isset($val['neaktyvus']) && $val['neaktyvus'] == 1) echo ' disabledInput'; ?>" />
                            <input type="text" name="vietos[]" value="<?php echo $val['vieta']; ?>" class="textbox textbox-70<?php if(isset($val['neaktyvus']) && $val['neaktyvus'] == 1) echo ' disabledInput'; ?>" />
                            <input type="date" name="datos[]" value="<?php echo $val['data']; ?>" class="textbox textbox-70<?php if(isset($val['neaktyvus']) && $val['neaktyvus'] == 1) echo ' disabledInput'; ?>" />
                            <input type="text" name="gerimai[]" value="<?php echo $val['gerimas']; ?>" class="textbox textbox-70<?php if(isset($val['neaktyvus']) && $val['neaktyvus'] == 1) echo ' disabledInput'; ?>" />
                            <input type="text" name="asmkodai[]" value="<?php echo $val['kodas']; ?>" class="textbox textbox-70<?php if(isset($val['neaktyvus']) && $val['neaktyvus'] == 1) echo ' disabledInput'; ?>" />
                            <input type="hidden" class="isDisabledForEditing" name="neaktyvus[]" value="<?php if(isset($val['neaktyvus']) && $val['neaktyvus'] == 1) echo "1"; else echo "0"; ?>" />
                            <a href="#" title="" class="removeChild<?php if(isset($val['neaktyvus']) && $val['neaktyvus'] == 1) echo " hidden"; ?>">šalinti</a>
                        </div>
                        <div class="float-clear"></div>
                        <?php
                    }
                }
                ?>
            </div>
            <p id="newItemButtonContainer">
                <a href="#" title="" class="addChild">Pridėti</a>
            </p>
        </fieldset>

        <p class="required-note">* pažymėtus laukus užpildyti privaloma</p>
        <p>
            <input type="submit" class="submit button" name="submit" value="Išsaugoti">
        </p>
        <?php if(isset($data['id'])) { ?>
            <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
        <?php } ?>
    </form>
</div>