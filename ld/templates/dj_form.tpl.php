<ul id="pagePath">
    <li><a href="index.php">Pradžia</a></li>
    <li><a href="index.php?module=<?php echo $module; ?>&action=list">Dalyviai</a></li>
    <li><?php if(!empty($id)) echo "Didžėjaus redagavimas"; else echo "Naujų didžėjaus įrašų pridėjimas"; ?></li>
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

            <legend>Asmens informacija</legend>
            <p>
                <label class="field" for="Asmens_kodas">Asmens kodas<?php echo in_array('Asmens_kodas', $required) ? '<span> *</span>' : ''; ?></label>
                <?php if(!isset($data[0]['editing'])) { ?>
                    <input type="text" id="Asmens_kodas" name="Asmens_kodas" class="textbox textbox-150" value="<?php echo isset($data[0]['Asmens_kodas']) ? $data[0]['Asmens_kodas'] : ''; ?>" />
                    <?php if(key_exists('Asmens_kodas', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['Asmens_kodas']} simb.)</span>"; ?>
                <?php } else { ?>
                    <span class="input-value"><?php echo isset($data[0]['Asmens_kodas']) ? $data[0]['Asmens_kodas'] : ''; ?></span>
                    <input type="hidden" name="editing" value="1" />
                    <input type="hidden" name="Asmens_kodas" value="<?php echo $data[0]['Asmens_kodas']; ?>" />
                <?php } ?>
            </p>
            <p>
                <label class="field" for="Lytis">Lytis<?php echo in_array('Lytis', $required) ? '<span> *</span>' : ''; ?></label>
                <select id="lytis" name="Lytis">
                    <option value="-1">Pasirinkite lytį</option>
                    <?php
                    // išrenkame visas markes
                    $lytys = ["Vyras", "Moteris", "Kita"];
                    foreach($lytys as $val) {
                        $selected = "";
                        if(isset($data[0]['Lytis']) && $data[0]['Lytis'] == $val) {
                            $selected = " selected='selected'";
                        }
                        echo "<option{$selected} value='{$val}'>{$val}</option>";
                    }
                    ?>
                </select>
            </p>
            <p>
                <label class="field" for="Vardas">Vardas<?php echo in_array('Vardas', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="text" id="Vardas" name="Vardas" class="textbox textbox-150" value="<?php echo isset($data[0]['Vardas']) ? $data[0]['Vardas'] : ''; ?>" />
                <?php if(key_exists('Vardas', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['Vardas']} simb.)</span>"; ?>
            </p>
            <p>
                <label class="field" for="Pavarde">Pavardė<?php echo in_array('Pavarde', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="text" id="Pavarde" name="Pavarde" class="textbox textbox-150" value="<?php echo isset($data[0]['Pavarde']) ? $data[0]['Pavarde'] : ''; ?>" />
                <?php if(key_exists('Pavarde', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['Pavarde']} simb.)</span>"; ?>
            </p>
            <p>
                <label class="field" for="Amzius">Amžius<?php echo in_array('Amzius', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="text" id="Amzius" name="Amzius" class="textbox textbox-150" value="<?php echo isset($data[0]['Amzius']) ? $data[0]['Amzius'] : ''; ?>" />
                <?php if(key_exists('Amzius', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['Amzius']} simb.)</span>"; ?>
            </p>
        </fieldset>
        <fieldset>
            <legend>Didžėjaus istorijos informacija</legend>
            <div class="childRowContainer">
                <div class="labelRight wide<?php if(empty($data) || sizeof($data) == 0) echo ' hidden'; ?>">Dirba nuo<?php echo in_array('Dirba_nuo', $required) ? '<span> *</span>' : ''; ?></div>
                <div class="labelRight wide<?php if(empty($data) || sizeof($data) == 0) echo ' hidden'; ?>">Dirba iki<?php echo in_array('Dirba_iki', $required) ? '<span> *</span>' : ''; ?></div>
                <div class="labelRight<?php if(empty($data) || sizeof($data) == 0) echo ' hidden'; ?>">Kaina</div>
                <div class="labelRight<?php if(empty($data) || sizeof($data) == 0) echo ' hidden'; ?>">Dainų stilius</div>
                <div class="labelRight<?php if(empty($data) || sizeof($data) == 0) echo ' hidden'; ?>">DJ vardas</div>
                <div class="labelRight wide<?php if(empty($data) || sizeof($data) == 0) echo ' hidden'; ?>">Patirtis nuo</div>
                <div class="float-clear"></div>
                <?php
                if(empty($data) || sizeof($data) == 0) {
                    ?>

                    <div class="childRow hidden">
                        <input type="date" name="from[]" value="" class="textbox textbox-150" />
                        <input type="date" name="until[]" value="" class="textbox textbox-150" />
                        <input type="text" name="prices[]" value="" class="textbox textbox-70" />
                        <input type="text" name="styles[]" value="" class="textbox textbox-70"/>
                        <input type="text" name="names[]" value="" class="textbox textbox-70"/>
                        <input type="date" name="experiences[]" value="" class="textbox textbox-150" />
                        <input type="hidden" class="isDisabledForEditing" name="neaktyvus[]" value="0" />
                        <a href="#" title="" class="removeChild">šalinti</a>
                    </div>
                    <div class="float-clear"></div>

                    <?php
                } else {
                    foreach($data as $key => $val) {
                        ?>
                        <div class="childRow">
                            <input type="date" name="from[]" value="<?php echo $val['Dirba_nuo']; ?>"
                                   class="textbox textbox-150 disabledInput"/>
                            <input type="date" name="until[]" value="<?php echo $val['Dirba_iki']; ?>"
                                   class="textbox textbox-150 disabledInput"/>
                            <input type="text" name="prices[]" value="<?php echo $val['Kaina']; ?>"
                                   class="textbox textbox-70"/>
                            <input type="text" name="styles[]" value="<?php echo $val['Dainu_stilius']; ?>"
                                   class="textbox textbox-70"/>
                            <input type="text" name="names[]" value="<?php echo $val['Scenos_vardas']; ?>"
                                   class="textbox textbox-70"/>
                            <input type="date" name="experiences[]" value="<?php echo $val['Patirtis_nuo']; ?>"
                                   class="textbox textbox-150 disabledInput"/>
                            <input type="hidden" class="isDisabledForEditing" name="neaktyvus[]"
                                   value="<?php if (isset($val['neaktyvus']) && $val['neaktyvus'] == 1) echo "1"; else echo "0"; ?>"/>
                        </div>
                        <div class="float-clear"></div>
                        <?php
                    }
                }
                ?>
            </div>
            <?php
                if(!isset($data[0]['editing'])) {
                    ?>
                    <p id="newItemButtonContainer">
                        <a href="#" title="" class="addChild">Pridėti</a>
                    </p>
                    <?php
                }
            ?>
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