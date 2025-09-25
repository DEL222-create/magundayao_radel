<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UserModel extends Model {
    protected $table = 'users';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Paginate users with optional search
     */
    public function page($q = '', $records_per_page = 5, $page = 1) {

        // Ensure page is integer >=1
        $page = max(1, (int)$page);
        $records_per_page = (int)$records_per_page;

        $query = $this->db->table($this->table);

        // Apply search if $q is not empty
        if (!empty($q)) {
            $query->like('username', '%'.$q.'%')
                  ->or_like('email', '%'.$q.'%');
        }

        // Total rows for pagination
        $countQuery = clone $query;
        $total_rows = $countQuery->select_count('*', 'count')
                                 ->get()['count'];

        // Paginated records
        $offset = ($page - 1) * $records_per_page;
        $records = $query->limit($records_per_page, $offset)
                         ->get_all();

        return [
            'records' => $records,
            'total_rows' => $total_rows
        ];
    }
}
