<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Auth {
    protected $UserModel;

    public function __construct()
    {
        $this->UserModel = new UserModel();

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
   
    /** Login check (plain password) */
    public function login($username, $password): bool
    {
        $user = $this->UserModel->db->table('users')
                                   ->where('username', $username)
                                   ->get();

        if ($user->getNumRows() > 0) {
            $row = $user->getRowArray();
            // ✅ plain password check
            return ($password === $row['password']);
        }

        return false;
    }

    /** ✅ Is logged in? */
    public function is_logged_in()
    {
        return !empty($_SESSION['logged_in']);
    }

    /** 👑 Role check */
    public function is_admin()
    {
        return (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');
    }

    /** 🚪 Logout */
    public function logout()
    {
        session_unset();
        session_destroy();
    }
}
