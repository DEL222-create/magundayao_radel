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

 public function index()
{
    $this->call->model('UserModel');
    $this->call->library('pagination');

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) $page = 1;

    // safe handling para walang warning
    $q = $this->io->get('q') ?? '';

    $records_per_page = 5;
    $offset = ($page - 1) * $records_per_page;

    // kuha records + count
    $records = $this->UserModel->get_records_with_pagination($records_per_page, $offset, $q);
    $total_rows = $this->UserModel->count_all_records($q);

    $base_url = 'user/index';
    if (!empty($q)) {
        $base_url .= '?q=' . urlencode($q);
    }

    $this->pagination->set_options([
        'first_link' => '« First',
        'last_link'  => 'Last »',
        'next_link'  => 'Next »',
        'prev_link'  => '« Prev',
        'page_query_string' => true,
        'query_string_segment' => 'page'
    ]);

    $this->pagination->set_theme('default');

    $this->pagination->initialize(
        $total_rows,
        $records_per_page,
        $page,
        $base_url
    );

    $data['all']  = $records;
    $data['page'] = $this->pagination->paginate();
    $data['q']    = $q; // para safe gamitin sa view

   $this->call->view('user/index', $data);
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

}
