<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Developer extends CI_Controller {

    public function __construct(){
        parent::__construct();
       $this->load->model('common_model');
        $this->load->model('login_model');
        $this->load->helper('url');
        $this->load->library('session');
    }


    public function index()
    {
        $data = array();
        $data['page_title'] = 'Developer';
        $data['developer'] = $this->common_model->get_single_custompages_info('developer');
        $this->load->view('developer', $data);
    }

    public function signup()
    {
        check_login_user_or_no_developer();
        $data = array();
        $data['page_title'] = 'Signup';
        $this->load->view('signup-developer', $data);
        if ($_POST) {

            $data = array(
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'email' => $_POST['email'],
                'password' => md5($_POST['password']),
                'status' => 1,
                'role' => 'developer',
                'created_at' => current_datetime()
            );

            $data = $this->security->xss_clean($data);
            
            //-- check duplicate email
            $email = $this->common_model->check_email_developer($_POST['email']);

            if (empty($email)) {
                $user_id = $this->common_model->insert($data, 'user');
            
                if ($this->input->post('role') == "user") {
                    $actions = $this->input->post('role_action');
                    foreach ($actions as $value) {
                        $role_data = array(
                            'user_id' => $user_id,
                            'action' => $value
                        ); 
                       $role_data = $this->security->xss_clean($role_data);
                       $this->common_model->insert($role_data, 'user_role');
                    }
                }
                //Code to send email...
                $gethtmlmail = $this->common_model->get_signup_mail("signup");

                $this->load->library('email'); 
                $this->email->from('storecreator.io@gmail.com', 'Storecreator');
                $this->email->to($_POST['email'],'Recipient Name');
                $this->email->subject('Account Created');
                $this->email->message($gethtmlmail->newslettermail); 
                try{
                $this->email->send();
                }catch(Exception $e){
                echo $e->getMessage();
                }
                /*****************************/
                $this->session->set_flashdata('msg', 'User added Successfully');
                redirect(base_url('developer/login'));
            } else {
                $this->session->set_flashdata('error_msg', 'Email already exist, try another email');
                redirect(base_url('developer/signup'));
            }
            

        }
    }

    public function login()
    {
        check_login_user_or_no_developer();
        $data = array();
        $data['page'] = 'Login';
        $this->load->view('login-developer', $data);

    }

    public function log(){
        check_login_user_or_no_developer();

        if($_POST){ 
            $query = $this->login_model->validate_user_developer();
            //-- if valid
            if($query){
                $data = array();
                foreach($query as $row){
                    $data = array(
                        'id' => $row->id,
                        'name' => $row->first_name,
                        'email' =>$row->email,
                        'role' =>$row->role,
                        'islogin' => TRUE
                    );
                    $this->session->set_userdata($data);
                    $url = base_url('signup-developer');
                }
                $this->session->set_flashdata('msg', 'Login Successfully');
                redirect(base_url('developer/dashboard'));
            }else{
                $this->session->set_flashdata('error_msg', 'Sorry Username or password is wrong');
                redirect(base_url('developer/login'));
            }
            
        }else{
            $data = array();
            $data['page'] = 'Login';
            $this->load->view('login',$data);
        }
    }

    public function dashboard()
    {
        // check_login_user_no_developer();
        $data = array();
        if($_POST){ 
            if(isset($_POST['appform'])) {
            
                $this->load->library('form_validation'); 
                $this->form_validation->set_error_delimiters('', '');       
                $this->form_validation->set_rules('title', 'Title', 'required');
                $this->form_validation->set_rules('titlearabic', 'Arabic Title', 'required');
                $this->form_validation->set_rules('appcategory', 'App Category', 'required');
                $this->form_validation->set_rules('content', 'Content', 'required');
                $this->form_validation->set_rules('arabiccontent', 'Arabic Content', 'required');
                $this->form_validation->set_rules('feature', 'Feature', 'required');
                $this->form_validation->set_rules('arabicfeature', 'Arabic Feature', 'required');

                //$this->form_validation->set_rules('email', 'Email', 'required');
                $data = array();
                $dataslider = array();
                if ($this->form_validation->run() == TRUE)
                {

                    $jsfilename = '';
                   if(!empty($_FILES['jsfile']['name'])){
                            $timestamp = time(); 
                          // Set preference 
                          $config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'plugins/'; 
                          $config['allowed_types'] = 'zip'; 
                          $config['max_size'] = '9200000'; // max_size in kb (5 MB) 
                          $config['file_name'] = $timestamp.$_FILES['jsfile']['name'];
                          // Load upload library 
                          $this->load->library('upload',$config); 

                          // File upload
                          if($this->upload->do_upload('jsfile')){ 
                             // Get data about the zipfile
                             $uploadData = $this->upload->data(); 
                             $jsfilename = $timestamp.$uploadData['file_name'];
                         }
                      }

                    $this->load->library('upload');
                    $imageDataappicon = $this->common_model->upload_image('9200000','appicon');

                    $ci =& get_instance();

                    $data = array(
                        'app_icon' => $imageDataappicon['images'],
                        'apptitle' => $_POST['title'],
                        'apptitlearb' => $_POST['titlearabic'],
                        'appcat_array' => $_POST['appcategory'],
                        'appabout' => $_POST['content'],
                        'appaboutarb' => $_POST['arabiccontent'],
                        'app_feature_content' => $_POST['feature'],
                        'appfilename' => $jsfilename,
                        'appuser' => $ci->session->userdata('id'),
                        'appactive' => '1',
                        'app_feature_content_arb' => $_POST['arabicfeature']
                    );

                    $data = $this->security->xss_clean($data);
                    $this->common_model->insert($data, 'code_app');
                    $insert_id = $this->db->insert_id();

                      if(!empty($_FILES['multipleimg']['name'])){
                        // Count total files
                        $countfiles = count($_FILES['multipleimg']['name']);
                        // Looping all files
                        for($i=0;$i<$countfiles;$i++){
                          if(!empty($_FILES['multipleimg']['name'][$i])){
                            // Define new $_FILES array - $_FILES['file']
                            $_FILES['multipleimgs']['name'] = $_FILES['multipleimg']['name'][$i];
                            $_FILES['multipleimgs']['type'] = $_FILES['multipleimg']['type'][$i];
                            $_FILES['multipleimgs']['tmp_name'] = $_FILES['multipleimg']['tmp_name'][$i];
                            $_FILES['multipleimgs']['error'] = $_FILES['multipleimg']['error'][$i];
                            $_FILES['multipleimgs']['size'] = $_FILES['multipleimg']['size'][$i];
                            // File upload
                            $imageData = $this->common_model->upload_image('9200000','multipleimgs');
                              $dataslider = array(
                                  'appsliderimg' => $imageData['images'],
                                  'appparent' => $insert_id
                              );

                              $dataslider = $this->security->xss_clean($dataslider);
                              $this->common_model->insert($dataslider, 'code_appslider');

                          }
                        }
                      }

                    //Code to send email...
                    $gethtmlmail = $this->common_model->get_signup_mail("appupload");
                    $this->load->library('email'); 
                    $this->email->from('storecreator.io@gmail.com', 'Storecreator');
                    $this->email->to($ci->session->userdata('email'),'Recipient Name');
                    $this->email->subject($gethtmlmail->newslettersubject);
                    $this->email->message($gethtmlmail->newslettermail); 
                    try{
                    $this->email->send();
                    }catch(Exception $e){
                    }


                    $this->session->set_flashdata('msg', 'App added Successfully. Please wait for approval!');
                    redirect(base_url('developer/dashboard'));
                } else {
                    $this->session->set_flashdata('error_msg', validation_errors());
                    redirect(base_url('developer/dashboard'));
                }

            } 
            if(isset($_POST['themeform'])) {
            
                $this->load->library('form_validation'); 
                $this->form_validation->set_error_delimiters('', '');       
                $this->form_validation->set_rules('title', 'Title', 'required');
                $this->form_validation->set_rules('arabictitle', 'Arabic Title', 'required');
                $this->form_validation->set_rules('link', 'Link', 'required');
                $this->form_validation->set_rules('type', 'Type', 'required');
                $this->form_validation->set_rules('arbtype', 'Arabic Type', 'required');

                //$this->form_validation->set_rules('email', 'Email', 'required');
                $data = array();
                if ($this->form_validation->run() == TRUE)
                {

                   if(!empty($_FILES['zipfile']['name'])){
                      $timestamp = time(); 
                      // Set preference 
                      $config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'zip/'; 
                      $config['allowed_types'] = 'zip'; 
                      $config['max_size'] = '9200000'; // max_size in kb (5 MB) 
                      $config['file_name'] = $timestamp.$_FILES['zipfile']['name'];
                      // Load upload library 
                      $this->load->library('upload',$config); 

                      // File upload
                      if($this->upload->do_upload('zipfile')){ 

                         // Get data about the zipfile
                         $uploadData = $this->upload->data(); 
                         $zipfilename = $uploadData['file_name'];

                     }else{ 
                     } 
                  }

                    $ci =& get_instance();

                    $this->load->library('upload');
                    $imageData = $this->common_model->upload_image('9200000','themeimage');
                    $data = array(
                        'themetitle' => $_POST['title'],
                        'themetitlearb' => $_POST['arabictitle'],
                        'themelink' => $_POST['link'],
                        'themetype' => $_POST['type'],
                        'themeimage' => $imageData['images'],
                        'themefile' => $zipfilename,
                        'themeuser' => $ci->session->userdata('id'),
                        'themeactive' => '1',
                        'themetypearb' => $_POST['arbtype']
                    );

                    $data = $this->security->xss_clean($data);
                    $this->common_model->insert($data, 'code_theme');


                    //Code to send email...
                    $gethtmlmail = $this->common_model->get_signup_mail("themeupload");
                    $this->load->library('email'); 
                    $this->email->from('storecreator.io@gmail.com', 'Storecreator');
                    $this->email->to($ci->session->userdata('email'),'Recipient Name');
                    $this->email->subject($gethtmlmail->newslettersubject);
                    $this->email->message($gethtmlmail->newslettermail); 
                    try{
                    $this->email->send();
                    }catch(Exception $e){
                    }
                    
                    $this->session->set_flashdata('msg', 'Theme added Successfully. Please wait for approval!');



                    redirect(base_url('developer/dashboard'));
                } else {
                    $this->session->set_flashdata('error_msg', validation_errors());
                    redirect(base_url('developer/dashboard'));
                }
            }
        }

        $data['page'] = 'Developer Dashboard';
        $data['appcategory'] = $this->common_model->get_all_app_category();
        $this->load->view('dashboard-developer', $data);

    }

}