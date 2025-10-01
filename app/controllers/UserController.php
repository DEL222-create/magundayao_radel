<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UserController extends Controller {
    public function __construct()
    {
        parent::__construct();
        $this->call->model('UserModel');
        $this->call->library('pagination');
    }

    public function index()
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;

        $q = $this->io->get('q') ?? '';

        $records_per_page = 5;
        $offset = ($page - 1) * $records_per_page;

        // get records + count
        $records = $this->UserModel->get_records_with_pagination($records_per_page, $offset, $q);
        $total_rows = $this->UserModel->count_all_records($q);

        // Build base_url with query string (para gumana ang search + pagination)
        $query_params = [];
        if (!empty($q)) {
            $query_params['q'] = $q;
        }
        $base_url = site_url('user/index') . (!empty($query_params) ? '?' . http_build_query($query_params) : '');

        // Setup pagination
        $this->pagination->set_options([
            'first_link' => '« First',
            'last_link'  => 'Last »',
            'next_link'  => 'Next »',
            'prev_link'  => '« Prev',
            'page_query_string' => true,
            'query_string_segment' => 'page'
        ]);

        $this->pagination->set_theme('default');
        $this->pagination->initialize($total_rows, $records_per_page, $page, $base_url);

        $data['all']  = $records;
        $data['page'] = $this->pagination->paginate();
        $data['q']    = $q;

        $this->call->view('user/index', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => trim($_POST['username']),
                'email'    => trim($_POST['email'])
                // removed password and role
            ];

            if ($this->UserModel->create_user($data)) {
                redirect('user/index');
            } else {
                $_SESSION['error'] = "Failed to create user.";
            }
        }

        $this->call->view('user/create');
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
            redirect('user/index');
        }

        $user = $this->UserModel->find($id);
        $this->call->view('user/edit', ['user' => $user]);
    }

    public function delete($id)
    {
        $user = $this->UserModel->find($id);
        if (!$user) {
            $_SESSION['error'] = "User not found.";
            redirect('user/index');
        }

        $deleted = $this->UserModel->delete($id);
        if ($deleted) {
            $_SESSION['success'] = "User deleted successfully.";
        } else {
            $_SESSION['error'] = "Failed to delete user.";
        }
        redirect('user/index');
    }
}
