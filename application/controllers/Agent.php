<?php

/**
 * Description of Agent
 *
 * @author Meet
 */
class Agent extends CI_Controller {

    public $data = array();

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            if ($this->session->userdata("user")->group_name != 'Agent') {
                redirect('/Forbidden');
            }
        }
    }

    public function index($param = '') {
        $this->data['dashabord'] = true;
        $this->data['counterup'] = true;
        $this->data['amcharts'] = true;
        $this->load->model('leadstore_m');
        $this->load->model('Customer_model');
        $this->load->model('Notifications_model');
        $this->load->model('Calendar_m');
        $this->load->model('Userlog_m');
        $agentId = $this->session->userdata('agent')->id;
        // For now display agent page
        $this->data['title'] = 'Agent | Dashboard';
        // $this->data['customers_submitted'] = $this->Customer_model->getAllSubmittedCustomers();
        // $this->data['customers_verified'] = $this->Customer_model->getAllVerifiedCustomers();
        // $this->data['customers_unverified'] = $this->Customer_model->getAllUnVerifiedCustomers();
        //$this->data['customers_count'] = $this->Customer_model->countAllCustomers();
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

        /* total assigned leads Filter wise */
        $relation = array(
            'fields' => "count(*) As total",
            'conditions' => $filter_data . "user = {$agentId} AND STATUS LIKE 'Lead' AND lead_status = 1"
        );
        $data = $this->leadstore_m->get_relation('', $relation);
        $this->data['totalAssignedLeads'] = $data['0']['total'];

        /* total assigned leads overall */
        $relation = array(
            'fields' => "count(*) As total",
            'conditions' => "user = {$agentId} AND STATUS LIKE 'Lead' AND lead_status = 1"
        );
        $data1 = $this->leadstore_m->get_relation('', $relation);
        $this->data['totalLeads'] = $data1['0']['total'];

        /* total premiums Filter wise */
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
        $this->data['totalAssignedPremium'] = $data['0']['total_premium'];

        /* total premiums Overall */
        $relation = array(
            'fields' => "sum(premium) As total_premium",
            'JOIN' => array(
                array(
                    'table' => 'lead_products',
                    'condition' => 'lead_products.lead_id = lead_store_mst.lead_id',
                    'type' => 'LEFT'
                ),
            ),
            'conditions' => "user = {$agentId} AND lead_status = 1"
        );
        $data = $this->leadstore_m->get_relation('', $relation);
        $this->data['totalPremium'] = $data['0']['total_premium'];

        /** Google Map * */
        $this->load->library('googlemaps');
        $marker = array();
        $relation_cleint = array(
            'fields' => 'lead_store_mst.*',
            'conditions' => $filter_data . "user = {$agentId} AND lead_store_mst.status LIKE 'Client' AND dispo IN('SALE MADE','NEW') AND lead_status = 1",
            'ORDER_BY' => array(
                'field' => 'created',
                'order' => 'DESC'
            )
        );

        $activeClients = $this->leadstore_m->get_relation('', $relation_cleint);
        if ($activeClients) {
            foreach ($activeClients as $client) {
                $address = '';
                if (strlen(trim($client['address'])) > 0) {
                    $address .= $client['address'];
                }
                if (strlen(trim($client['address1'])) > 0) {
                    $address .= ', ' . $client['address1'];
                }
                if (strlen(trim($client['city'])) > 0) {
                    $address .= ', ' . $client['city'];
                }
                if (strlen(trim($client['state'])) > 0) {
                    $address .= ', ' . $client['state'];
                }
                if (strlen(trim($client['postal_code'])) > 0) {
                    $address .= ', ' . $client['postal_code'];
                }
                if (strlen(trim($address)) > 0) {
                    $points = $this->googlemaps->get_lat_long_from_address($address);
                    $marker['position'] = $points[0] . ',' . $points[1];
                    $marker['animation'] = 'DROP';
                    $str = '<div class="info-window"><span class="ifo-name">' . $client['first_name'] . ' ' . $client['last_name'] . '</span><br /><span class="info-add"><i class="fa fa-map-marker"></i>&nbsp;&nbsp;' . $address . '</span><br /><span class="info-phone"><i class="fa fa-phone"></i>&nbsp;&nbsp;' . $client['phone'] . '</span></div>';
                    $marker['infowindow_content'] = $str;
                    $this->googlemaps->add_marker($marker);
                }
            }
        }
        $config['center'] = '37.090240, -95.712891';
        $config['zoom'] = '4';
        $this->googlemaps->initialize($config);
        $this->data['map'] = $this->googlemaps->create_map();
        /* -------- For Sales Chart ------------ */
        $premium_data = [];
        if ($duration == 'Today') {
            /* ------ For Today Graph ---------------------- */
            $date = date("Y-m-d");
            for ($i = 0; $i < 24; $i++) {
                $filter = "date(lead_store_mst.created) = '" . $date . "' AND HOUR(lead_store_mst.created) = " . $i . " AND ";
                $relation = array(
                    'fields' => "sum(premium) As total_premium",
                    'JOIN' => array(
                        array(
                            'table' => 'lead_products',
                            'condition' => 'lead_store_mst.lead_id = lead_products.lead_id',
                            'type' => 'LEFT'
                        ),
                    ),
                    'conditions' => $filter . "user = {$agentId} AND lead_status = 1",
                );
                $data = $this->leadstore_m->get_relation('', $relation);
                if ($i == 0) {
                    $premium_data[$i]['today_timely'] = "12 AM";
                } elseif ($i >= 1 && $i <= 11) {
                    $premium_data[$i]['today_timely'] = $i . " AM";
                } elseif ($i == 12) {
                    $premium_data[$i]['today_timely'] = $i . " PM";
                } elseif ($i >= 13 && $i <= 23) {
                    $premium_data[$i]['today_timely'] = ($i - 12) . " PM";
                }
                $premium_data[$i]['daily_premium'] = isset($data[0]['total_premium']) ? $data[0]['total_premium'] : '0';
            }
            /* ------ End For Today Graph ------------------ */
        } elseif ($duration == 'Week') {
            /* ------ For Weekly Graph -------------- */
            $monday = strtotime("last monday");
            $monday = date('w', $monday) == date('w') ? $monday + 7 * 86400 : $monday;

            for ($i = 0; $i <= 6; $i++) {
                $day = strtotime(date("Y-m-d", $monday) . " +" . $i . " days");
                $date = date("Y-m-d", $day);
                $days = date('D', strtotime($date));
                $filter = "date(lead_store_mst.created) = '" . $date . "' AND ";
                $relation = array(
                    'fields' => "sum(premium) As total_premium",
                    'JOIN' => array(
                        array(
                            'table' => 'lead_products',
                            'condition' => 'lead_store_mst.lead_id = lead_products.lead_id',
                            'type' => 'LEFT'
                        ),
                    ),
                    'conditions' => $filter . "user = {$agentId} AND lead_status = 1",
                );
                $data = $this->leadstore_m->get_relation('', $relation);
                $premium_data[$i]['week_day'] = $days;
                $premium_data[$i]['daily_premium'] = isset($data[0]['total_premium']) ? $data[0]['total_premium'] : '0';
            }
            /* ------ End For Weekly Graph ---------- */
        } elseif ($duration == 'Month') {
            /* ------ For Monthly Graph ------------------ */
            $curYear = date("Y");
            $curMonth = date("m");
            $total_days = cal_days_in_month(CAL_GREGORIAN, $curMonth, $curYear);
            for ($i = 0; $i < $total_days; $i++) {
                $date = date($curYear . "-" . $curMonth . "-" . ($i + 1));
                $filter = "date(lead_store_mst.created) = '" . $date . "' AND ";
                $relation = array(
                    'fields' => "sum(premium) As total_premium",
                    'JOIN' => array(
                        array(
                            'table' => 'lead_products',
                            'condition' => 'lead_store_mst.lead_id = lead_products.lead_id',
                            'type' => 'LEFT'
                        ),
                    ),
                    'conditions' => $filter . "user = {$agentId} AND lead_status = 1",
                );
                $data = $this->leadstore_m->get_relation('', $relation);
                $premium_data[$i]['month_day'] = $i + 1;
                $premium_data[$i]['daily_premium'] = isset($data[0]['total_premium']) ? $data[0]['total_premium'] : '0';
            }
            /* ------ End For Monthly Graph -------------- */
        } elseif ($duration == 'Quarter') {
            /* ------ For Quarterly Graph ---------------------- */
            $quarter_arr = array(
                '1' => array('1', '2', '3'),
                '2' => array('4', '5', '6'),
                '3' => array('7', '8', '9'),
                '4' => array('10', '11', '12'),
            );
            $curYear = date("Y");
            $curMonth = date("m");
            $curQuarter = ceil($curMonth / 3);
            $qu_arr = $quarter_arr[$curQuarter];
            for ($i = 0; $i < 3; $i++) {

                $filter = "MONTH(lead_store_mst.created) = '" . $qu_arr[$i] . "' AND YEAR(lead_store_mst.created) = " . $curYear . " AND ";
                $relation = array(
                    'fields' => "sum(premium) As total_premium",
                    'JOIN' => array(
                        array(
                            'table' => 'lead_products',
                            'condition' => 'lead_store_mst.lead_id = lead_products.lead_id',
                            'type' => 'LEFT'
                        ),
                    ),
                    'conditions' => $filter . "user = {$agentId} AND lead_status = 1",
                );
                $data = $this->leadstore_m->get_relation('', $relation);
                $monthName = date("M", mktime(0, 0, 0, $qu_arr[$i], 10));
                $premium_data[$i]['quarter_day'] = $monthName;
                $premium_data[$i]['daily_premium'] = isset($data[0]['total_premium']) ? $data[0]['total_premium'] : '0';
            }
            /* ------ End For Quarterly Graph ------------------ */
        } elseif ($duration == 'Year') {
            /* ------ For Yearly Graph ---------------------- */
            $curYear = date("Y");
            for ($i = 0; $i < 12; $i++) {

                $filter = "MONTH(lead_store_mst.created) = '" . ($i + 1) . "' AND YEAR(lead_store_mst.created) = " . $curYear . " AND ";
                $relation = array(
                    'fields' => "sum(premium) As total_premium",
                    'JOIN' => array(
                        array(
                            'table' => 'lead_products',
                            'condition' => 'lead_store_mst.lead_id = lead_products.lead_id',
                            'type' => 'LEFT'
                        ),
                    ),
                    'conditions' => $filter . "user = {$agentId} AND lead_status = 1",
                );
                $data = $this->leadstore_m->get_relation('', $relation);
                $monthName = date("M", mktime(0, 0, 0, ($i + 1), 10));
                $premium_data[$i]['yearly_month'] = $monthName;
                $premium_data[$i]['daily_premium'] = isset($data[0]['total_premium']) ? $data[0]['total_premium'] : '0';
            }
            /* ------ End For Yearly Graph ------------------ */
        } else {
            /* ------ For Last 5 year Graph ---------------------- */
            $curYear = date("Y");
            $lastYear = $curYear - 4;
            for ($i = 0; $i < 5; $i++) {

                $filter = "YEAR(lead_store_mst.created) = '" . ($lastYear + $i) . "' AND ";
                $relation = array(
                    'fields' => "sum(premium) As total_premium",
                    'JOIN' => array(
                        array(
                            'table' => 'lead_products',
                            'condition' => 'lead_store_mst.lead_id = lead_products.lead_id',
                            'type' => 'LEFT'
                        ),
                    ),
                    'conditions' => $filter . "user = {$agentId} AND lead_status = 1",
                );
                $data = $this->leadstore_m->get_relation('', $relation);
                $premium_data[$i]['yearly'] = $lastYear + $i;
                $premium_data[$i]['daily_premium'] = isset($data[0]['total_premium']) ? $data[0]['total_premium'] : '0';
            }
            /* ------ End For Last 5 year Graph ---------------------- */
        }

        $this->data['premium_data'] = $premium_data;
        /* -------- End For Sales Chart ------------ */

        /* --------------- For Calendar Data --------------------- */
        $relation = array(
            'conditions' => "user_id = " . $this->session->userdata('agent')->id,
            'ORDER_BY' => array(
                'field' => 'created',
                'order' => 'desc',
            ),
        );
        $this->data['event_data'] = $this->Calendar_m->get_relation('', $relation);
        /* --------------- End For Calendar Data --------------------- */

        /* --------------- For Feed Data ------------------------- */
        $relation = array(
            'conditions' => "to_id = " . $this->session->userdata("user")->id ." and feed_type = 0",
            'ORDER_BY' => array(
                'field' => 'created',
                'order' => 'desc',
            ),
        );
        $this->data['activity_feed_data'] = $this->Userlog_m->get_relation('', $relation);

        $relation = array(
            'conditions' => "to_id = " . $this->session->userdata("user")->id ." and feed_type = 1",
            'ORDER_BY' => array(
                'field' => 'created',
                'order' => 'desc',
            ),
        );
        $this->data['system_feed_data'] = $this->Userlog_m->get_relation('', $relation);
        /* --------------- End For Feed Data --------------------- */


        $this->template->load("agent", "profile_overview", $this->data);
    }

    /*
     * profile is used to manage profile of agent
     */

    public function profile($operation = 'view') {
        $this->load->model('Agent_model');
        $this->data['flag'] = false;
        if ($operation == 'personal') {
            if ($this->input->post()) {
                $this->form_validation->set_rules('fname', 'First Name', 'required');
                $this->form_validation->set_rules('lname', 'Last Name', 'required');
                $this->form_validation->set_rules('phone', 'Password Confirmation', 'required');
                $this->form_validation->set_rules('dob', 'Date of Birth', 'required');
                $this->form_validation->set_rules('address1', 'Address', 'required');
                $this->form_validation->set_rules('city', 'City', 'required');
                $this->form_validation->set_rules('zip', 'Zip Code', 'required');
                if ($this->form_validation->run()) {
                    $this->load->model('Agent_model');
                    $agent['fname'] = $this->input->post('fname');
                    $agent['mname'] = $this->input->post('mname');
                    $agent['lname'] = $this->input->post('lname');
                    $agent['date_of_birth'] = date("Y-m-d", strtotime($this->input->post('dob')));
                    $agent['phone_number'] = $this->input->post('phone');
                   // $agent['plivo_phone'] = $this->input->post('plivo_phone');
                    $agent['fax_number'] = $this->input->post('fax');
                    $agent['address_line_1'] = $this->input->post('address1');
                    $agent['address_line_2'] = $this->input->post('address2');
                    $agent['city_id'] = $this->input->post('city');
                    $agent['zip_code'] = $this->input->post('zip');
                    $res=$this->Agent_model->update($this->session->userdata('agent')->id, $agent);
                    if($res){
                        /* ---------- For User Log ------- */
                        $from_id = $this->session->userdata("user")->id;
                        $to_id = $this->session->userdata("user")->id;
                        $feed_type = 1;
                        $log_type = "profile";
                        $title= "Your Profile Updated";
                        $log_url = 'agent/profile';
                        user_log($from_id,$to_id,$feed_type,$log_type,$title,$log_url);
                        /* ---------- End For User Log ------- */
                    }
                    $this->session->set_flashdata('msg', 'Profile is successfully updated.');
                    redirect('Agent/profile');
                } else {
                    $this->data['flag'] = true;
                }
            }
        } else if ($operation == 'license') {
            if ($this->input->post()) {
                $this->form_validation->set_rules('npn', 'National Producer Number', 'required');
                $this->form_validation->set_rules('license_number', 'Resident License Number', 'required');
                $this->form_validation->set_rules('resident_state', 'Resident License State', 'required');
                if ($this->form_validation->run()) {
                    $this->load->model('Agent_model');
                    $agent_id = $this->session->userdata('agent')->id;
                    $agent['national_producer_number'] = $this->input->post('npn');
                    $agent['resident_license_number'] = $this->input->post('license_number');
                    $agent['resident_license_state_id'] = $this->input->post('resident_state');
                    $this->Agent_model->update($agent_id, $agent);

                    $states = array();
                    if (count($this->input->post('nonresident_license_state')) > 0) {
                        foreach ($this->input->post('nonresident_license_state') as $value) {
                            $state['agent_id'] = $agent_id;
                            $state['state_id'] = $value;
                            $states[] = $state;
                        }
                    }
                    $this->Agent_model->update_agent_state($agent_id, $states);

                    $this->session->set_flashdata('msg', 'Profile is successfully updated.');
                    redirect('Agent/profile');
                } else {
                    $this->data['flag'] = true;
                }
            }
        } else if ($operation == "upload") {
            $config['upload_path'] = 'uploads/agents';
            $config['allowed_types'] = 'gif|jpg|png';
            // $config['max_size']	= '100';
            // $config['max_width']  = '1024';
            // $config['max_height']  = '768';
            $this->upload->initialize($config);
            if ($this->upload->do_upload('image')) {
                $data = $this->upload->data();
                $agent['profile_image'] = $data['file_name'];
                $this->Agent_model->update($this->session->userdata('agent')->id, $agent);
                $this->load->model('User_model');
                $this->session->set_userdata('agent', $this->User_model->getAgentFromUser_id($this->session->userdata('user')->id));
                $this->session->set_userdata('msg', 'Profile Image Updated');
            } else {
                $this->session->set_userdata('msg', 'Profile Image not Updated. Please try again');
            }
            redirect('Agent/profile');
        } else if ($operation == 'change') {
            $old = base64_encode($this->input->post('old'));
            $new = base64_encode($this->input->post('new'));
            $this->load->model('User_model');
            if ($this->User_model->chkUser($this->session->userdata('user')->email_id, $old)) {
                if ($old == $new) {
                    echo '2';
                } else {
                    $this->User_model->changePassword($this->session->userdata('user')->id, $new);
                    echo '1';
                }
            } else {
                echo '0';
            }
            return;
        }
        $this->load->model('Country_model');
        $this->load->model('State_model');
        $this->load->model('City_model');
        $this->data['title'] = 'Agent | Profile';
        $this->data['country'] = $this->Country_model->getAll();
        $this->data['state'] = $this->State_model->getStateByCountryId($this->session->userdata('agent')->cid);
        $this->data['city'] = $this->City_model->getCityByStateId($this->session->userdata('agent')->sid);
        $this->data['agent'] = $this->Agent_model->getAgentInfo($this->session->userdata('agent')->id);
        $s = array();
        foreach ($this->data['agent']->non_resident_state as $state) {
            $s[] = $state['state_id'];
        }
        $this->data['agent']->non_resident_state = $s;
        $this->data['allState'] = $this->State_model->getAll();
        $this->template->load("agent", "profile", $this->data);
    }

    /*
     * manage_country is used to perform all functionality related to country
     *
     * @param $operation string specify what type of operation is performed on country table
     * @param $id int specify unique id of country
     *
     * return
     *      If $operation == 'getAll'
     *          return array[][] All country in the form of two dimensional array
     */

    public function manage_country($operation = "", $id = "") {
        $this->load->model('Country_model');
        if ($operation == "getAll") {
            return $this->Country_model->getAll();
        }
    }

    /*
     * manage_state is used to perform all functionality related to state
     *
     * @param $operation string specify what type of operation is performed on state table
     * @param $id int specify unique id of state
     *
     * return
     *      If $operation == 'getAll'
     *          return array[][] All state in the form of two dimensional array
     *      Else if $operation == 'getByCountryId'
     *          return string of state for specific country in option tag
     */

    public function manage_state($operation = "", $id = "") {
        $this->load->model('State_model');
        if ($operation == "getAll") {
            return $this->State_model->getAll();
        } else if ($operation == "getByCountryId") {
            $str = "<option value=''>Select State</option>";
            foreach ($this->State_model->getStateByCountryId($id) as $value) {
                $str .= "<option value='" . $value['id'] . "'>" . $value['name'] . "</option>";
            }
            echo $str;
            return;
        }
    }

    /*
     * manage_city is used to perform all functionality related to city
     *
     * @param $operation string specify what type of operation is performed on city table
     * @param $id int specify unique id of city
     *
     * return
     *      If $operation == 'getAll'
     *          return array[][] All city in the form of two dimensional array
     *      Else if $operation == 'getByStateId'
     *          return string of state for specific city in option tag
     */

    public function manage_city($operation = "", $id = "") {
        $this->load->model('City_model');
        if ($operation == "getAll") {
            return $this->City_model->getAll();
        } else if ($operation == "getByStateId") {
            $str = "";
            foreach ($this->City_model->getCityByStateId($id) as $value) {
                $str .= "<option value='" . $value['id'] . "'>" . $value['name'] . "</option>";
            }
            echo $str;
            return;
        }
    }

