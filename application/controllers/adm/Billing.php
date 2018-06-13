<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Billing extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            if ($this->session->userdata("user")->group_name != 'Admin') {
                redirect('/Forbidden');
            }
        }
        $this->load->model('transaction_m');
    }

    public function transaction() {
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert'] = TRUE;
        $this->data['title'] = 'Lead Store | Billing Transactions';
        $this->data['maintitle'] = 'Transaction';
        $this->data['listtitle'] = 'Transactions';
        $this->data['breadcrumb'] = 'Transactions';
        $this->data['addactioncontroller'] = 'adm/vertical/edit';
        $this->template->load('admin', 'billing/transaction/list', $this->data);
    }

    public function transactionjson() {
        $aColumns = array('tran_id', 'a.fname', 'name', 'stripe_transaction_id', 'date', 'amount', 'status', 'type');

        $relation = array(
            "fields" => implode(',', $aColumns) . ',concat(a.fname, " ", a.lname) as `a.fname`',
            "JOIN" => array(
                array(
                    "table" => 'agents a',
                    "condition" => 'agent_billing_transactions.agent_id = a.id ',
                    "type" => 'LEFT'
                ),
                array(
                    "table" => 'agencies age',
                    "condition" => 'a.agency_id = age.id ',
                    "type" => 'LEFT'
                )
            ),
        );
        $relation['ORDER_BY']['field'] = $aColumns[0];
        $relation['ORDER_BY']['order'] = 'DESC';
        /** Ordering */
        if (isset($_GET['iSortCol_0'])) {
            $relation['ORDER_BY']['field'] = $aColumns[$_GET['iSortCol_0']];
            $relation['ORDER_BY']['order'] = $_GET['sSortDir_' . 0];
            /* for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
              if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
              $relation['ORDER_BY']['field'] = $aColumns[$i];
              $relation['ORDER_BY']['order'] = $_GET['sSortDir_' . $i];
              }
              } */
        }
        $sWhere = '';
        if ($_GET['sSearch'] != "") {
            $sWhere .= " (";
            for ($i = 0; $i < count($aColumns); $i++) {
                $sWhere .= $aColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ') ';
        }
        $relation['conditions'] = $sWhere;

        // $aFilterResult = $this->transaction_m->get_relation('', $relation);

        /** Paging */
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $relation['LIMIT']['start'] = $_GET['iDisplayLength'];
            $relation['LIMIT']['end'] = $_GET['iDisplayStart'];
        }

        $rResult = $this->transaction_m->get_relation('', $relation);

        /* if ($aFilterResult) {
          $iFilteredTotal = count($rResult);
          } else {
          $iFilteredTotal = 0;
          } */
        $iFilteredTotal = count($rResult);
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

                for ($i = 0; $i < count($aColumns); $i++) {
                    if ($aColumns[$i] == 'tran_id') {
                        $row[] = $count++;
                    } elseif ($aColumns[$i] == 'amount') {
                        $row[] = formatMoney($aRow['amount'], 2, TRUE);
                    } else {
                        $row[] = $aRow[$aColumns[$i]];
                    }
                }
                if ($aRow['status'] == 'Fund') {
                    $row[] = '<a class="btn green" href="javascript:doRefund(\'' . encode_url($aRow['tran_id']) . '\')">Refund</a>';
                } else {
                    $row[] = '';
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
     * Give refund on behalf of payment
     * @return type
     */
    public function refund($id = NULL) {
        $this->load->model('agents');
        $post = $this->input->post();
        $return = array();

        if ($post && $id) {
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
            $id = decode_url($id);
            $transaction = $this->transaction_m->get_by(array('tran_id' => $id), TRUE);
            if ($transaction) {
                $tranId = $transaction->stripe_transaction_id;
                $agent = $this->agents->get($transaction->agent_id);
                $balance = $agent->balance;
                if ($transaction->status == 'Fund') {
                    $result = $this->stripe->charge_refund($tranId);
                    $data = json_decode($result);
                    if (isset($data->error)) {
                        $return['success'] = false;
                        $return['message'] = $data->error->message;
                        return $this->output
                                        ->set_content_type('application/json')
                                        ->set_output(json_encode($return));
                        exit;
                    }
                    switch ($data->status) {
                        case 'succeeded':
                            $price = (float) $data->amount_refunded / 100;
                            $balance = $balance - $price;
                            $this->agents->updateAgentBalance($agent->id, $price, 'sub');
                            $this->transaction_m->save(array('status' => 'Refund'), $id);
                            $return['success'] = true;
                            $return['message'] = toMoney($price) . " Amount refunded successfully.";
                            break;

                        default:
                            $return['success'] = false;
                            $return['message'] = "Transaction id not found.";
                            break;
                    }
                } else {
                    $return['success'] = false;
                    $return['message'] = "Transaction id not found.";
                }

                return $this->output
                                ->set_content_type('application/json')
                                ->set_output(json_encode($return));
            }


            exit;
        }
    }
    
    public function exporttransaction() {
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";
        $filename = "transaction.csv";
        $sql = "SELECT concat(a.fname, ' ', a.lname) as `Agent Name`, `name` as `Name`, `stripe_transaction_id` AS `TRANSACTION ID`, `date`, `amount`, `status`, `type` FROM `agent_billing_transactions` LEFT JOIN `agents` `a` ON `agent_billing_transactions`.`agent_id` = `a`.`id` LEFT JOIN `agencies` `age` ON `a`.`agency_id` = `age`.`id` ORDER BY `tran_id`";
        $result = $this->db->query($sql);
        $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
        force_download($filename, $data);
    }
}
