<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Billing extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            if ($this->session->userdata("user")->group_name != 'Agent') {
                redirect('/Forbidden');
            }
        }

        /*----------- For check Stripe test mode or live mode ------*/
        $stripe_data = unserialize(get_option('stripe_setting'));

        if(isset($stripe_data) && $stripe_data['stripe_mode'] == 'test'){
            $config['stripe_key_test_public'] = $stripe_data['stripe_key_test_public'];
            $config['stripe_key_test_secret'] = $stripe_data['stripe_key_test_secret'];  
            $config['stripe_test_mode'] = TRUE;  
        }else{
            $config['stripe_key_live_public'] = $stripe_data['stripe_key_live_public'];
            $config['stripe_key_live_secret'] = $stripe_data['stripe_key_live_secret'];
            $config['stripe_test_mode'] = FALSE;
        }
        /*----------- End For check Stripe test mode or live mode ------*/
    
        $config['stripe_verify_ssl'] = FALSE;
        $this->load->library('stripe', $config);
        $this->load->model('autofund_m');
        $this->load->model('transaction_m');
        $this->load->model('card_m');
        $this->load->model('agents');
    }

    /**
     * List all transaction created by the agents
     * @return type
     */
    public function transaction() {
        $this->data['datatable'] = TRUE;
        $this->data['validation'] = TRUE;
        $this->data['title'] = 'Agent | Billing Transaction';
        $this->data['pagetitle'] = 'Transaction';
        $this->data['datatable'] = TRUE;
        $this->data['listtitle'] = 'Transaction Listing';
        $this->data['addactioncontroller'] = 'crm/edit/lead';
        $this->data['label'] = "Transaction";
        $this->template->load("agent", "leadstore/billing/tranlist", $this->data);
    }

    public function transactionJson() {
        $agent = $this->agents->get($this->session->userdata('agent')->id);
        $aColumns = array('date', 'type', 'amount', 'stripe_transaction_id', 'status', 'card_id');
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
        $sWhere = " WHERE (agent_id = {$this->session->userdata('agent')->id})";
        if ($_GET['sSearch'] != "") {
            $sWhere .= " AND (";
            for ($i = 0; $i < count($aColumns); $i++) {
                $sWhere .= $aColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ') ';
        }


        $rResult = $this->transaction_m->query($sWhere, $sOrder, $sLimit);

        $aFilterResult = $this->transaction_m->query($sWhere);
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
                $row[] = $count++;
                for ($i = 0; $i < count($aColumns); $i++) {
                    if ($aColumns[$i] == 'status') {
                        switch ($aRow['status']) {
                            case 'Fund':
                                $row[] = '<span class="label label-sm label-success"> Active </span>';
                                break;
                            case 'Refund':
                                $row[] = '<span class="label label-sm label-success"> Refunded </span>';
                                break;
                            default:
                                # code...
                                break;
                        }
                    }elseif($aColumns[$i] == 'card_id'){
                        $card= $this->card_m->get($aRow['card_id'], TRUE);
                        if($card){
                            $result = $this->stripe->retrive_card($card->stripe_card_id, $agent->stripe_client_id);
                            $resultJson = json_decode($result);                           
                            $row[] = $resultJson->name.' - '.$resultJson->brand;
                        }else{
                            $row[] = 'Card Deleted';
                        }
                    }elseif($aColumns[$i] == 'amount'){
                        $row[] = formatMoney($aRow['amount'], 2);
                    }else {                    
                        $row[] = $aRow[$aColumns[$i]];
                    }
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

    /**
     * List all credit cards saved by the agents
     * @return null
     */
    public function creditcards() {
        $this->data['datatable'] = TRUE;
        $this->data['validation'] = TRUE;
        $this->data['title'] = 'Agent | Billing Credit Cards';
        $this->data['pagetitle'] = 'Credit Cards';
        $this->data['listtitle'] = 'Credit Cards Listing';
        $this->data['label'] = "Cards";
        $agent = $this->agents->get($this->session->userdata('agent')->id);
        $result = $this->stripe->customer_list_cards($agent->stripe_client_id, 100);
        $cards = json_decode($result);
        $this->data['cards'] = isset($cards->data) ? $cards->data : array();
        $this->template->load("agent", "leadstore/billing/cardlist", $this->data);
    }

    public function exporttransaction() {
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";
        $filename = "transaction.csv";
        $sql = "SELECT `date` AS `DATE`, `type` AS 'PAYMENT MODE', `amount` AS `AMOUNT`, `stripe_transaction_id` AS 'TRANSACTION ID', case status when 'Refund' then \"Refund\" when 'Fund' then \"Active\" end as `STATUS` FROM `agent_billing_transactions` WHERE `agent_id` =  {$this->session->userdata('agent')->id}";
        $result = $this->db->query($sql);
        $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
        force_download($filename, $data);
    }

    /**
     * save credit card information in database for logged in buyer
     * @param type|null $id
     * @return JSON
     */
    public function cardsprocess($id = NULL) {
        $rules = $this->card_m->rules;
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            return $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode(array('success' => false, 'message' => $errors)));
        } else {
            $post = $this->input->post();
            $agent = $this->agents->get($this->session->userdata('agent')->id);
            $data = $this->card_m->array_from_post(array(
                'card_holder_name', 'card_type', 'card_exp_date', 'card_cvv_code'
            ));
            if ($agent->stripe_client_id) {
                $stripeClientId = $agent->stripe_client_id;
            } else {
                $email = $this->session->userdata('user')->email_id;
                $result = $this->stripe->customer_create(array(), $email);
                $customer = json_decode($result);
                $stripeClientId = $customer->id;
                $this->agents->save(array('stripe_client_id' => $stripeClientId), $this->session->userdata('agent')->id);
            }
            $date = explode('/', $post['card_exp_date']);
            $card_data = array("card"
                => array(
                    'number' => $post['card_number'],
                    'cvc' => $post['card_cvv_code'],
                    'exp_month' => $date[0],
                    'exp_year' => $date[1],
                    'name' => $post['card_holder_name'],
            ));
            $result = $this->stripe->create_card_token($card_data);
            $token = json_decode($result);
            $tokenId = $token->id;
            $result = $this->stripe->customer_create_card($stripeClientId, $tokenId);
            $card = json_decode($result);
            $cardId = $card->id;
            //$data['card_number'] = $this->input->post('card_number');
            $data = array(
                'agent_id' => $this->session->userdata('agent')->id,
                'stripe_card_id' => $cardId,
            );
            $id = $this->card_m->save($data, $id);
            if ($id) {
                return $this->output
                                ->set_content_type('application/json')
                                ->set_output(json_encode(array('success' => true, 'message' => 'Card saved successfully.')));
            } else {
                return $this->output
                                ->set_content_type('application/json')
                                ->set_output(json_encode(array('success' => false, 'message' => 'Error occured.')));
            }
        }
    }

    public function carddelete($id = NULL) {
        if ($id) {
            $cardId = decode_url($id);
            $card = $this->card_m->get_by(array('stripe_card_id' => $cardId), TRUE);
            if ($card) {
                $agent = $this->agents->get($this->session->userdata('agent')->id);
                $this->stripe->delete_card_data($cardId, $agent->stripe_client_id);
                $this->card_m->delete($card->card_id);
                $this->session->set_flashdata('success', 'Card deleted successfully.');
            } else {
                $this->session->set_flashdata('success', "Card doen't exists.");
            }
        } else {
            $this->session->set_flashdata('success', "Card doen't exists.");
        }
        redirect('billing/creditcards');
    }

    public function massdeletecards() {
        $ids = $this->input->post('id');
        if (empty($ids)) {
            $this->session->set_flashdata('error', 'No Records have been selected.');
            redirect('billing/creditcards');
        }
        $action = $this->input->post('action');
        switch ($action) {
            case 'del':
                foreach ($ids as $key => $id) {
                    $cardId = decode_url($id);
                    $card = $this->card_m->get_by(array('stripe_card_id' => $cardId), TRUE);
                    if ($card) {
                        $agent = $this->agents->get($this->session->userdata('agent')->id);
                        $this->stripe->delete_card_data($cardId, $agent->stripe_client_id);
                        $this->card_m->delete($card->card_id);
                        $this->session->set_flashdata('success', 'Card deleted successfully.');
                    } else {
                        $this->session->set_flashdata('success', "Card doen't exists.");
                    }
                }
                break;
        }
        redirect('billing/creditcards');
    }

    /**
     * Display Setting for auto-funding feature for Buyer.
     * @return type
     */
    public function autofund() {
        $this->data['validation'] = TRUE;
        $this->data['title'] = "Agent | Billing Auto-fund";        
        $this->data['breadcrumb'] = "Auto-fund";
        $this->data['pagetitle'] = 'Auto Fund';
        $this->data['label'] = "Auto-fund";
        $this->data['listtitle'] = 'Auto Fund setting';
        $autoFund = $this->autofund_m->get_by(array('agent_id' => $this->session->userdata('agent')->id), TRUE);
        if($autoFund){
            $this->data['autoFund'] = $autoFund;
        }else{
            $this->data['autoFund'] = $this->autofund_m->get_new();
        }
        $this->template->load("agent", "leadstore/billing/autofund", $this->data);
    }
    
    public function autofundpost(){
        $post = $this->input->post();
        if($post){
            $autofundId = NULL;
            $autoFund = $this->autofund_m->get_by(array('agent_id' => $this->session->userdata('agent')->id), TRUE);            
            if($autoFund){
                $autofundId = $autoFund->fund_id;
            }
            $data = array(
                'agent_id' => $this->session->userdata('agent')->id,
                'card_id' => decode_url($post['method']),
                'add_price' => $post['add_price'],
                'condition_name' => $post['condition_name'],
                'is_active' => $post['is_active']
            );            
            $id = $this->autofund_m->save($data, $autofundId);
            if($id){
                $this->session->set_flashdata('success', "Auto fund data set successfully.");
                redirect('billing/autofund');
            }
        }
    }

    /**
     * callback function for card validation.
     * @param type|null $string
     * @return boolean
     */
    function cardnumber_validation($string = NULL) {
        $this->load->helper('my_credit_card'); // loading helper.
        $string = $this->input->post('card_number');
        $cards = unserialize(CREDIT_CARDS);
        $cardtype = $cards[$this->input->post('card_type')];
        if (checkCreditCard($string, $cardtype, $ccerror, $ccerrortext)) {
            return TRUE;
        } else {
            $this->form_validation->set_message("cardnumber_validation", 'The %s is not valid.');
            return FALSE;
        }
    }

    public function addfund() {
        $post = $this->input->post();
        if ($post) {
            $agent = $this->agents->get($this->session->userdata('agent')->id);
            $currentBalance = $agent->balance;
            $customerId = $agent->stripe_client_id;
            $return = array();
            $dollar = $post['amount'];
            $amt = $dollar;
            $card = decode_url($post['method']);
            $amount = (float) $dollar * 100;
            $cardData = array(
                'customer_id' => $customerId,
                'card_id' => $card
            );
            $result = $this->stripe->charge_card($amount, $cardData, 'Payment');
            $resultJson = json_decode($result);
            if (isset($resultJson->id) && strlen($resultJson->id) > 0) {
                $card = $this->card_m->get_by(array('stripe_card_id' => $card), TRUE);
                $tranId = $resultJson->id;
                $data = array(
                    'agent_id' => $this->session->userdata('agent')->id,
                    'date' => date('Y-m-d H:i:s', $resultJson->created),
                    'type' => 'Manual',
                    'amount' => $amt,
                    'stripe_transaction_id' => $tranId,
                    'card_id' => $card->card_id,
                    'status' => 'Fund'
                );
                $id = $this->transaction_m->save($data, NULL);                
                $this->agents->updateAgentBalance($this->session->userdata('agent')->id, $amt);
                $return = array('success' => true, 'message' => 'Fund added successfully.');
            } else {
                $return = array('success' => true, 'message' => 'Something goes wrong.');
            }
        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($return));
    }

}
