<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Database
{
    private static $instance = null;
    private $pdo;

    public function __construct($dbname = null)
    {
        try {
            // Get DB credentials from Render Environment Variables
            $host     = getenv('DB_HOST');
            $dbname   = getenv('DB_NAME');
            $username = getenv('DB_USER');
            $password = getenv('DB_PASS');
            $port     = getenv('DB_PORT') ?: 3306;

            if (!$host || !$dbname || !$username) {
                throw new Exception("Database environment variables not set.");
            }

            // Build DSN string for PDO
            $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";

            // Create PDO instance
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
}
