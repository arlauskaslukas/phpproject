<?php


class place
{
    private $PlaceTable = "";

    public function __construct()
    {
        $this->PlaceTable = config::DB_PREFIX . 'vieta';
    }
    public function getPlace($id)
    {
        $query = "SELECT * FROM {$this->PlaceTable} WHERE ID = {$id}";
        $data = mysql::select($query);
        return $data[0];
    }
    public function getPlacesList($limit = null, $offset = null) {
        $limitOffsetString = "";
        if(isset($limit)) {
            $limitOffsetString .= " LIMIT {$limit}";

            if(isset($offset)) {
                $limitOffsetString .= " OFFSET {$offset}";
            }
        }

        $query = "  SELECT *
					FROM {$this->PlaceTable}{$limitOffsetString}";
        $data = mysql::select($query);

        return $data;
    }
    public function getPlaceCount() {
        $query = "  SELECT COUNT(`ID`) as `kiekis`
					FROM {$this->PlaceTable}";
        $data = mysql::select($query);

        return $data[0]['kiekis'];
    }
    public function insertPlace($data)
    {
        $query = "INSERT INTO {$this->PlaceTable}
                            (
                                ID,
                                Pavadinimas,
                                Tipas,
                                Darbo_pradzia,
                                Ikurimo_laikas,
                                Reitingai,
                                Darbo_pabaiga
                            )
                            VALUES
                            (
                                '{$data['ID']}',
                                '{$data['Pavadinimas']}',
                                '{$data['Tipas']}',
                                '{$data['Darbo_pradzia']}',
                                '{$data['Ikurimo_laikas']}',
                                '{$data['Reitingai']}',
                                '{$data['Darbo_pabaiga']}'
                            )
        ";
        mysql::query($query);
    }

    public function updatePlace($data)
    {
        $query = "UPDATE {$this->PlaceTable}
                    SET     ID='{$data['ID']}',
                            Pavadinimas='{$data['Pavadinimas']}',
                            Tipas='{$data['Tipas']}',
                            Darbo_pradzia='{$data['Darbo_pradzia']}',
                            Ikurimo_laikas='{$data['Ikurimo_laikas']}',
                            Reitingai='{$data['Reitingai']}',
                            Darbo_pabaiga='{$data['Darbo_pabaiga']}'
                    WHERE   ID={$data['ID']}";
        mysql::query($query);
    }

    public function deletePlace($id)
    {
        $query = "  DELETE FROM {$this->PlaceTable} WHERE ID='{$id}'";
        mysql::query($query);
    }
}