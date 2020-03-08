<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Domain extends CI_Controller {

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
        $data['page_title'] = 'Domain';
        $data['users'] = $this->common_model->get_all_user();
        $data['categories'] = $this->common_model->get_all_domain_category();
        $data['main_content'] = $this->load->view('admin/domain/add_domain', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    //-- add new user by admin
    public function add()
    {   
        if ($_POST) {

            $t=time();
            $data = array(
                'domainuser' => $_POST['domainuser'],
                'domaintitle' => $_POST['domaintitle'],
                'domaintitlearb' => $_POST['domaintitlearb'],
                'domainlink' => $_POST['domainlink'],
                'domainsubdomain' => $_POST['domainsubdomain'],
                'categoryid' => $_POST['categoryid'],
                'seodescription' => $_POST['seodescription'],
                'seodescriptionarb' => $_POST['seodescriptionarb'],
                'seokeywords' => $_POST['seokeywords'],
                'seokeywordsarb' => $_POST['seokeywordsarb'],
                'footercode' => $_POST['footercode'],
                'headercode' => $_POST['headercode'],
                'hidefromsearchengine' => $_POST['hidefromsearchengine'],
                'domaintime' => date("Y-m-d H:i:s",$t)
            );
			
			$data = $this->security->xss_clean($data);

            if($_POST['domainlink'] != '') {
                $outPut = shell_exec("echo 'New@Store5000New' | sudo -S /bin/bash /var/www/storecreator.io/domaindns create ".$_POST['domainlink']);
            } else {
                $outPut = shell_exec("echo 'New@Store5000New' | sudo -S /usr/bin/bash /var/www/storecreator.io/virtualhost create ".$_POST['domainsubdomain']);
                $outPut2 = shell_exec("echo 'New@Store5000New' | sudo -S /usr/bin/certbot -d ".$_POST['domainsubdomain']." --no-redirect");
            }

			$domain_id = $this->common_model->insert($data, 'code_domain');

            $this->session->set_flashdata('msg', 'Domain added Successfully');
            redirect(base_url('admin/domain/domain_list'));
            
            
            

        }
    }
    public function domain_list()
    {
        $data['domains'] = $this->common_model->get_all_domain();
        $data['main_content'] = $this->load->view('admin/domain/domain', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    //-- update users info
    public function update($id)
    {
        if ($_POST) {
            $data['domain'] = $this->common_model->get_single_domain_info($id);

            $t=time();
            $data = array(
                'domainuser' => $_POST['domainuser'],
                'domaintitle' => $_POST['domaintitle'],
                'domaintitlearb' => $_POST['domaintitlearb'],
                'domainlink' => $_POST['domainlink'],
                'domainsubdomain' => $_POST['domainsubdomain'],
                'categoryid' => $_POST['categoryid'],
                'seodescription' => $_POST['seodescription'],
                'seodescriptionarb' => $_POST['seodescriptionarb'],
                'seokeywords' => $_POST['seokeywords'],
                'seokeywordsarb' => $_POST['seokeywordsarb'],
                'footercode' => $_POST['footercode'],
                'headercode' => $_POST['headercode'],
                'hidefromsearchengine' => $_POST['hidefromsearchengine'],
                'domaintime' => date("Y-m-d H:i:s",$t)
            );

            $data = $this->security->xss_clean($data);

            $this->common_model->edit_option($data, $id, 'code_domain', 'domainid');
            $this->session->set_flashdata('msg', 'Information Updated Successfully');
            redirect(base_url('admin/domain/domain_list'));

        }

        $data['users'] = $this->common_model->get_all_user();
        $data['categories'] = $this->common_model->get_all_domain_category();
        $data['domain'] = $this->common_model->get_single_domain_info($id);
        $data['main_content'] = $this->load->view('admin/domain/edit_domain', $data, TRUE);
        $this->load->view('admin/index', $data);
        
    }

    //-- delete domain
    public function delete($id)
    {
        $this->common_model->delete($id,'code_domain','domainid'); 
        $this->session->set_flashdata('msg', 'Domain deleted Successfully');
        redirect(base_url('admin/domain/domain_list'));
    }
    public function category_list()
    {
        $data['categories'] = $this->common_model->get_all_domain_category();
        $data['main_content'] = $this->load->view('admin/domain/category', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
    //-- add new user by admin
    public function category_add()
    {   
        if ($_POST) {

            $t=time();
            $data = array(
                'domaincatname' => $_POST['domaincatname'],
                'domaincatnamearb' => $_POST['domaincatnamearb'],
                'domaincattime' => date("Y-m-d H:i:s",$t)
            );
            
            $data = $this->security->xss_clean($data);

            $domain_id = $this->common_model->insert($data, 'code_domain_category');
            $this->session->set_flashdata('msg', 'Domain Category added Successfully');
            redirect(base_url('admin/domain/category_list'));
        }
    }
    public function category()
    {
        $data = array();
        $data['page_title'] = 'Domain Category';
        $data['main_content'] = $this->load->view('admin/domain/category_add', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
    //-- update users info
    public function categoryupdate($id)
    {
        if ($_POST) {
            $data['category'] = $this->common_model->get_single_domain_category_info($id);

            $t=time();
            $data = array(
                'domaincatname' => $_POST['domaincatname'],
                'domaincatnamearb' => $_POST['domaincatnamearb'],
                'domaincattime' => date("Y-m-d H:i:s",$t)
            );
            $data = $this->security->xss_clean($data);

            $this->common_model->edit_option($data, $id, 'code_domain_category', 'domaincatid');
            $this->session->set_flashdata('msg', 'Domain Category Updated Successfully');
            redirect(base_url('admin/domain/category_list'));

        }

        $data['category'] = $this->common_model->get_single_domain_category_info($id);
        $data['main_content'] = $this->load->view('admin/domain/edit_category', $data, TRUE);
        $this->load->view('admin/index', $data);
        
    }
    //-- delete domain
    public function categorydelete($id)
    {
        $this->common_model->delete($id,'code_domain_category','domaincatid'); 
        $this->session->set_flashdata('msg', 'Domain Category deleted Successfully');
        redirect(base_url('admin/domain/category_list'));
    }



}