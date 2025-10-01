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

    // Get users with pagination
    public function get_records_with_pagination($limit, $offset, $q = '')
    {
        $this->db->select('*')
                 ->from($this->table)
                 ->limit($limit, $offset);

        if (!empty($q)) {
            $this->db->like('username', $q)
                     ->or_like('email', $q);
        }

        return $this->db->get()->result();
    }

    // Count total users (for pagination)
    public function count_all_records($q = '')
    {
        $this->db->select('COUNT(*) as total')
                 ->from($this->table);

        if (!empty($q)) {
            $this->db->like('username', $q)
                     ->or_like('email', $q);
        }

        $row = $this->db->get()->row();
        return $row ? $row->total : 0;
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
