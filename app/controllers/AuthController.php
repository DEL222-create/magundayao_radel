<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller {
    public function __construct()
    {
        parent::__construct();
        $this->call->model('UserModel');
        $this->call->library('Auth'); // tawagin yung custom Auth library
        session_start(); // ensure session running
    }

    /** 🔑 Login Page */
   public function login()
{
    if ($this->io->method() == 'post') {
        $username = $this->io->post('username');
        $password = $this->io->post('password');

        // Kunin user from DB
        $user = $this->UserModel->getUserByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            // Store sa session
            $_SESSION['username'] = $user['username'];
            $_SESSION['role']     = $user['role'];

            redirect(site_url('auth/dashboard'));
        } else {
            $data['error'] = "❌ Invalid username or password";
            $this->call->view('auth/login', $data);
        }
    } else {
        $this->call->view('auth/login');
    }
}


    /** 📝 Register Page */
    public function register()
    {
        if ($this->io->method() == 'post') {
            $username = $this->io->post('username');
            $password = password_hash($this->io->post('password'), PASSWORD_BCRYPT);
            $role     = $this->io->post('role');

            $data = [
                'username' => $username,
                'password' => $password,
                'role'     => $role,
            ];

            if ($this->UserModel->insert($data)) {
                redirect(site_url('auth/login'));
            } else {
                echo "Error creating account.";
            }
        } else {
            $this->call->view('auth/register');
        }
    }

    /** 📊 Dashboard */
    public function dashboard()
    {
        if (!$this->auth->is_logged_in()) {
            redirect(site_url('auth/login'));
        }

        $this->call->view('auth/dashboard');
    }

    /** 🚪 Logout */
    public function logout()
    {
        $this->auth->logout();
        redirect(site_url('auth/login'));
    }
}
