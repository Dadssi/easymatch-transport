<?php 

namespace app\core;
use app\core\Database;

trait Model {
    
    use Database;

    // protected $table = "";
    protected $primaryKey = "id";
    // protected $allowedColumns = [];
    protected $limit = 10;
    protected $offset = 0;
    protected $orderColumn = "id";
    protected $orderType = "DESC";
    public $errors = [];

    // 🔍 Récupérer tous les enregistrements
    public function findAll() {
        $query = "SELECT * FROM $this->table ORDER BY $this->orderColumn $this->orderType LIMIT $this->limit OFFSET $this->offset";
        return $this->query($query);
    }

    // 🔍 Récupérer un enregistrement avec condition
    public function where($conditions, $exclude = []) {
        $query = "SELECT * FROM $this->table WHERE ";
        $params = [];

        foreach ($conditions as $key => $value) {
            $query .= "$key = :$key AND ";
            $params[$key] = $value;
        }

        foreach ($exclude as $key => $value) {
            $query .= "$key != :not_$key AND ";
            $params["not_$key"] = $value;
        }

        $query = rtrim($query, " AND ");
        $query .= " ORDER BY $this->orderColumn $this->orderType LIMIT $this->limit OFFSET $this->offset";

        return $this->query($query, $params);
    }

    // 🔍 Récupérer un seul enregistrement
    public function first($conditions, $exclude = []) {
        $results = $this->where($conditions, $exclude);
        return $results ? $results[0] : false;
    }

    // ➕ Ajouter un enregistrement
    public function insert($data) {
        $filteredData = array_intersect_key($data, array_flip($this->allowedColumns));

        $columns = implode(", ", array_keys($filteredData));
        $values = ":" . implode(", :", array_keys($filteredData));

        $query = "INSERT INTO $this->table ($columns) VALUES ($values)";
        return $this->query($query, $filteredData);
    }

    // ✏️ Mettre à jour un enregistrement
    public function update($id, $data) {
        $filteredData = array_intersect_key($data, array_flip($this->allowedColumns));
        $query = "UPDATE $this->table SET ";
        $params = [];

        foreach ($filteredData as $key => $value) {
            $query .= "$key = :$key, ";
            $params[$key] = $value;
        }

        $query = rtrim($query, ", ") . " WHERE $this->primaryKey = :id";
        $params["id"] = $id;

        return $this->query($query, $params);
    }

    // ❌ Supprimer un enregistrement
    public function delete($id) {
        $query = "DELETE FROM $this->table WHERE $this->primaryKey = :id";
        return $this->query($query, ["id" => $id]);
    }
}
