<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'email', 'role'];

    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
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