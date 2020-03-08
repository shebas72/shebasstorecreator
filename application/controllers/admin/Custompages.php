<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Custompages extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user_admin();
       $this->load->model('common_model');
       $this->load->model('login_model');
    }


    public function index()
    {
        $data = array();
        $data['page_title'] = 'Custompages';
        $data['main_content'] = $this->load->view('admin/custompages/add', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    //-- add new user by admin
    public function add()
    {   
        if ($_POST) {
            $t=time();
            $data = array(
                'pagestitle' => $_POST['pagestitle'],
                'pagestitlearb' => $_POST['pagestitlearb'],
                'pagescontent' => $_POST['pagescontent'],
                'pagescontentarb' => $_POST['pagescontentarb'],
                'pageslug' => $_POST['pageslug'],
                'pagestime' => date("Y-m-d H:i:s",$t)
            );

            $data = $this->security->xss_clean($data);
            
            //-- check duplicate email
                $custompages_id = $this->common_model->insert($data, 'code_pages')
                ;
                $this->session->set_flashdata('msg', 'Custompages added Successfully');
                redirect(base_url('admin/custompages/all_custompages_list'));
            
            
            

        }
    }

    public function all_custompages_list()
    {
        $data['pages'] = $this->common_model->get_all_custompages();
        $data['main_content'] = $this->load->view('admin/custompages/custompages', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    //-- update users info
    public function update($id)
    {
        if ($_POST) {
            $t=time();
            $data = array(
                'pagestitle' => $_POST['pagestitle'],
                'pagestitlearb' => $_POST['pagestitlearb'],
                'pagescontent' => $_POST['pagescontent'],
                'pagescontentarb' => $_POST['pagescontentarb'],
                'pageslug' => $_POST['pageslug'],
                'pagestime' => date("Y-m-d H:i:s",$t)
            );
            $data = $this->security->xss_clean($data);

            $this->common_model->edit_option($data, $id, 'code_pages', 'pagesid');
            $this->session->set_flashdata('msg', 'Information Updated Successfully');
            redirect(base_url('admin/custompages/all_custompages_list'));

        }

        $data['pages'] = $this->common_model->get_single_custompages_info($id);
        $data['main_content'] = $this->load->view('admin/custompages/edit_custompage', $data, TRUE);
        $this->load->view('admin/index', $data);
        
    }

    
    //-- active custompages
    public function active($id) 
    {
        $data = array(
            'status' => 1
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'custompages');
        $this->session->set_flashdata('msg', 'Custompages active Successfully');
        redirect(base_url('admin/custompages/all_custompages_list'));
    }

    //-- deactive custompages
    public function deactive($id) 
    {
        $data = array(
            'status' => 0
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'custompages');
        $this->session->set_flashdata('msg', 'Custompages deactive Successfully');
        redirect(base_url('admin/custompages/all_custompages_list'));
    }

    //-- delete custompages
    public function delete($id)
    {
        $this->common_model->delete($id,'code_pages','pagesid'); 
        $this->session->set_flashdata('msg', 'Custompages deleted Successfully');
        redirect(base_url('admin/custompages/all_custompages_list'));
    }


}