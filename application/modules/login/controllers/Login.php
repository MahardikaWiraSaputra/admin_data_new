<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('model_login');
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
    }

    public function index() 
    {
        if ($this->ion_auth->logged_in()) {
            redirect(base_url().'main/','refresh');
        } 
        else {
            // $this->load->view('login/login', $data);
            redirect(base_url().'login/masuk','refresh');
        }
    }

    public function masuk()
    {
        $data['title'] = 'Administrator Login';
        $this->load->view('login/login', $data);
    }

    public function sign(){
        if($this->ion_auth->logged_in()) {
            redirect(base_url().'main/','refresh');
        } 
        else {
            $data['title'] = 'Login Administrator';
            
            $this->form_validation->set_rules('username', 'Identity', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() == true){
                if ($this->ion_auth->login($this->input->post('username'), $this->input->post('password'))){
                    $output['success'] = true;
                    $output['message'] = $this->ion_auth->messages();
                    $output['url'] = base_url().'main/';
                    $this->session->set_userdata('periode',$this->input->post('periode'));
                   
                } 
                else {
                    $output['success'] = false;
                    $output['message'] = $this->ion_auth->errors();
                }
            } 
            else {
                $output['success'] = false;
                $output['message'] = $this->ion_auth->errors();
            }
            echo json_encode($output); 
        }
    }

    public function logout(){
        $data['title'] = 'Logout Administrator';
        if( $this->ion_auth->logout() ){
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            $this->session->unset_userdata('periode');
            redirect('login', 'refresh');
        }else{
            die(lang('logout_failed'));
        }
    }

}
