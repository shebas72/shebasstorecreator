<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App extends CI_Controller {

    public function __construct(){
        parent::__construct();
       $this->load->model('common_model');
       
    }


    public function index(){
        $data['page_title'] = 'Profile';
        $id = $this->session->userdata('id');
        $data['user'] = $this->common_model->get_single_user_info($id);
        //$data['user_role'] = $this->common_model->get_user_role($id);
        $data['country'] = $this->common_model->select('country');
        $data['main_content'] = $this->load->view('admin/user/profile', $data, TRUE);
        $this->load->view('admin/index', $data);
    }


    public function search()
    {
        $data = array();
        $data['page_title'] = 'Blog';
        $data['blog_content'] = $this->common_model->get_blog_custompages();
        $data['main_content'] = $this->load->view('blog', $data, TRUE);
        if ($_POST) {
            $data['app'] = $this->common_model->get_all_app_search($_POST['query']);
        } else {
            $data['app'] = $this->common_model->get_all_app();
        }
        $this->load->view('appsearch', $data);
    }
    //-- update users info
    public function id($id)
    {
        $data['app'] = $this->common_model->get_single_app_info($id);
        $data['appcomment'] = $this->common_model->get_all_app_comment($id);
        $data['appslider'] = $this->common_model->get_single_app_slider($id);
        $this->load->view('app-detail', $data);
        
    }
    //-- update users info
    public function comment()
    {
        //  if ($_POST) {
        //     $message = $_POST['message'];
        //     $blogid = $_POST['blogid'];
        //     $userid = $_POST['userid'];
        //     $t=time();

        //     $data = array(
        //         'commentpost' => $blogid,
        //         'commentuser' => $userid,
        //         'commentcontent' => $message,
        //         'commenttitme' => date("Y-m-d H:i:s",$t)
        //     );
            
        //     if (empty($email)) {
        //         $this->common_model->insert($data, 'code_comment');
        //         $this->session->set_flashdata('msg', 'Comment added Successfully');
        //         redirect(base_url('blog/id/'.$blogid));
        //     }else{
        //         redirect(base_url('blog/id/'.$blogid));
        //     }
        // }else{
        //     $this->session->set_flashdata('error_msg', 'Sorry! You was lost.');
        //      redirect(base_url('home'));
        // }
        
    }



}