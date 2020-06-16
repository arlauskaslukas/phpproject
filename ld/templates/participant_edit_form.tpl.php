<ul id="pagePath">
    <li><a href="index.php">Pradžia</a></li>
    <li><a href="index.php?module=<?php echo $module; ?>&action=list">Pradžia</a></li>
    <li><?php if(!empty($id)) echo "Dalyvio redagavimas"; else echo "Nauja vieta"; ?></li>
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
            <legend>Dalyvio informacija</legend>
            <p>
                <label class="field" for="id_Dalyvis">Dalyvio ID<?php echo in_array('id_Dalyvis', $required) ? '<span> *</span>' : ''; ?></label>
                <span class="input-value"><?php echo isset($data['id_Dalyvis']) ? $data['id_Dalyvis'] : ''; ?></span>
                <input type="hidden" name="editing" value="1" />
                <input type="hidden" name="id_Dalyvis" value="<?php echo $data['id_Dalyvis']; ?>" />
            </p>
            <p>
                <label class="field" for="Megstamiausia_vieta">Mėgstamiausia vieta<?php echo in_array('Megstamiausia_vieta', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="text" id="Megstamiausia_vieta" name="Megstamiausia_vieta" class="textbox textbox-150" value="<?php echo isset($data['Megstamiausia_vieta']) ? $data['Megstamiausia_vieta'] : ''; ?>" />
                <?php if(key_exists('Megstamiausia_vieta', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['Megstamiausia_vieta']} simb.)</span>"; ?>
            </p>
            <p>
                <label class="field" for="Pasirenkamas_gerimas">Data<?php echo in_array('Pasirenkamas_gerimas', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="text" id="Pasirenkamas_gerimas" name="Pasirenkamas_gerimas" class="textbox textbox-150" value="<?php echo isset($data['Pasirenkamas_gerimas']) ? $data['Pasirenkamas_gerimas'] : ''; ?>" />
                <?php if(key_exists('Pasirenkamas_gerimas', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['Pasirenkamas_gerimas']} simb.)</span>"; ?>
            </p>
            <p>
                <label class="field" for="Prisijungimo_data">Data<?php echo in_array('Prisijungimo_data', $required) ? '<span> *</span>' : ''; ?></label>
                <input type="date" id="Prisijungimo_data" name="Prisijungimo_data" class="textbox textbox-150" value="<?php echo isset($data['Prisijungimo_data']) ? $data['Prisijungimo_data'] : ''; ?>" />
                <?php if(key_exists('Prisijungimo_data', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['Prisijungimo_data']} simb.)</span>"; ?>
            </p>
            <p>
                <label class="field" for="fk_AsmuoAsmens_kodas">Renginio unikalus ID<?php echo in_array('fk_AsmuoAsmens_kodas', $required) ? '<span> *</span>' : ''; ?></label>
                <span class="input-value"><?php echo isset($data['fk_AsmuoAsmens_kodas']) ? $data['fk_AsmuoAsmens_kodas'] : ''; ?></span>
                <input type="hidden" name="editing" value="1" />
                <input type="hidden" name="fk_AsmuoAsmens_kodas" value="<?php echo $data['fk_AsmuoAsmens_kodas']; ?>" />
            </p>
        </fieldset>
        <p class="required-note">* pažymėtus laukus užpildyti privaloma</p>
        <p>
            <input type="submit" class="submit button" name="submit" value="Išsaugoti">
        </p>
    </form>
</div>