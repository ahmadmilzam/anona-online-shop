<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends Public_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->data['module'] = 'pages';
    }

	public function index()
	{
        $this->local_js     = array(
                                array('home.js')
                            );

        $this->carabiner->group('local_js', array('js'=>$this->local_js) );

        $this->template
             ->title($this->config->item('site_name'), 'Home')
             ->build('view_home', $this->data);
	}

}

/* End of file page.php */
/* Location: ./application/modules/page/controllers/page.php */