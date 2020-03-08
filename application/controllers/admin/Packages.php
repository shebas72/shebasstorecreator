<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Packages extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user_admin();
       $this->load->model('common_model');
       $this->load->model('login_model');
	   $this->load->database();
    }


    public function index()
    {
        $data = array();
        $data['page_title'] = 'Packages';
        $data['main_content'] = $this->load->view('admin/packages/add', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    //-- add new user by admin
    public function add()
    {   
        if ($_POST) {

            $data = array(
                'packagetitle' => $_POST['packagetitle'],
                'packagetitlearb' => $_POST['packagetitlearb'],
                'packageprice' => $_POST['packageprice'],
                'packageprice12' => $_POST['packageprice12'],
                'packageprice24' => $_POST['packageprice24'],
                'packagepricearb' => $_POST['packagepricearb'],
                'packagepricearb12' => $_POST['packagepricearb12'],
                'packagepricearb24' => $_POST['packagepricearb24'],
                'pack_domain' => $_POST['pack_domain'],
                'pack_disk' => $_POST['pack_disk'],
                'pack_bandwidth' => $_POST['pack_bandwidth']
            );

            $data = $this->security->xss_clean($data);
            
            //-- check duplicate email
            $packages_id = $this->common_model->insert($data, 'code_packages');

			foreach($_POST['action_name'] as $key => $fields){
				$batch_data[] = array(
					'packattparent'=> $packages_id,
                    'packattkey'=> $_POST['action_key'][$key],
                    'packattvalue'=> $fields,
					'packattvaluearb'=> $_POST['action_namearb'][$key],
				);
			}

			$this->db->insert_batch('code_packages_attribute',$batch_data);
            
			$this->session->set_flashdata('msg', 'Packages added Successfully');
            redirect(base_url('admin/packages/all_packages_list'));
            
            
            

        }
    }

    public function all_packages_list()
    {
        $data['packages'] = $this->common_model->get_all_packages();
        $data['main_content'] = $this->load->view('admin/packages/packages', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    //-- update users info
    public function update($id)
    {
        if ($_POST) {

            $data = array(
                'packagetitle' => $_POST['packagetitle'],
                'packagetitlearb' => $_POST['packagetitlearb'],
                'packageprice' => $_POST['packageprice'],
                'packageprice12' => $_POST['packageprice12'],
                'packageprice24' => $_POST['packageprice24'],
                'packagepricearb' => $_POST['packagepricearb'],
                'packagepricearb12' => $_POST['packagepricearb12'],
                'packagepricearb24' => $_POST['packagepricearb24'],
                'pack_domain' => $_POST['pack_domain'],
                'pack_disk' => $_POST['pack_disk'],
                'pack_bandwidth' => $_POST['pack_bandwidth'],
                'packageorder' => $_POST['packageorder'],
                'packagedefault' => $_POST['packagedefault']
            );
            $data = $this->security->xss_clean($data);
			
			$this->db->where('packattparent', $id);
			$this->db->delete('code_packages_attribute');
			
            foreach($_POST['action_name'] as $key => $fields){
				$batch_data[] = array(
					'packattparent'=> $id,
					'packattkey'=> $_POST['action_key'][$key],
					'packattvalue'=> $fields,
                    'packattvaluearb'=> $_POST['action_namearb'][$key],
				);
			}
			
			$this->db->insert_batch('code_packages_attribute',$batch_data);
			$this->common_model->edit_option($data, $id, 'code_packages', 'packageid');
            $this->session->set_flashdata('msg', 'Information Updated Successfully');
            redirect(base_url('admin/packages/all_packages_list'));

        }

        $data['packages'] = $this->common_model->get_single_packages_info($id);
		$query = $this->db->get_where('code_packages_attribute', array('packattparent' => $id));
		$data['packages_attr'] = $query->result();
        $data['main_content'] = $this->load->view('admin/packages/edit_package', $data, TRUE);
        $this->load->view('admin/index', $data);
        
    }

    
    //-- active packages
    public function active($id) 
    {
        $data = array(
            'status' => 1
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'packages');
        $this->session->set_flashdata('msg', 'Packages active Successfully');
        redirect(base_url('admin/packages/all_packages_list'));
    }

    //-- deactive packages
    public function deactive($id) 
    {
        $data = array(
            'status' => 0
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'packages');
        $this->session->set_flashdata('msg', 'Packages deactive Successfully');
        redirect(base_url('admin/packages/all_packages_list'));
    }

    //-- delete packages
    public function delete($id)
    {
        $this->common_model->delete($id,'code_packages','packageid'); 
        $this->session->set_flashdata('msg', 'Packages deleted Successfully');
        redirect(base_url('admin/packages/all_packages_list'));
    }


}