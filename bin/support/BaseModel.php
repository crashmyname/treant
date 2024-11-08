<?php

namespace Support;

use PDO;
use PDOException;
use Config\Database;
use Support\DB;

class BaseModel
{
    protected $table;
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $guarded = [];
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
    protected $orWhereConditions = [];

    public function __construct($attributes = [])
    {
        $this->attributes = $this->filterAttributes($attributes);
        $this->connect();
    }

    private function connect()
    {
        $database = new Database();
        $this->connection = $database->getConnection();
        if ($this->connection === null) {
            die('Connection Failed');
        }
    }

    private function filterAttributes($attributes)
    {
        // Jika fillable diisi, hanya ambil atribut yang ada di fillable
        if (!empty($this->fillable)) {
            return array_intersect_key($attributes, array_flip($this->fillable));
        }

        // Jika guarded diisi, buang atribut yang ada di guarded
        if (!empty($this->guarded)) {
            return array_diff_key($attributes, array_flip($this->guarded));
        }

        return $attributes;
    }

    public function fill(array $attributes)
    {
        $this->attributes = array_merge($this->attributes, $this->filterAttributes($attributes));
    }

    public static function create($attributes)
    {
        $instance = new static($attributes);
        $instance->save();
        return $instance;
    }

    public function beginTransaction()
    {
        $this->connection->beginTransaction();
    }

    // Commit Transaksi
    public function commit()
    {
        $this->connection->commit();
    }

    // Rollback Transaksi
    public function rollback()
    {
        $this->connection->rollback();
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
        if ($value === null || $value == '') {
            if ($operator === '=') {
                $operator = 'IS';
            } elseif ($operator === '!=') {
                $operator = 'IS NOT';
            }
            // Handle cases where the value is null, we use IS or IS NOT
            $this->whereConditions[] = "{$column} {$operator} NULL";
        } else {
            // Generate unique placeholder for each where condition
            $paramName = str_replace('.', '_', $column) . '_' . count($this->whereParams);
            $this->whereConditions[] = "{$column} {$operator} :{$paramName}";
            $this->whereParams[":{$paramName}"] = $value;
        }

        return $this;
    }

    public function whereIn($column, array $values)
    {
        if (empty($values)) {
            throw new \InvalidArgumentException('The values array cannot be empty for whereIn condition.');
        }

        // Generate unique placeholders for each value
        $placeholders = [];
        foreach ($values as $index => $value) {
            $paramName = str_replace('.', '_', $column) . "_in_{$index}";
            $placeholders[] = ":{$paramName}";
            $this->whereParams[":{$paramName}"] = $value;
        }

        // Build the WHERE IN clause
        $placeholdersString = implode(', ', $placeholders);
        $this->whereConditions[] = "{$column} IN ({$placeholdersString})";

        return $this;
    }

    public function orWhere($column, $operator = '=', $value = null)
    {
        if ($value === null || $value == '') {
            if ($operator === '=') {
                $operator = 'IS';
            } elseif ($operator === '!=') {
                $operator = 'IS NOT';
            }
            $this->orWhereConditions[] = "{$column} {$operator} NULL";
        } else {
            $paramName = str_replace('.', '_', $column) . '_' . count($this->whereParams);
            $this->orWhereConditions[] = "{$column} {$operator} :{$paramName}";
            $this->whereParams[":{$paramName}"] = $value;
        }

        return $this;
    }

    public function whereDate($column, $date)
    {
        return $this->where($column, '=', $date);
    }

    public function whereMonth($column, $month)
    {
        // return $this->where("MONTH({$column})", '=', $month);
        $this->whereConditions[] = "MONTH({$column}) = :month";
        $this->whereParams[':month'] = $month;
        return $this;
    }

    public function whereYear($column, $year)
    {
        // return $this->where("YEAR({$column})", '=', $year);
        $this->whereConditions[] = "YEAR({$column}) = :year";
        $this->whereParams[':year'] = $year;
        return $this;
    }

    public function innerJoin($table, $first, $operator, $second)
    {
        return $this->join($table, $first, $operator, $second, 'INNER');
    }

    public function leftJoin($table, $first, $operator, $second)
    {
        return $this->join($table, $first, $operator, $second, 'LEFT');
    }

    public function rightJoin($table, $first, $operator, $second)
    {
        return $this->join($table, $first, $operator, $second, 'RIGHT');
    }

    public function outerJoin($table, $first, $operator, $second)
    {
        return $this->join($table, $first, $operator, $second, 'OUTER');
    }

