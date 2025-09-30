<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller
{
    protected $UserModel;

    public function __construct()
    {
        parent::__construct();

        // load model file directly (avoid framework helper mismatch)
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

            if ($user && isset($user['password']) && password_verify($password, $user['password'])) {
                // set session
                $_SESSION['user_id']  = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role']     = $user['role'] ?? 'user';

                // redirect based on role
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

        // load view and pass $data (so error message shows)
        $this->call->view('auth/login', $data);
    }

    // -----------------------
    // REGISTER
    // -----------------------
    public function register()
    {
        if ($this->io->method() == 'post') {
            $username = trim($this->io->post('username'));
            $email    = trim($this->io->post('email'));
            $password = trim($this->io->post('password'));
            $role     = $this->io->post('role') ?? 'user';

            // simple validation (you can expand)
            if ($username === '' || $email === '' || $password === '') {
                $this->call->view('auth/register', ['error' => 'Please fill all fields.']);
                return;
            }

            $data = [
                'username' => $username,
                'email'    => $email,
                // hash the password before saving
                'password' => password_hash($password, PASSWORD_DEFAULT),
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
