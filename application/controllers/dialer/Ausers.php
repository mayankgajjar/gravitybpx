<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ausers extends CI_Controller{
    public function __construct(){
        parent::__construct();
        if(!$this->session->userdata("user")){
            redirect('login');
        }else{
            if($this->session->userdata("user")->group_name != 'Agency'){
                    redirect('/Forbidden');
            }
        }
        $this->data = array(
            "meta_title" => "Dialer Users",
            "title" => "Dialer Users",
            "breadcrumb" => "Dialer",
            "formtitle" => "",
            "listtitle" => "",
            "modelname" => "Dcampaign_m",
            "formactioncontroller" => "",
            "addactioncontroller" => "",
            "deleteactioncontroller" => "",
            "openparentsli" => "configuration",
            "activeparentsli" => "status_management",
            "deletetitle" => "Status",
            "datatablecontroller" => "statusmanagementcontroller/indexJson",
        );
        $this->load->library('vicidialdb');
        $this->load->model('vicidial/vusers_m','vusers_m');
        $this->load->model('vicidial/vugroup_m','vugroup_m');
        $this->load->model('vicidial/vinagent_m', 'vinagent_m');
        $this->load->model('agency_model');
        $this->load->model('agent_model');
    }

    public function agencyusers(){
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert'] = TRUE;
        $id = $this->session->userdata('agency')->id;
        $this->db->where(array('id' => $id));
        $agency = $this->db->get('agencies')->row();
        $this->data['breadcrumb'] = 'Dialer';
        $this->data['title'] = 'Dialer agencies users for : <strong>'. $agency->name.'</strong>';
        $this->data['listtitle'] = 'Dialer Agencies Users';

        $this->data['agencies'] = $this->agency_model->getAllAgencyInfo($id);
        $this->template->load("agency","dialer/agency/users/list",$this->data);
    }

    public function agenctusers(){
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert'] = TRUE;
        $id = $this->session->userdata('agency')->id;
        $agency = $this->agency_model->getAgencyInfo($id);
        $this->data['title'] = 'Dialer agents users for : <strong>'. $agency->name.'</strong>';
        $this->data['listtitle'] = 'Dialer Agents Users';
        $this->data['agents'] = $this->agent_model->getAllAgentInfo($id);

        $this->template->load("agency","dialer/agency/users/agent/list",$this->data);
    }

    public function edit($id=NULL){
        $this->data['validation'] = TRUE;
        $this->data['formtitle'] = 'Users';
        $this->data['groups'] = $this->vugroup_m->get();
        $rules = $this->vusers_m->rules;
        unset($rules['user_group']);
        if($id){
            $id = decode_url($id);
            $this->data['user'] = $this->vusers_m->get_by(array('user_id' => $id), TRUE);
            count($this->data['user']) || $this->data['errors'][] = 'User could not find.';
            $this->data['listtitle'] = 'Edit User '.$this->data['user']->user;
            $rules['pass']['rules'] = 'trim';
        }else{
            $this->data['listtitle'] = 'Add New User';
            $this->data['user'] = $this->vusers_m->get_new();
            redirect('dialer/ausers/agencyusers');
        }
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run() == TRUE){
            $data = $this->vusers_m->array_from_post(array(
                'email', 'pass', 'full_name', 'active'
            ));
            if(!$id){
                $data['user'] = clean($data['email']);
            }
            if( isset($data['pass']) && $data['pass'] == ''){
                unset($data['pass']);
            }
            //$other = $this->vusers_m->roles[$data['user_level']];
            //$newData = array_merge($data, $other);
            $userId = $this->vusers_m->save($data,$id);
            if($userId){
                $this->session->set_flashdata('success','User saved successfully.');
                redirect('dialer/ausers/edit/'.encode_url($userId));
            }else{
                $this->session->set_flashdata('error','Some thing went wrong.');
                redirect('dialer/ausers/edit/'.encode_url($id));
            }
        }

        $this->template->load('agency','dialer/agency/users/edit',$this->data);
    }

    public function agentedit($id = NULL, $agencyId = NULL){
        $this->data['validation'] = TRUE;
        $this->data['formtitle'] = 'Users';
        $this->data['title'] = 'Agent User';
        $this->data['groups'] = $this->vugroup_m->get();
        $agencyId = decode_url($agencyId);
        $this->data['agencyId'] = $agencyId;
        $rules = $this->vusers_m->rules;

        if($id){
            $id = decode_url($id);
            $this->data['user'] = $this->vusers_m->get_by(array('user_id' => $id), TRUE);
            count($this->data['user']) || $this->data['errors'][] = 'User could not find.';
            $this->data['listtitle'] = 'Edit User '.$this->data['user']->user;
            $rules['pass']['rules'] = 'trim';
            $agencyId = getAgncyFromUserId($this->data['user']->user_id);
            $this->data['ingroups'] = getInboundGroupsForUser($agencyId);
            $this->data['inagents'] = $this->vinagent_m->get_by_array(array('user' => $this->data['user']->user));
        }else{
            $this->data['listtitle'] = 'Add New User';
            $this->data['user'] = $this->vusers_m->get_new();
            redirect('dialer/ausers/agencyusers');
        }
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run() == TRUE){
            $data = $this->vusers_m->array_from_post(array(
                'email', 'pass', 'full_name', 'active', 'user_group'
            ));
            if(!$id){
                $data['user'] = clean($data['email']);
            }
            if( isset($data['pass']) && $data['pass'] == ''){
                unset($data['pass']);
            }
            //$other = $this->vusers_m->roles[$data['user_level']];
            //$newData = array_merge($data, $other);
            $userId = $this->vusers_m->save($data,$id);
            if($userId){
                if($this->input->post('ingroup')){
                    foreach($this->input->post('ingroup') as $ingroup){
                        if(strlen($this->data['user']->user) > 0){
                            $user = $this->data['user']->user;
                        }else{
                            $user = $userId;
                        }
                        $group_id = $ingroup;
                        $group_rank = $this->input->post('RANK_'.$ingroup);
                        $group_grade = $this->input->post('GRADE_'.$ingroup);
                        $group_web_vars = $this->input->post('WEB_'.$ingroup);
                        $vinagent = $this->vinagent_m->get_by(array('group_id' => $group_id,'user' => $user),TRUE);
                        $vId = NULL;
                        if($vinagent){
                            $vId = $vinagent->id;
                        }
                        $data = array('user' => $user, 'group_id' => $group_id, 'group_rank' => $group_rank, 'group_grade' => $group_grade, 'group_web_vars' => $group_web_vars );
                        $this->vinagent_m->save($data, $vId);
                    }
                }
                $this->session->set_flashdata('success','User saved successfully.');
                $this->session->set_flashdata('success','User saved successfully.');
                redirect('dialer/ausers/agentedit/'.encode_url($userId).'/'.  encode_url($agencyId));
            }else{
                $this->session->set_flashdata('error','Some thing went wrong.');
                redirect('dialer/ausers/agentedit/'.encode_url($id).'/'.  encode_url($agencyId));
            }
        }

        $this->template->load('agency','dialer/agency/users/agent/edit',$this->data);
    }

    public function profileedit($id=NULL){
        $this->data['validation'] = TRUE;
        $this->data['formtitle'] = 'Users';
        $this->data['groups'] = $this->vugroup_m->get();
        $rules = $this->vusers_m->rules;
        unset($rules['user_group']);
        if($id){
            $id = decode_url($id);
            $this->data['user'] = $this->vusers_m->get_by(array('user_id' => $id), TRUE);
            count($this->data['user']) || $this->data['errors'][] = 'User could not find.';
            $this->data['listtitle'] = 'Edit User '.$this->data['user']->user;
            $rules['pass']['rules'] = 'trim';
        }else{
            $this->data['listtitle'] = 'Add New User';
            $this->data['user'] = $this->vusers_m->get_new();
        }
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run() == TRUE){
            $data = $this->vusers_m->array_from_post(array(
                'email', 'pass', 'full_name', 'active'
            ));
            if(!$id){
                $data['user'] = clean($data['email']);
            }
            if( isset($data['pass']) && $data['pass'] == ''){
                unset($data['pass']);
            }
            //$other = $this->vusers_m->roles[$data['user_level']];
            //$newData = array_merge($data, $other);
            $userId = $this->vusers_m->save($data,$id);
            if($userId){
                $this->session->set_flashdata('msg','User saved successfully.');
                redirect('agency/profile');
            }else{
                $this->session->set_flashdata('msg','Some thing went wrong.');
                redirect('agency/profile');
            }
        }
         redirect('agency/profile');
    }
    public function _unique_email($email){
        $id = $this->uri->segment(4);
        $id = decode_url($id);
        $this->vicidialdb->db->where('email',$this->input->post('email'));
        !$id || $this->vicidialdb->db->where(' user_id!=', $id);
        $user = $this->vicidialdb->db->get('vicidial_users')->result();

        if(count($user)){
            $this->form_validation->set_message('_unique_email','%s should be unique.');
            return FALSE;
        }
        return TRUE;
    }

    public function createagency($agencyId =NULL){
        if($agencyId){
            $agencyId = decode_url($agencyId);
            $agency = $this->agency_model->getAgencyInfo($agencyId);

            if(!$agency){
                $this->session->set_flashdata('error','Agency not exists.');
                redirect('dialer/ausers/agencyusers');
            }
            //$user = $this->user_model->getAgencyFromUser_id($agency->user_id);
            $data = array(
                'id' => $agency->id,
                'name' => $agency->name,
                'password' => clean(base64_decode($agency->password)),
                'email' => $agency->email_id,
                'user'  => 'agency'.$agency->id
            );
            $res = $this->vusers_m->addAgencyFromCrm($data);
            if($res){
                $this->session->set_flashdata('success','Dialer user created successfully.');
            }
        }else{
            $this->session->set_flashdata('error','Agency id not find.');
        }
        redirect('dialer/ausers/agencyusers');
    }
    public function createagent($agentId =NULL){
        $this->data['validation'] = TRUE;
        $this->data['formtitle'] = 'Users';
        $this->data['title'] = 'Agent User';
        $this->data['groups'] = $this->vugroup_m->get();
        $this->load->model('agent_model');
        if($agentId){
            $agentId = decode_url($agentId);
            $agent = $this->agent_model->getAgentInfo($agentId);

            $this->data['ingroups'] = getInboundGroupsForUser($agent->agency_id);
            $this->data['inagents'] = array();
            if(!isset($agent->id) && $agent->id > 0){
                $this->session->set_flashdata('msg','Agent does not exists.');
                redirect('admin/manage_agent/view');
            }
            $this->data['metatitle'] = 'Create New Agent User';
            $this->data['listtitle'] = 'Create new user for :'. $agent->fname.' '.$agent->lname;
            //$user = $this->user_model->getAgencyFromUser_id($agency->user_id);
            $this->data['user'] = new stdClass();
            $this->data['user']->id =  $agent->id;
            $this->data['user']->full_name = $agent->fname.' '.$agent->lname;
            $this->data['user']->pass = base64_decode($agent->password);
            $this->data['user']->email = $agent->email_id;
            $this->data['agencyId'] = $agent->agency_id;
            $rules = $this->vusers_m->rules;
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run() == TRUE){
                $data = $this->vusers_m->array_from_post(array(
                    'email', 'pass', 'full_name', 'active', 'user_group'
                ));
                $data['user'] = 'agent'.$agent->id;
                $data['user_level'] = '1';
                $roles = $this->vusers_m->roles['1'];
                $data['pass'] = clean($data['pass']);
                $newUserData = array_merge($data, $roles);
                $vicidialUSerId = $this->vusers_m->save($newUserData,NULL);
                if($vicidialUSerId){
                    $this->agent_model->update($agent->id,array('vicidial_user_id' => $vicidialUSerId));
                    redirect('dialer/ausers/agenctusers');
                }
            }
//            $this->data = array(
//                'id' => $agent->id,
//                'name' => $agent->fname.' '.$agent->lname,
//                'password' => base64_decode($agent->password),
//                'email' => $agent->email_id
//            );
           // $res = $this->vusers_m->addAgentFromCrm($data);
           // if($res){
             //   $this->session->set_flashdata('success','Dialer user created successfully.');
           // }
        }else{
            $this->session->set_flashdata('msg','Agent id does not exists.');
            redirect('dialer/ausers/agenctusers');
        }
        $this->template->load('agency','dialer/agency/users/agent/add',$this->data);
        //redirect('dialer/ausers/agenctusers');
    }
}
