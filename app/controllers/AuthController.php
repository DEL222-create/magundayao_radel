<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

require_once __DIR__ . '/../models/UserModel.php';

class AuthController extends Controller {
    protected $userModel;

    public function __construct() {
        $this->userModel = new UserModel(); // instantiate UserModel

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->userModel->getUserByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id']  = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role']     = $user['role'];

                redirect('auth/dashboard');
            } else {
                echo "<div class='alert alert-danger text-center'>Invalid login credentials</div>";
            }
        }

        $this->call->view('auth/login');
    }

    public function register() {
        // dito ilalagay yung register logic
        $this->call->view('auth/register');
    }

    public function dashboard() {
        if (!isset($_SESSION['user_id'])) {
            redirect('auth/login');
        }
        $this->call->view('auth/dashboard');
    }

    public function logout() {
        session_destroy();
        redirect('auth/login');
    }
}
