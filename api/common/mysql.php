<?php

class PreparedStatement
{
    private $stmt, $result;
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
    }

    public function run($data = [])
    {
        if (!$this->stmt) throw new Exception("Invalid statement");

        foreach ($data as $param) {
            $type = gettype($param);

            if (isset(self::types[$type])) {
                $param_type = self::types[$type];
            } else {
                $param_type = self::types["default"];
            }

            mysqli_stmt_bind_param($this->stmt, $param_type, $param);
        }

        mysqli_stmt_execute($this->stmt);

        mysqli_stmt_bind_result($this->stmt, $this->result);
        mysqli_stmt_fetch($this->stmt);

        mysqli_stmt_close($this->stmt);

        return $this->result;
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
        if (!$this->statement) throw new Exception("Invalid statement");

        return new PreparedStatement($this->connection, $statement);
    }
}
