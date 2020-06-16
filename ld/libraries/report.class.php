<?php

class report
{
    private $PlaceTable = '';
    private $EventsTable = '';
    private $HostTable = '';
    private $ParticipantsTable = '';
    private $ParticipatedTable = '';
    private $PersonTable = '';

    public function __construct()
    {
        $this->PersonTable = config::DB_PREFIX . 'asmuo';
        $this->PlaceTable = config::DB_PREFIX . 'vieta';
        $this->EventsTable = config::DB_PREFIX . 'renginys';
        $this->HostTable = config::DB_PREFIX . 'vedejas';
        $this->ParticipantsTable = config::DB_PREFIX . 'dalyvis';
        $this->ParticipatedTable = config::DB_PREFIX . 'dalyvauja';
    }
    public function getPlaceTypes()
    {
        $query = "SELECT DISTINCT(Tipas) FROM {$this->PlaceTable}";
        $data = mysql::select($query);
        return $data;
    }
    public function getReport($type, $from, $until)
    {
        $whereClause = '';
        if ($type != '-1') {
            $whereClause .= " WHERE {$this->PlaceTable}.Tipas = '{$type}'";
            if (!empty($from)) {
                $whereClause .= " AND {$this->EventsTable}.Data >='{$from}'";
            }
            if (!empty($until)) {
                $whereClause .= " AND {$this->EventsTable}.Data <= '{$until}'";
            }
        } elseif (!empty($from)) {
            $whereClause .= " WHERE {$this->EventsTable}.Data >='{$from}'";
            if (!empty($until)) {
                $whereClause .= " AND {$this->EventsTable}.Data <= '{$until}'";
            }
        } elseif (!empty($until)) {
            $whereClause .= " WHERE {$this->EventsTable}.Data <= '{$until}'";
        }
        $query = "SELECT {$this->PlaceTable}.Pavadinimas, 
        {$this->PlaceTable}.Tipas, 
        {$this->EventsTable}.Data, 
        CONCAT({$this->PersonTable}.Vardas, ' ', {$this->PersonTable}.Pavarde) AS Vedejas, 
        {$this->EventsTable}.ID AS rid, 
        (SELECT COUNT({$this->ParticipatedTable}.fk_Dalyvisid_Dalyvis) 
        FROM {$this->ParticipatedTable} 
        WHERE {$this->ParticipatedTable}.fk_RenginysID=rid) AS Kiekis,
        (SELECT 
        IFNULL(CAST(AVG({$this->PersonTable}.Amzius) AS int), '-') 
        FROM {$this->PersonTable} 
        INNER JOIN {$this->ParticipantsTable} ON {$this->ParticipantsTable}.fk_AsmuoAsmens_kodas=Asmens_kodas 
        INNER JOIN {$this->ParticipatedTable} ON {$this->ParticipantsTable}.id_Dalyvis={$this->ParticipatedTable}.fk_Dalyvisid_Dalyvis 
        INNER JOIN {$this->EventsTable} ON {$this->ParticipatedTable}.fk_RenginysID={$this->EventsTable}.ID 
        WHERE {$this->EventsTable}.ID=rid) AS Vidurkis
        FROM {$this->PlaceTable} 
        LEFT JOIN {$this->EventsTable} ON {$this->PlaceTable}.ID=fk_VietaID 
        INNER JOIN {$this->HostTable} ON {$this->EventsTable}.fk_VedejasVedejo_ID={$this->HostTable}.Vedejo_ID 
        AND {$this->EventsTable}.fk_VedejasDirba_nuo={$this->HostTable}.Dirba_nuo 
        AND {$this->EventsTable}.fk_VedejasDIrba_iki={$this->HostTable}.Dirba_iki
        INNER JOIN {$this->PersonTable} ON {$this->HostTable}.fk_AsmuoAsmens_kodas={$this->PersonTable}.Asmens_kodas
        {$whereClause}
        ORDER BY Pavadinimas ASC;
        ";
        $data = mysql::select($query);
        return $data;
    }
    public function getEmployees($rid)
    {
        $query = " SELECT COUNT(data) 
                    AS darb
                    FROM (
                    SELECT  CONCAT(apsauginis.Dirba_nuo, ' - ', apsauginis.Dirba_iki) 
                    AS data 
                    FROM apsauginis 
                    INNER JOIN organizavimo_samata 
                    ON apsauginis.fk_Organizavimo_samataSutarties_nr=organizavimo_samata.Sutarties_nr 
                    INNER JOIN vieta 
                    ON organizavimo_samata.fk_VietaID=vieta.ID 
                    INNER JOIN renginys 
                    ON vieta.ID=renginys.fk_VietaID 
                    WHERE renginys.ID='{$rid}'
                UNION ALL
                    SELECT 
                    CONCAT(ieinaikaina2.fk_DJDirba_nuo, ' - ', ieinaikaina2.fk_DJDirba_iki) 
                    AS data 
                    FROM ieinaikaina2 
                    INNER JOIN organizavimo_samata 
                    ON organizavimo_samata.Sutarties_nr=ieinaikaina2.fk_Organizavimo_samataSutarties_nr 
                    INNER JOIN vieta 
                    ON organizavimo_samata.fk_VietaID=vieta.ID 
                    INNER JOIN renginys 
                    ON vieta.ID=renginys.fk_VietaID 
                    WHERE renginys.ID='{$rid}'
                UNION ALL
                    SELECT CONCAT(ieinaikaina3.fk_BarmenasDirba_nuo, ' - ', ieinaikaina3.fk_BarmenasDirba_iki) 
                    AS data FROM ieinaikaina3 
                    INNER JOIN organizavimo_samata 
                    ON organizavimo_samata.Sutarties_nr=ieinaikaina3.fk_Organizavimo_samataSutarties_nr 
                    INNER JOIN vieta 
                    ON organizavimo_samata.fk_VietaID=vieta.ID 
                    INNER JOIN renginys 
                    ON vieta.ID=renginys.fk_VietaID 
                    WHERE renginys.ID='{$rid}'
                UNION ALL
                    SELECT 
                    CONCAT(renginys.fk_VedejasDirba_nuo, ' - ', renginys.fk_VedejasDIrba_iki) 
                    AS data
                    FROM renginys 
                    WHERE renginys.ID='{$rid}') 
                    AS data
        ";
        $data = mysql::select($query);
        return $data[0]['darb'];
    }
    public function getParticipants($rid, $place)
    {
        $query = " SELECT CONCAT(asmuo.Vardas, ' ', asmuo.Pavarde) AS Dalyvis, 
        asmuo.Amzius, IF(dalyvis.Megstamiausia_vieta='{$place}', 'Ši vieta megstamiausia', 'Ne ši vieta megstamiausia') AS megst
        FROM asmuo 
        INNER JOIN dalyvis 
        ON dalyvis.fk_AsmuoAsmens_kodas=asmuo.Asmens_kodas 
        INNER JOIN dalyvauja 
        ON dalyvis.id_Dalyvis = dalyvauja.fk_Dalyvisid_Dalyvis 
        WHERE dalyvauja.fk_RenginysID = '{$rid}'        
        ";
        $data = mysql::select($query);
        return $data;
    }
    public function getSumParticipants($name)
    {
        $query = "SELECT SUM(kiekis) AS sum FROM (SELECT
        IFNULL(COUNT(dalyvauja.fk_Dalyvisid_Dalyvis), 0) AS kiekis
        FROM dalyvauja
        INNER JOIN renginys ON renginys.ID=dalyvauja.fk_RenginysID
        INNER JOIN vieta ON renginys.fk_VietaID=vieta.ID
        WHERE vieta.Pavadinimas='{$name}'
        ) AS sum;";
        $data = mysql::select($query);
        return $data[0]['sum'];
    }
    public function getSumAll($type, $from, $until)
    {
        $whereClause = '';
        if ($type != '-1') {
            $whereClause .= " WHERE {$this->PlaceTable}.Tipas = '{$type}'";
            if (!empty($from)) {
                $whereClause .= " AND {$this->EventsTable}.Data >='{$from}'";
            }
            if (!empty($until)) {
                $whereClause .= " AND {$this->EventsTable}.Data <= '{$until}'";
            }
        } elseif (!empty($from)) {
            $whereClause .= " WHERE {$this->EventsTable}.Data >='{$from}'";
            if (!empty($until)) {
                $whereClause .= " AND {$this->EventsTable}.Data <= '{$until}'";
            }
        } elseif (!empty($until)) {
            $whereClause .= " WHERE {$this->EventsTable}.Data <= '{$until}'";
        }
        $query = "SELECT COUNT(dalyvauja.fk_Dalyvisid_Dalyvis) AS suma
        FROM dalyvauja
        INNER JOIN renginys ON renginys.ID=dalyvauja.fk_RenginysID
        INNER JOIN vieta ON vieta.ID=renginys.fk_VietaID
        {$whereClause}";

        $data = mysql::select($query);
        return $data[0]['suma'];
    }
    public function getFavPlaceCount($place, $rid)
    {
        $query = "SELECT COUNT(dalyviai) 
        as kiekis 
        FROM ( 
            SELECT dalyvis.id_Dalyvis 
            AS dalyviai 
            FROM dalyvis 
            INNER JOIN dalyvauja 
            ON dalyvis.id_Dalyvis=dalyvauja.fk_Dalyvisid_Dalyvis 
            INNER JOIN renginys 
            ON renginys.ID=dalyvauja.fk_RenginysID 
            INNER JOIN vieta 
            ON renginys.fk_VietaID=vieta.ID 
            WHERE dalyvis.Megstamiausia_vieta='{$place}' AND renginys.ID='{$rid}' ) as kiekis
        ";
        $data = mysql::select($query);
        return $data[0]['kiekis'];
    }
}
