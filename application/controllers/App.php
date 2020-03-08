<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App extends CI_Controller {

    public function __construct(){
        parent::__construct();
       $this->load->model('common_model');
    }


    public function index()
    {
        $data = array();
        $data['page_title'] = 'App';
        $data['app_category'] = $this->common_model->get_all_app_category();
        $data['app'] = $this->common_model->get_all_app();
        $data['main_content'] = $this->load->view('blog', $data, TRUE);
        $this->load->view('app', $data);
    }

    public function search()
    {
        $data = array();
        $data['page_title'] = 'Blog';
        $data['main_content'] = $this->load->view('blog', $data, TRUE);
        if (isset($_POST['query'])) {
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
         if ($_POST) {
            $message = $_POST['message'];
            $appid = $_POST['appid'];
            $userid = $_POST['userid'];
            $t=time();

            $data = array(
                'app_com_appid' => $appid,
                'app_com_user' => $userid,
                'app_com_comment' => $message,
                'app_com_date' => date("Y-m-d H:i:s",$t)
            );
            
            if (empty($email)) {
                $this->common_model->insert($data, 'code_app_comment');
                $this->session->set_flashdata('msg', 'Comment added Successfully');
                redirect(base_url('app/id/'.$appid));
            }else{
                redirect(base_url('app/id/'.$appid));
            }
        }else{
            $this->session->set_flashdata('error_msg', 'Sorry! You was lost.');
             redirect(base_url('home'));
        }
        
    }



}