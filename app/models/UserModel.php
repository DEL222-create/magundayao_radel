<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UserModel extends Model
{
    protected $table = 'users';      // table name sa DB
    protected $primaryKey = 'id';    // primary key

    public function __construct()
    {
        parent::__construct();
    }

   public function getUserByUsername($username)
{
    $query = $this->db->table($this->users)
                      ->where('username', $username)
                      ->get();

    // Check muna kung may result bago i-row_array
    if ($query->getNumRows() > 0) {
        return $query->getRowArray();  // tama para isang row
    }

    return null; // walang nakita
}

    // Insert user (register)
   public function insertUser($data)
{
    return $this->db->table($this->table)->insert([
        'username' => $data['username'],
        'email'    => $data['email'],  
        'password' => password_hash($data['password'], PASSWORD_DEFAULT),
        'role'     => $data['role'],
    ]);
}


    // Kunin lahat ng users (may option sa pagination/search)
    public function page($q = '', $limit = 10, $page = 1)
    {
        $offset = ($page - 1) * $limit;

        $builder = $this->db->table($this->table);

        if (!empty($q)) {
            $builder->like('username', $q);
            $builder->or_like('email', $q);
        }

        $records = $builder->limit($limit, $offset)->get()->result_array();

        // count total rows
        $builder2 = $this->db->table($this->table);
        if (!empty($q)) {
            $builder2->like('username', $q);
            $builder2->or_like('email', $q);
        }
        $total_rows = $builder2->count_all_results();

        return [
            'records' => $records,
            'total_rows' => $total_rows
        ];
    }


    // Update user
    public function update($id, $data)
    {
        return $this->db->table($this->table)
                        ->where($this->primaryKey, $id)
                        ->update($data);
    }

    // Delete user
    public function delete($id)
    {
        return $this->db->table($this->table)
                        ->where($this->primaryKey, $id)
                        ->delete();
    }
}
