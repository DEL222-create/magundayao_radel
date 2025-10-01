<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UserModel extends Model
{
    protected $table = 'users';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
    }

    // Get paginated records with optional search
    public function get_records_with_pagination($limit, $offset, $search = '')
    {
        $sql = "SELECT * FROM {$this->table}";
        $params = [];

        if (!empty($search)) {
            $sql .= " WHERE username LIKE ? OR email LIKE ?";
            $params = ["%$search%", "%$search%"];
        }

        $sql .= " LIMIT " . (int)$limit . " OFFSET " . (int)$offset;
        return $this->db->get_all($sql, $params);
    }

    // Count total users (for pagination)
    public function count_all_records($search = '')
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $params = [];

        if (!empty($search)) {
            $sql .= " WHERE username LIKE ? OR email LIKE ?";
            $params = ["%$search%", "%$search%"];
        }

        $row = $this->db->get_row($sql, $params);
        return $row ? $row['total'] : 0;
    }

    // Find single user
    public function find($id, $with_deleted = false)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primary_key} = ?";
        $params = [$id];

        if (!$with_deleted && property_exists($this, 'deleted_field')) {
            $sql .= " AND {$this->deleted_field} IS NULL";
        }

        return $this->db->get_row($sql, $params);
    }

    // Insert new user
  public function create_user($data)
{
    $insertData = [
        'username' => $data['username'],
        'email'    => $data['email']
        // removed password and role
    ];

    return $this->db->insert($this->table, $insertData);
}

    // Update user by ID
    public function update($id, $data)
    {
        return $this->db->update($this->table, $data, [$this->primary_key => $id]);
    }

    // Delete user by ID
    public function delete($id)
    {
        return $this->db->delete($this->table, [$this->primary_key => $id]);
    }
}
