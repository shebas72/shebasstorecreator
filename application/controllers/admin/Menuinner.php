<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menuinner extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user_admin();
       $this->load->model('common_model');
       $this->load->model('login_model');
    }

	public function index()
    {
        $data = array();
        $data['page_title'] = 'Menu Inner Settings';
		$data['menus'] = $this->common_model->get_all_menus();
        $data['main_content'] = $this->load->view('admin/settings/menu_inner/add', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	 public function all_menu_inner_list()
    {
        $data['menuinners'] = $this->common_model->get_all_menu_inners();
        $data['main_content'] = $this->load->view('admin/settings/menu_inner/menu_inner', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
    public function active($id)
    {   
        $data['menuinnner'] = $this->common_model->get_single_menu_inner_info($id);
        if($data['menuinnner']->menuineeractive == '1') {

            $data = array(
                'menuineeractive' => '2'
            );
            $data = $this->security->xss_clean($data);

            $this->common_model->edit_option($data, $id, 'code_menuinner', 'menuinnerid');

        } else {

            $data = array(
                'menuineeractive' => '1'
            );
            $data = $this->security->xss_clean($data);

            $this->common_model->edit_option($data, $id, 'code_menuinner', 'menuinnerid');

        }
        $this->session->set_flashdata('msg', 'Menu Inner updated Successfully');
        redirect(base_url('admin/menuinner/all_menu_inner_list'));

    }
	
	public function add()
    {   
		 if ($_POST) {
            $data = array(
				'menuinnerparentid' => $_POST['menuinnerparent'],
                'menuinnertext' => $_POST['menuinnertitle'],
                'menuinnertextarb' => $_POST['menuinnertextarb'],
                'menuinnerlink' => $_POST['menuinnerlink'],
            );
			
			$data = $this->security->xss_clean($data);
            
			//-- check duplicate email
			$blog_id = $this->common_model->insert($data, 'code_menuinner');
			$this->session->set_flashdata('msg', 'Menu inner added Successfully');
			redirect(base_url('admin/menuinner/all_menu_inner_list'));
        }
	}
	
	
	public function update($id)
    {	
		if ($_POST) {
            $data = array(
                'menuinnerparentid' => $_POST['menuinnerparent'],
                'menuinnertext' => $_POST['menuinnertitle'],
                'menuinnertextarb' => $_POST['menuinnertextarb'],
                'menuinnerlink' => $_POST['menuinnerlink'],
            );
            $data = $this->security->xss_clean($data);

            $this->common_model->edit_option($data, $id, 'code_menuinner', 'menuinnerid');
            $this->session->set_flashdata('msg', 'Information Updated Successfully');
            redirect(base_url('admin/menuinner/all_menu_inner_list'));

        }
		$data['menus'] = $this->common_model->get_all_menus();
		$data['menuinnner'] = $this->common_model->get_single_menu_inner_info($id);
        $data['main_content'] = $this->load->view('admin/settings/menu_inner/edit_menu_inner', $data, TRUE);
        $this->load->view('admin/index', $data);
	}
	
	//-- delete blog
    public function delete($id)
    {
        $this->common_model->delete($id,'code_menuinner','menuinnerid'); 
        $this->session->set_flashdata('msg', 'Menu Inner deleted Successfully');
        redirect(base_url('admin/menuinner/all_menu_inner_list'));
    }
}