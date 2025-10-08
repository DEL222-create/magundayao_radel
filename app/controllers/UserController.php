<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UserController extends Controller {
    public function __construct()
    {
        parent::__construct();
        $this->call->model('UserModel');
        $this->call->library('pagination');
        $this->call->library('auth');

        if (!$this->auth->is_logged_in()) {
            redirect('auth/login');
            exit;
        }
    }

    public function index($page = 1)
    {
        $page = (int)$page;
        if ($page < 1) $page = 1;

        $q = isset($_GET['q']) ? trim($this->io->get('q')) : '';

        $records_per_page = 5;
        $all = $this->UserModel->page($q, $records_per_page, $page);
        $data['all'] = $all['records'];
        $total_rows = $all['total_rows'];

        $base_url = 'user/index';
        if (!empty($q)) {
            $base_url .= '?q=' . urlencode($q);
        }

        $this->pagination->set_options([
            'first_link' => '« First',
            'last_link'  => 'Last »',
            'next_link'  => 'Next »',
            'prev_link'  => '« Prev',
            'page_query_string' => false,
        ]);

        $this->pagination->set_theme('bootstrap');
        $this->pagination->initialize(
            $total_rows,
            $records_per_page,
            $page,
            $base_url
        );

        $data['page'] = $this->pagination->paginate();
        $data['auth'] = $this->auth;
        $this->call->view('user/index', $data);
    }


    public function create()
    {
        if ($this->io->method() == 'post') {
            $username = $this->io->post('username');
            $email = $this->io->post('email');

            $data = [
                'username' => $username,
                'email' => $email
            ];

            if ($this->UserModel->insert($data)) {
                redirect(site_url('user'));
            } else {
                echo "Error in creating user.";
            }

        } else {
            $this->call->view('user/create');
        }
    }

    public function update($id)
    {
        $user = $this->UserModel->find($id);
        if (!$user) {
            echo "User not found.";
            return;
        }

        if ($this->io->method() == 'post') {
            $username = $this->io->post('username');
            $email = $this->io->post('email');

            $data = [
                'username' => $username,
                'email' => $email
            ];

            if ($this->UserModel->update($id, $data)) {
                redirect(site_url('user'));
            } else {
                echo "Error in updating user.";
            }
        } else {
            $data['user'] = $user;
            $this->call->view('user/update', $data);
        }
    }

    public function delete($id)
    {
        if ($this->UserModel->delete($id)) {
            redirect(site_url('user'));
        } else {
            echo "Error in deleting user.";
        }
    }
}
