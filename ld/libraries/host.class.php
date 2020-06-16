<?php


class host
{
    private $PersonTable = "";
    private $HostTable = "";

    public function __construct()
    {
        $this->PersonTable = config::DB_PREFIX . 'asmuo';
        $this->HostTable = config::DB_PREFIX . 'vedejas';
    }

    public function getHost($hid, $from, $until)
    {
        $query = "SELECT * FROM {$this->HostTable} WHERE Vedejo_ID ={$hid} AND Dirba_nuo ='{$from}' AND Dirba_iki='{$until}'";
        $data = mysql::select($query);
        return $data[0];
    }

    public function getPersonList()
    {
        $query = "SELECT Asmens_kodas, Vardas, Pavarde FROM {$this->PersonTable}";
        $data = mysql::select($query);
        return $data;
    }

    public function getHostList($limit = null, $offset = null) {
        $limitOffsetString = "";
        if(isset($limit)) {
            $limitOffsetString .= " LIMIT {$limit}";

            if(isset($offset)) {
                $limitOffsetString .= " OFFSET {$offset}";
            }
        }

        $query = "SELECT {$this->HostTable}.*, {$this->PersonTable}.Vardas, {$this->PersonTable}.Pavarde, {$this->PersonTable}.Asmens_kodas
					FROM {$this->HostTable} 
					 INNER JOIN {$this->PersonTable} ON fk_AsmuoAsmens_kodas = {$this->PersonTable}.Asmens_kodas {$limitOffsetString}";
        $data = mysql::select($query);

        return $data;
    }

    public function getHostCount() {
        $query = "  SELECT COUNT(`Vedejo_ID`) as `kiekis`
					FROM {$this->HostTable}";
        $data = mysql::select($query);

        return $data[0]['kiekis'];
    }

    public function insertHost($data)
    {
        $query = "INSERT INTO {$this->HostTable}
                            (
                                Vedejo_ID,
                                Paslaugos_kaina,
                                Veda_vestuves,
                                Veda_giminiu_sventes,
                                Dirba_nuo,
                                Dirba_iki,
                                Patirtis_nuo,
                                fk_AsmuoAsmens_kodas
                            )
                            VALUES
                            (
                                {$data['Vedejo_ID']},
                                '{$data['Paslaugos_kaina']}',
                                '{$data['Veda_vestuves']}',
                                '{$data['Veda_giminiu_sventes']}',
                                '{$data['Dirba_nuo']}',
                                '{$data['Dirba_iki']}',
                                '{$data['Patirtis_nuo']}',
                                {$data['fk_AsmuoAsmens_kodas']}
                            )
        ";
//        var_dump($query); die();
        mysql::query($query);
    }

    public function updateHost($data)
    {
        $query = "UPDATE {$this->HostTable}
                    SET     Vedejo_ID='{$data['Vedejo_ID']}',
                            Paslaugos_kaina='{$data['Paslaugos_kaina']}',
                            Veda_vestuves='{$data['Veda_vestuves']}',
                            Veda_giminiu_sventes='{$data['Veda_giminiu_sventes']}',
                            Dirba_nuo='{$data['Dirba_nuo']}',
                            Dirba_iki='{$data['Dirba_iki']}',
                            Patirtis_nuo='{$data['Patirtis_nuo']}'
                    WHERE   Asmens_kodas={$data['Asmens_kodas']}";
        mysql::query($query);
    }

    public function deleteHost($HostID, $from, $until)
    {
        $query = "  DELETE FROM {$this->HostTable} 
                    WHERE Vedejo_ID='{$HostID}' AND
                    Dirba_nuo='{$from}' AND
                    Dirba_iki='{$until}'";
        mysql::query($query);
    }
}