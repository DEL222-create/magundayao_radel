<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller
{
    public function register()
    {
        if ($this->io->method() === 'post') {
            $username = $this->io->post('username');
            $password = $this->io->post('password');
            $confirm_password = $this->io->post('confirm_password');
            $email = $this->io->post('email');
            $role = isset($_POST['role']) ? $_POST['role'] : 'user';

            // Basic validation
            if (empty($username) || empty($password) || empty($email)) {
                $this->session->set_userdata('error', 'All fields are required.');
                $this->call->view('auth/register');
                return;
            }

            if ($password !== $confirm_password) {
                $this->session->set_userdata('error', 'Passwords do not match.');
                $this->call->view('auth/register');
                return;
            }

            if (strlen($password) < 6) {
                $this->session->set_userdata('error', 'Password must be at least 6 characters long.');
                $this->call->view('auth/register');
                return;
            }

            $this->call->library('auth');
            
            if ($this->auth->register($username, $email, $password, $role)) {
                $this->session->set_userdata('success', 'Account created successfully! Please log in.');
                redirect('auth/login');
            } else {
                $this->session->set_userdata('error', 'Registration failed. Username may already exist.');
            }
        }
        
        $this->call->view('auth/register');
    }


    public function login()
    {
        $this->call->library('session');
        $this->call->library('auth');

        if ($this->io->method() === 'post') {
            $username = $this->io->post('username');
            $password = $this->io->post('password');

            if ($this->auth->login($username, $password)) {
                // ✅ Get the user's role after successful login
                $role = $this->session->userdata('role');

                // Set success message
                $this->session->set_userdata('success', 'Welcome back! You have successfully logged in.');

                // ✅ Redirect based on role
                if ($role === 'admin') {
                    redirect('user/index'); // admin → user management page
                } else {
                    redirect('auth/dashboard'); // user → dashboard
                }
                
            } else {
                $this->session->set_userdata('error', 'Invalid username or password. Please try again.');
            }
        }

        $this->call->view('auth/login');
    }

    public function dashboard()
    {
        $this->call->library('auth');

        if (!$this->auth->is_logged_in()) {
            redirect('auth/login');
        }

        if (!$this->auth->has_role('admin') && !$this->auth->has_role('user')) {
            echo 'Access denied!';
            exit;
        }


        $this->call->view('auth/dashboard');
    }




    public function logout()
    {
        $this->call->library('auth');
        $this->call->library('session');
        
        // Set logout message
        $this->session->set_userdata('success', 'You have been successfully logged out.');
        
        $this->auth->logout();
        redirect('auth/login');
    }
}
?>