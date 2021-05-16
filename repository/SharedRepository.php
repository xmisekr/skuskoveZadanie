<?php

include_once 'Repository.php';

class SharedRepository extends Repository{
    public function __construct(){
        parent::__construct();
    }

    public function __destruct(){
        parent::__destruct();
    }

    public function executeConditionQuery($sql, $data){
        $statement = $this->connection->prepare($sql);

        if ($statement){
            $values = array_map(fn ($value) => is_array($value) ? implode(',', $value) : $value, array_values($data));
            $types = str_repeat('s', count($values));
            $statement->bind_param($types, ...$values);
            $statement->execute();

            return $statement;

        }else{
            $error = $this->connection->error;

        }
        return null;
    }

    private function joinConditions($sql, $conditions){
        $i = 0;
        foreach($conditions as $key => $value){
            if ($i == 0){
                $sql .=  is_array($value) ? " WHERE $key IN (?)" : " WHERE $key=?";
            }else{
                $sql .= is_array($value) ? " AND $key IN (?)" : " AND $key=?";
            }
            $i++;
        }

        return $sql;
    }

    public function selectAll($table, $conditions = []){
        $sql = "SELECT * FROM $table";

        if (empty($conditions)) {
            $statement = $this->connection->prepare($sql);

            $statement->execute();
            $records = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
    
        }else{
            $sql = $this->joinConditions($sql, $conditions);
           
            $statement = $this->executeConditionQuery($sql,$conditions);
            $records = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
        }

      
        return $records;
    }

    public function findById(string $tableName, int $id): ?array {
        return $this->selectOne($tableName, [
            'id' => $id,
        ]);
    }

    public function selectOne($table, $conditions){
        $sql = "SELECT * FROM $table";

        $sql = $this->joinConditions($sql, $conditions);
        $sql = $sql . " LIMIT 1";

        $statement = $this->executeConditionQuery($sql,$conditions);
        $records = $statement->get_result()->fetch_assoc();

        return $records;
    }


    public function delete($table, $id){
        $sql = "DELETE FROM $table WHERE id=?";

        $statement = $this->executeConditionQuery($sql, ['id' => $id]);

        return $statement;
    }

    public function update($table, $id, $data){
        $sql = "UPDATE $table SET ";

        $i = 0;
        foreach($data as $key => $value){
            if ($i == 0){
                $sql = $sql . " $key=?";
            }else{
                $sql = $sql . ", $key=?";
            }
            $i++;
        }
        $sql = $sql. " WHERE id=?";

        $data['id'] = $id;
        $statement = $this->executeConditionQuery($sql,$data);

        return $statement;        
    }

    public function insert($table, $data){
        $sql = "INSERT INTO $table (";

        $i = 0;
        foreach($data as $key => $value){
            if ($i == 0){
                $sql = $sql . "$key";
            }else{
                $sql = $sql . ", $key";
            }
            $i++;
        }
        $sql = $sql . ") VALUES (";

        $i = 0;
        foreach($data as $key => $value){
            if ($i == 0){
                $sql = $sql . "?";
            }else{
                $sql = $sql . ", ?";
            }
            $i++;
        }
        $sql = $sql . ")";

        $statement = $this->executeConditionQuery($sql,$data);
        return $statement;
    }
}