<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Crm extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            if ($this->session->userdata("user")->group_name != 'Agent') {
                redirect('/Forbidden');
            }
        }
        $this->load->model('leadstore_m');
        $this->load->model('leadfield_m');
        $this->load->model('leadfieldval_m');
        $this->load->model('leadnotes_m');
        $this->load->model('Calendar_m');
        $this->load->model('Tasks_m');
        $this->load->model('Agents');
    }

    public function index() {
        // For now display agent page
        $this->data['counterup'] = true;
        $this->data['title'] = 'Agent | CRM';
        $this->data['pagetitle'] = 'CRM';
        $this->data['ckeditor'] = TRUE;
        $agentId = $this->session->userdata('agent')->id;

        //---- For Filter Data -------
        $filter_data = '';
        $duration = $this->input->post('duration');
        if (!$duration) {
            $duration = 'Month';
        }

        if ($duration == 'Today') {
            $filter_data = "date(lead_store_mst.created) = CURDATE() AND ";
        } elseif ($duration == 'Week') {
            $filter_data = "yearweek(lead_store_mst.created) = yearweek(CURDATE()) AND YEAR(lead_store_mst.created) = YEAR(CURDATE()) AND ";
        } elseif ($duration == 'Month') {
            $filter_data = "MONTH(lead_store_mst.created) = MONTH(CURDATE()) AND YEAR(lead_store_mst.created) = YEAR(CURDATE()) AND ";
        } elseif ($duration == 'Quarter') {
            $filter_data = "QUARTER(lead_store_mst.created) = QUARTER(CURDATE()) AND YEAR(lead_store_mst.created) = YEAR(CURDATE()) AND ";
        } elseif ($duration == 'Year') {
            $filter_data = "YEAR(lead_store_mst.created) = YEAR(CURDATE()) AND ";
        }
        $this->data['duration'] = $duration;
        //---- End For Filter Data -------

        /* total assigned leads */
        $relation = array(
            'fields' => "count(*) As total",
            'conditions' => $filter_data . "user = {$agentId} AND STATUS LIKE 'Lead' AND lead_status = 1"
        );
        $data = $this->leadstore_m->get_relation('', $relation);
        $this->data['totalAssignedLeads'] = $data['0']['total'];

        /* total created Opportunity */
        $relation = array(
            'fields' => "count(*) As total",
            'conditions' => $filter_data . "user = {$agentId} AND STATUS LIKE 'Opportunity' AND dispo IN('QUOTED','CALLBACK') AND lead_status = 1"
        );
        $data = $this->leadstore_m->get_relation('', $relation);
        $this->data['totalOpportunityLeads'] = $data['0']['total'];

        /* total clients */
        $relation = array(
            'fields' => "count(*) As total",
            'conditions' => $filter_data . "user = {$agentId} AND STATUS LIKE 'Client' AND dispo IN('SALE MADE') AND lead_status = 1"
        );
        $data = $this->leadstore_m->get_relation('', $relation);
        $this->data['totalClientLeads'] = $data['0']['total'];

        /* total premiums */
        $relation = array(
            'fields' => "sum(premium) As total_premium",
            'JOIN' => array(
                array(
                    'table' => 'lead_products',
                    'condition' => 'lead_products.lead_id = lead_store_mst.lead_id',
                    'type' => 'LEFT'
                ),
            ),
            'conditions' => $filter_data . "user = {$agentId} AND lead_status = 1"
        );
        $data = $this->leadstore_m->get_relation('', $relation);
        $this->data['totalPremiumLeads'] = $data['0']['total_premium'];

        /* recent six leads */
        $relation = array(
            'conditions' => "user = {$agentId} AND STATUS LIKE 'Lead' AND lead_status = 1",
            'ORDER_BY' => array(
                'field' => 'lead_id',
                'order' => 'DESC'
            )
        );
        $relation['LIMIT']['start'] = 6;
        $relation['LIMIT']['end'] = 0;
        $recentLeads = $this->leadstore_m->get_relation('', $relation);
        $this->data['recentLeads'] = $recentLeads;

        /* recent six opportunities */
        $relation_opp = array(
            'conditions' => "user = {$agentId} AND STATUS LIKE 'Opportunity' AND dispo IN('QUOTED','CALLBACK') AND lead_status = 1",
            'ORDER_BY' => array(
                'field' => 'lead_id',
                'order' => 'DESC'
            )
        );
        $relation_opp['LIMIT']['start'] = 6;
        $relation_opp['LIMIT']['end'] = 0;
        $recentOppurtunities = $this->leadstore_m->get_relation('', $relation_opp);
        $this->data['recentOppurtunities'] = $recentOppurtunities;

        /* recent six client */
        $relation_cleint = array(
            'fields' => 'lead_store_mst.lead_id AS main_lead_id,lead_store_mst.first_name,lead_store_mst.email,lead_store_mst.source,lead_store_mst.middle_name,lead_store_mst.last_name,lead_store_mst.phone,lead_products.*,products.product_name,category.category_name,company.company_name,lead_store_mst.created as main_created',
            'JOIN' => array(
                array(
                    'table' => 'lead_products',
                    'condition' => 'lead_products.lead_id = lead_store_mst.lead_id',
                    'type' => 'LEFT'
                ),
                array(
                    'table' => 'products',
                    'condition' => 'products.id = lead_products.product_id',
                    'type' => 'LEFT'
                ),
                array(
                    'table' => 'category',
                    'condition' => 'lead_products.coverage_type = category.id',
                    'type' => 'LEFT'
                ),
                array(
                    'table' => 'company',
                    'condition' => 'company.id = lead_products.carriers',
                    'type' => 'LEFT'
                ),
            ),
            'conditions' => "user = {$agentId} AND lead_store_mst.status LIKE 'Client' AND dispo IN('SALE MADE') AND lead_status = 1",
            'ORDER_BY' => array(
                'field' => 'lead_store_mst.lead_id',
                'order' => 'DESC'
            )
        );
        $relation_cleint['LIMIT']['start'] = 10;
        $relation_cleint['LIMIT']['end'] = 0;
        $recentClients = $this->leadstore_m->get_relation('', $relation_cleint);

        $this->data['recentClients'] = $recentClients;
        $this->template->load("agent", "crm/index", $this->data);
    }

    public function leadindex() {
        // Fetch Dynamic Column Title
        $this->data['dynamic_col_data'] = $this->fetch_dynamic_title('Lead');
        $this->data['title'] = 'Agent | CRM Leads';
        $this->data['pagetitle'] = 'Leads';
        $this->data['datatable'] = TRUE;
        $this->data['ckeditor'] = TRUE;
        $this->data['listtitle'] = 'Leads Listing';
        $this->data['addactioncontroller'] = 'crm/edit/lead';
        $this->data['importactioncontroller'] = 'crm/loadbulk/lead';
        $this->data['exportactioncontroller'] = 'crm/export/lead';
        $this->data['label'] = "Lead";
        $this->data['type'] = 'Lead';
        $this->template->load("agent", "crm/list", $this->data);
    }

    public function indexjson($type = NULL) {

        // Fetch Dynamic Column
        $aColumns = $this->fetch_dynamic_column($type);

        // $aColumns = array('lead_id', 'main.first_name', 'member_id', 'dispo', 'city', 'phone', 'status', 'last_local_call_time');
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
        if ($type == NULL) {
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

        $rResult = $this->leadstore_m->queryForAgent($sWhere, $sOrder, $sLimit);

        $aFilterResult = $this->leadstore_m->queryForAgent($sWhere);
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
                    if ($aColumns[$i] == 'lead_id') {
                        $row[] = '<input type="checkbox" class="checkboxes is-check bubbleAction" name="id[]" value="' . encode_url($aRow['lead_id']) . '"/>';
                    } elseif ($aColumns[$i] == 'gender') {
                        if ($aRow[$aColumns[$i]] == 'M') {
                            $row[] = 'Male';
                        } elseif ($aRow[$aColumns[$i]] == 'F') {
                            $row[] = 'Female';
                        } else {
                            $row[] = 'N/A';
                        }
                    } elseif ($aColumns[$i] == 'phone') {
                        $row[] = formatPhoneNumber($aRow[$aColumns[$i]]);
                    } else {
                        $row[] = isset($aRow[$aColumns[$i]]) ? $aRow[$aColumns[$i]] : '';
                    }
                }
                $row[] = '<a title="Edit" data-toggle="tooltip" class="btn green btn-xs a-tooltip" href="' . site_url('crm/edit/' . lcfirst($type) . '/' . encode_url($aRow['lead_id'])) . '"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;<a title="Delete" data-toggle="tooltip" class="delete btn green btn-xs a-tooltip" href="' . site_url('crm/delete/' . lcfirst($type) . '/' . encode_url($aRow['lead_id'])) . '"><i class="fa fa-trash" aria-hidden="true"></i></a>&nbsp;<a class="btn green btn-xs a-tooltip" data-toggle="tooltip" href="jaavsript:;" title="Call"><i class="icon-call-out"></i></a>&nbsp;<a class="btn green btn-xs a-tooltip" href="' . site_url('lead/emailpopup/' . encode_url($aRow['lead_id'])) . '" title="Email Message" data-target="#ajaxemail" data-toggle="modal"><i class="icon-envelope"></i></a>&nbsp;<a class="btn green btn-xs a-tooltip attachment" title="Document" href="' . site_url('lead/filepopup/' . encode_url($aRow['lead_id'])) . '" data-target="#ajax" data-toggle="modal"><i class="fa fa-file"></i></a>';
                //$row[] = '<a title="Edit" data-toggle="tooltip" class="btn green btn-xs a-tooltip" href="' . site_url('crm/edit/' . lcfirst($type) . '/' . encode_url($aRow['lead_id'])) . '"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;<a title="Delete" data-toggle="tooltip" class="delete btn green btn-xs a-tooltip" href="' . site_url('crm/delete/' . lcfirst($type) . '/' . encode_url($aRow['lead_id'])) . '"><i class="fa fa-trash" aria-hidden="true"></i></a>&nbsp;<a class="btn green btn-xs a-tooltip" data-toggle="tooltip" href="jaavsript:;" title="Call"><i class="icon-call-out"></i></a>&nbsp;<a class="btn green btn-xs a-tooltip" href="' . site_url('lead/emailpopup/' . encode_url($aRow['lead_id'])) . '" title="Email Message" data-target="#ajaxemail" data-toggle="modal"><i class="icon-envelope"></i></a>&nbsp;<a class="btn green btn-xs a-tooltip" title="Document" href="' . site_url('lead/filepopup/' . encode_url($aRow['lead_id'])) . '" data-target="#ajax" data-toggle="modal"><i class="fa fa-file"></i></a>';

                $output['aaData'][] = $row;
            }
        } else {
            $output['aaData'] = array();
        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    public function edit($type = 'lead', $id = NULL) {
        $this->data['validation'] = TRUE;
        $this->data['datepicker'] = TRUE;
        $this->data['fancybox'] = TRUE;
        $this->data['audiojs'] = TRUE;
        $this->data['meta_title'] = "Lead Operation";
        $this->data['title'] = ucfirst($type);
        $this->data['cancelurl'] = $this->__cancelUrl($type);
        $this->data['breadcrumb'] = ucfirst($type);
        $this->data['countries'] = $this->db->get('country')->result();
        $this->data['states'] = $this->db->get('state')->result();
        $this->data['pagetitle'] = ucfirst($type);
        $this->data['status'] = ucfirst($type);
        if ($id) {
            $id = decode_url($id);
            $this->data['lead'] = $this->leadstore_m->get_by(array('lead_id' => $id), TRUE);
            count($this->data['lead']) || $this->data['errors'][] = 'List could not be found';
            $this->data['listtitle'] = "Edit " . ucfirst($type) . ' ' . $this->data['lead']->member_id;
            $totalAd['peoples'] = "";
            $this->data['requiredJson'] = $this->leadfield_m->getRequiredFieldJson($id);
        } else {
            $this->data['listtitle'] = "Add A New " . ucfirst($type);
            $this->data['lead'] = $this->leadstore_m->get_new();
        }

        $this->form_validation->set_rules($this->leadstore_m->rules);

        if ($this->form_validation->run() == TRUE) {

            $data = $this->leadstore_m->array_from_post(array(
                'agency_id', 'first_name', 'middle_name', 'last_name', 'gender', 'height', 'weight', 'email', 'dialcode', 'phone', 'cellphone', 'work_phone', 'address', 'country', 'state', 'city', 'postal_code', 'status', 'date_of_birth', 'opportunity_status', 'dispo', 'source', 'lead_status', 'notes', 'mothers_maiden_name', 'license_number', 'occupation'
            ));
            $data['agency_id'] = $this->session->userdata('agent')->agency_id;
            $data['user'] = $this->session->userdata('agent')->id;
            if ($data['date_of_birth'] != '') {
                $data['date_of_birth'] = date('Y-m-d', strtotime($data['date_of_birth']));
            }
            if ($id == NULL) {
                $data['owner'] = $this->session->userdata('user')->email_id;
                $data['member_id'] = getIncrementMemberId();

                /* ------ For Dispo Field ------- */
                if ($type == 'lead') {
                    $data['dispo'] = 'NEW';
                } elseif ($type == 'opportunity') {
                    $data['dispo'] = 'QUOTED';
                } elseif ($type == 'client') {
                    $data['dispo'] = 'SALE MADE';
                }
                /* ------ End For Dispo Field --- */
            } else {
                /* ------ For Dispo Field ------- */
                if ($type == 'lead') {
                    $data['dispo'] = 'NEW';
                } elseif ($type == 'client') {
                    $data['dispo'] = 'SALE MADE';
                }
                $data['dispo'] = $this->input->post('dispo');
                /* ------ End For Dispo Field --- */
            }

            if (!empty($_POST['custom_field'])) {
                $customFields = $_POST['custom_field'];
                foreach ($customFields as $key => $val) {
                    $v = $this->leadfieldval_m->get($key, TRUE);
                    if ($v) {
                        $valId = $v->value_id;
                    } else {
                        $valId = NULL;
                    }
                    $fieldVal = is_array($val) ? implode(',', $val) : $val;
                    $valData = array(
                        'field_id' => $key,
                        'value' => $fieldVal
                    );
                    $this->leadfieldval_m->save($valData, $valId);
                }
            }
            $leadId = $this->leadstore_m->save($data, $id);
            if ($leadId) {
                if ($id == NULL) {
                    updateIncrementMemberId();
                    $feed_type = 0;
                    $title = "New " . ucfirst($type) . " Created";
                } else {
                    $feed_type = 1;
                    $title = ucfirst($type) . " Updated";
                }
                /* ---------- For User Log ------- */
                $from_id = $this->session->userdata("user")->id;
                $to_id = $this->session->userdata("user")->id;
                $log_type = strtolower($type);
                $log_url = 'crm/edit/' . $type . '/' . encode_url($leadId);
                user_log($from_id, $to_id, $feed_type, $log_type, $title, $log_url);
                /* ---------- End For User Log ------- */

                $id = encode_url($leadId);
                $this->session->set_flashdata('success', 'Lead saved successfully.');
                redirect('crm/edit/' . $type . '/' . $id);
            }
        }

        if ($id) {
            $this->template->load("agent", "crm/edit", $this->data);
        } else {
            $this->template->load("agent", "crm/add", $this->data);
        }
    }

    public function massaction($type = 'lead') {
        $ids = $this->input->post('id');
        $redirectUrl = $this->__cancelUrl($type);
        if (empty($ids)) {
            $this->session->set_flashdata('error', 'No ' . ucfirst($type) . ' Records have been selected.');
            redirect($redirectUrl);
        }
        $action = $this->input->post('action');
        switch ($action) {
            case 'del':
                foreach ($ids as $key => $id) {
                    $id = decode_url($id);
                    $this->leadstore_m->delete($id);
                }
                $this->session->set_flashdata('success', ucfirst($type) . ' deleted successfully.');
                break;
        }
        redirect($redirectUrl);
    }

    public function delete($type = 'lead', $id = NULL) {
        if ($id) {
            $id = decode_url($id);
            $this->leadstore_m->delete($id);
            $this->session->set_flashdata('success', ucfirst($type) . ' deleted successfully.');
        } else {
            $this->session->set_flashdata('error', ucfirst($type) . ' doesn\'t exist.');
        }
        $redirectUrl = $this->__cancelUrl($type);
        redirect($redirectUrl);
    }

    public function opportunities() {
        // Fetch Dynamic Column Title
        $this->data['dynamic_col_data'] = $this->fetch_dynamic_title('Opportunity');
        $this->data['title'] = 'Agent | CRM Opportunities';
        $this->data['pagetitle'] = 'Opportunities';
        $this->data['datatable'] = TRUE;
        $this->data['ckeditor'] = TRUE;
        $this->data['knockout'] = TRUE;
        $this->data['listtitle'] = 'Opportunities Listing';
        $this->data['addactioncontroller'] = 'crm/edit/opportunity';
        $this->data['importactioncontroller'] = 'crm/loadbulk/opportunity';
        $this->data['exportactioncontroller'] = 'crm/export/opportunity';
        $this->data['label'] = "Opportunity";
        $this->data['type'] = 'Opportunity';
        $this->template->load("agent", "crm/list", $this->data);
    }

    public function clients() {
        // Fetch Dynamic Column Title
        $this->data['dynamic_col_data'] = $this->fetch_dynamic_title('Client');
        $this->data['title'] = 'Agent | CRM Clients';
        $this->data['pagetitle'] = 'Clients';
        $this->data['datatable'] = TRUE;
        $this->data['ckeditor'] = TRUE;
        $this->data['knockout'] = TRUE;
        $this->data['listtitle'] = 'Clients Listing';
        $this->data['addactioncontroller'] = 'crm/edit/client';
        $this->data['importactioncontroller'] = 'crm/loadbulk/client';
        $this->data['exportactioncontroller'] = 'crm/export/client';
        $this->data['label'] = "Client";
        $this->data['type'] = 'Client';
        $this->template->load("agent", "crm/list", $this->data);
    }

    private function __cancelUrl($type) {
        $url = '';
        switch ($type) {
            case 'lead':
                $url = site_url('crm/leadindex');
                break;
            case 'opportunity':
                $url = site_url('crm/opportunities');
                break;
            case 'client':
                $url = site_url('crm/clients');
                break;
        }
        return $url;
    }

    public function addfield($leadId = NULL) {
        if ($leadId) {
            $this->data['lead'] = decode_url($leadId);
            $fields = $this->leadfield_m->get_by(array('lead_id' => decode_url($leadId)));
            $this->data['customFields'] = $fields;
        }
        $this->load->view('agent/crm/field', $this->data);
    }

    public function removefield($leadId = NULL) {
        if ($leadId) {
            $this->data['lead'] = decode_url($leadId);
            $fields = $this->leadfield_m->get_by(array('lead_id' => decode_url($leadId)));
            $this->data['customFields'] = $fields;
        }
        $this->load->view('agent/crm/fieldremove', $this->data);
    }

    public function loadbulk($type = 'lead') {
        $this->data['title'] = 'Agent | CRM ' . ucfirst($type) . ' | Bulk Upload';
        $this->data['pagetitle'] = ucfirst($type) . ' Bulk Upload';
        $this->data['validation'] = TRUE;
        $this->data['listtitle'] = 'Import ' . ucfirst($type);
        $this->data['status'] = ucfirst($type);
        $this->template->load("agent", "crm/bulk", $this->data);
    }

    function image_upload() {
        if ($_FILES['lead_file']['size'] != 0) {
            $upload_dir = "./uploads/leads/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir);
            }
            $config['upload_path'] = $upload_dir;
            $config['allowed_types'] = 'csv';
            $config['file_name'] = $_FILES['lead_file']['name'];
            $config['overwrite'] = true;
            $config['max_size'] = '512000000000';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('lead_file')) {
                $this->form_validation->set_message('image_upload', $this->upload->display_errors());
                return false;
            } else {
                $this->upload_data['file'] = $this->upload->data();
                $this->_data = $this->upload->data();
                $this->_upload_filename = $this->_data['file_name'];
                $this->_upload_extension = $this->upload_data['file']['file_ext'];
                return true;
            }
        } else {
            $this->form_validation->set_message('image_upload', "No file selected");
            return false;
        }
    }

    function change_status($status = '', $lead_id = '') {
        $data['status'] = $status;
        $redirect = '';
        /* ---- For Redirect --- */
        if ($status == 'Lead') {
            $data['dispo'] = 'NEW';
            $data['opportunity_status'] = '';
            $redirect = 'leadindex';
        } elseif ($status == 'Opportunity') {
            $data['dispo'] = 'QUOTED';
            $data['opportunity_status'] = 'Pre-Qualified';
            $redirect = 'opportunities';
        } elseif ($status == 'Client') {
            $data['dispo'] = 'SALE MADE';
            $data['opportunity_status'] = '';
            $redirect = 'clients';
        }
        /* ---- For Redirect --- */
        $id = decode_url($lead_id);
        $res = $this->leadstore_m->save($data, $id);
        if ($res) {
            //-------------- For Convert Lead status ---------
            $NotesId = NULL;
            $note_data['lead_id'] = $id;
            $note_data['notes'] = "Status was changed to status " . $status;
            $note_data['user_group_id'] = $this->session->userdata("user")->user_group_id;
            $note_data['user_id'] = $this->session->userdata("user")->id;
            $this->leadnotes_m->save($note_data, $NotesId);
            //-------------- For Convert Lead status ---------

            $this->session->set_flashdata('success', "Convert Successfully");
        } else {
            $this->session->set_flashdata('error', "Error into Convert");
        }
        redirect('crm/' . $redirect);
    }

    public function fieldedit($id = NULL) {
        $this->load->model('leadfield_m');
        $this->form_validation->set_rules('field_name', 'Field Name', 'trim|required');
        $this->form_validation->set_rules('field_label', 'Field Label', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
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
            if ($post['field'] == 'add_new') {
                $fieldId = $this->leadfield_m->save($data, NULL);
            } else {
                $fieldId = $this->leadfield_m->save($data, $post['field']);
            }
            if (isset($post['is_deleted']) && $post['is_deleted'] == 'y') {
                $this->leadfield_m->delete($post['field']);
                $fieldVal = $this->leadfieldval_m->get_by(array('field_id' => $post['field']), TRUE);
                if ($fieldVal) {
                    $this->leadfieldval_m->delete($fieldVal->value_id);
                }
                $html = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Option deleted successfully.</div>';
            } else {
                $html = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Option saved successfully.</div>';
            }
            $output['success'] = true;

            $output['html'] = $html;
        } else {
            $output['success'] = false;
            $html = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' . validation_errors() . '</div>';
            $output['html'] = $html;
        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    public function fieldelete($id = NULL) {
        $this->load->model('leadfield_m');
        $this->form_validation->set_rules('field', 'Field Name', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post();
            $fieldId = $post['field'];
            $this->leadfield_m->delete($post['field']);
            $fieldVal = $this->leadfieldval_m->get_by(array('field_id' => $post['field']), TRUE);
            if ($fieldVal) {
                $this->leadfieldval_m->delete($fieldVal->value_id);
            }
            $html = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Option deleted successfully.</div>';
            $output['success'] = true;
            $output['html'] = $html;
        } else {
            $output['success'] = false;
            $html = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' . validation_errors() . '</div>';
            $output['html'] = $html;
        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    public function renderfields($leadId = NULL) {
        if ($leadId) {
            $lead = decode_url($leadId);
        }
        $fields = $this->leadfield_m->get_by(array('lead_id' => $lead, 'is_deleted' => 'N'));
        $html = '';
        if ($fields) {
            foreach ($fields as $field) {
                $settings = unserialize($field->field_settings);
                $fieldVal = $this->leadfieldval_m->get_by(array('field_id' => $field->field_id), TRUE);
                if ($fieldVal) {
                    $fieldSelectedVal = $fieldVal->value;
                } else {
                    $fieldSelectedVal = '';
                }
                $required = '';
                if ($settings['required'] == 'yes') {
                    $required = '<span class="required">*</span>';
                }
                switch ($settings['type']) {
                    case 'text':
                    case 'phone':
                    case 'email':
                        $html .= '<div class="form-group">';
                        $html .= '<label class="col-md-3 control-label">' . $settings['label'] . $required . '</label>';
                        $html .= '<div class="col-md-4">';
                        $html .= '<input id="custom_field_' . $field->field_id . '" type="text" name="custom_field[' . $field->field_id . ']" class="form-control" value="' . $fieldSelectedVal . '"/>';
                        $html .= '</div>';
                        $html .= '</div>';
                        break;
                    case 'select':
                        $html .= '<div class="form-group">';
                        $html .= '<label class="col-md-3 control-label">' . $settings['label'] . $required . '</label>';
                        $html .= '<div class="col-md-4">';
                        $html .= '<select id="custom_field_' . $field->field_id . '" name="custom_field[' . $field->field_id . ']" class="form-control">';
                        $html .= '<option value="">Please Select</option>';
                        foreach ($settings['options'] as $opt) {
                            $selected = '';
                            if ($fieldSelectedVal == $opt) {
                                $selected = 'selected="selected"';
                            }
                            $html .= '<option ' . $selected . ' value="' . $opt . '">' . $opt . '</option>';
                        }
                        $html .= '</select>';
                        $html .= '</div>';
                        $html .= '</div>';
                        break;
                    case 'radio':
                        $html .= '<div class="form-group">';
                        $html .= '<label class="col-md-3 control-label">' . $settings['label'] . $required . '</label>';
                        $html .= '<div class="col-md-4">';
                        foreach ($settings['options'] as $opt) {
                            $selected = '';
                            if ($fieldSelectedVal == $opt) {
                                $selected = 'checked="checked"';
                            }
                            $html .= '<label class="radio-inline"><input id="custom_field_' . $field->field_id . '" ' . $selected . ' type="radio" name="custom_field[' . $field->field_id . ']" value="' . $opt . '" />' . $opt . '</label>';
                        }
                        $html .= '</div>';
                        $html .= '</div>';
                        break;
                    case 'checkbox':
                        $html .= '<div class="form-group">';
                        $html .= '<label class="col-md-3 control-label">' . $settings['label'] . $required . '</label>';
                        $html .= '<div class="col-md-4">';
                        $fieldSelectedVal = explode(',', $fieldSelectedVal);
                        foreach ($settings['options'] as $opt) {
                            $selected = '';
                            if (in_array($opt, $fieldSelectedVal)) {
                                $selected = 'checked="checked"';
                            }
                            $html .= '<label class="checkbox-inline"><input id="custom_field_' . $field->field_id . '" ' . $selected . ' type="checkbox" name="custom_field[' . $field->field_id . '][]" value="' . $opt . '" />' . $opt . '</label>';
                        }
                        $html .= '</div>';
                        $html .= '</div>';
                        break;
                    case 'textarea':
                        $html .= '<div class="form-group">';
                        $html .= '<label class="col-md-3 control-label">' . $settings['label'] . $required . '</label>';
                        $html .= '<div class="col-md-4">';
                        $html .= '<textarea id="custom_field_' . $field->field_id . '" name="custom_field[' . $field->field_id . ']" class="form-control">' . $fieldSelectedVal . '</textarea>';
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

    public function refreshoption() {
        $post = $this->input->post();
        if ($post && $post['is_ajax'] == true) {
            $optionId = $post['option'];
            $field = $this->leadfield_m->get($optionId, TRUE);
            $fieldVal = $this->leadfieldval_m->get_by(array('field_id' => $field->field_id), TRUE);
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
        } else {
            $output['success'] = false;
            $output['json'] = array();
            return $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode($output));
        }
    }

    public function export($type = 'lead') {
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";
        $filename = "{$type}.csv";
        $status = ucfirst($type);
        $sql = "SELECT member_id AS `MEMBER ID`, dispo AS `DISPOSITION`, first_name AS `FIRST NAME`, middle_name AS `MIDDLE NAME`, last_name AS `LAST NAME`, gender AS `GENDER`, height AS `HEIGHT`, weight AS `WEIGHT`, address AS `ADDRESS`, address1 AS `ADDRESS1`, state AS `STATE`, city AS `CITY`, phone AS `PHONE`, postal_code AS `ZIP` , cellphone AS `CELLPHONE`, work_phone AS `WORK PHONE`, email AS `EMAIL`, mothers_maiden_name AS `MOTHER MAIDEN NAME`,license_number AS `LICENSE NUMBER`, date_of_birth AS `BIRTH DATE`, called_count AS `CALLED COUNT`, last_local_call_time AS `LAST CALL TIME`  from lead_store_mst WHERE status ='{$status}' AND user={$this->session->userdata('agent')->id} ORDER BY member_id DESC";
        $result = $this->db->query($sql);
        $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
        force_download($filename, $data);
    }

    public function get_popup_box() {
        $this->data['calendar'] = TRUE;
        $this->data['validation'] = TRUE;
        $this->data['colorpicker'] = TRUE;
        $this->data['daterangepicker'] = TRUE;
        $box_type = $this->input->post('boxtype');

        if ($box_type == 'lead') {
            $this->data['title'] = 'Add New Lead';
            $this->data['states'] = $this->db->get('state')->result();
            echo $this->load->view("agent/crm/popupbox/lead", $this->data, TRUE);
        } elseif ($box_type == 'opportunity') {
            $this->data['title'] = 'Add New Opportunity';
            $this->data['states'] = $this->db->get('state')->result();
            echo $this->load->view("agent/crm/popupbox/opportunity", $this->data, TRUE);
        } elseif ($box_type == 'client') {
            $this->data['title'] = 'Add New Client';
            $this->data['states'] = $this->db->get('state')->result();
            echo $this->load->view("agent/crm/popupbox/client", $this->data, TRUE);
        } elseif ($box_type == 'event') {
            $this->data['title'] = 'Add New Event';
            echo $this->load->view("agent/crm/popupbox/event", $this->data, TRUE);
        } elseif ($box_type == 'task') {
            $this->data['title'] = 'Add New Task';
            $sql = "SELECT id, CONCAT(fname,' ',lname) AS agent_name FROM `agents` WHERE `agency_id` = " . $this->session->userdata('agent')->agency_id . " AND `id` != " . $this->session->userdata('agent')->id . "";
            $query = $this->db->query($sql);
            $this->data['agent_list'] = $query->result_array();
            echo $this->load->view("agent/crm/popupbox/task", $this->data, TRUE);
        }
    }

    public function create_save() {
        $save_arr = $this->input->post();

        if ($save_arr['type'] == 'lead' || $save_arr['type'] == 'opportunity' || $save_arr['type'] == 'client') {
            $this->form_validation->set_rules($this->leadstore_m->rules);
        } else if ($save_arr['type'] == 'event') {
            $this->form_validation->set_rules($this->Calendar_m->rules);
        } else if ($save_arr['type'] == 'task') {
            $this->form_validation->set_rules($this->Tasks_m->rules);
        }
        if ($this->form_validation->run() == TRUE) {
            if ($save_arr['type'] == 'lead' || $save_arr['type'] == 'opportunity' || $save_arr['type'] == 'client') {
                $data = $this->leadstore_m->array_from_post(array(
                    'first_name', 'last_name', 'email', 'phone', 'address', 'state', 'city', 'postal_code'
                ));
                $data['agency_id'] = $this->session->userdata('agent')->agency_id;
                $data['user'] = $this->session->userdata('agent')->id;
                $data['owner'] = $this->session->userdata('user')->email_id;
                $data['member_id'] = getIncrementMemberId();

                if ($save_arr['type'] == 'lead') {
                    $data['dispo'] = 'NEW';
                    $data['status'] = 'Lead';
                } else if ($save_arr['type'] == 'opportunity') {
                    $data['dispo'] = 'QUOTED';
                    $data['status'] = 'Opportunity';
                } else if ($save_arr['type'] == 'client') {
                    $data['dispo'] = 'SALE MADE';
                    $data['status'] = 'Client';
                }

                $leadId = $this->leadstore_m->save($data, $id);
                if ($leadId) {
                    if ($id == NULL) {
                        updateIncrementMemberId();
                    }
                }
                if ($save_arr['type'] == 'lead') {
                    $this->session->set_flashdata('success', 'Lead saved successfully.');
                    $link = base_url('crm/leadindex');
                } else if ($save_arr['type'] == 'opportunity') {
                    $this->session->set_flashdata('success', 'Opportunity saved successfully.');
                    $link = base_url('crm/opportunities');
                } else if ($save_arr['type'] == 'client') {
                    $this->session->set_flashdata('success', 'Client saved successfully.');
                    $link = base_url('crm/clients');
                }
                echo $link;
            } elseif ($save_arr['type'] == 'event') {
                $data = $this->Calendar_m->array_from_post(array(
                    'event_start_date', 'event_end_date', 'event_start_time', 'event_end_time', 'event_color', 'event_desc'
                ));
                $data['event_start_date'] = date("Y-m-d", strtotime($data['event_start_date']));
                $data['event_end_date'] = date("Y-m-d", strtotime($data['event_end_date']));
                $data['user_id'] = $this->session->userdata('agent')->id;
                $event_id = $this->Calendar_m->save($data, $id);
                if ($event_id) {
                    /* ---------- For User Log ------- */
                    $from_id = $this->session->userdata("user")->id;
                    $to_id = $this->session->userdata("user")->id;
                    $feed_type = 0; // Activity Feed
                    $log_type = strtolower('calendar');
                    $title = "New Event Created";
                    $log_url = 'calendar/index';
                    user_log($from_id, $to_id, $feed_type, $log_type, $title, $log_url);
                    /* ---------- End For User Log ------- */
                    $link = base_url('calendar/index');
                    echo $link;
                }
            } elseif ($save_arr['type'] == 'task') {
                $data = $this->Calendar_m->array_from_post(array(
                    'task_description', 'task_start_time', 'task_end_time', 'task_note', 'task_date', 'assign_agent_id'
                ));
                $data['user_id'] = $this->session->userdata('agent')->user_id;
                $data['task_date'] = date("Y-m-d", strtotime($data['task_date']));
                if (isset($data['assign_agent_id']) && $data['assign_agent_id'] > 0) {
                    $data['assign_agent_id'] = $data['assign_agent_id'];
                    //-------- For log ------
                    $agent_data = $this->Agents->get($data['assign_agent_id'], TRUE);
                    $to_id = $agent_data->user_id;
                    $assign_name = $this->session->userdata('agent')->fname . " " . $this->session->userdata('agent')->lname;
                    $title = $assign_name . " Assigned New Task";
                    //-------- /For log ------
                } else {
                    $data['assign_agent_id'] = $this->session->userdata('agent')->id;
                    //-------- For log ------
                    $to_id = $this->session->userdata("user")->id;
                    $title = "New Task Created";
                    //-------- /For log ------
                }
                $task_id = $this->Tasks_m->save($data, $id);
                if ($task_id) {
                    /* ---------- For User Log ------- */
                    $feed_type = 0; // Activity Feed
                    $from_id = $this->session->userdata("user")->id;
                    $log_type = strtolower('task');
                    $log_url = 'task/index';
                    user_log($from_id, $to_id, $feed_type, $log_type, $title, $log_url);
                    /* ---------- End For User Log ------- */
                    $link = base_url('task/index');
                    echo $link;
                }
            }
        } else {
            $this->session->set_flashdata('error', 'Data Not save');
            echo 'error';
        }
    }

    /* --------------- For Display Dynamic Column Popup ------------ */

    public function dynamic_columns($lead_status = '') {
        $this->load->model('Crmdynamiccolumn_m');
        $relation = array(
            'user_id' => $this->session->userdata("user")->id,
            'status' => $lead_status,
        );
        $this->data['dynamic_col_data'] = $this->Crmdynamiccolumn_m->get_by($relation, TRUE);
        $this->data['lead_status'] = $lead_status;
        $this->data['column_list'] = array(
            'lead_category' => 'Lead Category',
            'member_id' => 'Member Id',
            'dispo' => 'Disposition',
            'gender' => 'Gender',
            // 'state'                  => 'State',
            'city' => 'City',
            'source' => 'Source',
            'phone' => 'Phone',
            'email' => 'Email',
            'postal_code' => 'Postal Code',
            'status' => 'Status',
            'last_local_call_time' => 'Created',
        );
        $this->load->view('popup/dynamic_column', $this->data);
    }

    /* --------------- For Store Dynamic Column Data ------------ */

    public function store_dynamic_column() {
        $this->load->model('Crmdynamiccolumn_m');
        //Convert column data in to serilaize form
        $dynamic_col = $this->input->post('columns');
        $str = '';
        if ($dynamic_col != '' && count($dynamic_col) > 0) {
            $str = serialize($dynamic_col);
        }
        //Decode id
        $dynamic_id = NULL;
        if ($this->input->post('dynamic_id') != '') {
            $dynamic_id = decode_url($this->input->post('dynamic_id'));
        }
        // store data array
        $data = array(
            'user_id' => $this->session->userdata("user")->id,
            'display_column' => $str,
            'status' => $this->input->post('status'),
        );
        $res = $this->Crmdynamiccolumn_m->save($data, $dynamic_id);
        echo $res;
    }

    /* ------------ For Fetch Dynamic Column Title --------- */

    public function fetch_dynamic_title($type) {
        $this->load->model('Crmdynamiccolumn_m');
        $relation = array(
            'user_id' => $this->session->userdata("user")->id,
            'status' => $type,
        );
        $res = $this->Crmdynamiccolumn_m->get_by($relation, TRUE);
        return $res;
    }

    /* ------------ For Fetch Dynamic Column --------- */

    public function fetch_dynamic_column($type) {
        $this->load->model('Crmdynamiccolumn_m');
        $relation = array(
            'user_id' => $this->session->userdata("user")->id,
            'status' => $type,
        );
        $dynamic_col_data = $this->Crmdynamiccolumn_m->get_by($relation, TRUE);
        if (count($dynamic_col_data) > 0 && (strlen($dynamic_col_data->display_column)) > 0) {
            $aColumns = array('lead_id', 'main.first_name');
            $col_set = unserialize($dynamic_col_data->display_column);
            if ($col_set != '' && count($col_set) > 0) {
                foreach ($col_set as $key => $col) {
                    array_push($aColumns, $key);
                }
            }
        } else {
            $aColumns = array('lead_id', 'main.first_name', 'member_id', 'dispo', 'city', 'phone', 'status', 'last_local_call_time');
        }
        return $aColumns;
    }

    /*
     * PLIVO SMS
     */

    public function testplivosms() {
        $this->load->library('plivo_sms');
        $resp = $this->plivo_sms->demoSMS();
        if ($resp->error) {
            echo $resp->error;
        } elseif ($resp->message_uuid) {
            echo 'SMS Sent';
        } else {
            echo 'Something Went Wrong!';
        }
        exit();
    }

    public function send_sms_lead($id = null, $test = null) {
        $this->load->library('plivo_sms');
    }

}
