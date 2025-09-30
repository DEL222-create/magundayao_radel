<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users'; // pangalan ng table mo
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'email'];


    public function __construct()
    {
        parent::__construct();
    }


    public function getUserByUsername($username) {
        return $this->db->table($this->table)
                        ->where('username', $username)
                        ->get()
                        ->getRowArray();
    }

    public function page($q = '', $records_per_page = null, $page = null) {
 
            if (is_null($page)) {
                return $this->db->table('users')->get_all();
            } else {
                $query = $this->db->table('users');

                // Build LIKE conditions
                $query->like('id', '%'.$q.'%')
                    ->or_like('username', '%'.$q.'%')
                    ->or_like('email', '%'.$q.'%');
                    
                // Clone before pagination
                $countQuery = clone $query;

                $data['total_rows'] = $countQuery->select_count('*', 'count')
                                                ->get()['count'];

                $data['records'] = $query->pagination($records_per_page, $page)
                                        ->get_all();

                return $data;
            }
        }

}