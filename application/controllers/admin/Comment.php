<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comment extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user_admin();
       $this->load->model('common_model');
       $this->load->model('login_model');
    }


    public function index()
    {
        $data = array();
        $data['users'] = $this->common_model->get_all_user();
        $data['blogs'] = $this->common_model->get_all_blog();
        $data['page_title'] = 'Comment';
        $data['main_content'] = $this->load->view('admin/comment/add', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    //-- add new user by admin
    public function add()
    {   
        if ($_POST) {

            $t=time();
            $data = array(
                'commentpost' => $_POST['commentpost'],
                'commentuser' => $_POST['commentuser'],
                'commentcontent' => $_POST['commentcontent'],
                'commenttitme' => date("Y-m-d H:i:s",$t)
            );

            $data = $this->security->xss_clean($data);
            
            //-- check duplicate email
                $comment_id = $this->common_model->insert($data, 'code_comment')
                ;
                $this->session->set_flashdata('msg', 'Comment added Successfully');
                redirect(base_url('admin/comment/all_comment_list'));
            
            
            

        }
    }

    public function all_comment_list()
    {
        $data['comments'] = $this->common_model->get_all_comment();
        $data['main_content'] = $this->load->view('admin/comment/comments', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    //-- update users info
    public function update($id)
    {
        if ($_POST) {

            $t=time();
            $data = array(
                'commentpost' => $_POST['commentpost'],
                'commentuser' => $_POST['commentuser'],
                'commentcontent' => $_POST['commentcontent'],
                'commenttitme' => date("Y-m-d H:i:s",$t)
            );
            $data = $this->security->xss_clean($data);

            $this->common_model->edit_option($data, $id, 'code_comment', 'commentid');
            $this->session->set_flashdata('msg', 'Information Updated Successfully');
            redirect(base_url('admin/comment/all_comment_list'));

        }

        $data['comment'] = $this->common_model->get_single_comment_info($id);
        $data['users'] = $this->common_model->get_all_user();
        $data['blogs'] = $this->common_model->get_all_blog();
        $data['main_content'] = $this->load->view('admin/comment/edit_comment', $data, TRUE);
        $this->load->view('admin/index', $data);
        
    }

    
    //-- active comment
    public function active($id) 
    {
        $data = array(
            'status' => 1
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'comment');
        $this->session->set_flashdata('msg', 'Comment active Successfully');
        redirect(base_url('admin/comment/all_comment_list'));
    }

    //-- deactive comment
    public function deactive($id) 
    {
        $data = array(
            'status' => 0
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'comment');
        $this->session->set_flashdata('msg', 'Comment deactive Successfully');
        redirect(base_url('admin/comment/all_comment_list'));
    }

    //-- delete comment
    public function delete($id)
    {
        $this->common_model->delete($id,'code_comment','commentid'); 
        $this->session->set_flashdata('msg', 'Comment deleted Successfully');
        redirect(base_url('admin/comment/all_comment_list'));
    }


}