<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Theme extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user_admin();
       $this->load->model('common_model');
       $this->load->model('login_model');
        $this->load->helper('url');
        $this->load->library('session');
    }


    public function index()
    {
        $data = array();
        $data['page_title'] = 'Theme';
        $data['main_content'] = $this->load->view('admin/theme/add', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    //-- add new user by admin
    public function add()
    {   
        if ($_POST) {

            $data = array(
                'themetype' => $_POST['themetype'],
                'themeuser' => $_POST['themeuser'],
                'themeactive' => '2',
                'themetypearb' => $_POST['themetypearb'],
                'themetitle' => $_POST['themetitle'],
                'themetitlearb' => $_POST['themetitlearb'],
                'themefolder' => $_POST['themefolder'],
                //'themeimage' => $_POST['themeimage'],
                'themelink' => $_POST['themelink']
            );

            $data = $this->security->xss_clean($data);
            
            //-- check duplicate email

                $this->load->library('upload');
                if (!empty($_FILES['themeimage']['name'])) {
                    $imageData = $this->common_model->upload_image('92000000','themeimage');
                    $data['themeimage'] = $imageData['images'];
                }
                $theme_id = $this->common_model->insert($data, 'code_theme');
                $this->session->set_flashdata('msg', 'Theme added Successfully');
                redirect(base_url('admin/theme/all_theme_list'));
                
            
            
            

        }
    }

    public function all_theme_list()
    {
        $data['themes'] = $this->common_model->get_all_theme_admin();
        $data['main_content'] = $this->load->view('admin/theme/themes', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    //-- update users info
    public function update($id)
    {
        if ($_POST) {
			$data['theme'] = $this->common_model->get_single_theme_info($id);
            $data = array(
                'themetype' => $_POST['themetype'],
                'themeuser' => $_POST['themeuser'],
                'themeactive' => '2',
                'themetypearb' => $_POST['themetypearb'],
                'themetitle' => $_POST['themetitle'],
                'themetitlearb' => $_POST['themetitlearb'],
                'themefolder' => $_POST['themefolder'],
                'themelink' => $_POST['themelink']
            );
            $data = $this->security->xss_clean($data);
				

                $this->load->library('upload');
                if (!empty($_FILES['themeimage']['name'])) {
                  $imageData = $this->common_model->upload_image('92000000','themeimage');
                  $data['themeimage'] = $imageData['images'];
                }

            //Code to send email...
            $gethtmlmail = $this->common_model->get_signup_mail("themeapprove");
            $appurl = base_url('themes');
            $useremail  = $this->common_model->get_email($_POST['themeuser']);
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


            $this->common_model->edit_option($data, $id, 'code_theme', 'themeid');
            $this->session->set_flashdata('msg', 'Information Updated Successfully');
            // redirect(base_url('admin/theme/all_theme_list'));

        }

        $data['theme'] = $this->common_model->get_single_theme_info($id);
        $data['main_content'] = $this->load->view('admin/theme/edit_theme', $data, TRUE);
        $this->load->view('admin/index', $data);
        
    }

    
    //-- active theme
    public function active($id) 
    {
        $data = array(
            'status' => 1
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'theme');
        $this->session->set_flashdata('msg', 'Theme active Successfully');
        redirect(base_url('admin/theme/all_theme_list'));
    }

    //-- deactive theme
    public function deactive($id) 
    {
        $data = array(
            'status' => 0
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'theme');
        $this->session->set_flashdata('msg', 'Theme deactive Successfully');
        redirect(base_url('admin/theme/all_theme_list'));
    }

    //-- delete theme
    public function delete($id)
    {
        $this->common_model->delete($id,'code_theme','themeid'); 
        $this->session->set_flashdata('msg', 'Theme deleted Successfully');
        redirect(base_url('admin/theme/all_theme_list'));
    }


}