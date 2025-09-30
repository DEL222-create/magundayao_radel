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
             // set session, redirect sa user list
        } else {
             // Invalid username/password
        }

        }

        $this->call->view('auth/login');
    }

    // -----------------------
    // REGISTER
    // -----------------------
    public function register()
    {
        if ($this->request->getMethod() === 'post') {
            $data = [
                'username' => $this->request->getPost('username'),
                'email'    => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
                'role'     => $this->request->getPost('role'),
            ];

            // Save user
            $this->UserModel->insertUser($data);

            // Redirect to login page or user list
            return redirect()->to('/auth/login');
        }

        return view('register'); // load register view
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
