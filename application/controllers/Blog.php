<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends CI_Controller {

    public function __construct(){
        parent::__construct();
       $this->load->model('common_model');
    }


    public function index()
    {
        $data = array();
        $data['page_title'] = 'Blog';
        $data['blog_content'] = $this->common_model->get_blog_custompages();
        $data['main_content'] = $this->load->view('blog', $data, TRUE);
        $data['blogs'] = $this->common_model->get_all_blog();
        $this->load->view('blog', $data);
    }

    public function search()
    {
        $data = array();
        $data['page_title'] = 'Blog';
        $data['blog_content'] = $this->common_model->get_blog_custompages();
        $data['main_content'] = $this->load->view('blog', $data, TRUE);
        if (isset($_POST)) {
            $data['blogs'] = $this->common_model->get_all_blog_search($_POST['query']);
        } else {
            $data['blogs'] = $this->common_model->get_all_blog();
        }
        $this->load->view('blog', $data);
    }
    //-- update users info
    public function id($id)
    {
        $data['latestblog'] = $this->common_model->get_all_blog_latest();
        $data['blog'] = $this->common_model->get_single_blog_info($id);
        $data['blogcomment'] = $this->common_model->get_all_post_comment($id);
        $data['main_content'] = $this->load->view('blog-detail', $data, TRUE);
        $this->load->view('blog-detail', $data);
        
    }
    //-- update users info
    public function comment()
    {
         if (isset($_POST)) {
            $message = $_POST['message'];
            $blogid = $_POST['blogid'];
            $userid = $_POST['userid'];
            $t=time();

            $data = array(
                'commentpost' => $blogid,
                'commentuser' => $userid,
                'commentcontent' => $message,
                'commenttitme' => date("Y-m-d H:i:s",$t)
            );
            
            if (empty($email)) {
                $this->common_model->insert($data, 'code_comment');
                $this->session->set_flashdata('msg', 'Comment added Successfully');
                redirect(base_url('blog/id/'.$blogid));
            }else{
                redirect(base_url('blog/id/'.$blogid));
            }
        }else{
            $this->session->set_flashdata('error_msg', 'Sorry! You was lost.');
             redirect(base_url('home'));
        }
        
    }



}