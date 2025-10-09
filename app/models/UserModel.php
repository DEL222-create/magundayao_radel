<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Model: UsersModel
 * 
 * Automatically generated via CLI.
 */
class UserModel extends Model {
    protected $table = 'user';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_user_by_id($id)
    {
        return $this->db->table($this->table)
                        ->where('id', $id)
                        ->get();
    }

    public function get_user_by_username($username)
    {
        return $this->db->table($this->table)
                        ->where('username', $username)
                        ->get();
    }

    public function update_password($user_id, $new_password)
    {
        return $this->db->table($this->table)
                        ->where('id', $user_id)
                        ->update([
                            'password' => password_hash($new_password, PASSWORD_DEFAULT)
                        ]);
    }

    public function get_all_users()
    {
        return $this->db->table($this->table)->get_all();
    }

    public function get_logged_in_user()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['user']['id'])) {
            return $this->get_user_by_id($_SESSION['user']['id']);
        }

        return null;
    }

    /**
     * Pagination with search
     */
    public function page($q = '', $records_per_page = null, $page = null)
    {
        if (is_null($page)) {
            // No pagination, return all users
            return $this->db->table($this->table)->get_all();
        } else {
            $offset = ($page - 1) * $records_per_page;

            // Build search query using PDO directly
            $sql = "SELECT * FROM {$this->table} 
                    WHERE id LIKE :q
                       OR username LIKE :q
                       OR email LIKE :q
                       OR role LIKE :q
                    LIMIT :limit OFFSET :offset";

            $stmt = $this->db->pdo->prepare($sql);
            $stmt->bindValue(':q', '%'.$q.'%', PDO::PARAM_STR);
            $stmt->bindValue(':limit', (int)$records_per_page, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            $stmt->execute();

            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Count total rows for pagination
            $count_sql = "SELECT COUNT(*) AS count FROM {$this->table} 
                          WHERE id LIKE :q
                             OR username LIKE :q
                             OR email LIKE :q
                             OR role LIKE :q";
            $count_stmt = $this->db->pdo->prepare($count_sql);
            $count_stmt->bindValue(':q', '%'.$q.'%', PDO::PARAM_STR);
            $count_stmt->execute();
            $total_rows = $count_stmt->fetch(PDO::FETCH_ASSOC)['count'];

            return [
                'total_rows' => $total_rows,
                'records' => $records
            ];
        }
    }
}
