<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user_admin();
       $this->load->model('common_model');
       $this->load->model('login_model');
    }


    public function index()
    {
        $data = array();
        $data['page_title'] = 'App';
        $data['categories'] = $this->common_model->get_all_app_category();
        $data['main_content'] = $this->load->view('admin/app/add', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    public function app_list()
    {
        $data['apps'] = $this->common_model->get_all_app_admin();
        $data['main_content'] = $this->load->view('admin/app/app_list', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    //-- delete blog
    public function appdelete($id)
    {
        $this->common_model->delete($id,'code_app','appid'); 
        $this->session->set_flashdata('msg', 'App app deleted Successfully');
        redirect(base_url('admin/app/app_list'));
    }
    //-- update users info
    public function appupdate($id)
    {
        if ($_POST) {
            $data = array();
            $t=time();
            $jsfilename = '';
           if(!empty($_FILES['appfilename']['name'])){
                    $timestamp = time(); 
                  // Set preference 
                  $config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'plugins/'; 
                  $config['allowed_types'] = 'zip'; 
                  $config['max_size'] = '9200000'; // max_size in kb (5 MB) 
                  $config['file_name'] = $timestamp.$_FILES['appfilename']['name'];
                  // Load upload library 
                  $this->load->library('upload',$config); 

                  // File upload
                  if($this->upload->do_upload('appfilename')){ 
                     // Get data about the zipfile
                     $jsfilename = $config['file_name'];
                 }
                  $data = array(
                      'appfilename' => $jsfilename
                  );
                  $this->common_model->edit_option($data, $id, 'code_app', 'appid');
              }
            $this->load->library('upload');
           if(!empty($_FILES['app_icon']['name'])){
                $imageDataappicon = $this->common_model->upload_image('9200000','app_icon');
                $appicon = $imageDataappicon['images'];
                $data = array(
                    'app_icon' => $imageDataappicon['images']
                );
                $data = $this->security->xss_clean($data);
                $this->common_model->edit_option($data, $id, 'code_app', 'appid');
            } else {
            }

            // appslider
            $data = array(
                'appcat_array' => $_POST['appcat_array'],
                'apptitle' => $_POST['apptitle'],
                'apptitlearb' => $_POST['apptitlearb'],
                'appabout' => $_POST['appabout'],
                'appaboutarb' => $_POST['appaboutarb'],
                'app_feature_content' => $_POST['app_feature_content'],
                'app_feature_content_arb' => $_POST['app_feature_content_arb'],
                'appactive' => $_POST['appactive'],
                'apptime' => date("Y-m-d H:i:s",$t)
            );
            $data = $this->security->xss_clean($data);
            
                //-- check duplicate email

            //Code to send email...
            $gethtmlmail = $this->common_model->get_signup_mail("appapprove");
            $appurl = base_url('app/id/').$id;
            $useremail  = $this->common_model->get_email($_POST['appuser']);
            $completemail = str_replace("{{URL}}",$appurl,$gethtmlmail->newslettermail);
            $this->load->library('email'); 
            $this->email->from('storecreator.io@gmail.com', 'Storecreator');
            $this->email->to($useremail[0]->email,'Recipient Name');
            $this->email->subject($gethtmlmail->newslettersubject);
            $this->email->message($completemail); 
            try{
              $this->email->send();
            }catch(Exception $e){
            }


            $this->common_model->edit_option($data, $id, 'code_app', 'appid');
            if(!empty($_FILES['appslider']['name'])) {

              // Looping all files
                  $imageData = $this->common_model->upload_image('920000','appslider');
                  $dataslider = array(
                      'appsliderimg' => $imageData['images'],
                      'appparent' => $id
                  );

                  $dataslider = $this->security->xss_clean($dataslider);
                  $this->common_model->insert($dataslider, 'code_appslider');

            }

            // $this->session->set_flashdata('msg', 'App added Successfully');
            // redirect(base_url('admin/app/app_list'));
            
            
            

        }
        $data['app'] = $this->common_model->get_single_app_info($id);
        $data['categories'] = $this->common_model->get_all_app_category();
        $data['main_content'] = $this->load->view('admin/app/edit_app', $data, TRUE);
        $this->load->view('admin/index', $data);
    }


    public function comment()
    {
        if ($_POST) {
            $t=time();
            $data = array(
                'app_com_appid' => $_POST['comappname'],
                'app_com_user' => $_POST['comuser'],
                'app_com_comment' => $_POST['comcomment'],
                'app_com_date' => date("Y-m-d H:i:s",$t)
            );
            $data = $this->security->xss_clean($data);
            //-- check duplicate email
            $blog_id = $this->common_model->insert($data, 'code_app_comment');
            $this->session->set_flashdata('msg', 'App comment added Successfully');
            redirect(base_url('admin/app/comment_list'));
        
        }
        $data = array();
        $data['users'] = $this->common_model->get_all_user();
        $data['app'] = $this->common_model->get_all_app_admin();
        $data['page_title'] = 'App comment';
        $data['main_content'] = $this->load->view('admin/app/comment_add', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    public function comment_list()
    {
        $data['comments'] = $this->common_model->get_overall_app_comment();
        $data['main_content'] = $this->load->view('admin/app/comment_list', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    //-- delete blog
    public function appcommentdelete($id)
    {
        $this->common_model->delete($id,'code_app_comment','app_com_id'); 
        $this->session->set_flashdata('msg', 'App comment deleted Successfully');
        redirect(base_url('admin/app/comment_list'));
    }
    //-- update users info
    public function commentupdate($id)
    {
        if ($_POST) {
            
            $t=time();
            $data = array(
                'app_com_appid' => $_POST['comappname'],
                'app_com_user' => $_POST['comuser'],
                'app_com_comment' => $_POST['comcomment'],
                'app_com_date' => date("Y-m-d H:i:s",$t)
            );
            $data = $this->security->xss_clean($data);
            $this->common_model->edit_option($data, $id, 'code_app_comment', 'app_com_id');
            $this->session->set_flashdata('msg', 'Information Updated Successfully');
            redirect(base_url('admin/app/comment_list'));

        }
        $data['users'] = $this->common_model->get_all_user();
        $data['app'] = $this->common_model->get_all_app_admin();
        $data['comment'] = $this->common_model->get_single_app_comment_info($id);
        $data['main_content'] = $this->load->view('admin/app/edit_comment', $data, TRUE);
        $this->load->view('admin/index', $data);
        
    }


    public function category()
    {
        if ($_POST) {
            $data = array(
                'app_cat_name' => $_POST['categoryname'],
                'app_cat_name_arb' => $_POST['categorynamearb']
            );
            $data = $this->security->xss_clean($data);
            //-- check duplicate email
            $blog_id = $this->common_model->insert($data, 'code_app_categories');
            $this->session->set_flashdata('msg', 'App category added Successfully');
            redirect(base_url('admin/app/categories_list'));
        
        }
        $data = array();
        $data['page_title'] = 'App category';
        $data['main_content'] = $this->load->view('admin/app/category_add', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    public function categories_list()
    {
        $data['categories'] = $this->common_model->get_all_app_category();
        $data['main_content'] = $this->load->view('admin/app/categories_list', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    //-- delete blog
    public function appcategorydelete($id)
    {
        $this->common_model->delete($id,'code_app_categories','app_cat_id'); 
        $this->session->set_flashdata('msg', 'App Category deleted Successfully');
        redirect(base_url('admin/app/categories_list'));
    }
    //-- update users info
    public function categoryupdate($id)
    {
        if ($_POST) {
            $data = array(
                'app_cat_name' => $_POST['categoryname'],
                'app_cat_name_arb' => $_POST['categorynamearb']
            );
            $data = $this->security->xss_clean($data);
            $this->common_model->edit_option($data, $id, 'code_app_categories', 'app_cat_id');
            $this->session->set_flashdata('msg', 'Information Updated Successfully');
            redirect(base_url('admin/app/categories_list'));

        }

        $data['category'] = $this->common_model->get_single_app_category_info($id);
        $data['main_content'] = $this->load->view('admin/app/edit_categories', $data, TRUE);
        $this->load->view('admin/index', $data);
        
    }

    //-- add new user by admin
    public function add()
    {   
        if ($_POST) {

            $t=time();
            $jsfilename = '';
           if(!empty($_FILES['appfilename']['name'])){
                    $timestamp = time(); 
                  // Set preference 
                  $config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'plugins/'; 
                  $config['allowed_types'] = 'zip'; 
                  $config['max_size'] = '9200000'; // max_size in kb (5 MB) 
                  $config['file_name'] = $timestamp.$_FILES['appfilename']['name'];
                  // Load upload library 
                  $this->load->library('upload',$config); 

                  // File upload
                  if($this->upload->do_upload('app_filename')){ 
                     // Get data about the zipfile
                     $jsfilename = $config['file_name'];
                 }
              }

            $this->load->library('upload');
            $imageDataappicon = $this->common_model->upload_image('9200000','app_icon');

            $data = array(
                'app_icon' => $imageDataappicon['images'],
                'appcat_array' => $_POST['appcat_array'],
                'apptitle' => $_POST['apptitle'],
                'apptitlearb' => $_POST['apptitlearb'],
                'appabout' => $_POST['app_about_content'],
                'appaboutarb' => $_POST['app_about_content_arabic'],
                'app_feature_content' => $_POST['app_feature_content'],
                'app_feature_content_arb' => $_POST['app_feature_content_arabic'],
                'appactive' => $_POST['appactive'],
                'appfilename' => $jsfilename,
                'apptime' => date("Y-m-d H:i:s",$t)
            );
			$data = $this->security->xss_clean($data);
            
				//-- check duplicate email
			
			$blog_id = $this->common_model->insert($data, 'code_app');

          // Count total files
            if(!empty($_FILES['appslider']['name'])) {
                $countfiles = count((array)$_FILES['appslider']['name']);
              // Looping all files
              for($i=0;$i<$countfiles;$i++){
                if(!empty($_FILES['appslider']['name'][$i])){
                  // Define new $_FILES array - $_FILES['file']
                  $_FILES['appsliders']['name'] = $_FILES['appslider']['name'][$i];
                  $_FILES['appsliders']['type'] = $_FILES['appslider']['type'][$i];
                  $_FILES['appsliders']['tmp_name'] = $_FILES['appslider']['tmp_name'][$i];
                  $_FILES['appsliders']['error'] = $_FILES['appslider']['error'][$i];
                  $_FILES['appsliders']['size'] = $_FILES['appslider']['size'][$i];
                  // File upload
                  $imageData = $this->common_model->upload_image('9200000','appsliders');
                    $dataslider = array(
                        'appsliderimg' => $imageData['images'],
                        'appparent' => $insert_id
                    );

                    $dataslider = $this->security->xss_clean($dataslider);
                    $this->common_model->insert($dataslider, 'code_appslider');

                }
              }
          }

            $this->session->set_flashdata('msg', 'App added Successfully');
            redirect(base_url('admin/app/app_list'));
            
            
            

        }
    }



}