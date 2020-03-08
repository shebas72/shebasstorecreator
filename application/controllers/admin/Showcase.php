<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Showcase extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user_admin();
       $this->load->model('common_model');
       $this->load->model('login_model');
		$this->load->library('upload');
    }


    public function index()
    {
        $data = array();
        $data['page_title'] = 'Showcase';
        $data['main_content'] = $this->load->view('admin/showcase/add', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    //-- add new user by admin
    public function add()
    {   
        if ($_POST) {

            $data = array(
                'showcasetype' => $_POST['showcasetype'],
                'showcasetitle' => $_POST['showcasetitle'],
                //'showcaseimage' => $_POST['showcaseimage'],
                'showcaselink' => $_POST['showcaselink']
            );

            $data = $this->security->xss_clean($data);
            
            //-- check duplicate email
				$imageData = $this->common_model->upload_image('92000','showcaseimage');
				$data['showcaseimage'] = $imageData['images'];

                $showcase_id = $this->common_model->insert($data, 'code_showcase');
                $this->session->set_flashdata('msg', 'Showcase added Successfully');
                redirect(base_url('admin/showcase/all_showcase_list'));
        }
    }

    public function all_showcase_list()
    {
        $data['showcases'] = $this->common_model->get_all_showcase();
        $data['main_content'] = $this->load->view('admin/showcase/showcases', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    //-- update users info
    public function update($id)
    {
        if ($_POST) {
			$data['showcase'] = $this->common_model->get_single_showcase_info($id);
            $data = array(
                'showcasetype' => $_POST['showcasetype'],
                'showcasetitle' => $_POST['showcasetitle'],
                //'showcaseimage' => $_POST['showcaseimage'],
                'showcaselink' => $_POST['showcaselink']
            );
            $data = $this->security->xss_clean($data);
			
			if($_POST['existedImage'] != $data['showcase']->showcaseimage){
				$imageData = $this->common_model->upload_image('92000','showcaseimage');
				$data['showcaseimage'] = $imageData['images'];
			}else{
				$data['showcaseimage'] = $_POST['existedImage'];
			}
			
            $this->common_model->edit_option($data, $id, 'code_showcase', 'showcaseid');
            $this->session->set_flashdata('msg', 'Information Updated Successfully');
            redirect(base_url('admin/showcase/all_showcase_list'));

        }

        $data['showcase'] = $this->common_model->get_single_showcase_info($id);
        $data['main_content'] = $this->load->view('admin/showcase/edit_showcase', $data, TRUE);
        $this->load->view('admin/index', $data);
        
    }

    
    //-- active showcase
    public function active($id) 
    {
        $data = array(
            'status' => 1
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'showcase');
        $this->session->set_flashdata('msg', 'Showcase active Successfully');
        redirect(base_url('admin/showcase/all_showcase_list'));
    }

    //-- deactive showcase
    public function deactive($id) 
    {
        $data = array(
            'status' => 0
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'showcase');
        $this->session->set_flashdata('msg', 'Showcase deactive Successfully');
        redirect(base_url('admin/showcase/all_showcase_list'));
    }

    //-- delete showcase
    public function delete($id)
    {
        $this->common_model->delete($id,'code_showcase','showcaseid'); 
        $this->session->set_flashdata('msg', 'Showcase deleted Successfully');
        redirect(base_url('admin/showcase/all_showcase_list'));
    }


}