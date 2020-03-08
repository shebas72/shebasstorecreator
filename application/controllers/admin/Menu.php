<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user_admin();
       $this->load->model('common_model');
       $this->load->model('login_model');
    }

	public function index()
    {
        $data = array();
        $data['page_title'] = 'Menu Settings';
        $data['main_content'] = $this->load->view('admin/settings/menu/add', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	 public function all_menu_list()
    {
        $data['menus'] = $this->common_model->get_all_menus();
        $data['main_content'] = $this->load->view('admin/settings/menu/menu', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	
	 public function add()
    {   
		 if ($_POST) {
            $data = array(
                'menuname' => $_POST['menuname'],
                'menulocation' => $_POST['menulocation'],
            );
			
			$data = $this->security->xss_clean($data);
            
			//-- check duplicate email
			$blog_id = $this->common_model->insert($data, 'code_menu');
			$this->session->set_flashdata('msg', 'Menu added Successfully');
			redirect(base_url('admin/menu/all_menu_list'));
        }
	}
	
	    //-- update users info
    public function update($id)
    {	
		if ($_POST) {
            $data = array(
                'menuname' => $_POST['menuname'],
                'menulocation' => $_POST['menulocation'],
            );
            $data = $this->security->xss_clean($data);

            $this->common_model->edit_option($data, $id, 'code_menu', 'menuid');
            $this->session->set_flashdata('msg', 'Information Updated Successfully');
            redirect(base_url('admin/menu/all_menu_list'));

        }
	
		$data['menu'] = $this->common_model->get_single_menu_info($id);
        $data['main_content'] = $this->load->view('admin/settings/menu/edit_menu', $data, TRUE);
        $this->load->view('admin/index', $data);
	}
	
	//-- delete blog
    public function delete($id)
    {
        $this->common_model->delete($id,'code_menu','menuid'); 
        $this->session->set_flashdata('msg', 'Menu deleted Successfully');
        redirect(base_url('admin/menu/all_menu_list'));
    }
}