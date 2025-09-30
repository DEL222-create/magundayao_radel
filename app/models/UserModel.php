<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UserModel extends Model
{
    protected $table = 'users'; // table name
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
    }

    // Pagination + Search
   public function page($q = '', $limit = 5, $page = 1)
{
    $offset = ($page - 1) * $limit;

    // COUNT total
    if (!empty($q)) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE username LIKE ?";
        $result = $this->db->get_all($sql, ['%' . $q . '%']);
        $total = isset($result[0]['total']) ? $result[0]['total'] : 0;

        $sql = "SELECT * FROM {$this->table} WHERE username LIKE ? LIMIT {$limit} OFFSET {$offset}";
        $records = $this->db->get_all($sql, ['%' . $q . '%']);
    } else {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $result = $this->db->get_all($sql);
        $total = isset($result[0]['total']) ? $result[0]['total'] : 0;

        $sql = "SELECT * FROM {$this->table} LIMIT {$limit} OFFSET {$offset}";
        $records = $this->db->get_all($sql);
    }

    return [
        'records' => $records,
        'total_rows' => $total
    ];
}

// Count records (with optional search)
public function count_all_records($search = '')
{
    if (!empty($search)) {
        $row = $this->db->fetch("SELECT COUNT(*) as total FROM {$this->table} WHERE username LIKE ?", ['%' . $search . '%']);
    } else {
        $row = $this->db->fetch("SELECT COUNT(*) as total FROM {$this->table}");
    }
    return $row ? $row['total'] : 0;
}

// Get paginated records
public function get_records_with_pagination($limit, $search = '')
{
    $offset = $limit['offset'];
    $per_page = $limit['limit'];

    if (!empty($search)) {
        return $this->db->fetchAll("SELECT * FROM {$this->table} WHERE username LIKE ? LIMIT {$per_page} OFFSET {$offset}", ['%' . $search . '%']);
    } else {
        return $this->db->fetchAll("SELECT * FROM {$this->table} LIMIT {$per_page} OFFSET {$offset}");
    }
}


    // Insert
    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    // Update
    public function update($id, $data)
    {
        return $this->db->update($this->table, $data, [$this->primary_key => $id]);
    }

    // Delete
    public function delete($id)
    {
        return $this->db->delete($this->table, [$this->primary_key => $id]);
    }

    // Find by ID (compatible with parent Model)
    public function find($id, $with_deleted = false)
    {
        // ignore $with_deleted kasi wala kang soft delete
        return $this->db->get_row("SELECT * FROM {$this->table} WHERE {$this->primary_key} = ?", [$id]);
    }
}
