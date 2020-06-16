<ul id="pagePath">
    <li><a href="index.php">Pradžia</a></li>
    <li><a href="index.php?module=<?php echo $module; ?>&action=list">Pradžia</a></li>
    <li><?php if(!empty($id)) echo "Vedejo redagavimas"; else echo "Naujas vedejas"; ?></li>
</ul>
<div class="float-clear"></div>
<div id="formContainer">
    <?php if($formErrors!=null) { ?>
        <div class="errorBox">
            Neįvesti arba neteisingai įvesti šie laukai:
            <?php
            echo $formErrors;
            ?>
        </div>
    <?php } ?>
    <form action="" method="post">
        <fieldset>

            <legend>Vedejo informacija</legend>
            <p>
                <label class="field" for="Vedejo_ID">Vedejo ID<?php echo in_array('Vedejo_ID', $required) ? '<span> *</span>' : ''; ?></label>
                <?php if(!isset($data['editing'])) { ?>
                    <input type="text" id="Vedejo_ID" name="Vedejo_ID" class="textbox textbox-150" value="<?php echo isset($data['Vedejo_ID']) ? $data['Vedejo_ID'] : ''; ?>" />
                    <?php if(key_exists('Vedejo_ID', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['Vedejo_ID']} simb.)</span>"; ?>
                <?php } else { ?>
                    <span class="input-value"><?php echo isset($data['Vedejo_ID']) ? $data['Vedejo_ID'] : ''; ?></span>
                    <input type="hidden" name="editing" value="1" />
                    <input type="hidden" name="Vedejo_ID" value="<?php echo $data['Vedejo_ID']; ?>" />
                <?php } ?>
            </p>
            <p>
                <label class="field" for="Paslaugos_kaina">Paslaugos kaina<?php echo in_array('Paslaugos_kaina', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="text" id="Paslaugos_kaina" name="Paslaugos_kaina" class="textbox textbox-150" value="<?php echo isset($data['Paslaugos_kaina']) ? $data['Paslaugos_kaina'] : ''; ?>" />
                <?php if(key_exists('Paslaugos_kaina', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['Paslaugos_kaina']} simb.)</span>"; ?>
            </p>
            <p>
                <label class="field" for="Veda_vestuves">Veda vestuves</label>
                <input type="checkbox" id="Veda_vestuves" name="Veda_vestuves" value="1">
            </p>
            <p>
                <label class="field" for="Veda_giminiu_sventes">Veda giminiu sventes</label>
                <input type="checkbox" id="Veda_giminiu_sventes" name="Veda_giminiu_sventes" value="1">
            </p>
            <p>
                <label class="field" for="Dirba_nuo">Dirba nuo<?php echo in_array('Dirba_nuo', $required) ? '<span> *</span>' : ''; ?></label>
                <?php if(!isset($data['editing'])) { ?>
                    <input type="date" id="Dirba_nuo" name="Dirba_nuo" class="textbox textbox-150" value="<?php echo isset($data['Dirba_nuo']) ? $data['Dirba_nuo'] : ''; ?>" />
                    <?php if(key_exists('Dirba_nuo', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['Dirba_nuo']} simb.)</span>"; ?>
                <?php } else { ?>
                    <span class="input-value"><?php echo isset($data['Dirba_nuo']) ? $data['Dirba_nuo'] : ''; ?></span>
                    <input type="hidden" name="editing" value="1" />
                    <input type="hidden" name="Dirba_nuo" value="<?php echo $data['Dirba_nuo']; ?>" />
                <?php } ?>
            </p>
            <p>
                <label class="field" for="Dirba_iki">Dirba iki<?php echo in_array('Dirba_iki', $required) ? '<span> *</span>' : ''; ?></label>
                <?php if(!isset($data['editing'])) { ?>
                    <input type="date" id="Dirba_iki" name="Dirba_iki" class="textbox textbox-150" value="<?php echo isset($data['Dirba_iki']) ? $data['Dirba_iki'] : ''; ?>" />
                    <?php if(key_exists('Dirba_iki', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['Dirba_iki']} simb.)</span>"; ?>
                <?php } else { ?>
                    <span class="input-value"><?php echo isset($data['Dirba_iki']) ? $data['Dirba_iki'] : ''; ?></span>
                    <input type="hidden" name="editing" value="1" />
                    <input type="hidden" name="Dirba_iki" value="<?php echo $data['Dirba_iki']; ?>" />
                <?php } ?>
            </p>
            <p>
                <label class="field" for="Patirtis_nuo">Patirtis nuo<?php echo in_array('Patirtis_nuo', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="date" id="Patirtis_nuo" name="Patirtis_nuo" class="textbox textbox-150" value="<?php echo isset($data['Patirtis_nuo']) ? $data['Patirtis_nuo'] : ''; ?>" />
                <?php if(key_exists('Patirtis_nuo', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['Patirtis_nuo']} simb.)</span>"; ?>
            </p>
            <p>
                <label class="field" for="fk_AsmuoAsmens_kodas">Asmens kodas<?php echo in_array('fk_AsmuoAsmens_kodas', $required) ? '<span> *</span>' : ''; ?></label>
                <select id="fk_AsmuoAsmens_kodas" name="fk_AsmuoAsmens_kodas">
                    <option value="-1">Pasirinkite asmens koda</option>
                    <?php
                    // išrenkame visas markes
                    $codes = $hostObj->getPersonList();
                    $i = 0;
                    foreach($codes as $key => $val) {
                        $selected = "";
                        if(isset($data['fk_AsmuoAsmens_kodas']) && $data['fk_AsmuoAsmens_kodas'] == $val["Asmens_kodas"]) {
                            $selected = " selected='selected'";
                        }
                        echo "<option{$selected} value='{$val["Asmens_kodas"]}'>{$val["Asmens_kodas"]}, {$val['Vardas']} {$val['Pavarde']}</option>";
                    }
                    ?>
                </select>
            </p>
        </fieldset>
        <p class="required-note">* pažymėtus laukus užpildyti privaloma</p>
        <p>
            <input type="submit" class="submit button" name="submit" value="Išsaugoti">
        </p>
    </form>
</div>