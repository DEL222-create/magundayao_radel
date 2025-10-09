<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Database
{
    private static $instance = null;
    private $pdo;

    // For query builder style
    private $table;
    private $where = '';
    private $params = [];

    public function __construct($dbname = null)
    {
        try {
            $host     = getenv('DB_HOST');
            $dbname   = getenv('DB_NAME');
            $username = getenv('DB_USER');
            $password = getenv('DB_PASS');
            $port     = getenv('DB_PORT') ?: 3306;

            if (!$host || !$dbname || !$username) {
                throw new Exception("Database environment variables not set.");
            }

            $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
            $this->pdo = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (Exception $e) {
            die("DB Connection failed: " . $e->getMessage());
        }
    }

    public static function instance($dbname = null)
    {
        if (self::$instance === null) {
            self::$instance = new Database($dbname);
        }
        return self::$instance;
    }

    /** ================= CORE QUERY HELPERS ================= **/

    public function query($sql, $params = [])
{
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}


    public function fetch($sql, $params = [])
    {
        return $this->query($sql, $params)->fetch();
    }

    public function fetchAll($sql, $params = [])
    {
        return $this->query($sql, $params)->fetchAll();
    }

    /** ================= LAVALUST STYLE ALIASES ================= **/

    public function get_row($sql, $params = [])
    {
        return $this->fetch($sql, $params);
    }

    public function get_all($sql, $params = [])
    {
        return $this->fetchAll($sql, $params);
    }

    /** ================= CRUD HELPERS ================= **/

    public function insert($table, $data)
    {
        $keys = implode(',', array_keys($data));
        $placeholders = ':' . implode(',:', array_keys($data));
        $sql = "INSERT INTO {$table} ({$keys}) VALUES ({$placeholders})";
        $this->query($sql, $data);
        return $this->pdo->lastInsertId();
    }

    public function update($table, $data, $where)
    {
        $set = implode(', ', array_map(fn($k) => "$k = :$k", array_keys($data)));
        $whereClause = implode(' AND ', array_map(fn($k) => "$k = :where_$k", array_keys($where)));

        $params = $data;
        foreach ($where as $k => $v) {
            $params["where_$k"] = $v;
        }

        $sql = "UPDATE {$table} SET {$set} WHERE {$whereClause}";
        return $this->query($sql, $params);
    }

    public function delete($table, $where)
    {
        $whereClause = implode(' AND ', array_map(fn($k) => "$k = :$k", array_keys($where)));
        $sql = "DELETE FROM {$table} WHERE {$whereClause}";
        return $this->query($sql, $where);
    }

    /** ================= CHAINABLE QUERY BUILDER ================= **/

    public function table($table)
    {
        $this->table = $table;
        $this->where = '';
        $this->params = [];
        return $this;
    }

    public function where($column, $value)
    {
        $this->where = "WHERE {$column} = :{$column}";
        $this->params = [$column => $value];
        return $this;
    }

    public function get()
    {
        $sql = "SELECT * FROM {$this->table} {$this->where} LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table} {$this->where}";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
