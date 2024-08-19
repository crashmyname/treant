<?php

namespace Support;

use PDO;
use PDOException;

class BaseModel
{
    protected $table;
    protected $primaryKey = 'id';
    protected $attributes = [];
    protected $connection;
    protected $selectColumns = ['*'];
    protected $whereConditions = [];
    protected $whereParams = [];
    protected $joins = [];
    protected $groupBy;
    protected $orderBy = [];
    protected $distinct = '';
    protected $limit;
    protected $offset;

    public function __construct($attributes = [])
    {
        $this->attributes = $attributes;
        $this->connect();
    }

    private function connect()
    {
        try {
            $dsn = "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_DATABASE'];
            $this->connection = new PDO($dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }

    public static function create($attributes)
    {
        $instance = new static($attributes);
        $instance->save();
        return $instance;
    }

    public static function query()
    {
        return new static();
    }

    public function select(...$columns)
    {
        $this->selectColumns = empty($columns) ? ['*'] : $columns;
        return $this;
    }

    public function distinct($value = true)
    {
        $this->distinct = $value ? 'DISTINCT' : '';
        return $this;
    }

    public function where($column, $operator = '=', $value = null)
    {
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }

        $this->whereConditions[] = "{$column} {$operator} :{$column}";
        $this->whereParams[":{$column}"] = $value;
        return $this;
    }

    public function whereDate($column, $date)
    {
        return $this->where($column, '=', $date);
    }

    public function whereMonth($column, $month)
    {
        return $this->where("MONTH({$column})", '=', $month);
    }

    public function whereYear($column, $year)
    {
        return $this->where("YEAR({$column})", '=', $year);
    }

    public function join($table, $first, $operator, $second, $type = 'INNER')
    {
        $this->joins[] = "{$type} JOIN {$table} ON {$first} {$operator} {$second}";
        return $this;
    }

    public function groupBy($columns)
    {
        $this->groupBy = is_array($columns) ? implode(', ', $columns) : $columns;
        return $this;
    }

    public function orderBy($column, $direction = 'ASC')
    {
        $this->orderBy[] = "{$column} {$direction}";
        return $this;
    }

    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function offset($offset)
    {
        $this->offset = $offset;
        return $this;
    }

    public function get()
    {
        $sql = "SELECT {$this->distinct} " . implode(', ', $this->selectColumns) . " FROM {$this->table}";

        if (!empty($this->joins)) {
            $sql .= ' ' . implode(' ', $this->joins);
        }

        if (!empty($this->whereConditions)) {
            $sql .= ' WHERE ' . implode(' AND ', $this->whereConditions);
        }

        if (!empty($this->groupBy)) {
            $sql .= ' GROUP BY ' . $this->groupBy;
        }

        if (!empty($this->orderBy)) {
            $sql .= ' ORDER BY ' . implode(', ', $this->orderBy);
        }

        if ($this->limit !== null) {
            $sql .= ' LIMIT ' . (int)$this->limit;
        }

        if ($this->offset !== null) {
            $sql .= ' OFFSET ' . (int)$this->offset;
        }

        $stmt = $this->connection->prepare($sql);

        foreach ($this->whereParams as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function first()
    {
        $this->limit(1);
        $results = $this->get();
        return !empty($results) ? $results[0] : null;
    }

    public static function all()
    {
        $instance = new static();
        $sql = "SELECT * FROM {$instance->table}";
        $stmt = $instance->connection->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function count()
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table}";

        if (!empty($this->joins)) {
            $sql .= ' ' . implode(' ', $this->joins);
        }

        if (!empty($this->whereConditions)) {
            $sql .= ' WHERE ' . implode(' AND ', $this->whereConditions);
        }

        $stmt = $this->connection->prepare($sql);

        foreach ($this->whereParams as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['count'];
    }

    public function save()
    {
        if (isset($this->attributes[$this->primaryKey])) {
            $this->update();
        } else {
            $columns = implode(',', array_keys($this->attributes));
            $placeholders = ':' . implode(', :', array_keys($this->attributes));
            $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";

            $stmt = $this->connection->prepare($sql);

            foreach ($this->attributes as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }

            $stmt->execute();
            $this->attributes[$this->primaryKey] = $this->connection->lastInsertId();
        }
    }

    public function update()
    {
        $setClause = [];
        foreach ($this->attributes as $key => $value) {
            $setClause[] = "{$key} = :{$key}";
        }
        $setClause = implode(', ', $setClause);

        $sql = "UPDATE {$this->table} SET {$setClause} WHERE {$this->primaryKey} = :{$this->primaryKey}";

        $stmt = $this->connection->prepare($sql);

        foreach ($this->attributes as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }

        $stmt->execute();
    }

    public function delete()
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :{$this->primaryKey}";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':' . $this->primaryKey, $this->attributes[$this->primaryKey]);
        $stmt->execute();
    }

    public static function find($id)
    {
        $instance = new static();
        $sql = "SELECT * FROM {$instance->table} WHERE {$instance->primaryKey} = :id";
        $stmt = $instance->connection->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return new static($data);
        }

        return null;
    }

    public function toArray()
    {
        return $this->attributes;
    }

    public function __get($name)
    {
        return $this->attributes[$name] ?? null;
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }
}
?>