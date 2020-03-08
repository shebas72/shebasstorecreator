<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends CI_Controller {

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
        $data['page_title'] = 'Blog';
        $data['domains'] = $this->common_model->get_all_domain();
        $data['main_content'] = $this->load->view('admin/blog/add', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    //-- add new user by admin
    public function add()
    {   
        if (isset($_POST['submit'])) {

            $data = array(
                'blogtitle' => $_POST['blogtitle'],
                'blogtitlearb' => $_POST['blogtitlearb'],
                //'blogimg' => $_POST['blogimg'],
                'blogdate' => $_POST['blogdate'],
                'blogtime' => $_POST['blogtime'],
                'blogcontent' => $_POST['blogcontent'],
                'blogcontentarb' => $_POST['blogcontentarb']
            );
			
			
			
			$data = $this->security->xss_clean($data);
            
				//-- check duplicate email
			
				$imageData = $this->common_model->upload_image('92000','blogimg');
				$data['blogimg'] = !empty($imageData['images']) ? $imageData['images'] : "";

				$blog_id = $this->common_model->insert($data, 'code_blog');
                $this->session->set_flashdata('msg', 'Blog added Successfully');
                redirect(base_url('admin/blog/all_blog_list'));
            
            
            

        }
    }

    public function all_blog_list()
    {
        $data['blogs'] = $this->common_model->get_all_blog();
        $data['main_content'] = $this->load->view('admin/blog/blogs', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    //-- update users info
    public function update($id)
    {
        if (isset($_POST['submit'])) {
			$data['blog'] = $this->common_model->get_single_blog_info($id);

            $data = array(
                'blogtitle' => $_POST['blogtitle'],
                'blogtitlearb' => $_POST['blogtitlearb'],
                //'blogimg' => $_POST['blogimg'],
                'blogdate' => $_POST['blogdate'],
                'blogtime' => $_POST['blogtime'],
                'blogcontent' => $_POST['blogcontent'],
                'blogcontentarb' => $_POST['blogcontentarb']
            );
            $data = $this->security->xss_clean($data);
			if(empty($_POST['existedImage']) || $_POST['existedImage'] != $data['blog']->blogimg){
				$imageData = $this->common_model->upload_image('92000','blogimg');
				$data['blogimg'] = $imageData['images'];
			}else{
				$data['blogimg'] = $_POST['existedImage'];
			}
            $this->common_model->edit_option($data, $id, 'code_blog', 'blogid');
            $this->session->set_flashdata('msg', 'Information Updated Successfully');
            redirect(base_url('admin/blog/all_blog_list'));

        }

        $data['blog'] = $this->common_model->get_single_blog_info($id);
        $data['main_content'] = $this->load->view('admin/blog/edit_blog', $data, TRUE);
        $this->load->view('admin/index', $data);
        
    }

    
    //-- active blog
    public function active($id) 
    {
        $data = array(
            'status' => 1
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'blog');
        $this->session->set_flashdata('msg', 'Blog active Successfully');
        redirect(base_url('admin/blog/all_blog_list'));
    }

    //-- deactive blog
    public function deactive($id) 
    {
        $data = array(
            'status' => 0
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'blog');
        $this->session->set_flashdata('msg', 'Blog deactive Successfully');
        redirect(base_url('admin/blog/all_blog_list'));
    }

    //-- delete blog
    public function delete($id)
    {
        $this->common_model->delete($id,'code_blog','blogid'); 
        $this->session->set_flashdata('msg', 'Blog deleted Successfully');
        redirect(base_url('admin/blog/all_blog_list'));
    }


}