//    public function check_notification() {
//        $curdate = date("Y-m-d");
//        $curtime = date("H:i");
//        $this->db->where('event_start_date', $curdate);
//        $this->db->where('event_start_time', $curtime);
//        $query = $this->db->get('calendar');
//        $result = $query->result_array();
//        echo json_encode($result);
//    }
//
//    public function check_task_notification() {
//        $curdate = date("Y-m-d");
//        $curtime = date("H:i");
//        $this->db->where('task_date', $curdate);
//        $this->db->where('task_start_time', $curtime);
//        $this->db->where("(assign_agent_id = " . $this->session->userdata('agent')->id . " OR user_id = " . $this->session->userdata('agent')->user_id . ")", NULL, FALSE);
//        $query = $this->db->get('tasks');
//        $result = $query->result_array();
//        echo json_encode($result);
//    }

//    public function fetch_notification(){
//        $this->db->where('to_id', $this->session->userdata('user')->id);
//        $this->db->where("(log_type = 'calendar' OR log_type = 'voice_mail')");
//        $this->db->order_by('log_id','desc');
//        $query = $this->db->get('user_log');
//        $data['notifications'] = $query->result_array();
//        $res=$this->load->view('templates/agent_notification',$data,TRUE);
//        echo $res;
//    }
//
//    public function fetch_unread_notification_count(){
//        $this->db->where('to_id', $this->session->userdata('user')->id);
//        $this->db->where("(log_type = 'calendar' OR log_type = 'voice_mail')");
//        $this->db->where('status','0'); // 0  Means Unread message
//        $this->db->order_by('log_id','desc');
//        $query = $this->db->get('user_log');
//        $res = $query->num_rows();
//        echo $res;
//    }

    public function read_notification($notify_id){
//        $notify_id = decode_url($notify_id);
        //---------- For Update Log status (read) ----------
        $this->db->where('log_id', $notify_id);
        $this->db->where('to_id', $this->session->userdata('user')->id);
        $this->db->set('status','1');
        $res=$this->db->update('user_log');

        //------- For fetch redirect url from user log --------
        $this->db->where('log_id',$notify_id);
        $this->db->where('to_id', $this->session->userdata('user')->id);
        $query = $this->db->get('user_log');
        $log_data = $query->row_array();
        if(isset($log_data['log_url']) && $log_data['log_url'] != ''){
            redirect($log_data['log_url']);
        }else{
            redirect('agent');
        }
    }

}
