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
    public function page($q, $limit, $page)
    {
        $offset = ($page - 1) * $limit;

        // Count total
        if (!empty($q)) {
            $this->db->like('username', $q);
        }
        $total = $this->db->count_all_results($this->table, false);

        // Reset query for fetching records
        if (!empty($q)) {
            $this->db->like('username', $q);
        }
        $records = $this->db->get($this->table, $limit, $offset)->result_array();

        return [
            'total_rows' => $total,
            'records'    => $records
        ];
    }
}
