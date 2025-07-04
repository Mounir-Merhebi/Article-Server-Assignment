<?php 
abstract class Model{

    protected static string $table;
    protected static string $primary_key = "id";

    public static function find(mysqli $mysqli, int $id){
        $sql = sprintf("Select * from %s WHERE %s = ?", 
                        static::$table, 
                        static::$primary_key);
        
        $query = $mysqli->prepare($sql);
        $query->bind_param("i", $id);
        $query->execute();

        $data = $query->get_result()->fetch_assoc();

        return $data ? new static($data) : null;
    }

    public static function all(mysqli $mysqli){
        $sql = sprintf("Select * from %s", static::$table);
        
        $query = $mysqli->prepare($sql);
        $query->execute();

        $data = $query->get_result();

        $objects = [];
        while($row = $data->fetch_assoc()){
            $objects[] = new static($row); //creating an object of type "static" / "parent" and adding the object to the array
        }

        return $objects; //we are returning an array of objects!!!!!!!!
    }

    public static function create(mysqli $mysqli, array $data)
    {
        $tableName = static::$table;
        $columns = array_keys($data);
        $columnsSql = implode(', ', $columns);
        $placeholders = implode(', ', array_fill(0, count($columns), '?'));

        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            $tableName,
            $columnsSql,
            $placeholders
        );

        $query = $mysqli->prepare($sql);

        if ($query === false) {
            error_log("Failed to prepare statement: " . $mysqli->error);
            return false;
        }

        $types = '';
        $values = [];

        foreach ($data as $key => $value) {
            if (is_int($value)) {
                $types .= 'i';
            } elseif (is_float($value)) {
                $types .= 'd';
            } elseif (is_string($value)) {
                $types .= 's';
            } elseif (is_bool($value)) {
                $types .= 'i';
                $value = (int)$value;
            } elseif (is_null($value)) {
                $types .= 's';
            } else {
                $types .= 's';
                $value = (string)$value;
            }
            $values[] = $value;
        }

        if (!empty($values)) {
            $bindResult = $query->bind_param($types, ...$values);
            if ($bindResult === false) {
                error_log("Failed to bind parameters: " . $query->error);
                $query->close();
                return false;
            }
        }
        $executeResult = $query->execute();
        if ($executeResult === false) { 
            error_log("Failed to execute statement: " . $query->error);
            $query->close();
            return false;
        }
        $newId = $mysqli->insert_id;

        $query->close();

        return $newId;
    }


    public static function deleteAll(mysqli $mysqli): bool
    {
        $sql = sprintf("DELETE FROM %s", static::$table);
        
        $query = $mysqli->prepare($sql);
        if ($query === false) {
            error_log("Failed to prepare delete statement: " . $mysqli->error);
            return false;
        }
        
        $executeResult = $query->execute();
        
        if ($executeResult === false) {
            error_log("Failed to execute delete statement: " . $query->error);
        }

        $rowsAffected = $query->affected_rows;
        $query->close();

        return $rowsAffected > 0;
    }


    public static function delete(mysqli $mysqli, int $id): bool
    {
        $sql = sprintf("DELETE FROM %s WHERE %s = ?", static::$table, static::$primary_key);
        
        $query = $mysqli->prepare($sql);
        if ($query === false) {
            error_log("Failed to prepare delete statement: " . $mysqli->error);
            return false;
        }

        $query->bind_param("i", $id);
        
        $executeResult = $query->execute();
        
        if ($executeResult === false) {
            error_log("Failed to execute delete statement: " . $query->error);
        }

        $rowsAffected = $query->affected_rows;
        $query->close();

        return $rowsAffected > 0;
    }


    public static function update(mysqli $mysqli, array $data): bool {
        $table = static::$table;
        $primary_key = static::$primary_key;
    
        if (!isset($data[$primary_key])) {
            error_log("Primary key '$primary_key' is missing in update data.");
            return false;
        }
    
        $id = $data[$primary_key];
        unset($data[$primary_key]);
    
        $columns = array_keys($data);
        $values = array_values($data);
    
        $columnArray = [];
        foreach ($columns as $column) {
            $columnArray[] = "$column = ?";
        }
        $columnsString = implode(', ', $columnArray);
        $values[] = $id;
   
        $types = '';
        foreach ($values as $value) {
            if (is_int($value)) {
                $types .= 'i';
            } elseif (is_float($value)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }
        }
    
        $sql = sprintf("UPDATE %s SET %s WHERE %s = ?", $table, $columnsString, $primary_key);
        $query = $mysqli->prepare($sql);
        if (!$query) {
            error_log("Failed to prepare update statement: " . $mysqli->error);
            return false;
        }
    
        $query->bind_param($types, ...$values);
        $success = $query->execute();
        $query->close();
    
        return $success;
    }
    
    


    //you have to continue with the same mindset
    //Find a solution for sending the $mysqli everytime... 
    //Implement the following: 
    //1- update() -> non-static function 
    //2- create() -> static function
    //3- delete() -> static function 
}



