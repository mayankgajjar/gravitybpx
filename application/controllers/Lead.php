<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Lead extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            if ($this->session->userdata("user")->group_name != 'Agent' && $this->session->userdata("user")->group_name != 'Admin' && $this->session->userdata("user")->group_name != 'Agency') {
                redirect('/Forbidden');
            }
        }
        $this->load->model('leadstore_m');
        $this->load->model('leadfile_m');
        $this->load->model('leadpeople_m');
        $this->load->model('leadproduct_m');
        $this->load->model('leademail_m');
        $this->load->model('leadnotes_m');
        $this->load->model('leadSmsLog_m', 'leadsmslog_m');
        $this->load->model('Company_model', 'company');
    }

    public function leadfile($leadId = NULL) {
        $leadId = decode_url($leadId);
        if ($leadId) {
            $this->load->model('recording_m');
            $this->data['leadId'] = $leadId;
            $files = $this->leadfile_m->get_by(array('lead_id' => $leadId));
            $option = array(
                'fields' => "recording_log.callUUid, recording_url",
                'JOIN' => array(
                    array(
                        'table' => 'call_log',
                        'condition' => 'recording_log.callUUid = call_log.CallUUID',
                        'type' => 'left'
                    ),
                ),
                'conditions' => 'lead_id = ' . $leadId
            );
            $recordings = $this->recording_m->get_relation('', $option);
            $this->data['leadDocs'] = $files;
            $this->data['recordings'] = $recordings;
            $html = $this->load->view('agent/crm/files', $this->data, TRUE);
            $output['success'] = TRUE;
            $output['html'] = $html;
        } else {

        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    public function upload($leadId = NULL) {
        ini_set('memory_limit', '-1');
        $post = $this->input->post();
        $leadId = decode_url($leadId);
        if ($_FILES['attachment']['size'] != 0 && $leadId) {
            $upload_dir = "./uploads/leads/agent/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir);
            }
            $config['upload_path'] = $upload_dir;
            $config['allowed_types'] = 'csv|gif|png|jpeg|jpg|dox|xls|docx|xlxs';
            $config['file_name'] = isset($post['attachname']) ? $post['attachname'] : $_FILES['attachname']['name'];
            $config['overwrite'] = true;
            $config['max_size'] = '512000000000';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('attachment')) {
                $output['success'] = FALSE;
                $html = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' . $this->upload->display_errors() . '</div>';
                $output['html'] = $html;
            } else {
                $this->upload_data['file'] = $this->upload->data();
                $this->_data = $this->upload->data();
                $this->_upload_filename = $_FILES['attachment']['name'];
                $this->_upload_extension = $this->upload_data['file']['file_ext'];
                $data = array(
                    'lead_id' => $leadId,
                    'path' => $this->_data['file_name']
                );
                $res = $this->leadfile_m->save($data, NULL);
                if ($res) {
                    /* ---------- For User Log ------- */
                    $lead_data = $this->leadstore_m->get_relation('lead_store_mst', ['lead_id' => $leadId]);
                    $from_id = $this->session->userdata("user")->id;
                    $to_id = $this->session->userdata("user")->id;
                    $feed_type = 1;
                    $log_type = "file_upload";
                    $title = "File Uploaded";
                    $log_url = 'crm/edit/' . $lead_data[0]['status'] . '/' . encode_url($leadId);
                    user_log($from_id, $to_id, $feed_type, $log_type, $title, $log_url);
                    /* ---------- End For User Log ------- */
                }
                $output['success'] = TRUE;
                $html = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> File uploaded successfully.</div>';
                $output['html'] = $html;
            }
        } else {
            $output['success'] = FALSE;
            $html = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Something went wrong.</div>';
            $output['html'] = 'Something went wrong.';
        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    public function filedelete($fileId = NULL) {
        $fileId = decode_url($fileId);
        if ($fileId) {
            $file = $this->leadfile_m->get($fileId, TRUE);
            if ($file) {
                $this->leadfile_m->delete($file->file_id);
                $uploadFile = "./uploads/leads/agent/" . $file->path;
                @unlink($uploadFile);
                $output['success'] = TRUE;
                $html = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong>File deleted successfully.</div>';
                $output['html'] = $html;
            } else {
                $output['success'] = FALSE;
                $html = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>File not found.</div>';
            }
        } else {
            $output['success'] = FALSE;
            $html = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>File not found.</div>';
        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    public function leadpeople($leadId = NULL) {
        $leadId = decode_url($leadId);
        if ($leadId) {
            $this->data['leadId'] = $leadId;
            $peoples = $this->leadpeople_m->get_by(array('lead_id' => $leadId));
            $this->data['leadPeoples'] = $peoples;
            $html = $this->load->view('agent/crm/people', $this->data, TRUE);
            $output['success'] = TRUE;
            $output['html'] = $html;
        } else {

        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    public function leadpeopleform($leadId = NULL, $peopleId = NULL) {
        $leadId = decode_url($leadId);
        if ($peopleId) {
            $peopleId = decode_url($peopleId);
        }
        $this->data['leadId'] = $leadId;
        if ($peopleId > 0) {
            $people = $this->leadpeople_m->get($peopleId, TRUE);
        } else {
            $people = $this->leadpeople_m->get_new();
        }
        $this->data['people'] = $people;
        $this->data['countries'] = $this->db->get('country')->result();
        $this->data['states'] = $this->db->get('state')->result();
        $this->load->view('agent/crm/peopleform', $this->data);
    }

    public function peopleformpost() {
        $peopleId = NULL;
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post();
            $data = $this->leadpeople_m->array_from_post(array(
                'lead_id', 'name', 'email', 'phone', 'cell_phone', 'address', 'city', 'city', 'state', 'zip', 'relation', 'date_of_birth', 'height', 'weight', 'gender', 'fb_user_ID', 'tweet_hand', 'linkedln_URL', 'notes'
            ));
            $data['lead_id'] = decode_url($data['lead_id']);
            if (strtotime($data['date_of_birth'])) {
                $data['date_of_birth'] = date('Y-m-d', strtotime($data['date_of_birth']));
            }
            if ($post['people_id']) {
                $peopleId = decode_url($post['people_id']);
            }
            $id = $this->leadpeople_m->save($data, $peopleId);
            if ($id) {
                $output['success'] = TRUE;
                $html = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Person saved successfully.</div>';
                $output['html'] = $html;
            } else {
                $output['success'] = FALSE;
                $html = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Something goes wrong.</div>';
                $output['html'] = $html;
            }
        } else {
            $output['success'] = FALSE;
            $html = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' . validation_errors() . '</div>';
            $output['html'] = $html;
        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    public function leadpdelete() {
        $post = $this->input->post();
        if ($post && $post['is_ajax']) {
            unset($post['is_ajax']);
            $peopleId = decode_url($post['people_id']);
            $this->leadpeople_m->delete($peopleId);
            $output['success'] = TRUE;
            $html = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong>Person deleted successfully.</div>';
            $output['html'] = $html;
        } else {
            $output['success'] = FALSE;
            $html = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>File not found.</div>';
        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    public function leadprodcut($leadId = NULL) {
        $leadId = decode_url($leadId);
        if ($leadId) {
            $this->data['leadId'] = $leadId;
            $option = array(
                'fields' => 'lead_products.*,products.*,category.category_name,company.company_name',
                'conditions' => 'lead_id = ' . $leadId,
                'JOIN' => array(
                    array(
                        'table' => 'products',
                        'condition' => 'products.id = lead_products.product_id',
                        'type' => 'inner'
                    ),
                    array(
                        'table' => 'category',
                        'condition' => 'lead_products.coverage_type = category.id',
                        'type' => 'inner'
                    ),
                    array(
                        'table' => 'company',
                        'condition' => 'company.id = lead_products.carriers',
                        'type' => 'inner'
                    ),
                ),
                'ORDER_BY' => array(
                    'field' => 'lead_product_id',
                    'order' => 'DESC'
                )
            );
            $products = $this->leadproduct_m->get_relation('', $option);
            $this->data['leadProducts'] = $products;
            $html = $this->load->view('agent/crm/products', $this->data, TRUE);
            $output['success'] = TRUE;
            $output['html'] = $html;
        } else {

        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    public function prodcutform($leadId = NULL, $leadProductId = NULL) {
        $this->load->model('Products_model', 'product_m');
        if ($leadId) {
            $leadId = decode_url($leadId);
        }
        $leadProduct = NULL;
        if ($leadProductId) {
            $leadProductId = decode_url($leadProductId);
            $leadProduct = $this->leadproduct_m->get($leadProductId, TRUE);
        }
        if ($leadProduct) {
            $this->data['leadProduct'] = $leadProduct;
        } else {
            $this->data['leadProduct'] = $this->leadproduct_m->get_new();
        }
        $this->data['leadId'] = $leadId;
        $this->data['companies'] = $this->company->getAll();
        $sql = "SELECT * FROM category WHERE is_active = 1";
        $query = $this->db->query($sql);
        $this->data['categories'] = $query->result();
        $this->data['string'] = $this->getAllProducts($this->data['leadProduct']);
        $this->load->view('agent/crm/productform', $this->data);
    }

    public function productformpost() {
        $post = $this->input->post();
        $savedId = array();
        if ($post) {
            $products_id = $post['products_id'];
            $leadId = $post['lead_id'];
            if ($leadId) {
                $leadId = decode_url($leadId);
            }
            $lead_product_id = NULL;
            if (isset($post['lead_product_id']) && strlen($post['lead_product_id']) > 0) {
                $lead_product_id = decode_url($post['lead_product_id']);
            }
            $data = array(
                'lead_id' => $leadId,
                'status' => 'QUOTED',
                'premium' => $post['premium'],
                'enrollment_fee' => $post['enrollment_fee'],
                'coverage_type' => $post['coverage_type'],
                'carriers' => $post['carriers'],
                'plan_type' => $post['plan_type'],
                'policy_length' => $post['policy_length'],
                'coinsurance' => $post['coinsurance'],
                'co_pays' => $post['co_pays'],
                'specialist_co_pays' => $post['specialist_co_pays'],
                'deductible_amount' => $post['deductible_amount'],
                'max_out_pocket' => $post['max_out_pocket'],
                'max_benefits' => $post['max_benefits'],
                'product_id' => $post['products_id'],
                'product_policy_no' => $post['product_policy_no']
            );
            $prid = $this->leadproduct_m->save($data, $lead_product_id);

            if ($prid) {
                $output['success'] = TRUE;
                $html = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Prodcuts saved successfully.</div>';
                $output['html'] = $html;
            } else {
                $output['success'] = FALSE;
                $html = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Something goes wrong.</div>';
                $output['html'] = $html;
            }
        } else {
            $output['success'] = FALSE;
            $html = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Something goes wrong.</div>';
            $output['html'] = $html;
        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    public function productdelete() {
        $post = $this->input->post();
        if ($post && $post['is_ajax']) {
            unset($post['is_ajax']);
            $productId = decode_url($post['lead_prodcut_id']);
            $this->leadproduct_m->delete($productId);
            $output['success'] = TRUE;
            $html = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Product deleted successfully.</div>';
            $output['html'] = $html;
        } else {
            $output['success'] = FALSE;
            $html = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> Product not found.</div>';
        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    private function getAllProducts($selected = array()) {
        $this->load->model('Products_model', 'product_m');
        $return_string = '';
        $products1 = $this->product_m->getAll();
        $this->data['products'] = $products1;
        $this->data['selectedProducts'] = $selected;
        $return_string = $this->load->view('agent/crm/productlist', $this->data, TRUE);
        return $return_string;
    }

    public function filepopup($leadId = NULL) {
        if ($leadId) {
            $leadId = decode_url($leadId);
            $this->data['leadId'] = $leadId;
            $this->data['files'] = $this->leadfile_m->get_by(array('lead_id' => $leadId));
            $this->load->view('popup/file', $this->data);
        }
    }

    public function emailpopup($leadId = NULL) {
        if ($leadId) {
            $leadId = decode_url($leadId);
            $this->data['leadId'] = $leadId;
            $files = $this->leadfile_m->get_by(array('lead_id' => $leadId));
            $this->data['send'] = $this->leadstore_m->getLeadEmail($leadId);
            if ($files) {
                $this->data['files'] = $files;
            } else {
                $this->data['files'] = '';
            }
            $this->load->view('popup/email', $this->data);
        }
    }

    public function emailpost($leadId = NULL) {
        if ($leadId) {
            $this->load->model('email_model', 'email_m');
            $leadId = decode_url($leadId);
            $lead = $this->leadstore_m->get_by(array('lead_id' => $leadId), TRUE);
            $post = $this->input->post();
            $attachments = array();
            $attachmentsFile = array();
            if ($_FILES['attachmentfile'] != '') {
                foreach ($_FILES['attachmentfile']['name'] as $key => $attachmentTemp) {
                    $temp = explode(".", $_FILES['attachmentfile']['name'][$key]);
                    $extension = end($temp);
                    $newname = $_FILES['attachmentfile']["tmp_name"][$key] . "." . $extension;
                    rename($_FILES['attachmentfile']["tmp_name"][$key], $newname);
                    $attachmentsFile[$key] = $newname;
                }
            }
            $upload_dir = "./uploads/leads/agent/";
            if ($post['attachment'] && is_array($post['attachment'])) {
                foreach ($post['attachment'] as $attachment) {
                    if (file_exists($upload_dir . $attachment)) {
                        $attachments[] = $upload_dir . $attachment;
                    }
                }
            }
            $attachments = array_merge($attachments, $attachmentsFile);
            $result = $this->email_m->mail_send($post['subject'], $this->input->post('to'), html_entity_decode($post['body']), $post['from_email'], $post['from_name'], $attachments, $this->input->post('bcc'));
            if ($result) {
                $data = array(
                    'lead_id' => $leadId,
                    'user' => $this->session->userdata('user')->id,
                    'email_message' => serialize(array(
                        'subject' => $post['subject'],
                        'from' => $post['from_email'],
                        'message' => html_escape($post['body'])
                    ))
                );
                $this->leademail_m->save($data, NULL);
                //-------------- For Convert Lead status ---------
                $NotesId = NULL;
                $note_data['lead_id'] = $leadId;
                $note_data['notes'] = "Email was sent to " . $lead->email . " with subject " . $post['subject'];
                $note_data['user_group_id'] = $this->session->userdata("user")->user_group_id;
                $note_data['user_id'] = $this->session->userdata("user")->id;
                $this->leadnotes_m->save($note_data, $NotesId);
                //-------------- For Convert Lead status ---------

                $html = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Email send successfully.</div>';
                $output['success'] = TRUE;
                $output['html'] = $html;
            } else {
                $html = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Something went wrong.</div>';
                $output['success'] = FALSE;
                $output['html'] = $html;
            }
        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    public function notes($leadId = NULL) {
        $leadId = decode_url($leadId);
        if ($leadId) {
            $this->data['leadId'] = $leadId;
            //$notes = $this->leadnotes_m->get_by(array('lead_id' => $leadId));
            $option = array(
                'fields' => 'lead_notes.*,CONCAT(a.fname," ",a.lname) as agent_name,CONCAT(age.fname," ",age.lname) as agency_name,adm.name as admin_name',
                'conditions' => 'lead_id = ' . $leadId,
                'JOIN' => array(
                    array(
                        'table' => 'agents a',
                        'condition' => 'lead_notes.user_id = a.user_id and lead_notes.user_group_id=3',
                        'type' => 'LEFT'
                    ),
                    array(
                        'table' => 'agencies age',
                        'condition' => 'lead_notes.user_id = age.user_id and lead_notes.user_group_id=2',
                        'type' => 'LEFT'
                    ),
                    array(
                        'table' => 'admin adm',
                        'condition' => 'lead_notes.user_id = adm.user_id and lead_notes.user_group_id=1',
                        'type' => 'LEFT'
                    ),
                ),
                'ORDER_BY' => array(
                    'field' => 'created',
                    'order' => 'DESC'
                )
            );

            $notes = $this->leadnotes_m->get_relation('', $option);
            $this->data['leadNotes'] = $notes;
            $html = $this->load->view('agent/crm/notes', $this->data, TRUE);
            $output['success'] = TRUE;
            $output['html'] = $html;
        } else {

        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    public function noteformpost() {
        $this->form_validation->set_rules('notes', 'Notes', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post();
            $NotesId = NULL;
            $data = $this->leadpeople_m->array_from_post(array(
                'lead_id', 'notes'
            ));
            $data['user_group_id'] = $this->session->userdata("user")->user_group_id;
            $data['user_id'] = $this->session->userdata("user")->id;

            $id = $this->leadnotes_m->save($data, $NotesId);
            if ($id) {
                $output['success'] = TRUE;
                $html = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Notes saved successfully.</div>';
                $output['html'] = $html;
            } else {
                $output['success'] = FALSE;
                $html = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Something goes wrong.</div>';
                $output['html'] = $html;
            }
        } else {
            $output['success'] = FALSE;
            $html = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' . validation_errors() . '</div>';
            $output['html'] = $html;
        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    /**
     * @uses Send Bulk Email via Action Bubble
     * @param JSon leadIds ID of Lead with Send and BCC specifications
     */
    public function mailAction() {
        if ($this->input->post('idsJson') != "") {
            $leadIds = json_decode($this->input->post('idsJson'), TRUE);
            $send = "";
            $bbc = "";
            for ($i = 0; $i < count($leadIds); $i++) {
                if ($leadIds[$i]['send'] != '') {
                    $id = decode_url($leadIds[$i]['send']);
                    $send = $this->leadstore_m->getLeadEmail($id);
                } else {
                    if ($bbc == '') {
                        $bbcID = decode_url($leadIds[$i]['bcc']);
                        $bbc = $this->leadstore_m->getLeadEmail($bbcID);
                    } else {
                        $bbcID = decode_url($leadIds[$i]['bcc']);
                        $bbc .= ',' . $this->leadstore_m->getLeadEmail($bbcID);
                    }
                }
            }
            $this->data['send'] = $send;
            $this->data['bbc'] = $bbc;
            echo $this->load->view('popup/email', $this->data, true);
        } else {
            exit('Lead ID NULL || ERROR');
        }
    }

    /**
     * @uses Send Bulk or Single SMS via Action Bubble
     * @param JSON ID(s) of Lead
     */
    public function sendSMS() {
        if ($this->input->post('idsJson') != "") {
            $this->load->library('plivo_sms');
            $leadIds = json_decode($this->input->post('idsJson'), TRUE);
            $text = "Test From Action Bubble";
            $decodedID = array();
            $phoneNumbers = "";
            for ($i = 0; $i < count($leadIds); $i++) {
                $id = decode_url($leadIds[$i]['send']);
                $decodedID[$i] = $id;
                $leadPhoneNumber = $this->leadstore_m->getLeadNumber($id);
                if ($i == 0) {
                    $phoneNumbers = $leadPhoneNumber;
                } else {
                    $phoneNumbers .= '<' . $leadPhoneNumber;
                }
            }
            // $id = decode_url($leadIds[0]['send']);
            //$leadPhoneNumber = $this->leadstore_m->getLeadNumber($id);
            if ($this->input->post('reload') == 'false') {
                $this->data['reload'] = 'false';
            } else {
                $this->data['reload'] = 'true';
            }
            $this->data['leadIds'] = serialize($decodedID);
            $this->data['phoneNumbers'] = $phoneNumbers;
            echo $this->load->view('popup/sms', $this->data, true);
        } else {
            exit('Lead ID NULL || ERROR');
        }
    }

    public function smspost() {
        $this->load->library('plivo_sms');
        $leadPhoneNumber = $this->input->post('to');
        $text = $this->input->post('smstext');
        $leadIds = $this->input->post('leadIds');
        if ($leadPhoneNumber != '' && $text != '') {
            $agentID = $this->session->userdata('agent')->id;
            $leadPhone = explode('<', $leadPhoneNumber);
            $this->load->model('agents');
            $agentPlivo = $this->agents->get_by(array('id' => $agentID), true);
            $agentNumber = '1' . $agentPlivo->plivo_phone;
            $optionsTotal = array(
                'fields' => 'count(*) as total_sms',
                'conditions' => "DATE_FORMAT(created, '%Y-%m-%d') = CURDATE() AND sender_number=$agentNumber"
            );
            $getAgentSMScount = $this->leadsmslog_m->get_relation('', $optionsTotal);
            $SMScouter = $getAgentSMScount[0]['total_sms'] + count($leadPhone);
            $sendable = '';
            foreach ($leadPhone as $key => $phone) {
                $phone = substr($phone, 1);
                $optionsCount = array(
                    'fields' => 'lead_id,sms_count,phone',
                    'conditions' => "phone =$phone  AND user=$agentID"
                );
                $getleadSMScount = $this->leadstore_m->get_relation('', $optionsCount);
                if ($getleadSMScount[0]['sms_count'] <= 2) {
                    $datacounter = $getleadSMScount[0]['sms_count'] + 1;
//                    $this->leadstore_m->save(array('sms_count' => $datacounter), $getleadSMScount[$key]['lead_id']);
                    if (count($getleadSMScount) != 0) {
                        if ($sendable == '') {
                            $sendable = '1' . $getleadSMScount[0]['phone'];
                        } else {
                            $sendable .= '<1' . $getleadSMScount[0]['phone'];
                        }
                    }
                }
            }
//            $sendableArray = explode('<', $sendable);
            if ($SMScouter <= 200) {
                $resp = $this->plivo_sms->send_sms($agentNumber, $sendable, $text);
                $resp = json_decode($resp);
                if ($resp->error) {
                    echo $resp->error;
                } elseif ($resp->message_uuid) {
                    $plivoStdArray = array('api_id' => $resp->api_id, 'message' => $resp->message);
                    $phoneArray = explode('<', $sendable);
                    $plivoRes = array();
                    foreach ($phoneArray as $key => $number) {
                        $plivoRes = $plivoStdArray;
                        $plivoRes['message_uuid'] = $resp->message_uuid[$key];
                        $dataSave = array('sms_status' => 'outbound', 'sender_number' => $agentNumber, 'receiver_number' => $number, 'text' => $text, 'plivo_response' => serialize($plivoRes));
                        $this->leadsmslog_m->save($dataSave, NULL);
                        /* ---------- For User Log ------- */
                        $lead_data = $this->leadstore_m->get_by(['phone' => substr($number, 1), 'user' => $this->session->userdata('agent')->id], TRUE);
                        if ($lead_data->first_name != '') {
                            $name = $lead_data->first_name . " " . $lead_data->last_name;
                        } else {
                            $name = $lead_data->phone;
                        }
                        /* ---------- For LEAD NOTE ------- */
                        $noteArray = array('lead_id' => $lead_data->lead_id, 'user_group_id' => $this->session->userdata('user')->user_group_id, 'user_id' => $this->session->userdata('user')->id, 'notes' => 'SMS Sent TO');
                        $this->leadnotes_m->save($noteArray);
                        /* -------------------------------- */
                        $from_id = $this->session->userdata("user")->id;
                        $to_id = $this->session->userdata("user")->id;
                        $feed_type = 0; // Activity Feed
                        $log_type = strtolower('send_sms');
                        $title = "New SMS Sent to " . $name;
                        $log_url = '';
                        user_log($from_id, $to_id, $feed_type, $log_type, $title, $log_url);
                        /* ---------- End For User Log ------- */
                    }
                    echo 'SMS Sent Successfully';
                } else {
                    echo 'Something Went Wrong!';
                }
            } else {
                echo 'sms_limt';
            }
        }
    }

    /**
     * @uses get Lead Phone number AJAX METHOD RETURN CALLABLE NUMBER.
     *
     */
    public function phoneNumberById() {
        if ($this->input->post('idsJson') != "") {
            $leadIds = json_decode($this->input->post('idsJson'), TRUE);
            $id = decode_url($leadIds[0]['send']);
            $leadPhoneNumber = $this->leadstore_m->getLeadNumber($id);
            echo $leadPhoneNumber;
        } else {
            exit('Lead ID NULL || ERROR');
        }
    }

}
