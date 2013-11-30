<?php defined('BASEPATH') OR exit('No direct script access.');

class MY_Controller extends MX_Controller {

    public $data            = array();
    public $active_page     = '';
    public $main_css        = array();
    public $main_js         = array();
    public $local_css       = array();
    public $local_js        = array();

    public function __construct()
    {
        $this->load->library('cache');
        $this->load->library('carabiner');

        $carabiner_config = array(
            'script_dir'    => 'assets/js/',
            'style_dir'     => 'assets/css/',
            'cache_dir'     => 'assets/cache/',
            'combine'       => TRUE,
            'minify_css'    => TRUE,
            'base_uri'      => base_url(),
            'minify_js'     => TRUE,
            //'dev'           => TRUE
        );
        $this->carabiner->config($carabiner_config);
    }

}

class Public_Controller extends MY_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->main_css = array(
            array('app.css')
        );

        $this->main_js = array(
            array('jquery.min.js'),
            array('foundation.min.js'),
            array('plugin.js'),
            array('app.js')
        );

        $this->carabiner->group('main_css', array('css'=>$this->main_css) );
        $this->carabiner->group('main_js', array('js'=>$this->main_js) );

        $this->template->set_layout('public_layout');
    }

}

class Admin_Controller extends MY_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->main_css = array(
            array('app.css'),
            array('font-awesome.min.css')
        );

        $this->main_js = array(
            array('jquery.js'),
            array('foundation.min.js')
        );

        $this->template->set_layout('admin_layout');

        /**
         * This code is for prevent back button to see the page after logout
         *
         * CI Version:
         */
        $this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
        $this->output->set_header('Pragma: no-cache');
        /**
         * PHP Version:
         * header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
         * header('Cache-Control: no-store, no-cache, must-revalidate');
         * header('Cache-Control: post-check=0, pre-check=0',false);
         * header('Pragma: no-cache');
         */

        // Load the session, CI2 as a library, CI3 uses it as a driver
        if (substr(CI_VERSION, 0, 1) == '2')
        {
            $this->load->library('session');
        }
        else
        {
            $this->load->driver('session');
        }
        // Load auth library only for admin section, it depends on your application
        $this->load->library('users/ion_auth');

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->form_validation->CI =& $this;    // Hack to make it work properly with HMVC

        //login check
        $exception_uri = array(
            'admin/login',
            'admin/logout',
            'admin/forgot_password',
            'admin/reset_password'
        );

        if(!in_array(uri_string(), $exception_uri))
        {
            if (!$this->ion_auth->logged_in())
            {
                //redirect them to the login page
                redirect('admin/login', 'refresh');
            }
        }
    }

}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */