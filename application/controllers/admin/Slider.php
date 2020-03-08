<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Slider extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user_admin();
       $this->load->model('common_model');
       $this->load->model('login_model');
		$this->load->library('upload');
		$this->load->database();
    }
	
	public function index()
    {
        $data = array();
        $data['page_title'] = 'Slider';
        $data['main_content'] = $this->load->view('admin/slider/add', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	public function all_slider_list()
    {
        $data['sliders'] = $query = $this->db->get('code_slider')->result_array();
		$data['main_content'] = $this->load->view('admin/slider/slider', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	public function add()
    {   
       if(!empty($_FILES['sliderimage']['name'])){

            
            //-- check duplicate email
				$imageData = $this->common_model->upload_image('92000','sliderimage');
				$data['sliderimg'] = $imageData['images'];
				$data = $this->security->xss_clean($data);

                $slider_id = $this->common_model->insert($data, 'code_slider');
                $this->session->set_flashdata('msg', 'Slider Image added Successfully');
                redirect(base_url('admin/slider/all_slider_list'));

        }else{
			
					$this->session->set_flashdata('msg', 'Please select image');
					redirect(base_url('admin/slider'));
		}
    }
	
	
	 public function update($id)
    {
		 if(!empty($_FILES['sliderimage']['name'])){
     
			$imageData = $this->common_model->upload_image('92000','sliderimage');
			$data['sliderimg'] = $imageData['images'];
			$data = $this->security->xss_clean($data);
            $this->common_model->edit_option($data, $id, 'code_slider', 'sliderid');
            $this->session->set_flashdata('msg', 'Information Updated Successfully');
            redirect(base_url('admin/slider/all_slider_list'));

        }

        $data['slider'] = $query = $this->db->get_where('code_slider',array('sliderid'=>$id))->result();
        $data['main_content'] = $this->load->view('admin/slider/edit_slider', $data, TRUE);
        $this->load->view('admin/index', $data);
	}

}