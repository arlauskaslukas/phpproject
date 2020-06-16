<ul id="pagePath">
    <li><a href="index.php">Pradžia</a></li>
    <li><a href="index.php?module=<?php echo $module; ?>&action=list">Pradžia</a></li>
    <li><?php if(!empty($id)) echo "Vietos redagavimas"; else echo "Nauja vieta"; ?></li>
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
            <legend>Vietos informacija</legend>
            <p>
                <label class="field" for="ID">Vietos ID<?php echo in_array('ID', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="text" id="ID" name="ID" class="textbox textbox-150" value="<?php echo isset($data['ID']) ? $data['ID'] : ''; ?>" />
                <?php if(key_exists('ID', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['ID']} simb.)</span>"; ?>
            </p>
            <p>
                <label class="field" for="Pavadinimas">Pavadinimas<?php echo in_array('Pavadinimas', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="text" id="Pavadinimas" name="Pavadinimas" class="textbox textbox-150" value="<?php echo isset($data['Pavadinimas']) ? $data['Pavadinimas'] : ''; ?>" />
                <?php if(key_exists('Pavadinimas', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['Pavadinimas']} simb.)</span>"; ?>
            </p>
            <p>
                <label class="field" for="Tipas">Tipas<?php echo in_array('Tipas', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="text" id="Tipas" name="Tipas" class="textbox textbox-150" value="<?php echo isset($data['Tipas']) ? $data['Tipas'] : ''; ?>" />
                <?php if(key_exists('Tipas', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['Tipas']} simb.)</span>"; ?>
            </p>
            <p>
                <label class="field" for="Ikurimo_laikas">Įkūrimo laikas<?php echo in_array('Ikurimo_laikas', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="date" id="Ikurimo_laikas" name="Ikurimo_laikas" class="textbox textbox-150" value="<?php echo isset($data['Ikurimo_laikas']) ? $data['Ikurimo_laikas'] : ''; ?>" />
                <?php if(key_exists('Ikurimo_laikas', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['Ikurimo_laikas']} simb.)</span>"; ?>
            </p>
            <p>
                <label class="field" for="Reitingai">Reitingai<?php echo in_array('Reitingai', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="text" id="Reitingai" name="Reitingai" class="textbox textbox-150" value="<?php echo isset($data['Reitingai']) ? $data['Reitingai'] : ''; ?>" />
                <?php if(key_exists('Reitingai', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['Reitingai']} simb.)</span>"; ?>
            </p>
            <p>
                <label class="field" for="Darbo_pradzia">Darbo pradžia<?php echo in_array('Darbo_pradzia', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="text" id="Darbo_pradzia" name="Darbo_pradzia" class="textbox textbox-150" value="<?php echo isset($data['Darbo_pradzia']) ? $data['Darbo_pradzia'] : ''; ?>" />
                <?php if(key_exists('Darbo_pradzia', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['Darbo_pradzia']} simb.)</span>"; ?>
            </p>
            <p>
                <label class="field" for="Darbo_pabaiga">Darbo pabaiga<?php echo in_array('Darbo_pabaiga', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="text" id="Darbo_pabaiga" name="Darbo_pabaiga" class="textbox textbox-150" value="<?php echo isset($data['Darbo_pabaiga']) ? $data['Darbo_pabaiga'] : ''; ?>" />
                <?php if(key_exists('Darbo_pabaiga', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['Darbo_pabaiga']} simb.)</span>"; ?>
            </p>

        </fieldset>
        <p class="required-note">* pažymėtus laukus užpildyti privaloma</p>
        <p>
            <input type="submit" class="submit button" name="submit" value="Išsaugoti">
        </p>
    </form>
</div>