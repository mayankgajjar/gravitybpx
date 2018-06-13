<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Ajax extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        }
    }

    public function getcity() {
        $post = $this->input->post();
        if ($post) {
            $this->db->where('state_id', $post['state']);
            $cities = $this->db->get('city')->result();
            $html = '<select class="form-control" name="city">';
            $html .= '<option value="">Please Select</option>';
            foreach ($cities as $city) {
                $selected = '';
                if (isset($post['city']) && ucwords($city->name) == ucwords($post['city'])) {
                    $selected = 'selected="selected"';
                }
                $html .= '<option value="' . ucwords($city->name) . '" ' . $selected . '>' . $city->name . '</option>';
            }
            $html .= '</select>';
            $data['success'] = TRUE;
            $data['result'] = $html;
            return $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode($data));
        } else {
            $data['success'] = FALSE;
            $data['html'] = '<input type="text" name="city" class="form-control" />';
            return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($data));
        }
    }

    public function getagents() {
        $this->load->model('agents');
        $post = $this->input->post();
        if ($post && $post['is_ajax'] == true) {
            unset($post['is_ajax']);
            $agencyId = $post['id'];
            if(decode_url($agencyId)){
                $agencyId = decode_url($agencyId);
            }
            $relation = array(
                "fields" => "GROUP_CONCAT(DISTINCT agents.id) AS agents,GROUP_CONCAT(DISTINCT CONCAT(agents.fname,' ',agents.lname)) as names,count(agency_id) as total,name",
                "JOIN" => array(
                    array(
                        "table" => 'agencies age',
                        "condition" => 'age.id = agents.agency_id ',
                        "type" => 'LEFT'
                    ),
                ),
                "GROUP_BY" => 'agency_id',
                'conditions' => "agency_id = {$agencyId} "
            );
            $agents = $this->agents->get_relation('', $relation);
            $html = '';
            $html = '<option value="">Please select agent</option>';
            foreach($agents as $agent){
                $html .= '<optgroup label="'.$agent['name'].'">';
                if($agent['total'] > 0){
                    $ages = explode(',',$agent['names']);
                    $ids = explode(',',$agent['agents']);
                    foreach($ages as $key => $ag){
                         $html .= '<option data-agency="'.$agent['name'].'" value="'. encode_url($ids[$key]).'">'.$ag.'</option>';
                    }
                }                
                $html .= '</optgroup>';
            }
            return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array('success' => true, 'html' => $html)));            
            
        }
    }
    
    public function checkPhone($id='') {
        $phone_number =  $this->input->post('phone');
        if(isset($id)){
            $con_arr = array('phone' => $phone_number , 'user' => $this->session->userdata('agent')->id , 'lead_id !=' => $id);
        } else {
            $con_arr = array('phone' => $phone_number , 'user' => $this->session->userdata('agent')->id);
        }
        
        $query = $this->db->where($con_arr)->get('lead_store_mst');
        if ($query->num_rows() != 0) {
            echo 'false';
            //$msg = "Phone number is already exist, please try other number";
        } else {
            echo 'true';
            //$msg = "Phone number is valid";
        }
        //echo $msg;
    }
    
    public function checkEmail($id='') {
        $email =  $this->input->post('email');
        if(isset($id)){
            $con_arr = array('email' => $email , 'user' => $this->session->userdata('agent')->id , 'lead_id !=' => $id);
        } else {
            $con_arr = array('email' => $email , 'user' => $this->session->userdata('agent')->id);
        }
        
        $query = $this->db->where($con_arr)->get('lead_store_mst');
        if ($query->num_rows() != 0) {
            echo 'false';
            //$msg = "Email address is already exist, please try other email address";
        } else {
            echo 'true';
            //$msg = "Email address is valid";
        }
        //echo $msg;
    }


}
