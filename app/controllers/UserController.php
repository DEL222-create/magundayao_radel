<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Controller: UsersController
 */

class UserController extends Controller {

    public function __construct()
    {
        parent::__construct();
        if (session_status() === PHP_SESSION_NONE) session_start();
    }

    // Helper to check if logged in
    private function check_login() {
        if (!isset($_SESSION['user'])) {
            redirect('/auth/login');
            exit;
        }
    }

    public function index()
    {
        $this->call->model('UserModel');
        $this->check_login();

        $logged_in_user = $_SESSION['user']; 
        $data['logged_in_user'] = $logged_in_user;

        $page = isset($_GET['page']) ? $this->io->get('page') : 1;
        $q    = isset($_GET['q']) && !empty($_GET['q']) ? trim($this->io->get('q')) : '';

        $records_per_page = 5;
        $users = $this->UsersModel->page($q, $records_per_page, $page);

        $data['users'] = $users['records'];
        $total_rows = $users['total_rows'];

        $this->pagination->set_options([
            'first_link'     => '⏮ First',
            'last_link'      => 'Last ⏭',
            'next_link'      => 'Next →',
            'prev_link'      => '← Prev',
            'page_delimiter' => '&page='
        ]);
        $this->pagination->set_theme('custom');
        $this->pagination->initialize($total_rows, $records_per_page, $page, 'users?q='.$q);
        $data['page'] = $this->pagination->paginate();

        $this->call->view('users/index', $data);
    }

    public function create()
{
    $this->call->model('UserModel');

    // Get logged-in user
    $logged_in_user = $_SESSION['user'] ?? ['role' => 'user'];

    if ($this->io->method() === 'post') {

        $username = $this->io->post('username');
        $email = $this->io->post('email');
        $password = $this->io->post('password'); 

        // Only allow admin to set role
        if ($logged_in_user['role'] === 'admin') {
            $role = $this->io->post('role') ?? 'user';
        } else {
            $role = 'user'; // force normal users to create only 'user' accounts
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $data = [
            'username' => $username,
            'email'    => $email,
            'password' => $hashedPassword,
            'role'     => $role
        ];

        if ($this->UserModel->insert($data)) {
            redirect('/user');
        } else {
            echo 'Failed to create user.';
        }
    } else {
        $this->call->view('user/create', ['logged_in_user' => $logged_in_user]);
    }
}


    public function update($id)
    {
        $this->call->model('UserModel');
        $this->check_login();

        $logged_in_user = $_SESSION['user'];

        $user = $this->UserModel->get_user_by_id($id);
        if (!$user) {
            echo "User not found.";
            return;
        }

        // Restrict normal users to edit only their own account
        if ($logged_in_user['role'] !== 'admin' && $logged_in_user['id'] != $id) {
            echo "You are not allowed to edit other users.";
            return;
        }

        if ($this->io->method() === 'post') {
            $username = $this->io->post('username');
            $email    = $this->io->post('email');

            if ($logged_in_user['role'] === 'admin') {
                $role = $this->io->post('role');
                $password = $this->io->post('password');

                // Validate role
                $allowed_roles = ['admin', 'user'];
                if (!in_array($role, $allowed_roles)) $role = 'user';

                $data = [
                    'username' => $username,
                    'email'    => $email,
                    'role'     => $role
                ];

                if (!empty($password)) {
                    $data['password'] = password_hash($password, PASSWORD_BCRYPT);
                }
            } else {
                // Normal user cannot change role or password
                $data = [
                    'username' => $username,
                    'email'    => $email
                ];
            }

            if ($this->UserModel->update($id, $data)) {
                redirect('/user');
            } else {
                echo 'Failed to update user.';
            }
        } else {
            $data['user'] = $user;
            $data['logged_in_user'] = $logged_in_user;
            $this->call->view('user/update', $data);
        }
    }

    public function delete($id)
    {
        $this->call->model('UserModel');
        $this->check_login();

        $logged_in_user = $_SESSION['user'];

        // Only admin can delete users
        if ($logged_in_user['role'] !== 'admin') {
            echo "You are not allowed to delete users.";
            return;
        }

        if ($this->UserModel->delete($id)) {
            redirect('/user');
        } else {
            echo 'Failed to delete user.';
        }
    }

  public function register()
    {
        $this->call->model('UserModel');

        if ($this->io->method() === 'post') {
            $username = $this->io->post('username');
            $email    = $this->io->post('email');
            $password = password_hash($this->io->post('password'), PASSWORD_BCRYPT);

            // Normal registration defaults to 'user' role
            $role = 'user';
            $data = [
                'username' => $username,
                'email'    => $email,
                'password' => $password,
                'role'     => $role
            ];

            if ($this->UserModel->insert($data)) {
                redirect('/auth/login');
            }
        }

        $this->call->view('/auth/register');
    }
    public function login()
    {
        $this->call->library('auth');

        $error = null;

        if ($this->io->method() === 'post') {
            $username = $this->io->post('username');
            $password = $this->io->post('password');

            $this->call->model('UsersModel');
            $user = $this->UserModel->get_user_by_username($username);

            if ($user) {
                if ($this->auth->login($username, $password)) {
                    $_SESSION['user'] = [
                    
    'id'       => $user['id'],
                        'username' => $user['username'],
                        'role'     => $user['role']
                    ];

                    redirect('/user');
                } else {
                    $error = "Incorrect password!";
                }
            } else {
                $error = "Username not found!";
            }
        }

        $this->call->view('auth/login', ['error' => $error]);
    }

    public function dashboard()
    {
        $this->call->model('UserModel');
        $this->check_login();

        $page = isset($_GET['page']) ? $this->io->get('page') : 1;
        $q    = isset($_GET['q']) && !empty($_GET['q']) ? trim($this->io->get('q')) : '';

        $records_per_page = 5;
        $user = $this->UserModel->page($q, $records_per_page, $page);

        $data['user'] = $user['records'];
        $total_rows = $user['total_rows'];

        $this->pagination->set_options([
            'first_link'     => '⏮ First',
            'last_link'      => 'Last ⏭',
            'next_link'      => 'Next →',
            'prev_link'      => '← Prev',
            'page_delimiter' => '&page='
        ]);
        $this->pagination->set_theme('bootstrap');
        $this->pagination->initialize($total_rows, $records_per_page, $page, 'users?q='.$q);
        $data['page'] = $this->pagination->paginate();

        $this->call->view('user/dashboard', $data);
    }

    public function logout()
    {
        $this->call->library('auth');
        $this->auth->logout();
        redirect('auth/login');
    }

}