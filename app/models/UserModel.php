<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UserModel extends Model
{
    protected $table = 'users';      // table name sa DB
    protected $primary_key = 'id';    // primary key

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get user by username
     * Returns assoc array or null
     */
    public function getUserByUsername($username)
    {
        $result = $this->db->table($this->table)
                           ->where('username', $username)
                           ->get(); // your Database->get returns assoc array or false

        if ($result && is_array($result)) {
            return $result;
        }

        return null;
    }

    /**
     * Insert new user
     * $data must already contain hashed password
     */
    public function insertUser(array $data)
    {
        $insert = [
            'username' => $data['username'] ?? null,
            'email'    => $data['email'] ?? null,
            'password' => $data['password'] ?? null,
            'role'     => $data['role'] ?? 'user'
        ];

        return $this->db->table($this->table)->insert($insert);
    }

    /**
     * Paginated list (used by your controller)
     */
    public function page($q = '', $limit = 5, $page = 1)
    {
        $offset = ($page - 1) * $limit;

        // build query for records
        $builder = $this->db->table($this->table);
        if (!empty($q)) {
            $builder->like('username', '%'.$q.'%');
            $builder->or_like('email', '%'.$q.'%');
        }
        $records = $builder->limit($limit, $offset)->get_all();

        // build query for count
        $countBuilder = $this->db->table($this->table);
        if (!empty($q)) {
            $countBuilder->like('username', '%'.$q.'%');
            $countBuilder->or_like('email', '%'.$q.'%');
        }

        try {
            $countRow = $countBuilder->select_count('*', 'count')->get();
            $total_rows = is_array($countRow) && isset($countRow['count']) ? (int)$countRow['count'] : count($records);
        } catch (\Throwable $e) {
            // fallback
            $total_rows = count($this->db->table($this->table)->get_all());
        }

        return [
            'records' => $records,
            'total_rows' => $total_rows
        ];
    }

    // update/delete can use your $this->db wrapper similarly
}
