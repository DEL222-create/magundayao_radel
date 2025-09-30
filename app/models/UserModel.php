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

    // Pagination with optional search
    public function page($q = '', $limit = 10, $page = 1)
    {
        $offset = ($page - 1) * $limit;

        // COUNT total rows
        if (!empty($q)) {
            $this->db->like('username', $q);
        }
        $this->db->from($this->table);
        $total = $this->db->count();   // <-- tamang bilang ng rows

        // FETCH paginated records
        if (!empty($q)) {
            $this->db->like('username', $q);
        }
        $this->db->limit($limit, $offset);
        $records = $this->db->get($this->table)->result_array();

        return [
            'total_rows' => $total,
            'records'    => $records
        ];
    }
}
