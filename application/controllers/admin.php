<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model('model_test');
    }

    //admin dashboard
    public function index()
    {
        if (!$this->ion_auth->logged_in())
        {
            redirect('admin/login', 'refresh');
        }

        $this->template
             ->title($this->config->item('site_name'), 'Dashboard')
             ->build('admin/view_dashboard', $this->data);
    }

    //login
    public function login()
    {
        if ($this->ion_auth->logged_in())
        {
            //redirect them to dashboard if already logged in
            redirect('admin', 'refresh');
        }

        //validate form input
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() === TRUE)
        {
            //check to see if the user is logging in
            //check for "remember me"
            $remember = (bool) $this->input->post('remember');

            if ($this->ion_auth->login($this->input->post('email'), $this->input->post('password'), $remember))
            {
                //if the login is successful
                //redirect them back to the home page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect('admin', 'refresh');
            }
            else
            {
                //if the login was un-successful
                //redirect them back to the login page
                $this->session->set_flashdata('error', $this->ion_auth->errors());
                redirect('admin/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        }
        else
        {
            $this->template
                 ->title($this->config->item('site_name'), 'Login')
                 ->set_layout('modal_layout')
                 ->build('admin/view_login', $this->data);
        }
    }

    //forgot password
    public function forgot_password()
    {
        $this->form_validation->set_rules('email', $this->lang->line('forgot_password_validation_email_label'), 'required');
        if ($this->form_validation->run() == false)
        {
            $this->template
                 ->title($this->config->item('site_name'), 'Forgot Password')
                 ->set_layout('modal_layout')
                 ->build('admin/view_forgot_password', $this->data);
        }
        else
        {
            // get identity for that email
            $check = $this->ion_auth_model->email_check($this->input->post('email'));

            if(!$check)
            {
                $this->ion_auth->set_message('forgot_password_email_not_found');
                $this->session->set_flashdata('error', $this->ion_auth->messages());
                redirect("admin/forgot_password", 'refresh');
            }

            //run the forgotten password method to email an activation code to the user
            $forgotten = $this->ion_auth->forgotten_password($this->input->post('email'));

            if ($forgotten)
            {
                //if there were no errors
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("admin/login", 'refresh'); //we should display a confirmation page here instead of the login page
            }
            else
            {
                $this->session->set_flashdata('error', $this->ion_auth->errors());
                redirect("admin/forgot_password", 'refresh');
            }
        }
    }

    //reset password - final step for forgotten password
    public function reset_password($code = FALSE)
    {
        if (!$code)
        {
            show_404();
        }

        $user = $this->ion_auth->forgotten_password_check($code);

        if ($user)
        {
            //if the code is valid then display the password reset form

            $this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
            $this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

            if ($this->form_validation->run() == false)
            {
                //display the form

                //set the flash data error message if there is one
                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
                $this->data['new_password'] = array(
                    'name'      => 'new',
                    'id'        => 'new',
                    'type'      => 'password',
                    'pattern'   => '^.{'.$this->data['min_password_length'].'}.*$',
                );
                $this->data['new_password_confirm'] = array(
                    'name' => 'new_confirm',
                    'id'   => 'new_confirm',
                    'type' => 'password',
                    'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
                );
                $this->data['user_id'] = array(
                    'name'  => 'user_id',
                    'id'    => 'user_id',
                    'type'  => 'hidden',
                    'value' => $user->id,
                );
                $this->data['csrf'] = $this->_get_csrf_nonce();
                $this->data['code'] = $code;

                //render
                $this->_render_page('admin/reset_password', $this->data);
            }
            else
            {
                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id'))
                {

                    //something fishy might be up
                    $this->ion_auth->clear_forgotten_password_code($code);

                    show_error($this->lang->line('error_csrf'));

                }
                else
                {
                    // finally change the password
                    $identity = $user->{$this->config->item('identity', 'ion_auth')};

                    $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

                    if ($change)
                    {
                        //if the password was successfully changed
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        $this->logout();
                    }
                    else
                    {
                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                        redirect('admin/reset_password/' . $code, 'refresh');
                    }
                }
            }
        }
        else
        {
            //if the code is invalid then send them back to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("admin/forgot_password", 'refresh');
        }
    }

    //log the user out
    public function logout()
    {
        //log the user out
        $logout = $this->ion_auth->logout();

        //redirect them to the login page
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect('admin/login', 'refresh');
    }

    public function cache()
    {
        //$this->cache->delete_all('model_test');
        $data['data'] = $this->cache->model('model_test', 'get', array()); // keep for 2 minutes
        //$data['data'] = $this->model_test->get(); // keep for 2 minutes

        $this->load->view('admin/cache', $data, FALSE);

    }

}
/* End of file admin.php */
/* Location: ./application/controllers/admin.php */