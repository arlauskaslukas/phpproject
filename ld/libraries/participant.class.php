<?php


class participant
{
    private $PersonTable = "";
    private $ParticipantTable = "";
    private $ParticipatedTable = "";
    private $PlaceTable = "";
    private $EventTable = "";
    private $HostTable = "";

    public function __construct()
    {
        $this->PersonTable = config::DB_PREFIX . 'asmuo';
        $this->ParticipantTable = config::DB_PREFIX . 'dalyvis';
        $this->ParticipatedTable = config::DB_PREFIX . 'dalyvauja';
        $this->PlaceTable = config::DB_PREFIX . 'vieta';
        $this->EventTable = config::DB_PREFIX . 'renginys';
        $this->HostTable = config::DB_PREFIX . 'vedejas';
    }

    public function getParticipant($id)
    {
        $query = "SELECT * FROM {$this->ParticipantTable} WHERE id_Dalyvis={$id}";
        $data = mysql::select($query);
        return $data[0];
    }

    public function getPersonList()
    {
        $query = "SELECT Asmens_kodas, Vardas, Pavarde FROM {$this->PersonTable}";
        $data = mysql::select($query);
        return $data;
    }
    public function getPlacesList() {

        $query = "  SELECT * FROM {$this->PlaceTable}";
        $data = mysql::select($query);
        return $data;
    }

    public function getHostList() {
        $query = "SELECT {$this->HostTable}.*, {$this->PersonTable}.Vardas, {$this->PersonTable}.Pavarde, {$this->PersonTable}.Asmens_kodas
					FROM {$this->HostTable} 
					 INNER JOIN {$this->PersonTable} ON fk_AsmuoAsmens_kodas = {$this->PersonTable}.Asmens_kodas";
        $data = mysql::select($query);

        return $data;
    }

    public function getParticipantList($limit = null, $offset = null) {
        $limitOffsetString = "";
        if(isset($limit)) {
            $limitOffsetString .= " LIMIT {$limit}";

            if(isset($offset)) {
                $limitOffsetString .= " OFFSET {$offset}";
            }
        }

        $query = "SELECT {$this->ParticipantTable}.id_Dalyvis, {$this->PersonTable}.Vardas, {$this->PersonTable}.Pavarde, {$this->PersonTable}.Asmens_kodas, {$this->EventTable}.Pavadinimas, {$this->PlaceTable}.Pavadinimas 
                AS 'Vieta'
					FROM {$this->ParticipantTable} 
					 INNER JOIN {$this->PersonTable} ON {$this->ParticipantTable}.fk_AsmuoAsmens_kodas = {$this->PersonTable}.Asmens_kodas
					  INNER JOIN {$this->ParticipatedTable} ON {$this->ParticipantTable}.id_Dalyvis = {$this->ParticipatedTable}.fk_Dalyvisid_Dalyvis
					  INNER JOIN {$this->EventTable} ON {$this->ParticipatedTable}.fk_RenginysID = {$this->EventTable}.ID
					  INNER JOIN {$this->PlaceTable} ON {$this->EventTable}.fk_VietaID = {$this->PlaceTable}.ID
					  {$limitOffsetString}";
        $data = mysql::select($query);

        return $data;
    }

    public function getParticipantCount() {
        $query = "  SELECT COUNT(`fk_Dalyvisid_Dalyvis`) as `kiekis`
					FROM {$this->ParticipatedTable}";
        $data = mysql::select($query);

        return $data[0]['kiekis'];
    }

    public function insertEvent($data) {
        $HostData = explode(",",$data["vedejas"]);
        $query = "INSERT INTO {$this->EventTable}
                 (
                    Pavadinimas,
                    Data,
                    Amziaus_limitas,
                    ID,
                    Pradzios_laikas,
                    Pabaigos_laikas,
                    fk_VietaID,
                    fk_VedejasDirba_iki,
                    fk_VedejasDirba_nuo,
                    fk_VedejasVedejo_ID
                 )
                 VALUES
                 (
                    '{$data["Pavadinimas"]}',
                    '{$data["Data"]}',
                    {$data["Amziaus_limitas"]},
                    {$data["ID"]},
                    '{$data["Pradzios_laikas"]}',
                    '{$data["Pabaigos_laikas"]}',
                    {$data["fkVietaID"]},
                    '{$HostData[2]}',
                    '{$HostData[1]}',
                    '{$HostData[0]}'
                 )";
        mysql::query($query);
    }
    public function insertParticipants($data) {
        if(isset($data["asmkodai"]) && sizeof($data["asmkodai"])>0) {
            foreach ($data["asmkodai"] as $key => $val) {
                if($data['neaktyvus'] == array() || $data['neaktyvus'][$key]==0)
                {
                    $query = "INSERT INTO {$this->ParticipantTable}
                    (
                        Megstamiausia_vieta,
                        Pasirenkamas_gerimas,
                        Prisijungimo_data,
                        id_Dalyvis,
                        fk_AsmuoAsmens_kodas
                    )
                    VALUES
                    (
                        '{$data["vietos"][$key]}',
                        '{$data["gerimai"][$key]}',
                        '{$data["datos"][$key]}',
                        '{$data["ids"][$key]}',
                        '{$val}'
                    )";
                    mysql::query($query);
                }
            }
        }
    }

    public function insertParticipated($data) {
        if(isset($data["asmkodai"]) && sizeof($data["asmkodai"])>0) {
            foreach ($data["asmkodai"] as $key => $val) {
                if($data['neaktyvus'] == array() || $data['neaktyvus'][$key]==0)
                {
                    $query = "INSERT INTO {$this->ParticipatedTable}
                    (
                        fk_RenginysID,
                        fk_Dalyvisid_Dalyvis
                    )
                    VALUES
                    (
                        '{$data["ID"]}',
                        '{$data["ids"][$key]}'
                    )";
                    mysql::query($query);
                }
            }
        }
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

    public function updateParticipant($data)
    {
        $query = "UPDATE {$this->ParticipantTable}
                    SET     id_Dalyvis='{$data['id_Dalyvis']}',
                            Prisijungimo_data='{$data['Prisijungimo_data']}',
                            Pasirenkamas_gerimas='{$data['Pasirenkamas_gerimas']}',
                            Megstamiausia_vieta='{$data['Megstamiausia_vieta']}',
                            fk_AsmuoAsmens_kodas='{$data['fk_AsmuoAsmens_kodas']}',
                    WHERE   id_Dalyvis={$data['id_Dalyvis']}";
        mysql::query($query);
    }

    public function deleteParticipant($id)
    {
        $query = " DELETE FROM {$this->ParticipatedTable}
                    WHERE fk_Dalyvisid_Dalyvis='{$id}'";
        mysql::query($query);
        $query = "  DELETE FROM {$this->ParticipantTable} 
                    WHERE id_Dalyvis='{$id}'";
        mysql::query($query);
    }
}