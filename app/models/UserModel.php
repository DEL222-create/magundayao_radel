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

    // Count total rows (manual query)
    if (!empty($q)) {
        $sql = "SELECT COUNT(*) as cnt FROM {$this->table} WHERE username LIKE ?";
        $bind = ["%$q%"];
        $total = $this->db->query($sql, $bind)->row_array()['cnt'];
    } else {
        $sql = "SELECT COUNT(*) as cnt FROM {$this->table}";
        $total = $this->db->query($sql)->row_array()['cnt'];
    }

    // Fetch records with limit and offset
    if (!empty($q)) {
        $sql = "SELECT * FROM {$this->table} WHERE username LIKE ? LIMIT ? OFFSET ?";
        $bind = ["%$q%", $limit, $offset];
        $records = $this->db->query($sql, $bind)->result_array();
    } else {
        $sql = "SELECT * FROM {$this->table} LIMIT ? OFFSET ?";
        $bind = [$limit, $offset];
        $records = $this->db->query($sql, $bind)->result_array();
    }

    return [
        'total_rows' => $total,
        'records'    => $records
    ];
}

}
