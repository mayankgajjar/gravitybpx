<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emailconfiguration extends CI_Controller{

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        }
        $this->load->model('emailconfiguration_m');
    }

    public function index(){
        $this->data['datatable'] = TRUE;
        $this->data['title'] = 'Email Configuration';
        $this->data['title_email'] = 'Email Configuration';
        $this->data['title_smtp'] = 'SMTP Configuration';
        $this->data['pagetitle'] = 'Email Configuration';
        $this->data['listtitle'] = 'Email Configuration';
        $this->data['label'] = 'Email Configuration';
        $sql = "SELECT * FROM `email_configuration` WHERE `user_id` = {$this->session->userdata('agent')->user_id} AND `is_delete` = 'No' AND `config_type` = 'Email_Client'";
        $query = $this->db->query($sql);
        $this->data['emailclient_already_added'] =  $query->num_rows();
        
        $sql2 = "SELECT * FROM `email_configuration` WHERE `user_id` = {$this->session->userdata('agent')->user_id} AND `is_delete` = 'No' AND `config_type` = 'SMTP'";
        $query2 = $this->db->query($sql2);
        $this->data['smtp_already_added'] =  $query2->num_rows();
        
        $this->template->load('agent','email_configuration/index', $this->data);
    }
    
   public function emailjson(){
        $table = 'email_configuration email';
        $aColumns = array('email.configuration_id','email.username','email.host','email.port','email.ssl_type','email.smtp_type','email.config_type');
        $bColumns = array('configuration_id','username','host','port','ssl_type','smtp_type','config_type');
        
        $relation = array(
                "fields" => 'email.configuration_id,email.username,email.host,email.port,email.ssl_type,email.smtp_type,email.config_type',
            );    
        
        $relation['conditions'] = "email.user_id = {$this->session->userdata('agent')->user_id} AND email.is_delete = 'NO'";
         
        /** Ordering */
        if (isset($_GET['iSortCol_0'])) {
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $relation['ORDER_BY']['field'] = $aColumns[$i];
                    $relation['ORDER_BY']['order'] = $_GET['sSortDir_' . $i];
                }
            }
        }

        // /*
        //  * Filtering
        //  * NOTE this does not match the built-in DataTables filtering which does it
        //  * word by word on any field. It's possible to do here, but concerned about efficiency
        //  * on very large tables, and MySQL's regex functionality is very limited
        //  */
        $sWhere = "";
        if ($_GET['sSearch'] != "") {

            $sWhere .= " AND (";
            for ($i = 0; $i < count($aColumns); $i++) {
                $sWhere .= $aColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ') ';
        }
        $relation['conditions'] .= $sWhere;

        $aFilterResult = $this->emailconfiguration_m->get_relation($table, $relation);
        /** Paging */
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $relation['LIMIT']['start'] = $_GET['iDisplayLength'];
            $relation['LIMIT']['end'] = $_GET['iDisplayStart'];
        }
        $rResult = $this->emailconfiguration_m->get_relation($table, $relation);
        
        /*echo $this->db->last_query();
        die;*/
      
        if ($aFilterResult) {
            $iFilteredTotal = count($aFilterResult);
        } else {
            $iFilteredTotal = 0;
        }
        $iTotal = $iFilteredTotal;

        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array()
        );

        $segement = $_GET['iDisplayStart'];
        $count = 1;

        if ($segement) :
            $count = $_GET['iDisplayStart'] + 1;
        endif;

        if ($rResult) {
            foreach ($rResult as $aRow) {
                $row = array();
                for ($i = 0; $i < count($bColumns); $i++) {
                    if($bColumns[$i] == 'configuration_id'){
                        $row[] = $count++;
                    } elseif ($bColumns[$i] == 'config_type') {
                        $row[] = str_replace('_', ' ', $aRow[$bColumns[$i]]);
                    } else {
                        $row[] = isset($aRow[$bColumns[$i]]) ? $aRow[$bColumns[$i]] : '';
                    }
                }
               
                if(strtolower($aRow['configuration_id'])){                    
                    $row[] = '<a class="edit_configuration" title="Edit Configuration" data-custom-value="'. encode_url($aRow['configuration_id']).'"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;'
                        . '<a class="delete_configuration" title="Delete Configuration" data-custom-value="'. encode_url($aRow['configuration_id']).'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                } 
                
                $output['aaData'][] = $row;
            }
        } else {
            $output['aaData'] = array();
        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
        
    }
    
    public function SaveConfiguration(){
        $save_arr = $this->input->post();
        $this->form_validation->set_rules($this->emailconfiguration_m->rules);
       
        if ($this->form_validation->run() == TRUE) {
            if($save_arr['config_type'] == 'SMTP'){
                $data = $this->emailconfiguration_m->array_from_post(array('username', 'port', 'host', 'smtp_type','config_type'));
            } else {
                $data = $this->emailconfiguration_m->array_from_post(array('username', 'port', 'host', 'ssl_type','config_type'));
            }
            
            if(isset($save_arr['id']) && $save_arr['id'] != ''){
                $id = $save_arr['id'];
            }
            $data['password'] = base64_encode($this->input->post('password'));
            $data['user_id'] = $this->session->userdata('agent')->user_id;
            $data['is_delete'] = 'No';
            $this->emailconfiguration_m->save($data, $id);
            echo 'Configuration saved successfully';
        } else {
            echo 'Configuration is not saved';
        }
    }
    
    public function delete_configuration(){
        $id = decode_url($this->input->post('id'));
        $data['is_delete'] = 'Yes';
        $this->emailconfiguration_m->save($data, $id);
        echo 'Configuration Successfully Deleted';
    }
    
    public function edit_configuration(){
        $id = decode_url($this->input->post('id'));
        $this->db->where('configuration_id',$id);
        $query = $this->db->get('email_configuration');
        $data['data'] = $query->row_array();
        
//        $data['title'] = 'Email Configuration';
        echo json_encode($data);
    }
    
    
}
