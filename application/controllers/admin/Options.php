<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Options extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user_admin();
       $this->load->model('common_model');
       $this->load->model('login_model');
    }
	
	public function index()
    {
        $data = array();
        $data['page_title'] = 'Options Settings';
        $data['main_content'] = $this->load->view('admin/settings/options/edit_options', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	 public function update()
    {	
		if ($_POST) {
			foreach($_POST as $post){
				$data = array(
					'optionkey' => $post['key'],
                    'optionvalue' => $post['value'],
					'optionvaluearb' => $post['valuearb'],
				);
				$data = $this->security->xss_clean($data);

				$this->common_model->edit_option($data, $post['id'], ' code_option', 'optionid');
			}
            $this->session->set_flashdata('msg', 'Information Updated Successfully');
            redirect(base_url('admin/options'));

        }
        $data['main_content'] = $this->load->view('admin/settings/options/edit_options', $data, TRUE);
        $this->load->view('admin/index', $data);
	}
}
