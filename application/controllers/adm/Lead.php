<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lead extends CI_Controller{

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            if ($this->session->userdata("user")->group_name != 'Admin') {
                redirect('/Forbidden');
            }
        }
        $this->load->model('leadstore_m');
        $this->load->model('agency_model');
        $this->load->model('agents');
        $this->load->model('leadfield_m');
        $this->load->model('leadfieldval_m');
        $this->load->model('leadnotes_m');
    }

    public function index(){
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert'] = TRUE;
        $this->data['title'] = 'Admin | CRM Lead';
        $this->data['maintitle'] = 'Lead';
        $this->data['listtitle'] = "Lead Listing";
        $this->data['label'] = "Lead";
        $this->data['type'] = 'Lead';
        $this->data['addactioncontroller'] = 'adm/lead/edit';
        $this->data['importactioncontroller'] = 'adm/lead/loadbulk/lead';
        $this->data['exportactioncontroller'] = 'adm/lead/export/lead';
        $this->template->load('admin','crm/list',$this->data);
    }

    public function indexjson($type = NULL){
        $aColumns = array('lead_id', 'main.first_name','ag.fname', 'member_id','dispo','city', 'phone', 'status', 'last_local_call_time', 'name');
        /*
         * Paging
         */
        $sLimit = "";
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = " LIMIT " . $_GET['iDisplayStart'] . ", " .
                    $_GET['iDisplayLength'];
        }

        /*
         * Ordering
         */
        if (isset($_GET['iSortCol_0'])) {
            $sOrder = "ORDER BY  ";
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $sOrder .= $aColumns[intval($_GET['iSortCol_' . $i])] . "
                                            " . $_GET['sSortDir_' . $i] . ", ";
                }
            }

            $sOrder = substr_replace($sOrder, "", -2);
            if ($sOrder == "ORDER BY") {
                $sOrder = "";
            }
        }

        /*
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        $sWhere = "";
        if($type == NULL){
            $type = 'Lead';
        }
        $sWhere = "WHERE status = '{$type}' ";
        if ($_GET['sSearch'] != "") {
            $sWhere .= "AND (";
            for ($i = 0; $i < count($aColumns); $i++) {
                    $sWhere .= $aColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ') ';
        }

        $rResult = $this->leadstore_m->query($sWhere, $sOrder, $sLimit);

        $aFilterResult = $this->leadstore_m->query($sWhere);
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
                //$row[] = $count++;

                for ($i = 0; $i < count($aColumns); $i++) {
                        if($aColumns[$i] == 'lead_id'){
                            $row[] = '<input type="checkbox" class="checkboxes"  name="id[]" value="' . encode_url($aRow['lead_id']) . '"/>';
                        }else{
                            $row[] = isset($aRow[$aColumns[$i]]) ? $aRow[$aColumns[$i]] : '';
                        }
                }

                 $row[] = '<a href="' . site_url('adm/lead/edit/'. lcfirst($type).'/'. encode_url($aRow['lead_id'])) . '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="' . site_url('adm/lead/delete/'.lcfirst($type).'/'. encode_url($aRow['lead_id'])) . '"><i class="fa fa-trash" aria-hidden="true"></i></i></a>';

                $output['aaData'][] = $row;
            }
        } else {
            $output['aaData'] = array();
        }

        return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($output));

    }

    public function edit($type = 'lead',$id = NULL){
        $this->data['validation'] = TRUE;
        $this->data['datepicker'] = TRUE;
        $this->data['meta_title'] = ucfirst($type)." Operation";
        $this->data['title'] = ucfirst($type);
        $this->data['breadcrumb'] = ucfirst($type);
        $this->data['fancybox'] = TRUE;
        $this->data['cancelurl'] = $this->__cancelUrl($type);
        $this->data['agencies'] = $this->agency_model->get_nested();
        $this->data['countries'] = $this->db->get('country')->result();
        $this->data['states'] = $this->db->get('state')->result();
        $this->data['status'] = ucfirst($type);
        $relation = array(
            "fields" => "GROUP_CONCAT(DISTINCT agents.id) AS agents,GROUP_CONCAT(DISTINCT CONCAT(agents.fname,' ',agents.lname)) as names,count(agency_id) as total,name",
            "JOIN" => array(
                    array(
                        "table" => 'agencies age',
                        "condition" => 'age.id = agents.agency_id ',
                        "type" => 'LEFT'
                    ),
            ),
            "GROUP_BY" => 'agency_id'
        );
        $this->data['agents'] = $this->agents->get_relation('',$relation);

        if ($id) {
            $id = decode_url($id);
            $this->data['lead'] = $this->leadstore_m->get_by(array('lead_id' => $id), TRUE);
            count($this->data['lead']) || $this->data['errors'][] = 'List could not be found';
            $this->data['listtitle'] = "Edit Lead";
            $this->data['requiredJson'] = $this->leadfield_m->getRequiredFieldJson($id);
        } else {
            $this->data['listtitle'] = "Add A New ".ucfirst($type);
            $this->data['lead'] = $this->leadstore_m->get_new();
        }

        $this->form_validation->set_rules($this->leadstore_m->rules);
        if($this->form_validation->run() == TRUE){
            $data = $this->leadstore_m->array_from_post(array(
                'agency_id', 'first_name', 'middle_name', 'last_name', 'gender', 'height', 'weight', 'email', 'dialcode', 'phone', 'cellphone', 'work_phone','address', 'work_phone', 'country', 'state', 'city', 'postal_code', 'status', 'user', 'date_of_birth','opportunity_status','dispo','source','lead_status', 'notes', 'mothers_maiden_name', 'license_number', 'occupation'
            ));
            if($data['user'] != ''){
                $data['user'] = decode_url($data['user']);
            }
            if($data['date_of_birth'] != ''){
                $data['date_of_birth'] = date('Y-m-d', strtotime($data['date_of_birth']));
            }
            if($id == NULL){
                $data['owner'] = $this->session->userdata('user')->email_id;
                $data['member_id'] = getIncrementMemberId();

                /*------ For Dispo Field ------- */
                if($type == 'lead'){
                    $data['dispo'] = 'NEW';
                }elseif($type == 'opportunity'){
                    $data['dispo'] = 'QUOTED';
                }elseif($type == 'client'){
                    $data['dispo'] = 'SALE MADE';
                }
                /*------ End For Dispo Field --- */
            }else{
                 /*------ For Dispo Field ------- */
                if($type == 'lead'){
                    $data['dispo'] = 'NEW';
                }elseif($type == 'client'){
                    $data['dispo'] = 'SALE MADE';
                }
                /*------ End For Dispo Field --- */
            }

            if(!empty($_POST['custom_field'])){
                $customFields = $_POST['custom_field'];
                foreach($customFields as $key => $val){
                    $v = $this->leadfieldval_m->get($key, TRUE);
                    if($v){
                        $valId = $v->value_id;
                    }else{
                        $valId = NULL;
                    }
                    $fieldVal = is_array($val) ? implode(',', $val) : $val;
                    $valData = array(
                      'field_id' => $key,
                      'value' =>  $fieldVal
                    );
                    $this->leadfieldval_m->save($valData, $valId);
                }
            }

            $leadId = $this->leadstore_m->save($data,$id);
            if($leadId){
                if($id == NULL){
                    updateIncrementMemberId();
                }
                $id = encode_url($leadId);
                $this->session->set_flashdata('success', 'Lead saved successfully.');
                redirect('adm/lead/edit/'.$type.'/'.$id);
            }
        }
        if($id){
            $this->template->load('admin', "admin/crm/edit", $this->data);
        }else{
            $this->template->load('admin', "admin/crm/add", $this->data);
        }
    }

    public function massaction($type = 'lead'){
        $ids = $this->input->post('id');

        if (empty($ids)) {
            $this->session->set_flashdata('error', 'No Lead Records have been selected.');
            redirect('adm/lead/index');
        }
        $action = $this->input->post('action');
        switch ($action) {
            case 'del':
                foreach ($ids as $key => $id) {
                    $id = decode_url($id);
                    $this->leadstore_m->delete($id);
                }
                $this->session->set_flashdata('success', 'Leads deleted successfully.');
                break;
        }
        redirect('adm/lead/index');
    }

    public function delete($type = 'lead', $id = NULL) {
        if ($id) {
            $id = decode_url($id);
            $this->leadstore_m->delete($id);
            $this->session->set_flashdata('success', ucfirst($type).' deleted successfully.');
        } else {
            $this->session->set_flashdata('error', ucfirst($type).' doesn\'t exist.');
        }
        $redirectUrl = $this->__cancelUrl($type);
        redirect($redirectUrl);
    }

    public function opportunities(){
        $this->data['title'] = 'Admin | CRM Opportunities';
        $this->data['pagetitle'] = 'Opportunities';
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert'] = TRUE;
        $this->data['maintitle'] = 'Opportunities';
        $this->data['listtitle'] = "Opportunities Listing";
        $this->data['addactioncontroller'] = 'adm/lead/edit/opportunity';
        $this->data['importactioncontroller'] = 'adm/lead/loadbulk/opportunity';
        $this->data['exportactioncontroller'] = 'adm/lead/export/opportunity';
        $this->data['label'] = "Opportunity";
        $this->data['type'] = 'Opportunity';
        $this->template->load('admin','crm/list',$this->data);
    }

    public function clients(){
        $this->data['title'] = 'Admin | CRM Clients';
        $this->data['pagetitle'] = 'Clients';
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert'] = TRUE;
        $this->data['maintitle'] = 'Clients';
        $this->data['listtitle'] = 'Clients Listing';
        $this->data['addactioncontroller'] = 'adm/lead/edit/client';
        $this->data['importactioncontroller'] = 'adm/lead/loadbulk/client';
        $this->data['exportactioncontroller'] = 'adm/lead/export/client';
        $this->data['label'] = "Client";
        $this->data['type'] = 'Client';
        $this->template->load('admin','crm/list',$this->data);
    }

    private function __cancelUrl($type){
        $url = '';
        switch($type){
            case 'lead':
                $url = site_url('adm/lead/index');
                break;
            case 'opportunity':
                $url = site_url('adm/lead/opportunities');
                break;
            case 'client':
                $url = site_url('adm/lead/clients');
                break;
        }
        return $url;
    }

    public function loadbulk($type = 'lead'){
        $this->data['title'] = 'Admin | CRM '.ucfirst($type).' | Bulk Upload';
        $this->data['maintitle'] = ucfirst($type).' Bulk Upload';
        $this->data['validation'] = TRUE;
        $this->data['listtitle'] = 'Import '.ucfirst($type);
        $this->data['status'] = ucfirst($type);
        $this->data['downloadLink'] = site_url('adm/lead/download');
        $this->form_validation->set_rules('lead_file', 'Load Lead File', 'callback_image_upload');
        if($this->form_validation->run() == TRUE){
            $file = "./uploads/leads/".$this->_upload_filename;
            switch ($type){
                case 'lead':
                    $status = 'Lead';
                    $dispo = 'NEW';
                    break;
                case 'opportunity':
                    $status = 'Opportunity';
                    $dispo = 'QUOTED';
                    break;
                case 'client':
                    $status = 'Client';
                    $dispo = 'SALE MADE';
                    break;
            }
            if(file_exists($file)){
                $handle = fopen($file, 'r');
                $row = 1;
                $i = 1;
                $total = 0;
                $eRecords = 0;
                $headers = array();
                while (!feof($handle)){
                    $leadId = NULL;
                    $buffer=rtrim(fgets($handle, 4096));
                    $buffer=stripslashes($buffer);
                    if (strlen($buffer)>0){
                        $row = explode(',', preg_replace('/[\'\"]/i', '', $buffer));
                        if( $i == 1){
                            $headers = $row;
                            $i++;
                            continue;
                        }
                        $headers = array_map('trim', $headers);
                        $data = array_combine($headers,$row);
                        $data = array_map('trim', $data);
                        /* height format */
                        if((strlen($data['first_name']) <= 0) || (strlen($data['last_name']) <= 0) || (strlen($data['phone']) <= 0 ) || (!is_numeric($data['phone']))){
                            $eRecords++;
                            break;
                        }
                        if(strlen($data['height']) > 0){
                            $data['height'].= '"';
                            $data['height'] = substr_replace($data['height'], "'", 1, 0);
                        }
                        if($data['date_of_birth'] != ''){
                            $data['date_of_birth'] = date('Y-m-d', strtotime($data['date_of_birth']));
                        }
                        if(isset($data['agent']) && strlen($data['agent']) > 0){
                            $email = $data['agent'];
                            unset($data['agent']);
                            $stmt = "SELECT * from users u JOIN agents a ON u.id = a.user_id WHERE u.email_id = '{$email}'";
                            $query = $this->db->query($stmt);
                            if($query->num_rows() > 0){
                                $row = $query->row();
                                $data['user'] = $row->id;
                                $data['agency_id'] = $row->agency_id;
                            }
                        }else{
                            unset($data['agent']);
                        }
                        if(isset($data['agency']) && strlen($data['agency']) > 0){
                            $email = $data['agency'];
                            unset($data['agency']);
                            $stmt = "SELECT * from users u JOIN agencies a ON u.id = a.user_id WHERE u.email_id = '{$email}'";
                            $query = $this->db->query($stmt);
                            if($query->num_rows() > 0){
                                $row = $query->row();
                                $data['agency_id'] = $row->id;
                            }
                        }else{
                            unset($data['agency']);
                        }
                        $data['status'] = $status;
                        $data['owner'] = $this->session->userdata('user')->email_id;
                        $data['dispo'] = $dispo;
                        if(isset($data['member_id']) && strlen($data['member_id']) > 0 && is_numeric($data['member_id'])){
                            $leadData = $this->leadstore_m->get_by(array('member_id' => $data['member_id']), TRUE);
                            if($leadData){
                                $leadId = $leadData->lead_id;
                            }
                        }else{
                            $data['member_id'] = getIncrementMemberId();
                        }
                        $lead = $this->leadstore_m->save($data, $leadId);
                        if($lead){
                            if($leadId == NULL){
                                updateIncrementMemberId();
                            }
                            $total++;
                        }
                        $i++;
                    }
                }
                fclose($handle);
            }
            if($total > 0){
                $this->session->set_flashdata('success',$total." {$type} are uploaded.");
            }
            if($eRecords > 0){
                $this->session->set_flashdata('error',$eRecords." {$type} are not uploaded. Because some required  fields are empty.");
            }
            @unlink($file);
            redirect('adm/lead/loadbulk/'.$type);
        }
        $this->template->load("admin", "crm/bulk", $this->data);
    }
    function image_upload(){
        if($_FILES['lead_file']['size'] != 0){
            $upload_dir = "./uploads/leads/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir);
            }
            $config['upload_path']   = $upload_dir;
            $config['allowed_types'] = 'csv';
            $config['file_name']     = $_FILES['lead_file']['name'];
            $config['overwrite']     = true;
            $config['max_size']	 = '512000000000';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('lead_file')){
                $this->form_validation->set_message('image_upload', $this->upload->display_errors());
                return false;
            }else{
                $this->upload_data['file'] =  $this->upload->data();
                $this->_data =  $this->upload->data();
                $this->_upload_filename = $_FILES['lead_file']['name'];
                $this->_upload_extension = $this->upload_data['file']['file_ext'];
                return true;
            }
	}
	else{
            $this->form_validation->set_message('image_upload', "No file selected");
            return false;
	}
    }
    public function removefield($leadId = NULL){
        if($leadId){
            $this->data['lead'] = decode_url($leadId);
            $fields = $this->leadfield_m->get_by(array('lead_id' => decode_url($leadId)));
            $this->data['customFields'] = $fields;
        }
        $this->load->view('admin/crm/fieldremove', $this->data);
    }
    function change_status($status='',$lead_id=''){
        $data['status'] = $status;
        $redirect ='';
        /*---- For Redirect --- */
        if($status == 'Lead'){
            $data['dispo'] = 'NEW';
            $data['opportunity_status'] = '';
            $redirect = 'index';
        }elseif($status == 'Opportunity'){
            $data['dispo'] = 'QUOTED';
            $data['opportunity_status'] = 'Pre-Qualified';
            $redirect = 'opportunities';
        }elseif($status == 'Client'){
            $data['dispo'] = 'SALE MADE';
            $data['opportunity_status'] = '';
            $redirect = 'clients';
        }
        /*---- For Redirect --- */
        $id = decode_url($lead_id);
        $res = $this->leadstore_m->save($data,$id);
        if($res){
            //-------------- For Convert Lead status ---------
            $NotesId = NULL;
            $note_data['lead_id'] = $id;
            $note_data['notes'] = "Status was changed to status ".$status;
            $note_data['user_group_id'] = $this->session->userdata("user")->user_group_id;
            $note_data['user_id'] = $this->session->userdata("user")->id;
            $this->leadnotes_m->save($note_data, $NotesId);
            //-------------- For Convert Lead status ---------
            $this->session->set_flashdata('success',"Convert Successfully");
        }else{
            $this->session->set_flashdata('error',"Error into Convert");
        }
        redirect('adm/lead/'.$redirect);
    }

    public function addfield($leadId = NULL){
        if($leadId){
            $this->data['lead'] = decode_url($leadId);
            $fields = $this->leadfield_m->get_by(array('lead_id' => decode_url($leadId)));
            $this->data['customFields'] = $fields;
        }
        $this->load->view('admin/crm/field', $this->data);
    }

    public function fieldedit($id = NULL){
        $this->load->model('leadfield_m');
        $this->form_validation->set_rules('field_name','Field Name','trim|required');
        $this->form_validation->set_rules('field_label','Field Label','trim|required');

        if($this->form_validation->run() == TRUE){
            $post = $this->input->post();
            $data['lead_id'] = decode_url($post['lead_id']);
            $data['field_name'] = $post['field_name'];
            $settings = array(
                'label' => $post['field_label'],
                'required' => $post['field_required'],
                'type' => $post['field_type'],
                'options' => $post['field_options']
            );
            $data['field_settings'] = serialize($settings);
            if($post['field'] == 'add_new'){
                $fieldId = $this->leadfield_m->save($data, NULL);
            }else{
                $fieldId = $this->leadfield_m->save($data, $post['field']);
            }
            if(isset($post['is_deleted']) && $post['is_deleted'] == 'y'){
                $this->leadfield_m->delete($post['field']);
                $fieldVal = $this->leadfieldval_m->get_by(array('field_id' => $post['field']), TRUE);
                if($fieldVal){
                    $this->leadfieldval_m->delete($fieldVal->value_id);
                }
                $html = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Option deleted successfully.</div>';
            }else{
                $html = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Option saved successfully.</div>';
            }
            $output['success'] = true;

            $output['html'] = $html;
        }else{
            $output['success'] = false;
            $html = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.validation_errors().'</div>';
            $output['html'] = $html;
        }
        return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($output));
    }
    public function fieldelete($id = NULL){
        $this->load->model('leadfield_m');
        $this->form_validation->set_rules('field','Field Name','trim|required');
        if($this->form_validation->run() == TRUE){
            $post = $this->input->post();
            $fieldId = $post['field'];
            $this->leadfield_m->delete($post['field']);
            $fieldVal = $this->leadfieldval_m->get_by(array('field_id' => $post['field']), TRUE);
            if($fieldVal){
                $this->leadfieldval_m->delete($fieldVal->value_id);
            }
            $html = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Option deleted successfully.</div>';
            $output['success'] = true;
            $output['html'] = $html;
        }else{
            $output['success'] = false;
            $html = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.validation_errors().'</div>';
            $output['html'] = $html;
        }
        return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($output));
    }
    public function renderfields($leadId = NULL){
        if($leadId){
            $lead = decode_url($leadId);
        }
        $fields = $this->leadfield_m->get_by(array('lead_id' => $lead, 'is_deleted' => 'N'));
        $html = '';
        if($fields){
            foreach($fields as $field){
                $settings = unserialize($field->field_settings);
                $fieldVal = $this->leadfieldval_m->get_by(array('field_id' => $field->field_id), TRUE);
                if($fieldVal){
                    $fieldSelectedVal = $fieldVal->value;
                }else{
                    $fieldSelectedVal = '';
                }
                $required = '';
                if($settings['required'] == 'yes'){
                    $required = '<span class="required">*</span>';
                }
                switch($settings['type']){
                    case 'text':
                    case 'phone':
                    case 'email':
                        $html .= '<div class="form-group">';
                        $html .= '<label class="col-md-3 control-label">'.$settings['label'].$required.'</label>';
                        $html .= '<div class="col-md-4">';
                        $html .= '<input type="text" name="custom_field['.$field->field_id.']" class="form-control" value="'.$fieldSelectedVal.'"/>';
                        $html .= '</div>';
                        $html .= '</div>';
                        break;
                    case 'select':
                        $html .= '<div class="form-group">';
                        $html .= '<label class="col-md-3 control-label">'.$settings['label'].$required.'</label>';
                        $html .= '<div class="col-md-4">';
                        $html .= '<select name="custom_field['.$field->field_id.']" class="form-control">';
                        $html .= '<option value="">Please Select</option>';
                        foreach($settings['options'] as $opt){
                            $selected = '';
                            if($fieldSelectedVal == $opt){
                                $selected = 'selected="selected"';
                            }
                            $html .= '<option '.$selected.' value="'.$opt.'">'.$opt.'</option>';
                        }
                        $html .= '</select>';
                        $html .= '</div>';
                        $html .= '</div>';
                        break;
                    case 'radio':
                        $html .= '<div class="form-group">';
                        $html .= '<label class="col-md-3 control-label">'.$settings['label'].$required.'</label>';
                        $html .= '<div class="col-md-4">';
                        foreach($settings['options'] as $opt){
                            $selected = '';
                            if($fieldSelectedVal == $opt){
                                $selected = 'checked="checked"';
                            }
                            $html .= '<label class="radio-inline"><input '.$selected.' type="radio" name="custom_field['.$field->field_id.']" value="'.$opt.'" />'.$opt.'</label>';
                        }
                        $html .= '</div>';
                        $html .= '</div>';
                        break;
                    case 'checkbox':
                        $html .= '<div class="form-group">';
                        $html .= '<label class="col-md-3 control-label">'.$settings['label'].$required.'</label>';
                        $html .= '<div class="col-md-4">';
                        $fieldSelectedVal = explode(',', $fieldSelectedVal);
                        foreach($settings['options'] as $opt){
                            $selected = '';
                            if(in_array($opt, $fieldSelectedVal)){
                                $selected = 'checked="checked"';
                            }
                            $html .= '<label class="checkbox-inline"><input '.$selected.' type="checkbox" name="custom_field['.$field->field_id.'][]" value="'.$opt.'" />'.$opt.'</label>';
                        }
                        $html .= '</div>';
                        $html .= '</div>';
                        break;
                    case 'textarea':
                        $html .= '<div class="form-group">';
                        $html .= '<label class="col-md-3 control-label">'.$settings['label'].$required.'</label>';
                        $html .= '<div class="col-md-4">';
                        $html .= '<textarea name="custom_field['.$field->field_id.']" class="form-control">'.$fieldSelectedVal.'</textarea>';
                        $html .= '</div>';
                        $html .= '</div>';
                        break;
                }
            }
        }
        $output['html'] = $html;
        $output['refreshjson'] = json_decode($this->leadfield_m->getRequiredFieldJson($lead));
        return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($output));
    }
    public function refreshoption(){
        $post = $this->input->post();
        if($post && $post['is_ajax'] == true){
            $optionId = $post['option'];
            $field = $this->leadfield_m->get($optionId, TRUE);
            $fieldVal = $this->leadfieldval_m->get_by(array('field_id' => $field->field_id),TRUE);
            $fieldOptions = array(
                'field_id' => $field->field_id,
                'field_name' => $field->field_name,
                'field_settings' => unserialize($field->field_settings),
                'value_id' => isset($fieldVal) ? $fieldVal->value_id : '',
                'value' => isset($fieldVal) ? $fieldVal->value : ''
            );
            $output['success'] = true;
            $output['json'] = $fieldOptions;
            return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($output));
        }else{
            $output['success'] = false;
            $output['json'] = array();
            return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
        }
    }
    public function export($type = 'lead'){
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";
        $filename = "{$type}.csv";
        $status = ucfirst($type);
        $sql = "SELECT member_id AS `MEMBER ID`, (CASE WHEN a.name IS NULL THEN 'Admin' ELSE a.name END) AS `AGENCY NAME`, (CASE WHEN ag.id IS NULL THEN 'Not Asssigned' ELSE CONCAT(ag.fname,' ',ag.lname) END) AS `AGENT NAME`, dispo AS `DISPOSITION`, first_name AS `FIRST NAME`, middle_name AS `MIDDLE NAME`, last_name AS `LAST NAME`, gender AS `GENDER`, height AS `HEIGHT`, weight AS `WEIGHT`, address AS `ADDRESS`, address1 AS `ADDRESS1`, state AS `STATE`, city AS `CITY`, phone AS `PHONE`, postal_code AS `ZIP` , cellphone AS `CELLPHONE`, work_phone AS `WORK PHONE`, email AS `EMAIL`, mothers_maiden_name AS `MOTHER MAIDEN NAME`,license_number AS `LICENSE NUMBER`, main.date_of_birth AS `BIRTH DATE`, called_count AS `CALLED COUNT`, last_local_call_time AS `LAST CALL TIME` from lead_store_mst main LEFT JOIN agencies a ON main.agency_id = a.id LEFT JOIN agents ag ON main.user = ag.id WHERE status ='{$status}' ORDER BY member_id DESC";
        $result = $this->db->query($sql);
        $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
        force_download($filename, $data);
    }
}