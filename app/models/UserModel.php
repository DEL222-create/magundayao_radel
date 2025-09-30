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

    /**
     * Get user by username
     */
    public function getUserByUsername($username)
    {
        $result = $this->db->table($this->table)
                           ->where('username', $username)
                           ->get();

        // depende sa DB wrapper mo: kung object -> convert to array
        if ($result && method_exists($result, 'getRowArray')) {
            return $result->getRowArray();
        }

        // kung diretso array na ang balik
        if ($result && is_array($result)) {
            return $result;
        }

        return null;
    }

    /**
     * Insert new user (plain password, walang email)
     */
    public function insertUser(array $data)
    {
        $insert = [
            'username' => $data['username'] ?? null,
            'password' => $data['password'] ?? null,
            'role'     => $data['role'] ?? 'user'
        ];

        return $this->db->table($this->table)->insert($insert);
    }

    /**
     * Paginated list (search only by username)
     */
    public function page($q = '', $limit = 5, $page = 1)
    {
        $offset = ($page - 1) * $limit;

        // records
        $builder = $this->db->table($this->table);
        if (!empty($q)) {
            $builder->like('username', '%'.$q.'%');
        }
        $records = $builder->limit($limit, $offset)->get_all();

        // count
        $countBuilder = $this->db->table($this->table);
        if (!empty($q)) {
            $countBuilder->like('username', '%'.$q.'%');
        }

        try {
            $countRow = $countBuilder->select_count('*', 'count')->get();
            $total_rows = (is_array($countRow) && isset($countRow['count'])) 
                ? (int)$countRow['count'] 
                : count($records);
        } catch (\Throwable $e) {
            $total_rows = count($this->db->table($this->table)->get_all());
        }

        return [
            'records'    => $records,
            'total_rows' => $total_rows
        ];
    }
}
