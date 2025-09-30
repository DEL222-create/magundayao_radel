<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Auth {
    protected $UserModel;

    public function __construct()
    {
        $this->UserModel = Model('UserModel'); // access UserModel
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /** 🔑 Login check */
    public function login($username, $password)
    {
        $user = $this->UserModel->db->table('users')
                    ->where('username', $username)
                    ->get();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role']     = $user['role'];
            $_SESSION['logged_in'] = true;
            return true;
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
