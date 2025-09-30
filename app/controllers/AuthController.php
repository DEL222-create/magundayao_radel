<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller
{
    protected $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->call->model('UserModel');   // load UserModel
        $this->userModel = new UserModel();

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

            $user = $this->userModel->getUserByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                // ✅ Save session
                $_SESSION['user_id']  = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role']     = $user['role'];

                // ✅ Redirect depende sa role
                if ($user['role'] === 'admin') {
                    redirect(site_url('user'));
                } else {
                    redirect(site_url('auth/dashboard'));
                }
            } else {
                $data['error'] = "❌ Invalid username or password.";
                $this->call->view('auth/login', $data);
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
            $username = trim($this->io->post('username'));
            $password = password_hash(trim($this->io->post('password')), PASSWORD_BCRYPT);
            $role     = $this->io->post('role');

            $data = [
                'username' => $username,
                'password' => $password,
                'role'     => $role
            ];

            if ($this->userModel->insertUser($data)) {
                redirect(site_url('auth/login'));
            } else {
                $data['error'] = "⚠️ Registration failed.";
                $this->call->view('auth/register', $data);
                return;
            }
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
