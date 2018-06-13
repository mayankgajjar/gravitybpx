<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Calendar extends CI_Controller{

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
           if ($this->session->userdata("user")->group_name != 'Agent') {
                redirect('/Forbidden');
            }
        }
        $this->load->model('Calendar_m');
    }

    public function index(){
        $this->data['calendar'] = TRUE;
        $this->data['validation'] = TRUE;
        $this->data['colorpicker'] = TRUE;
        $this->data['daterangepicker'] = TRUE;
        $this->data['title'] = 'Agent | Calendar';
        $relation = array(
                    'conditions' => "user_id = ".$this->session->userdata('agent')->id,
                    'ORDER_BY' => array(
                            'field' => 'created',
                            'order' => 'desc',
                        ),
                    );
        $this->data['event_data'] = $this->Calendar_m->get_relation('',$relation);
        $this->template->load('agent','calendar/index', $this->data);
    }

    public function add_event(){
        $this->form_validation->set_rules($this->Calendar_m->rules);
        if($this->form_validation->run() == TRUE){
             $data = $this->Calendar_m->array_from_post(array(
                'event_start_date','event_end_date' ,'event_start_time','event_end_time', 'event_color','event_desc'
            ));
             $data['event_start_date'] =  date("Y-m-d", strtotime($data['event_start_date']));
             $data['event_end_date'] =  date("Y-m-d", strtotime($data['event_end_date']));
             $data['user_id'] = $this->session->userdata('agent')->id;
             $event_id = $this->Calendar_m->save($data,$id);
             if($event_id){
                /* ---------- For User Log ------- */
                $from_id = $this->session->userdata("user")->id;
                $to_id = $this->session->userdata("user")->id;
                $feed_type = 0; // Activity Feed
                $log_type = strtolower('calendar');
                $title= "New Event Created";
                $log_url = 'calendar/index';
                user_log($from_id,$to_id,$feed_type,$log_type,$title,$log_url);
                /* ---------- End For User Log ------- */
                
                $relation = array(
                    'conditions' => "user_id = ".$this->session->userdata('agent')->id,
                    'ORDER_BY' => array(
                            'field' => 'created',
                            'order' => 'desc',
                        ),
                    );
                $this->data['event_data'] = $this->Calendar_m->get_relation('',$relation);
                $res = $this->load->view('agent/calendar/list_event', $this->data,true);
                $out['success'] = TRUE;
                $out['sider'] = $res;
                $out['json'] = $this->data['event_data'];
                echo json_encode($out);
             }else{
                $out['success'] = FALSE;
                echo json_encode($out);
             }
        }
        // redirect('calendar');
    }

    public function delete_event($event_id){
        $event_id = decode_url($event_id);
        $res = $this->Calendar_m->delete($event_id);
        // redirect('calendar');
        $relation = array(
                    'conditions' => "user_id = ".$this->session->userdata('agent')->id,
                    'ORDER_BY' => array(
                            'field' => 'created',
                            'order' => 'desc',
                        ),
                    );
        $this->data['event_data'] = $this->Calendar_m->get_relation('',$relation);
        $res = $this->load->view('agent/calendar/list_event', $this->data,true);
        $out['sider'] = $res;
        $out['json'] = $this->data['event_data'];
        echo json_encode($out);
    }
}
