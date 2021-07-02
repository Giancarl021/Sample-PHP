<?php
// mysqli_report(MYSQLI_REPORT_ALL);
class PreparedStatement
{
    private $stmt;
    private const types = [
        "string" => "s",
        "integer" => "i",
        "double" => "d",
        "default" => "s"
    ];

    public function __construct($connection, $statement)
    {
        if (!$connection) throw new Exception("Invalid connection");
        $this->connection = $connection;

        $this->stmt = mysqli_prepare($connection, $statement);

        if (!$this->stmt) {
            throw new Exception(mysqli_error($this->connection));
        }
    }

    public function run($data = [])
    {
        if (!$this->stmt) throw new Exception("Invalid statement");

        $types = "";

        foreach ($data as $param) {
            $type = gettype($param);

            if (isset(self::types[$type])) {
                $param_type = self::types[$type];
            } else {
                $param_type = self::types["default"];
            }

            $types .= $param_type;
        }

        $rows = [];

        if (count($data) > 0) {
            mysqli_stmt_bind_param($this->stmt, $types, ...$data);
        }

        mysqli_stmt_execute($this->stmt);

        $result = mysqli_stmt_get_result($this->stmt);

        if (gettype($result) === "boolean") {
            return $result;
        }

        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }

        mysqli_stmt_close($this->stmt);

        return $rows;
    }
}

class MySQL
{
    private $connection;
    public function __construct($hostname, $username, $password, $database, $port = 3306)
    {
        $this->connection = mysqli_connect($hostname, $username, $password, $database, $port);

        if (mysqli_connect_errno()) {
            throw new Exception(mysqli_connect_error());
        }
    }

    public function prepare($statement)
    {
        if (!$this->connection) throw new Exception("Invalid connection");
        if (!$statement) throw new Exception("Invalid statement");

        return new PreparedStatement($this->connection, $statement);
    }

    public function query($query)
    {
        if (!$this->connection) throw new Exception("Invalid connection");
        if (!$query) throw new Exception("Invalid query");

        $result = mysqli_query($this->connection, $query);

        if (!$result) {
            throw new Exception(mysqli_error($this->connection));
            return;
        }

        $rows = $this->assoc_types($result);

        mysqli_free_result($result);

        return $rows;
    }

    public function close()
    {
        mysqli_close($this->connection);
    }

    private function assoc_types($result)
    {
        $fields = mysqli_fetch_fields($result);
        $data = [];
        $types = [];
        foreach ($fields as $field) {
            switch ($field->type) {
                case MYSQLI_TYPE_NULL:
                    $types[$field->name] = 'null';
                    break;
                case MYSQLI_TYPE_BIT:
                    $types[$field->name] = 'boolean';
                    break;
                case MYSQLI_TYPE_TINY:
                case MYSQLI_TYPE_SHORT:
                case MYSQLI_TYPE_LONG:
                case MYSQLI_TYPE_INT24:
                case MYSQLI_TYPE_LONGLONG:
                    $types[$field->name] = 'int';
                    break;
                case MYSQLI_TYPE_FLOAT:
                case MYSQLI_TYPE_DOUBLE:
                    $types[$field->name] = 'float';
                    break;
                default:
                    $types[$field->name] = 'string';
                    break;
            }
        }
        while ($row = mysqli_fetch_assoc($result)) array_push($data, $row);
        for ($i = 0; $i < count($data); $i++) {
            foreach ($types as $name => $type) {
                settype($data[$i][$name], $type);
            }
        }

        return $data;
    }
}
