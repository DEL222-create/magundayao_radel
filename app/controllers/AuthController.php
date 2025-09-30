<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller
{
    protected $UserModel;

    public function __construct()
    {
        parent::__construct();
        $this->UserModel = model('UserModel');

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    // -----------------------
    // LOGIN
    // -----------------------
    public function login()
    {
        if ($this->io->method() == 'post') {
            $username = trim($this->io->post('username'));
            $password = trim($this->io->post('password'));

            $user = $this->UserModel->getUserByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                // Login successful
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                redirect(site_url('auth/dashboard'));
            } else {
                // Invalid username/password
                $this->call->view('auth/login', ['error' => 'Invalid username or password.']);
                return;
            }
        }

        $this->call->view('auth/login');
    }

    // -----------------------
    // REGISTER
    // -----------------------
    public function register()
    {
        if ($this->io->method() == 'post') {
            $data = [
                'username' => $this->io->post('username'),
                'email'    => $this->io->post('email'),
                'password' => $this->io->post('password'),
                'role'     => $this->io->post('role'),
            ];

            // Save user
            $this->UserModel->insertUser($data);

            // Redirect to login page
            redirect(site_url('auth/login'));
        }

        $this->call->view('auth/register');
    }

    // -----------------------
    // DASHBOARD
    // -----------------------
    public function dashboard()
    {
        if (!isset($_SESSION['user_id'])) {
            redirect(site_url('auth/login'));
        }

        $this->call->view('auth/dashboard');
    }

    // -----------------------
    // LOGOUT
    // -----------------------
    public function logout()
    {
        session_destroy();
        redirect(site_url('auth/login'));
    }
}
