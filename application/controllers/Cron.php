<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->input->is_cli_request()) {
            echo "This script can only be accessed via the command line" . PHP_EOL;
            exit;
        }
        $this->load->model('autofund_m');
        $this->load->model('card_m');
        $this->load->model('transaction_m');
        $this->load->model('agents');
        // Sets the server not to have a time out.
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        // Expand the array displays
        ini_set('xdebug.var_display_max_depth', 5);
        ini_set('xdebug.var_display_max_children', 256);
        ini_set('xdebug.var_display_max_data', 1024);
    }

    public function index($arg) {
        $this->autofundcron($arg);
    }

    private function autofundcron($validate = NULL) {
        if ($validate && $validate == 'CLICRON') {
            $autofunds = $this->autofund_m->get();
            if ($autofunds) {
                /* ----------- For check Stripe test mode or live mode ------ */
                $stripe_data = unserialize(get_option('stripe_setting'));

                if (isset($stripe_data) && $stripe_data['stripe_mode'] == 'test') {
                    $config['stripe_key_test_public'] = $stripe_data['stripe_key_test_public'];
                    $config['stripe_key_test_secret'] = $stripe_data['stripe_key_test_secret'];
                    $config['stripe_test_mode'] = TRUE;
                } else {
                    $config['stripe_key_live_public'] = $stripe_data['stripe_key_live_public'];
                    $config['stripe_key_live_secret'] = $stripe_data['stripe_key_live_secret'];
                    $config['stripe_test_mode'] = FALSE;
                }
                /* ----------- End For check Stripe test mode or live mode ------ */

                $config['stripe_verify_ssl'] = FALSE;
                $this->load->library('stripe', $config);
                foreach ($autofunds as $key => $autofund) {
                    if ($autofund->is_active == 'YES') {
                        $agent = $this->agents->get($autofund->agent_id, TRUE);
                        $cards = $this->card_m->get_by(array('agent_id' => $agent->id));
                        $card = $cards[0];
                        $cardId = $card->stripe_card_id;
                        $addPrice = intval($autofund->add_price);
                        $condition = intval($autofund->condition_name);
                        if (intval($agent->balance) < $condition) {
                            $return = array();
                            $dollar = $addPrice;
                            $amt = $dollar;
                            $amount = (float) $dollar * 100;

                            $cardData = array(
                                'customer_id' => $agent->stripe_client_id,
                                'card_id' => $cardId
                            );
                            $result = $this->stripe->charge_card($amount, $cardData, 'Payment');
                            $resultJson = json_decode($result);
                            if (isset($resultJson->id) && strlen($resultJson->id) > 0) {
                                $tranId = $resultJson->id;
                                $data = array(
                                    'agent_id' => $agent->id,
                                    'date' => date('Y-m-d H:i:s', $resultJson->created),
                                    'type' => 'Auto',
                                    'amount' => $amt,
                                    'stripe_transaction_id' => $tranId,
                                    'card_id' => $card->card_id,
                                    'status' => 'Fund'
                                );
                                $id = $this->transaction_m->save($data, NULL);
                                $this->agents->updateAgentBalance($agent->id, $amt);
                                $return = array('success' => true, 'message' => 'Fund added successfully.');
                            } else {
                                $return = array('success' => true, 'message' => 'Something goes wrong.');
                            }
                            return $this->output
                                            ->set_content_type('application/json')
                                            ->set_output(json_encode($return));
                            // exit;
                        } //if( intval($company->balance) < $condition  )
                    } //if($autofund->status == ACTIVE)
                } //foreach ($autofunds as $key => $autofund)
            }
        } else {
            echo 'Not Allowed';
        }
    }

    /**
     * @uses For Lead Transfer process FROM Raw Lead Master TO Lead Store Master.
     * @param string $tokan
     */
    public function leadTransfer($tokan = null) {
        if ($tokan && $tokan == 'transfer') {
            $this->load->model('rawlead_m');
            $this->load->model('templeadconvert_m');
            $this->load->model('leadstore_m');
            $this->load->model('leadfieldval_m');
            $this->load->model('leadfield_m');
            $option = array('conditions' => array('status' => 'false'), 'LIMIT' => array('start' => '1', 'end' => '0'), 'ORDER_BY' => array('field' => 'created', 'order' => 'ASC'));
            $data = $this->templeadconvert_m->get_relation('', $option);
            $data = $data[0];
            $agentDetails = unserialize($data['agent_details']);
            $value = (object) $data;
            if ($value->status == "false") {
                $whereProcess = array('status' => 'process');
                $this->templeadconvert_m->save($whereProcess, $value->id);
                // Fetch ID from Temp TABLE
                $rawData = array();
                $this->db->trans_begin();
                if ($value->lead_ids != "") {
                    $leadArray = explode(',', $value->lead_ids);
                    // Fetch data from Raw Leads Table Based on Temp Table IDs
                    foreach ($leadArray as $key => $lead) {
                        $rawData = $this->rawlead_m->get_by(['id' => $lead], TRUE);
                        if ($rawData != '') {
                            //Gender
                            if ($rawData->gender == 'male') {
                                $gender = "M";
                            } else if ($rawData->gender == 'female') {
                                $gender = "F";
                            } else {
                                $gender = "U";
                            }
                            /**
                             * Main Table Lead Store Array
                             */
                            $leadData['raw_lead_id'] = $rawData->id;
                            $leadData['order_item_id'] = $value->order_item_id;
                            $leadData['lead_category'] = $rawData->lead_category;
                            $leadData['member_id'] = getIncrementMemberId();
                            $leadData['user'] = $value->agent_id;
                            $leadData['first_name'] = $rawData->first_name;
                            $leadData['last_name'] = $rawData->last_name;
                            $leadData['gender'] = $gender;
                            $leadData['height'] = $rawData->height;
                            $leadData['weight'] = $rawData->weight;
                            $leadData['status'] = 'Lead';
                            $leadData['address'] = $rawData->last_name;
                            $leadData['state'] = $rawData->state;
                            $leadData['city'] = $rawData->city;
                            $leadData['source'] = $rawData->source_url;
                            $leadData['phone'] = $rawData->phone;
                            $leadData['work_phone'] = $rawData->alt_phone;
                            $leadData['email'] = $rawData->email;
                            //$leadData['security_number'] = $rawData->ssn;
                            $leadData['date_of_birth'] = $rawData->date_of_birth;
                            $leadData['agency_id'] = $agentDetails['agency_id'];
                            $leadData['postal_code'] = $rawData->zip;
                            $leadData['owner'] = $agentDetails['email'];
                            //- For Extra Fields
                            $leadData['ip_address'] = $rawData->ip_address;
                            $leadData['best_time_to_call'] = $rawData->best_time_to_call;
                            $leadData['existing_condition'] = $rawData->existing_condition;
                            $leadData['expectant_parent'] = $rawData->expectant_parent;
                            $leadData['current_coverage'] = $rawData->current_coverage;
                            $leadData['opt_in'] = $rawData->opt_in;
                            $leadData['driver_status'] = $rawData->driver_status;
                            $leadData['own_rent'] = $rawData->own_rent;
                            $leadData['military'] = $rawData->military;
                            $leadData['us_citizen'] = $rawData->us_citizen;
                            $leadData['income_type'] = $rawData->income_type;
                            $leadData['net_monthly_income'] = $rawData->net_monthly_income;
                            $leadData['opt_in_2'] = $rawData->opt_in_2;
                            $this->leadstore_m->save($leadData);
                            updateIncrementMemberId();
                        }
                    }
                }
                // TEMP STATUS CHANGE IF DATA IS INSERTED
                $this->templeadconvert_m->save(['status' => 'true'], $value->id);
                if ($this->db->trans_status() === FALSE) {
                    // FAIL Mail For Lead Transfer
                    $this->db->trans_rollback();
                    $whereFalse = array('status' => 'false');
                    $this->templeadconvert_m->save($whereFalse, $value->id);
//                    echo 'ROLL BACK';
                } else {
                    $this->db->trans_commit();
                    $whereTrue = array('status' => 'true');
                    $this->templeadconvert_m->save($whereTrue, $value->id);
//                    echo 'Commit';
                    // Success Mail For Lead Transfer
                }
            } /* else {
              echo 'No New Requests';
              } */
        } else {
            echo 'Not Allowed';
        }
    }

}
