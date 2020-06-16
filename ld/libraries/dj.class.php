<?php


class dj
{
    private $PersonTable = "";
    private $DJTable = "";

    public function __construct()
    {
        $this->PersonTable = config::DB_PREFIX . 'asmuo';
        $this->DJTable = config::DB_PREFIX . 'dj';
    }

    public function getDJ($from, $until)
    {
        $query = "SELECT * FROM {$this->DJTable} WHERE Dirba_nuo ='{$from}' AND Dirba_iki='{$until}'";
        $data = mysql::select($query);
        return $data[0];
    }

    public function getPersonList()
    {
        $query = "SELECT Asmens_kodas, Vardas, Pavarde FROM {$this->PersonTable}";
        $data = mysql::select($query);
        return $data;
    }

    public function getDJList($limit = null, $offset = null) {
        $limitOffsetString = "";
        if(isset($limit)) {
            $limitOffsetString .= " LIMIT {$limit}";

            if(isset($offset)) {
                $limitOffsetString .= " OFFSET {$offset}";
            }
        }

        $query = "SELECT {$this->DJTable}.*, {$this->PersonTable}.Vardas, {$this->PersonTable}.Pavarde, {$this->PersonTable}.Asmens_kodas
					FROM {$this->DJTable} 
					 INNER JOIN {$this->PersonTable} ON fk_AsmuoAsmens_kodas = {$this->PersonTable}.Asmens_kodas {$limitOffsetString}";
        $data = mysql::select($query);

        return $data;
    }

    public function getDJCount() {
        $query = "  SELECT COUNT(`fk_AsmuoAsmens_kodas`) as `kiekis`
					FROM {$this->DJTable}";
        $data = mysql::select($query);

        return $data[0]['kiekis'];
    }

    public function insertDJ($data)
    {
        $query = "INSERT INTO {$this->DJTable}
                            (
                                Dainu_stilius,
                                Kaina,
                                Scenos_vardas,
                                Dirba_nuo,
                                Dirba_iki,
                                Patirtis_nuo,
                                fk_AsmuoAsmens_kodas
                            )
                            VALUES
                            (
                                {$data['Dainu_stilius']},
                                '{$data['Kaina']}',
                                '{$data['Scenos_vardas']}',
                                '{$data['Dirba_nuo']}',
                                '{$data['Dirba_iki']}',
                                '{$data['Patirtis_nuo']}',
                                {$data['fk_AsmuoAsmens_kodas']}
                            )
        ";
//        var_dump($query); die();
        mysql::query($query);
    }

    public function insertPerson($data)
    {
        $query = "INSERT INTO {$this->PersonTable}
                            (
                                Asmens_kodas,
                                Lytis,
                                Vardas,
                                Pavarde,
                                Amzius
                            )
                            VALUES
                            (
                                '{$data['Asmens_kodas']}',
                                '{$data['Lytis']}',
                                '{$data['Vardas']}',
                                '{$data['Pavarde']}',
                                '{$data['Amzius']}'
                            )
        ";
        mysql::query($query);
    }

    public function insertDJs($data)
    {
        if(isset($data["names"]) && sizeof($data["names"])>0) {
            foreach ($data["names"] as $key => $val) {
                    $query = "INSERT INTO {$this->DJTable}
                    (
                        Dainu_stilius,
                        Patirtis_nuo,
                        Kaina,
                        Scenos_vardas,
                        Dirba_nuo,
                        Dirba_iki,
                        fk_AsmuoAsmens_kodas                      
                    )
                    VALUES
                    (
                        '{$data["styles"][$key]}',
                        '{$data["experiences"][$key]}',
                        '{$data["prices"][$key]}',
                        '{$val}',
                        '{$data["from"][$key]}',
                        '{$data["until"][$key]}',
                        '{$data["Asmens_kodas"]}'
                    )";
                    mysql::query($query);
            }
        }
    }
    public function getDJs($id)
    {
        $query = "SELECT {$this->PersonTable}.*, {$this->DJTable}.* 
                FROM `{$this->PersonTable}` 
                INNER JOIN {$this->DJTable} ON {$this->PersonTable}.Asmens_kodas = {$this->DJTable}.fk_AsmuoAsmens_kodas 
                WHERE Asmens_kodas='{$id}'";
        $data = mysql::select($query);
        return $data;
    }

    public function updateDJs($data)
    {
        if(isset($data["names"]) && sizeof($data["names"])>0) {
            foreach ($data["names"] as $key => $val) {
                    $query = "UPDATE {$this->DJTable}
                    SET     Kaina='{$data['prices'][$key]}',
                            Dainu_stilius='{$data['styles'][$key]}',
                            Scenos_vardas='{$data['names'][$key]}',
                            Dirba_nuo='{$data['from'][$key]}',
                            Dirba_iki='{$data['until'][$key]}',
                            Patirtis_nuo='{$data['experiences'][$key]}'
                    WHERE   Dirba_nuo='{$data['from'][$key]}' AND Dirba_iki='{$data['until'][$key]}' AND fk_AsmuoAsmens_kodas={$data['Asmens_kodas']}";
                    //print_r($query); die();
                    mysql::query($query);
            }
        }
    }

    public function deleteDJ($id,$from, $until)
    {
        $query = "  DELETE FROM {$this->DJTable} 
                    WHERE Dirba_nuo='{$from}' AND
                    Dirba_iki='{$until}' AND fk_AsmuoAsmens_kodas={$id}";
        //print_r($query); die();
        mysql::query($query);
    }
}