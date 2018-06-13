<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller{
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            if ($this->session->userdata("user")->group_name == 'Agent') {
                redirect('/Forbidden');
            }
        }
        $this->load->library('vicidialdb');
        $this->load->model('agency_model');
        $this->load->model('agent_model');
        $this->load->model('vicidial/aphones_m','aphones_m');
        $this->load->model('vicidial/avoicemail_m', 'avoicemail_m');
        $this->load->model('vicidial/vclassmenu_m', 'vclassmenu_m');
        $this->load->model('vicidial/vcampaigns_m', 'vcampaigns_m');
        $this->load->model('vicidial/indid_m','indid_m');
        $this->load->model('vicidial/aphones_m','aphones_m');
        $this->load->model('vicidial/vugroup_m', 'vugroup_m');
        $this->load->model('vicidial/agroups_m', 'agroups_m');
        $this->load->model('vicidial/vingroup_m', 'vingroup_m');
        $this->load->model('vicidial/vusers_m', 'vusers_m');
        $this->load->model('vicidial/vregroup_m','vregroup_m');
        $this->load->model('vicidial/aregroup_m','aregroup_m');
    }
    public function getvoicemaillist($field = ''){
        $this->avoicemail_m->createTempTable();
        $tempTable = $this->avoicemail_m->_temptable;
        $stmt="SELECT voicemail_id,fullname,email,name from {$tempTable} as main, agency_voicemail as av,agencies AS age where main.active='Y' AND av.vicidial_voicemail_id = main.voicemail_id AND age.id = av.agency_id order by voicemail_id";
        $voicemails1 = $this->db->query($stmt)->result_array();
        $stmt="SELECT voicemail_id,fullname,email,extension from phones where active='Y' order by voicemail_id";
        //$voicemails2 = $this->vicidialdb->db->query($stmt)->result_array();
        $voicemails2 = $this->aphones_m->queryForAgency();
        $voicemails3 = $this->aphones_m->queryForAgent();
        $this->data['voicemail1'] = $voicemails1;
        $this->data['voicemail2'] = $voicemails2;
        $this->data['voicemail3'] = $voicemails3;
        $this->data['field'] = $field;
        $this->load->view('dialer/ajax/voicemail',$this->data);
    }
    public function getingroups(){
        $post = $this->input->post();
        if($post && $post['id'] != ''){
            if(decode_url($post['id'])){
                $post['id'] = decode_url($post['id']);
            }
            if($post['id'] > 0){
                $this->vingroup_m->createTempTable();
                $tempTable = $this->vingroup_m->_temptable;
                $stmt="SELECT group_id,group_name from {$tempTable}  main,agency_inbound_group sub WHERE sub.vicidial_ingroup_id = main.group_id AND group_id NOT IN('AGENTDIRECT') AND sub.agency_id = {$post['id']} order by group_id;";
                $ingroups = $this->db->query($stmt)->result_array();
            }else{
               $stmt="SELECT group_id,group_name from vicidial_inbound_groups WHERE group_id NOT IN('AGENTDIRECT') order by group_id;";
               $ingroups = $this->vicidialdb->db->query($stmt)->result_array();
            }
            $html = '<select name="group_id" id="group_id" class="form-control">';
            $html .= '<option SELECTED value="---NONE---">---NONE---</option>';
            foreach($ingroups as $ingroup){
                $selected = optionSetValue($post['ingroup'], $ingroup['group_id']);
                $html .= '<option value="'.$ingroup['group_id'].'" '.$selected.'>'.$ingroup['group_id'].' - '.$ingroup['group_name'].'</option>';
            }
            $html .= '</select>';
            $output['success'] = TRUE;
            $output['html'] = $html;
            return $this->output
                    ->set_content_type('application/json')
                     ->set_output(json_encode($output));
        }else{
            $output['success'] = FALSE;
            $output['html'] = '<select name="group_id" id="group_id" class="form-control"></select>';
            return $this->output
                    ->set_content_type('application/json')
                     ->set_output(json_encode($output));
        }
    }
    public function getrouteingroup(){
        $post = $this->input->post();
        if($post){
            if(decode_url($post['id'])){
                $post['id'] = decode_url($post['id']);
            }
            if($post['id'] > 0){
                $this->vingroup_m->createTempTable();
                $tempTable = $this->vingroup_m->_temptable;
                $stmt="SELECT group_id,group_name from {$tempTable} main,agency_inbound_group sub WHERE sub.vicidial_ingroup_id = main.group_id AND sub.agency_id = {$post['id']} order by group_id;";
                $ingroups = $this->db->query($stmt)->result_array();
            }else{
                $stmt="SELECT group_id,group_name from vicidial_inbound_groups order by group_id;";
                $ingroups = $this->vicidialdb->db->query($stmt)->result_array();
            }

            $html = '<select name="user_route_settings_ingroup" id="user_route_settings_ingroup" class="form-control">';
            $html .= '<option SELECTED value="---NONE---">---NONE---</option>';
            foreach($ingroups as $ingroup){
                $selected = optionSetValue($post['ingroup'], $ingroup['group_id']);
                $html .= '<option value="'.$ingroup['group_id'].'" '.$selected.'>'.$ingroup['group_id'].' - '.$ingroup['group_name'].'</option>';
            }
            $html .= '</select>';
            $output['success'] = TRUE;
            $output['html'] = $html;
            return $this->output
                    ->set_content_type('application/json')
                     ->set_output(json_encode($output));
        }else{
            $output['success'] = FALSE;
            $output['html'] = '<select name="user_route_settings_ingroup" id="user_route_settings_ingroup" class="form-control"></select>';
            return $this->output
                    ->set_content_type('application/json')
                     ->set_output(json_encode($output));
        }
    }
    public function getcallmenu(){
        $post = $this->input->post();
        if($post){
            if(decode_url($post['id'])){
                $post['id'] = decode_url($post['id']);
            }
            if($post['id'] > 0){
                $this->vclassmenu_m->createTempTable();
                $tempTable = $this->vclassmenu_m->_temptable;
                $stmt="SELECT menu_id,menu_name,menu_prompt from {$tempTable} main,agency_call_menu sub WHERE sub.vicidial_menu_id = main.menu_id AND sub.agency_id = {$post['id']} order by menu_id;";
                $callmenues = $this->db->query($stmt)->result();
            }else{
               $stmt="SELECT menu_id,menu_name,menu_prompt from vicidial_call_menu order by menu_id;";
               $callmenues = $this->vicidialdb->db->query($stmt)->result();
            }

            $html = '<select name="menu_id" id="menu_id" class="form-control">';
            $html .= '<option value=""></option>';
            foreach($callmenues as $callmenu){
                $selected = optionSetValue($post['menu'], $callmenu->menu_id);
                $html .= '<option value="'.$callmenu->menu_id.'" '.$selected.'>'.$callmenu->menu_id.' - '.$callmenu->menu_name.' - '.$callmenu->menu_prompt.'</option>';
            }
            $html .= '</select>';
            $output['success'] = TRUE;
            $output['html'] = $html;
            return $this->output
                    ->set_content_type('application/json')
                     ->set_output(json_encode($output));
        }else{
            $output['success'] = FALSE;
            $output['html'] = '<select name="user_route_settings_ingroup" id="user_route_settings_ingroup" class="form-control"></select>';
            return $this->output
                    ->set_content_type('application/json')
                     ->set_output(json_encode($output));
        }
    }
    public function sound($var){
        $this->data['files'] = getSoundFileList();
        $this->data['var'] = $var;
        $stmt = "SELECT sounds_web_directory FROM system_settings";
        $res = $this->vicidialdb->db->query($stmt)->row();
        $this->data['sounds_web_directory'] = $res->sounds_web_directory;
        $this->load->view('dialer/ajax/sound',$this->data);
    }
    public function menuoptions(){
        $post = $this->input->post();
        if($post){
            $id = decode_url($post['id']);
            $call_menu_list = '';
            $ingroup_list='';
            $IGcampaign_id_list='';
            $did_list='';
            $phone_list='';
            if($id > 0){
                $this->vclassmenu_m->createTempTable();
                $tempTable = $this->vclassmenu_m->_temptable;
                $stmt="SELECT menu_id,menu_name from {$tempTable} as main,agency_call_menu as sub WHERE main.menu_id = sub.vicidial_menu_id AND sub.agency_id = {$id} ORDER BY menu_id limit 10000;";
                $query = $this->db->query($stmt);
                $results = $query->result_array();
                foreach($results as $row){
                    $call_menu_list.= '<option value="'.$row['menu_id'].'">'.$row['menu_id'].' - '.$row['menu_name'].'</option>';
                }
                /*
                 * to do : add agency filter
                 */
                $stmt="SELECT group_id,group_name from vicidial_inbound_groups where active='Y' and group_id NOT LIKE \"AGENTDIRECT%\" order by group_id;";
                $query = $this->vicidialdb->db->query($stmt);
                $results = $query->result_array();
                foreach($results as $row){
                    $ingroup_list.= '<option value="'.$row['group_id'].'">'.$row['group_id'].' - '.$row['group_name'].'</option>';
                }
                /* campaigns */
                $this->vcampaigns_m->cretaeTempTable();
                $stmt="SELECT campaign_id,campaign_name from vicidial_campaigns as main,agency_campaigns as sub where active='Y' AND main.campaign_id = sub.vicidial_campaign_id AND sub.agency_id = {$id}  order by campaign_id;";
                $query = $this->db->query($stmt);
                $results = $query->result_array();
                foreach($results as $row){
                    $IGcampaign_id_list.= '<option value="'.$row['campaign_id'].'">'.$row['campaign_id'].' - '.$row['campaign_name'].'</option>';
                }
                /* did options*/
                $this->indid_m->createTempTable();
                $tempTable = $this->indid_m->_temptable ;
                $stmt="SELECT main.did_id,did_pattern,did_description,did_route from {$tempTable} as main,agency_inbound_did as sub where did_active='Y' AND main.did_id = sub.vicidial_did_id order by did_pattern;";
                $query = $this->db->query($stmt);
                $results = $query->result_array();
                foreach($results as $row){
                    $did_list.= '<option value="'.$row['did_pattern'].'">'.$row['did_pattern'].' - '.$row['did_description'].'</option>';
                }
                /* phone list */
                $this->aphones_m->createTempTable();
                $tempTable = $this->aphones_m->_temptable;
                $ids[] = $id;
                $vUserIds = array();
                $stmt = "SELECT id,vicidial_user_id FROM agencies WHERE id = $id";
                $query = $this->db->query($stmt);
                $row = $query->row_array();
                $vUserIds[] = $row['vicidial_user_id'];
//                $stmt = "SELECT id,vicidial_user_id FROM agencies WHERE parent_agency = $id";
//                $query = $this->db->query($stmt);
//                $results = $query->result_array();
//                foreach($results as $row){
//                    $ids = $row['id'];
//                    $vUserIds[] = $row['vicidial_user_id'];
//                }
                $stmt = "SELECT id,vicidial_user_id FROM agents WHERE agency_id = $id";
                $query = $this->db->query($stmt);
                $results = $query->result_array();
                foreach($results as $row){
                    $vUserIds[] = $row['vicidial_user_id'];
                }
                $vUserIds = implode(',', $vUserIds);
                $stmt="SELECT login,server_ip,extension,dialplan_number from {$tempTable} as main, users_phones as sub where active='Y' AND main.id = sub.vicidial_phone_id AND sub.vicidial_user_id IN({$vUserIds}) order by login,server_ip;";
                $query = $this->db->query($stmt);
                $results = $query->result_array();
                foreach($results as $row){
                    $phone_list.= '<option value="'.$row['login'].'">'.$row['login'].' - '.$row['server_ip'].' - '.$row['extension'].' - '.$row['dialplan_number'].'</option>';
                }
            }else{
                /* call menu */
                $stmt="SELECT menu_id,menu_name from vicidial_call_menu order by menu_id limit 10000;";
                $query = $this->vicidialdb->db->query($stmt);
                $results = $query->result_array();
                foreach($results as $row){
                    $call_menu_list.= '<option value="'.$row['menu_id'].'">'.$row['menu_id'].' - '.$row['menu_name'].'</option>';
                }
                /* inbound group */
                $stmt="SELECT group_id,group_name from vicidial_inbound_groups where active='Y' and group_id NOT LIKE \"AGENTDIRECT%\" order by group_id;";
                $query = $this->vicidialdb->db->query($stmt);
                $results = $query->result_array();
                foreach($results as $row){
                    $ingroup_list.= '<option value="'.$row['group_id'].'">'.$row['group_id'].' - '.$row['group_name'].'</option>';
                }
                /* campaigns */
                $stmt="SELECT campaign_id,campaign_name from vicidial_campaigns where active='Y' order by campaign_id;";
                $query = $this->vicidialdb->db->query($stmt);
                $results = $query->result_array();
                foreach($results as $row){
                    $IGcampaign_id_list.= '<option value="'.$row['campaign_id'].'">'.$row['campaign_id'].' - '.$row['campaign_name'].'</option>';
                }
                /* did options*/
                $stmt="SELECT did_pattern,did_description,did_route from vicidial_inbound_dids where did_active='Y' order by did_pattern;";
                $query = $this->vicidialdb->db->query($stmt);
                $results = $query->result_array();
                foreach($results as $row){
                    $did_list.= '<option value="'.$row['did_pattern'].'">'.$row['did_pattern'].' - '.$row['did_description'].'</option>';
                }
                /* phone list */
                $stmt="SELECT login,server_ip,extension,dialplan_number from phones where active='Y' order by login,server_ip;";
                $query = $this->vicidialdb->db->query($stmt);
                $results = $query->result_array();
                foreach($results as $row){
                    $phone_list.= '<option value="'.$row['login'].'">'.$row['login'].' - '.$row['server_ip'].' - '.$row['extension'].' - '.$row['dialplan_number'].'</option>';
                }
            }
            $output['success'] = TRUE;
            $output['call_menu_list'] = $call_menu_list;
            $output['ingroup_list'] = $ingroup_list;
            $output['IGcampaign_id_list'] = $IGcampaign_id_list;
            $output['did_list'] = $did_list;
            $output['phone_list'] = $phone_list;
            return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($output));
        }
    }
    public function getAgencyGroup(){
        if($post = $this->input->post()){
            $select = '<select name="user_group" class="form-control" id="user_group">';
            if(isset($post['id']) && $post['id'] != ''){
                $id = decode_url($post['id']);
                $select.= '<option value="">Please Select</option>';
                $groups = $this->agroups_m->getAgencyGroup($id);
            }else{
                $groups = $this->vugroup_m->get();
                $selectable = '';
                if( isset($post['group']) && '---ALL---' == $post['group']){
                    $selectable = 'selected="selected"';
                }

                $select .= '<option value="---ALL---" '.$selectable.'>All Admin User Groups</option>';
            }
            if(!$groups){
                $groups = array();
            }
            foreach ($groups as $group){
                $selectable = '';
                if( isset($post['group']) && $group->user_group == $post['group']){
                    $selectable = 'selected="selected"';
                }
                $select.= '<option value="'.$group->user_group.'" '.$selectable.'>'.$group->user_group.'-'.$group->group_name.'</option>';
            }
            $select.= '</select>';
            $data['success'] = 'TRUE';
            $data['html'] = $select;
            return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));
        }
    }
    public function gettrackingingroups(){
        $post = $this->input->post();
        if($post && $post['id'] != ''){
            if(decode_url($post['id'])){
                $post['id'] = decode_url($post['id']);
            }
            if($post['id'] > 0){
                $this->vingroup_m->createTempTable();
                $tempTable = $this->vingroup_m->_temptable;
                $stmt="SELECT group_id,group_name from {$tempTable}  main,agency_inbound_group sub WHERE sub.vicidial_ingroup_id = main.group_id AND group_id NOT IN('AGENTDIRECT') AND sub.agency_id = {$post['id']} order by group_id;";
                $ingroups = $this->db->query($stmt)->result_array();
            }else{
               $stmt="SELECT group_id,group_name from vicidial_inbound_groups WHERE group_id NOT IN('AGENTDIRECT') order by group_id;";
               $ingroups = $this->vicidialdb->db->query($stmt)->result_array();
            }
            $html = '<select name="tracking_group" id="tracking_group" class="form-control">';
            $html .= '<option SELECTED value="CALLMENU">CALLMENU - Default</option>';
            foreach($ingroups as $ingroup){
                $selected = optionSetValue($post['group'], $ingroup['group_id']);
                $html .= '<option value="'.$ingroup['group_id'].'" '.$selected.'>'.$ingroup['group_id'].' - '.$ingroup['group_name'].'</option>';
            }
            $html .= '</select>';
            $output['success'] = TRUE;
            $output['html'] = $html;
            return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($output));
        }else{
            $output['success'] = FALSE;
            $output['html'] = '<select name="tracking_group" id="tracking_group" class="form-control"></select>';
            return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($output));
        }
    }
    public function getUser(){
        $post = $this->input->post();
        if($post && $post['id'] != ''){
            $this->vusers_m->cretaeTempTable();
            $html = '<select class="form-control" name="user_start" id="user_start">';
            $options = '';
            if($post['id'] && $post['id'] != ''){
                $id = decode_url($post['id']);
                $stmt = "SELECT main.*, sub.name FROM vicidial_users main,agencies sub WHERE sub.vicidial_user_id = main.user_id AND sub.parent_agency = {$id}";
                $stmt_B = "SELECT main.*, sub.name FROM vicidial_users main,agencies sub WHERE sub.vicidial_user_id = main.user_id AND sub.id = {$id}";
                $query = $this->db->query($stmt_B);
                $row = $query->row();
                if($row){
                    $selected = '';
                    if($post['user'] == $row->user){
                        $selected = 'selected="selected"';
                    }
                    $options.= '<option value="'.$row->user.'" '.$selected.'>'.$row->user.' - '.$row->name.'</option>';
                }
                $stmt_A = "SELECT main.*,sub.fname,sub.lname FROM vicidial_users main,agents sub WHERE sub.vicidial_user_id = main.user_id AND sub.agency_id = {$id}";
            }else{
                $stmt = "SELECT main.*,sub.name FROM vicidial_users main,agencies sub WHERE sub.vicidial_user_id = main.user_id";
                $stmt_A = "SELECT main.*,sub.fname,sub.lname FROM vicidial_users main,agents sub WHERE sub.vicidial_user_id = main.user_id";
            }
            /* Agency User */
            $query = $this->db->query($stmt);
            $result = $query->result();
            if($result){
                $options.='<optgroup label="Agency User">';
                foreach($result as $row){
                    $selected = '';
                    if($post['user'] == $row->user){
                        $selected = 'selected="selected"';
                    }
                    $options.= '<option value="'.$row->user.'" '.$selected.'>'.$row->user.' - '.$row->name.'</option>';
                }
                $options.='</optgroup>';
            }
            /* Agents users */
            $query = $this->db->query($stmt_A);
            $result = $query->result();
            if($result){
                $options.='<optgroup label="Agent User">';
                foreach($result as $row){
                    $selected = '';
                    if($post['user'] == $row->user){
                        $selected = 'selected="selected"';
                    }
                    $options.= '<option value="'.$row->user.'" '.$selected.'>'.$row->user.' - '.$row->fname.' '.$row->lname.'</option>';
                }
                $options.='</optgroup>';
            }
            $html .= $options;
            $html.= '</select>';
            $output['success'] = TRUE;
            $output['html'] = $html;
            return $this->output
                    ->set_content_type('application/json')
                     ->set_output(json_encode($output));
        }else{
            $output['success'] = FALSE;
            $output['html'] = '<input type="text" class="form-control" name="user_start" id="user_start" />';
            return $this->output
                        ->set_content_type('application/json')
                         ->set_output(json_encode($output));
        }
    }
    public function getCampaigns(){
        $post = $this->input->post();
        if( $post && $post['id'] != ''){
            $post['id'] = decode_url($post['id']);
//            $query = "select * from {$this->db->protect_identifiers('agencies',TRUE)} WHERE id=".$post['id'];
//            $results = $this->db->query($query)->row_array();
//            if($results['parent_agency'] > 0){
//                $ids[] = $results['parent_agency'];
//            }
            $ids[] = $post['id'];
            $this->db->where_in('agency_id',$ids);
            $campaaigns = $this->db->get('agency_campaigns')->result();
            $campaignId = array();
            foreach($campaaigns as $campaign){
                $campaignId[] = $campaign->vicidial_campaign_id;
            }
            if(count($campaignId) <= 0){
                $data['success'] = 'FALSE';
                $this->data['campaigns'] = array();
                $string = $this->load->view('dialer/ajax/campaign',$this->data,TRUE);
                $data['html'] = $string;
                return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($data));
            }
            $this->vicidialdb->db->where_in('campaign_id', $campaignId);
            $this->data['campaigns'] = $this->vicidialdb->db->get('vicidial_campaigns')->result();
            $this->data['cId'] = $this->input->post('campaign');
            $string = $this->load->view('dialer/ajax/campaign',$this->data,TRUE);
            $data['success'] = 'TRUE';
            $data['html'] = $string;
            return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($data));
        }else{
                $data['success'] = 'FALSE';
                $this->data['campaigns'] = array();
                $string = $this->load->view('dialer/ajax/campaign',$this->data,TRUE);
                $data['html'] = $string;
                return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($data));
        }
        exit;
    }
    public function getringroups(){
        $post = $this->input->post();
        if($post && $post['id'] != ''){
            if(decode_url($post['id'])){
                $post['id'] = decode_url($post['id']);
            }
            if($post['id'] > 0){
                $this->vingroup_m->createTempTable();
                $tempTable = $this->vingroup_m->_temptable;
                $stmt="SELECT group_id,group_name from {$tempTable}  main,agency_inbound_group sub WHERE sub.vicidial_ingroup_id = main.group_id AND sub.agency_id = {$post['id']} order by group_id;";
                $ingroups = $this->db->query($stmt)->result_array();
            }else{
               $stmt="SELECT group_id,group_name from vicidial_inbound_groups WHERE group_id order by group_id;";
               $ingroups = $this->vicidialdb->db->query($stmt)->result_array();
            }
            $html = '<select name="closer_campaigns[]" id="group_id" class="form-control" multiple="multiple">';
            $pIngroups = json_decode($post['ingroup']);
            foreach($ingroups as $ingroup){
                $selected = '';
                if(in_array($ingroup['group_id'], $pIngroups)){
                    $selected = 'selected="selected"';
                }
                $html .= '<option value="'.$ingroup['group_id'].'" '.$selected.'>'.$ingroup['group_id'].' - '.$ingroup['group_name'].'</option>';
            }
            $html .= '</select>';
            $output['success'] = TRUE;
            $output['html'] = $html;
            return $this->output
                    ->set_content_type('application/json')
                     ->set_output(json_encode($output));
        }else{
            $output['success'] = FALSE;
            $output['html'] = '<select name="groups[]" id="group_id" class="form-control" multiple></select>';
            return $this->output
                    ->set_content_type('application/json')
                     ->set_output(json_encode($output));
        }
    }
    public function getexgroup(){
        $post = $this->input->post();
        $html = '';
        if($post && $post['id'] !=''){
           $post['id'] = decode_url($post['id']);
           $this->vregroup_m->createTempTable();
           $_tempTable = $this->vregroup_m->_temptable;
           $stmt = "SELECT main.*,amain.id,amain.agency_id,age.name FROM {$this->db->protect_identifiers($_tempTable, TRUE)} AS main, {$this->db->protect_identifiers('agency_extension_group', TRUE)} amain,{$this->db->protect_identifiers('agencies', TRUE)} age WHERE amain.vicidial_extension_id = main.extension_id AND amain.agency_id=age.id AND age.id = {$post['id']}";
           $query = $this->db->query($stmt);
           $result = $query->result();
           $html.= '<select name="extension_group" id="extension_group" class="form-control">';
           $html.= '<option value="NONE" selected '.optionSetValue('NONE', $this->input->post('group')).'>NONE</option>';
           foreach($result as $row){
               $html.= '<option value="'.$row->extension_group_id.'" '.optionSetValue('NONE', $this->input->post('group')).'>'.$row->extension_group_id.'</option>';
           }
           $html.= '</select>';
           $output['success'] = TRUE;
           $output['html'] = $html;
           return $this->output
                       ->set_content_type('application/json')
                       ->set_output(json_encode($output));
        }else{
           $html.= '<select name="extension_group" id="extension_group" class="form-control">';
           $html.= '<option value="NONE" '.optionSetValue('NONE', $this->input->post('group')).'>NONE</option>';
           $html.= '</select>';
           $output['success'] = FALSE;
           $output['html'] = $html;
           return $this->output
                       ->set_content_type('application/json')
                       ->set_output(json_encode($output));
        }
    }
}
