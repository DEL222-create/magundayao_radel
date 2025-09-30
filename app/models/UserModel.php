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
     * Paginated user list with optional search
     */
    public function page($q = '', $limit = 10, $page = 1)
    {
        $offset = ($page - 1) * $limit;

        // Count total rows
        if (!empty($q)) {
            $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE username LIKE :q";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':q' => "%$q%"]);
        } else {
            $sql = "SELECT COUNT(*) as total FROM {$this->table}";
            $stmt = $this->db->query($sql);
        }
    }
}