<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UserController extends Controller {
    public function __construct()
    {
        parent::__construct();
        $this->call->model('UserModel');
        $this->call->library('pagination');

        // Custom pagination styles
        $this->pagination->set_theme('custom');
        $this->pagination->set_custom_classes([
            'nav'    => 'flex justify-center mt-6',
            'ul'     => 'inline-flex space-x-2',
            'li'     => '',
            'a'      => 'px-3 py-1 rounded-lg border text-gray-300 hover:bg-gray-700 transition',
            'active' => 'bg-blue-600 text-white border-blue-600'
        ]);
    }

    public function index($page = 1)
    {
        $page = max(1, (int)$page);
        
        $per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
        $allowed = [10, 25, 50, 100];
        if (!in_array($per_page, $allowed)) $per_page = 10;

        $search = $_GET['search'] ?? '';

        // Total rows
        $total_rows = $this->UserModel->count_all_records($search);

        // Build query params (para hindi mawala sa pagination)
        $query_params = [];
        if (!empty($search)) $query_params['search'] = $search;
        if ($per_page !== 10) $query_params['per_page'] = $per_page;

        $base_url = 'user/index';
        if (!empty($query_params)) {
            $base_url .= '?' . http_build_query($query_params);
        }

        // Initialize pagination
        $pagination_data = $this->pagination->initialize(
            $total_rows,
            $per_page,
            $page,
            $base_url,
            5
        );

        // Get records
        $data['users'] = $this->UserModel->get_records_with_pagination(
            $pagination_data['limit'],
            $search
        );

        $data['pagination_info'] = $pagination_data['info'];
        $data['pagination_html'] = $this->pagination->paginate();

        $data['search'] = $search;
        $data['per_page'] = $per_page;
        $data['current_page'] = $page;
        $data['total_pages'] = ceil($total_rows / $per_page);

        $this->call->view('users/index', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => trim($_POST['username']),
                'email'    => trim($_POST['email']),
                'password' => password_hash($_POST['password'], PASSWORD_BCRYPT)
            ];

            $this->UserModel->insert($data);
            redirect('/user');
        }

        $this->call->view('users/create');
    }

    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => trim($_POST['username']),
                'email'    => trim($_POST['email']),
            ];

            if (!empty($_POST['password'])) {
                $data['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
            }

            $this->UserModel->update($id, $data);
            redirect('/user');
        }

        $user = $this->UserModel->find($id);
        $this->call->view('users/edit', ['user' => $user]);
    }

    public function delete($id)
    {
        $user = $this->UserModel->find($id);
        if (!$user) {
            $_SESSION['error'] = "User not found.";
            header('Location: /user');
            exit;
        }

        $deleted = $this->UserModel->delete($id);
        if ($deleted) {
            $_SESSION['success'] = "User deleted successfully.";
        } else {
            $_SESSION['error'] = "Failed to delete user.";
        }
        header('Location: /user');
        exit;
    }

    function login()
    {
        $this->call->view('users/login');
    }
}
