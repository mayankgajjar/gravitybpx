<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ltransfer extends CI_Controller{
    private $_template;
	public function __construct(){
		parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            if ($this->session->userdata("user")->group_name == 'Agent') {
                redirect('/Forbidden');
            }
        }
        $this->_template = strtolower ($this->session->userdata ( 'user' )->group_name);
        $this->data = array(
            "meta_title" => "Transfer Leads",
            "title" => "Transfer Leads",
            "breadcrumb" => "Transfer Leads",
            "formtitle" => "Transfer Leads",
            "listtitle" => "",
            "formactioncontroller" => "",
            "addactioncontroller" => "",
            "deleteactioncontroller" => "",
            "openparentsli" => "configuration",
            "activeparentsli" => "status_management",
            "deletetitle" => "Status",
            "datatablecontroller" => "statusmanagementcontroller/indexJson",
        );
        $this->load->library('vicidialdb');
        $this->load->model('vicidial/transfer', 'transfer');
        $this->load->model('vicidial/vusers_m', 'vusers_m');
        $this->load->model('vicidial/vstatuses', 'vstatuses');
	}

	public function index(){
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert']= TRUE;
        $this->data['listtitle'] = 'Transfer Leads';
        $this->data['title'] = 'Transfer Leads';
        $this->template->load($this->_template,"dialer/admin/transfer/list",$this->data);
	}

	public function indexjson(){
        $aColumns = array('id' ,'lead_id' , 'dispo_choice', 'agent', 'agency', 'created');
        /*
         * Paging
         */
        $sLimit = "";
        if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ){
            $sLimit = " LIMIT ". $_GET['iDisplayStart'].", ".$_GET['iDisplayLength'];
        }
        /*
         * Ordering
         */
        if ( isset( $_GET['iSortCol_0'] ) ){
            $sOrder = "ORDER BY  ";
                for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ){
                    if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ){
                        $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
                                        ".$_GET['sSortDir_'.$i] .", ";
                    }
                }

                $sOrder = substr_replace( $sOrder, "", -2 );
                if ( $sOrder == "ORDER BY" ){
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
        if ( $_GET['sSearch'] != "" ){
            $sWhere .= " WHERE (";
            for ( $i=0 ; $i<count($aColumns) ; $i++ ){
                if($aColumns[$i] != 'agency'){
                    $sWhere .= $aColumns[$i]." LIKE '%". $_GET['sSearch']."%' OR ";
                }
            }
            $sWhere = substr_replace( $sWhere, "", -3 );
            $sWhere .= ') ';
        }


        $rResult = $this->transfer->query($sWhere, $sOrder, $sLimit);

        $aFilterResult = $this->transfer->query($sWhere);
        if($aFilterResult){
            $iFilteredTotal = count($aFilterResult);
        }else{
            $iFilteredTotal = 0;
        }
        $iTotal = count($this->transfer->get());

        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array()
        );


        $segement = $_GET['iDisplayStart'];
        $count = 1;

        if($segement):
             $count = $_GET['iDisplayStart'] + 1;
        endif;
        if($rResult){
            foreach( $rResult as $aRow ){
                $row = array();
                //$row[] = $count++;
                $user = $this->vusers_m->get_by(array('user' => $aRow['agent']), TRUE);
                $agent = false;
                if($user){
        			$id = $user->user_id;
        			$stmt = "SELECT id, fname, lname, agency_id, vicidial_user_id FROM agents WHERE vicidial_user_id={$id}";
        			$agent = $this->db->query($stmt)->row();
                }
                for ( $i=0 ; $i<count($aColumns) ; $i++ ){
                	if($aColumns[$i] == 'id'){
		                $row[] = $count++;
                	}else if($aColumns[$i] == 'lead_id'){
                        if($this->_template == 'agency'){
                          $row[] = '<a class="btn" target="_blank" href="'.site_url('dialer/alists/addlead/'.encode_url($aRow[$aColumns[$i]])).'">'.$aRow[ $aColumns[$i] ].'</a>';
                        }else{
                		  $row[] = '<a class="btn" target="_blank" href="'.site_url('dialer/lists/addlead/'.encode_url($aRow[$aColumns[$i]])).'">'.$aRow[ $aColumns[$i] ].'</a>';
                        }
                	}else if($aColumns[$i] == 'dispo_choice'){
                		$status = $this->vstatuses->get_by(array('status' => $aRow['dispo_choice']),TRUE);
                		if($status)
                			$row[] =  $status->status.' - '.$status->status_name;
                	}else if($aColumns[$i] == 'agent'){
                		if($agent){
        					$row[] = '<a class="btn" target="_blank" href="'.site_url($this->_template.'/manage_agent/agent_info/'.$agent->id).'">'.$agent->fname.' '.$agent->lname.'---'.$aRow['agent'].'</a>';
                		}else{
                			$row[] = $aRow['agent'];
                		}
                	}else if($aColumns[$i] == 'agency'){
            			if($agent){
            				$agencyId = $agent->agency_id;
            				$stmt = "SELECT id,name FROM agencies WHERE id={$agencyId}";
            				$agency = $this->db->query($stmt)->row();
            				if($agency){
            					$row[] = '<a class="btn" target="_blank" href="'.site_url($this->_template.'/manage_agency/agency_info/'.$agency->id).'">'.$agency->name.'</a>';
            				}else{
            					$row[] = '';
            				}
                		}else{
                			$row[] = '';
                		}
            		}else{
                    	$row[] = $aRow[ $aColumns[$i] ];
                    }
                }
                $output['aaData'][] = $row;
		    }
        }else{
            $output['aaData'] =  array();
        }
        return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($output));
	}
}