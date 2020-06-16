<ul id="pagePath">
    <li><a href="index.php">Pradžia</a></li>
    <li><a href="index.php?module=<?php echo $module; ?>&action=list">Pradžia</a></li>
    <li><?php if(!empty($id)) echo "Asmens redagavimas"; else echo "Naujas asmuo"; ?></li>
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

            <legend>Asmens informacija</legend>
            <p>
                <label class="field" for="Asmens_kodas">Asmens kodas<?php echo in_array('Asmens_kodas', $required) ? '<span> *</span>' : ''; ?></label>
                <?php if(!isset($data['editing'])) { ?>
                    <input type="text" id="Asmens_kodas" name="Asmens_kodas" class="textbox textbox-150" value="<?php echo isset($data['Asmens_kodas']) ? $data['Asmens_kodas'] : ''; ?>" />
                    <?php if(key_exists('Asmens_kodas', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['Asmens_kodas']} simb.)</span>"; ?>
                <?php } else { ?>
                    <span class="input-value"><?php echo isset($data['Asmens_kodas']) ? $data['Asmens_kodas'] : ''; ?></span>
                    <input type="hidden" name="editing" value="1" />
                    <input type="hidden" name="Asmens_kodas" value="<?php echo $data['Asmens_kodas']; ?>" />
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
                        if(isset($data['Lytis']) && $data['Lytis'] == $val) {
                            $selected = " selected='selected'";
                        }
                        echo "<option{$selected} value='{$val}'>{$val}</option>";
                    }
                    ?>
                </select>
            </p>
            <p>
                <label class="field" for="Vardas">Vardas<?php echo in_array('Vardas', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="text" id="Vardas" name="Vardas" class="textbox textbox-150" value="<?php echo isset($data['Vardas']) ? $data['Vardas'] : ''; ?>" />
                <?php if(key_exists('Vardas', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['Vardas']} simb.)</span>"; ?>
            </p>
            <p>
                <label class="field" for="Pavarde">Pavardė<?php echo in_array('Pavarde', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="text" id="Pavarde" name="Pavarde" class="textbox textbox-150" value="<?php echo isset($data['Pavarde']) ? $data['Pavarde'] : ''; ?>" />
                <?php if(key_exists('Pavarde', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['Pavarde']} simb.)</span>"; ?>
            </p>
            <p>
                <label class="field" for="Amzius">Amžius<?php echo in_array('Amzius', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="text" id="Amzius" name="Amzius" class="textbox textbox-150" value="<?php echo isset($data['Amzius']) ? $data['Amzius'] : ''; ?>" />
                <?php if(key_exists('Amzius', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['Amzius']} simb.)</span>"; ?>
            </p>
        </fieldset>
        <p class="required-note">* pažymėtus laukus užpildyti privaloma</p>
        <p>
            <input type="submit" class="submit button" name="submit" value="Išsaugoti">
        </p>
    </form>
</div>