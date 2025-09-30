<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller
{
    protected $UserModel;

    public function __construct()
    {
        parent::__construct();

        require_once __DIR__ . '/../models/UserModel.php';
        $this->UserModel = new UserModel();

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    // -----------------------
    // LOGIN
    // -----------------------
    public function login()
    {
        $data = [];

        if ($this->io->method() == 'post') {
            $username = trim($this->io->post('username'));
            $password = trim($this->io->post('password'));

            $user = $this->UserModel->getUserByUsername($username);

            // ✅ Plain password check
            if ($user && isset($user['password']) && $password === $user['password']) {
                $_SESSION['user_id']  = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role']     = $user['role'] ?? 'user';

                if ($_SESSION['role'] === 'admin') {
                    redirect(site_url('user')); // admin -> user list
                } else {
                    redirect(site_url('auth/dashboard'));
                }
                return;
            } else {
                $data['error'] = "Invalid username or password.";
            }
        }

        $this->call->view('auth/login', $data);
    }

    // -----------------------
    // REGISTER
    // -----------------------
    public function register()
    {
        if ($this->io->method() == 'post') {
            $username = trim($this->io->post('username'));
            $password = trim($this->io->post('password'));
            $role     = $this->io->post('role') ?? 'user';

            if ($username === '' || $password === '') {
                $this->call->view('auth/register', ['error' => 'Please fill all fields.']);
                return;
            }

            $data = [
                'username' => $username,
                // ✅ plain password (no hashing)
                'password' => $password,
                'role'     => $role,
            ];

            $this->UserModel->insertUser($data);

            redirect(site_url('auth/login'));
            return;
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
