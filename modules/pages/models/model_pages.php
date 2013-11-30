<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_page extends MY_Model {

    public function get_redaksi()
    {
        $this->db->where('status', 'aktif');
        $this->db->get('table_redaksi');

        $result = $this->db->result();

        return $result;
    }

}

/* End of file model_page.php */
/* Location: ./application/modules/page/models/model_page.php */