<?php

class person {

    private $PersonTable = "";
    
    public function __construct()
    {
        $this->PersonTable = config::DB_PREFIX . 'asmuo';
    }

    public function getPerson($personCode)
    {
        $query = "SELECT * FROM {$this->PersonTable} WHERE Asmens_kodas = {$personCode}";
        $data = mysql::select($query);
        return $data[0];
    }

    public function getPersonList($limit = null, $offset = null) {
		$limitOffsetString = "";
		if(isset($limit)) {
			$limitOffsetString .= " LIMIT {$limit}";
			
			if(isset($offset)) {
				$limitOffsetString .= " OFFSET {$offset}";
			}	
		}
		
		$query = "  SELECT *
					FROM {$this->PersonTable}{$limitOffsetString}";
		$data = mysql::select($query);
		
		return $data;
    }

    public function getPersonCount() {
		$query = "  SELECT COUNT(`Asmens_kodas`) as `kiekis`
					FROM {$this->PersonTable}";
		$data = mysql::select($query);
		
		return $data[0]['kiekis'];
	}

    public function checkIfRemovable($id)
    {
        $tables = array('apsauginis', 'barmenas', 'dalyvis', 'dj', 'vedejas');
        foreach($tables as $table)
        {
            $query = "SELECT COUNT(`fk_AsmuoAsmens_kodas`) as `kiekis` FROM {$table} WHERE fk_AsmuoAsmens_kodas={$id}";
            $data = mysql::select($query);
            if($data[0]['kiekis']!=0) return false;
        }
        return true;
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
    
    public function updatePerson($data)
    {
        $query = "UPDATE {$this->PersonTable}
                    SET     Asmens_kodas='{$data['Asmens_kodas']}',
                            Lytis='{$data['Lytis']}',
                            Vardas='{$data['Vardas']}',
                            Pavarde='{$data['Pavarde']}',
                            Amzius='{$data['Amzius']}'
                    WHERE   Asmens_kodas={$data['Asmens_kodas']}";
        mysql::query($query);
    }

    public function deletePerson($personCode)
    {
        $query = "  DELETE FROM {$this->PersonTable} WHERE Asmens_kodas='{$personCode}'";
        mysql::query($query);
    }
}