    private function join($table, $first, $operator, $second, $type)
    {
        $validJoinTypes = ['INNER', 'LEFT', 'RIGHT', 'OUTER'];

        if (in_array(strtoupper($type), $validJoinTypes)) {
            $this->joins[] = "{$type} JOIN {$table} ON {$first} {$operator} {$second}";
        } else {
            throw new \InvalidArgumentException("Invalid join type: {$type}");
        }

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

        if (!empty($this->whereConditions) || !empty($this->orWhereConditions)) {
            $sql .= ' WHERE ';
            $conditions = [];

            if (!empty($this->whereConditions)) {
                $conditions[] = '(' . implode(' AND ', $this->whereConditions) . ')';
            }

            if (!empty($this->orWhereConditions)) {
                $conditions[] = '(' . implode(' OR ', $this->orWhereConditions) . ')';
            }

            $sql .= implode(' AND ', $conditions); // Gabung AND dan OR dengan benar
        }

        if (!empty($this->groupBy)) {
            $sql .= ' GROUP BY ' . $this->groupBy;
        }

        if (!empty($this->orderBy)) {
            $sql .= ' ORDER BY ' . implode(', ', $this->orderBy);
        }

        if ($this->limit !== null) {
            $sql .= ' LIMIT ' . (int) $this->limit;
        }

        if ($this->offset !== null) {
            $sql .= ' OFFSET ' . (int) $this->offset;
        }

        $stmt = $this->connection->prepare($sql);

        foreach ($this->whereParams as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function toSql()
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
            $sql .= ' LIMIT ' . (int) $this->limit;
        }

        if ($this->offset !== null) {
            $sql .= ' OFFSET ' . (int) $this->offset;
        }

        return $sql;
    }

    public function first()
    {
        $this->limit(1);
        $results = $this->get();
        if (!empty($results)) {
            return new static($results[0]);
        }
        return null;
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

        if (!empty($this->whereConditions) || !empty($this->orWhereConditions)) {
            $sql .= ' WHERE ';
            $conditions = [];

            // Memasukkan where conditions
            if (!empty($this->whereConditions)) {
                $conditions[] = '(' . implode(' AND ', $this->whereConditions) . ')';
            }

            // Memasukkan orWhere conditions
            if (!empty($this->orWhereConditions)) {
                $conditions[] = '(' . implode(' OR ', $this->orWhereConditions) . ')';
            }

            // Gabungkan semua kondisi
            $sql .= implode(' AND ', $conditions);
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
        $this->connection = DB::getConnection();
        if (isset($this->attributes[$this->primaryKey])) {
            $this->updates();
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

    public function updates()
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
    public function update($data)
    {
        // Buat klausa SET untuk SQL query
        $this->connection = DB::getConnection();
        $setClause = [];
        foreach ($data as $key => $value) {
            $setClause[] = "{$key} = :{$key}";
        }
        $setClause = implode(', ', $setClause);

        // Siapkan SQL query untuk update
        $sql = "UPDATE {$this->table} SET {$setClause} WHERE {$this->primaryKey} = :{$this->primaryKey}";

        // Siapkan statement
        $stmt = $this->connection->prepare($sql);

        // Bind data baru yang akan diupdate
        foreach ($data as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }

        // Bind primary key untuk WHERE clause
        $stmt->bindValue(':' . $this->primaryKey, $this->attributes[$this->primaryKey]);

        // Eksekusi query
        $stmt->execute();
    }

    public function hasOne($relatedModel, $foreignKey, $localKey = 'id')
    {
        $relatedInstance = new $relatedModel();
        $relatedInstance->where($foreignKey, '=', $this->attributes[$localKey]);
        return $relatedInstance->first();
    }

    // One-to-Many relationship
    public function hasMany($relatedModel, $foreignKey, $localKey = 'id')
    {
        $relatedInstance = new $relatedModel();
        return $relatedInstance->where($foreignKey, '=', $this->attributes[$localKey])->get();
    }

    // Belongs-to relationship
    public function belongsTo($relatedModel, $foreignKey, $ownerKey = 'id')
    {
        $relatedInstance = new $relatedModel();
        return $relatedInstance->where($ownerKey, '=', $this->attributes[$foreignKey])->first();
    }

    // Many-to-Many relationship
    public function belongsToMany($relatedModel, $pivotTable, $foreignKey, $relatedKey, $localKey = 'id', $relatedLocalKey = 'id')
    {
        $relatedInstance = new $relatedModel();
        $query = "SELECT {$relatedInstance->table}.* FROM {$relatedInstance->table} 
                  INNER JOIN {$pivotTable} ON {$relatedInstance->table}.{$relatedLocalKey} = {$pivotTable}.{$relatedKey}
                  WHERE {$pivotTable}.{$foreignKey} = :local_key";

        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(':local_key', $this->attributes[$localKey]);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
