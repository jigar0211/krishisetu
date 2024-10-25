<?php

error_reporting(E_ALL);
error_reporting(E_ERROR);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

class Database
{
    private $conn;
    private $join_tables = [];
    function __construct()
    {
        $dsn = "mysql:host=" . HOSTNAME . ";dbname=" . DATABASE . ";";
        $db_user = USERNAME;
        $db_password = PASSWORD;
        try {
            $this->conn = new PDO($dsn, $db_user, $db_password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function joins($type, $table, $on)
    {
        $this->join_tables[] = "{$type} JOIN {$table} ON {$on}";
    }
    
    public function Insert($tablename, $values = array())
    {
        $sql = "INSERT INTO {$tablename} (`" . implode("`, `", array_keys($values)) . "`) VALUES (:" . implode(", :", array_keys($values)) . ")";
        $int_qry = $this->conn->prepare($sql);

        $prefix = ":";
        $array = array_combine(
            array_map(
                function ($k) use ($prefix) {
                    return $prefix . $k;
                },
                array_keys($values)
            ),
            $values
        );

        if ($int_qry->execute($array)) {
            return $this->conn->lastInsertId();
        } else {
            return false;
        }
    }
    public function query($sql)
    {
        return $this->conn->prepare($sql);
    }
    public function Update($tablename, $values, $where)
    {
        $sql = "UPDATE {$tablename} SET ";

        $keys = array_keys($values);
        $sql_parts = [];
        foreach ($keys as $key) {
            $sql_parts[] = "`{$key}`=:{$key}";
        }
        $sql .= implode(", ", $sql_parts);
        $sql .= " WHERE ";
        $keys = array_keys($where);
        $sql_parts = [];
        foreach ($keys as $key) {
            $sql_parts[] = "`{$key}`=:{$key}";
        }
        $sql .= implode(" AND ", $sql_parts);

        $int_qry = $this->conn->prepare($sql);

        $mix_array = array_merge($values, $where);

        $prefix = ":";
        $array = array_combine(
            array_map(
                function ($k) use ($prefix) {
                    return $prefix . $k;
                },
                array_keys($mix_array)
            ),
            $mix_array
        );

        if ($int_qry->execute($array)) {
            return true;
        } else {
            return false;
        }
    }

    public function Delete($tablename, $where)
    {
        $sql = "DELETE FROM {$tablename}";

        $sql .= " WHERE ";
        $keys = array_keys($where);
        $sql_parts = [];
        foreach ($keys as $key) {
            $sql_parts[] = "`{$key}`=:{$key}";
        }
        $sql .= implode(" AND ", $sql_parts);

        $int_qry = $this->conn->prepare($sql);
        $prefix = ":";
        $array = array_combine(
            array_map(
                function ($k) use ($prefix) {
                    return $prefix . $k;
                },
                array_keys($where)
            ),
            $where
        );


        if ($int_qry->execute($array)) {
            return true;
        } else {
            return false;
        }
    }

    public function prepareWhere($where, $cond_type = "AND", $cond = "=")
    {
        $sql = '';
        $keys = array_keys($where);
        $sql_parts = [];
        foreach ($keys as $key) {
            $sql_parts[] = "`{$key}` {$cond} :{$key}";
        }
        $sql = implode(" {$cond_type} ", $sql_parts);

        $prefix = ":";
        $array = array_combine(
            array_map(
                function ($k) use ($prefix) {
                    return $prefix . $k;
                },
                array_keys($where)
            ),
            $where
        );
        return [$sql, $array];
    }

    public function list($tablename, $where = null, $cond_type = "AND", $start = 0, $limit = 10)
    {
        $sql = "SELECT * FROM {$tablename}";
        $array = [];
        if (!is_null($where) && is_array($where)) {
            $sql .= " WHERE ";
            foreach ($where as $key => $cond) {
                $sql_parts[] = $cond[0];
                $array = array_merge($array, $cond[1]);
            }
            $sql .= implode(" {$cond_type} ", $sql_parts);
        }
        $sql .= " LIMIT {$start}, {$limit}";

        $int_qry = $this->conn->prepare($sql);
        $int_qry->execute($array);

        $data['rows'] = $int_qry->fetchAll(PDO::FETCH_OBJ);

        $count_sql = "SELECT COUNT(*) as count FROM {$tablename}";
        if (!empty($where)) {
            $count_sql .= " WHERE ";
            $count_sql .= implode(" {$cond_type} ", $sql_parts);
        }
        $count_qry = $this->conn->prepare($count_sql);
        $count_qry->execute($array);

        $data['total'] = $count_qry->fetch(PDO::FETCH_OBJ)->count;

        return $data;
    }

    /*
    $conditions = [
        [
            'where' => ['email' => 'admin@local.com', 'mobile' => 'admin@local.com'],
            'groupCondition' => 'OR'
        ],
        [
            'where' => ['role' => 'admin', 'status' => 'active'],
            'groupCondition' => 'AND'
        ]
    ];
     */

    public function get($tablename, $select, $conditions, $fixedCondition = null)
    {
        $sql = "SELECT {$select} FROM {$tablename}";

        if (count($this->join_tables)) {
            $sql .= implode(" ", $this->join_tables);
        }

        $sql .= " WHERE ";

        // Prepare parts of the condition (each group)
        $sql_parts = [];

        // Process the dynamic conditions with group logic
        foreach ($conditions as $group) {
            $group_conditions = [];

            foreach ($group['where'] as $key => $value) {
                $group_conditions[] = "`{$key}`=:{$key}";
            }

            // Combine group conditions using the specified groupCondition ('AND' or 'OR')
            $sql_parts[] = '(' . implode(" {$group['groupCondition']} ", $group_conditions) . ')';
        }

        // Join all groups with 'AND' (you can modify this logic if needed)
        $sql .= implode(" AND ", $sql_parts);

        // Append fixed condition if provided (e.g., is_enabled = 1)
        if ($fixedCondition) {
            $sql .= " {$fixedCondition} ";
        }

        // Prepare the query
        $int_qry = $this->conn->prepare($sql);

        // Flatten the parameters for binding
        $array = [];
        foreach ($conditions as $group) {
            $array = array_merge($array, $group['where']);
        }

        // Prefix the keys with ':'
        $prefix = ":";
        $array = array_combine(
            array_map(
                function ($k) use ($prefix) {
                    return $prefix . $k;
                },
                array_keys($array)
            ),
            $array
        );

        // Execute the query
        $int_qry->execute($array);
        // $int_qry->debugDumpParams();
        // Fetch and return the result
        return $int_qry->fetch(PDO::FETCH_ASSOC);
    }

    public function select($tablename, $select = "*", $conditions = array(), $fixedCondition = null)
    {
        $sql = " SELECT {$select} FROM {$tablename} ";

        if (count($this->join_tables)) {
            $sql .= implode(" ", $this->join_tables);
        }

        if (!empty($conditions))
            $sql .= " WHERE ";

        // Prepare parts of the condition (each group)
        $sql_parts = [];

        // Process the dynamic conditions with group logic
        foreach ($conditions as $group) {
            $group_conditions = [];

            foreach ($group['where'] as $key => $value) {
                $cols = explode(".", $key);
                if (count($cols) ==2){
                    $col = $cols[0] . ".`{$cols[1]}`";
                }else{
                    $col = "`{$key}`";
                }
                $group_conditions[] = "{$col}=:" . str_replace('.', '_', $key);
            }

            // Combine group conditions using the specified groupCondition ('AND' or 'OR')
            $sql_parts[] = '(' . implode(" {$group['groupCondition']} ", $group_conditions) . ')';
        }

        // Join all groups with 'AND' (you can modify this logic if needed)
        $sql .= implode(" AND ", $sql_parts);

        // Append fixed condition if provided (e.g., is_enabled = 1)
        if ($fixedCondition) {
            $sql .= " {$fixedCondition}";
        }

        // Prepare the query
        $int_qry = $this->conn->prepare($sql);

        // Flatten the parameters for binding
        $array = [];
        foreach ($conditions as $group) {
            $array = array_merge($array, $group['where']);
        }

        // Prefix the keys with ':'
        $prefix = ":";
        $array = array_combine(
            array_map(
                function ($k) use ($prefix) {
                    return $prefix . str_replace('.', '_', $k);
                },
                array_keys($array)
            ),
            $array
        );
        
        // Execute the query
        $int_qry->execute($array);
        // $int_qry->debugDumpParams();
        // Fetch and return the result
        return $int_qry->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetch($tablename, $id)
    {
        $sql = "SELECT * FROM {$tablename} WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function val($table, $column, $value)
    {
        $query = "SELECT * FROM $table WHERE $column = :value";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':value', $value);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function set_setting($key, $value)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO settings (params, params_val)
        VALUES (:params, :params_val)
        ON DUPLICATE KEY UPDATE params_val = :params_val_update"
        );

        $stmt->bindParam(':params', $key);
        $stmt->bindParam(':params_val', $value);
        $stmt->bindParam(':params_val_update', $value);
        $stmt->execute();
    }
    public function fetchAll($tableName)
    {
        $query = "SELECT * FROM {$tableName}";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        // Fetch all results as an associative array
        return $stmt->fetchAll(PDO::FETCH_OBJ); // Use PDO::FETCH_ASSOC for associative arrays
    }

    public function logUserAction($user_id, $action_details, $page)
    {
        $serialized_action = serialize($action_details);
        $current_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO user_logs (user_id, action, page, log_date_time) VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $user_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $serialized_action, PDO::PARAM_STR);
        $stmt->bindParam(3, $page, PDO::PARAM_STR);
        $stmt->bindParam(4, $current_date, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

        $stmt->close();
    }

    public function SelectOne($table, $conditions)
    {
        $sql = "SELECT * FROM " . $table . " WHERE ";
        $sql .= implode(" AND ", array_map(function ($key) {
            return "$key = :$key";
        }, array_keys($conditions)));
        $stmt = $this->conn->prepare($sql);

        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
