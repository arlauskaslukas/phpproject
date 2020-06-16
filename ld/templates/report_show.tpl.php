<ul id="reportInfo">
    <li class="title">Renginių ataskaita</li>
    <li>Sudarymo data: <span><?php echo date('Y-m-d'); ?></span></li>
    <li>Renginių laikotarpis:
        <span>
		<?php if (!empty($data['dataNuo'])) {
      if (!empty($data['dataIki'])) {
          echo "nuo {$data['dataNuo']} iki {$data['dataIki']}";
      } else {
          echo "nuo {$data['dataNuo']}";
      }
  } else {
      if (!empty($data['dataIki'])) {
          echo "iki {$data['dataIki']}";
      } else {
          echo 'nenurodyta';
      }
  } ?>
		</span>
    </li>
</ul>
<?php if (isset($resData)) { ?>
    <table class="reportTable">
        <tr class="gray">
            <th>Vietos pavadinimas</th>
            <th>Tipas</th>
            <th class="width100">Data</th>
            <th class="width100">Vedėjas</th>
            <th class="width100">Dalyvių kiekis</th>
            <th class="width100">Dalyvių amžiaus vidurkis</th>
            <th class="width100">Darbuotojų skaičius</th>
            <th class="width100">Kiek dalyvių pasirinko šią vietą kaip mėgstamiausia</th>
        </tr>

        <?php
        // suformuojame lentelę

        if (isset($resData[0]['Pavadinimas'])) {
            $prev = $resData[0]['Pavadinimas'];
        }
        foreach ($resData as $key => $val) {
            if ($prev != $val['Pavadinimas']) {
                //insert calculated stuff
                echo "<tr class=\"gray\">" .
                    '<td></td>' .
                    '<td></td>' .
                    '<td></td>' .
                    '<td></td>' .
                    '<th><strong>Iš viso vietoje lankėsi:</strong></th>' .
                    "<td>{$reportObj->getSumParticipants($prev)}</td>" .
                    '<td></td>' .
                    '<td></td>' .
                    '</tr>';
                $prev = $val['Pavadinimas'];
            }
            echo '<tr>' .
                "<td>{$val['Pavadinimas']}</td>" .
                "<td>{$val['Tipas']}</td>" .
                "<td>{$val['Data']}</td>" .
                "<td>{$val['Vedejas']}</td>" .
                "<td>{$val['Kiekis']}</td>" .
                "<td>{$val['Vidurkis']}</td>" .
                "<td>{$reportObj->getEmployees($val['rid'])}</td>" .
                "<td>{$reportObj->getFavPlaceCount(
                    $val['Pavadinimas'],
                    $val['rid']
                )}</td>" .
                '</tr>';
            $participantData = $reportObj->getParticipants(
                $val['rid'],
                $val['Pavadinimas']
            );
            foreach ($participantData as $k => $v) {
                echo "<tr class=\"gray\">" .
                    '<td></td>' .
                    '<td></td>' .
                    '<td></td>' .
                    '<td></td>' .
                    "<td>{$v['Dalyvis']}</td>" .
                    "<td>{$v['Amzius']}</td>" .
                    '<td></td>' .
                    "<td>{$v['megst']}</td>" .
                    '</tr>';
            }
        }
        echo "<tr class=\"gray\">" .
            '<td></td>' .
            '<td></td>' .
            '<td></td>' .
            '<td></td>' .
            '<th><strong>Iš viso vietoje lankėsi:</strong></th>' .
            "<td>{$reportObj->getSumParticipants($prev)}</td>" .
            '<td></td>' .
            '<td></td>' .
            '</tr>';
        //visu sumacija
        echo "<tr class=\"gray\">" .
            '<td></td>' .
            '<td></td>' .
            '<td></td>' .
            '<td></td>' .
            '<th><strong>Iš viso:</strong></th>' .
            "<td>{$reportObj->getSumAll(
                $data['Tipas'],
                $data['dataNuo'],
                $data['dataIki']
            )}</td>" .
            '<td></td>' .
            '<td></td>' .
            '</tr>';
        ?>
    </table>
    <a href="index.php?module=report&action=form" title="Nauja ataskaita" style="margin-bottom: 15px" class="button large float-right">nauja ataskaita</a>
    <?php } else { ?>
    <div class="warningBox">
        Nurodytu laikotartpiu paslaugų užsakyta nebuvo.
    </div>
    <?php }
?>
