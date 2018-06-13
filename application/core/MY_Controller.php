<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('common_model', '', TRUE);
        $this->load->helper('common');
        check_isvalidated();

        $this->filterSuffix = "";
        $this->perpageSuffix = "";

        if ($this->input->get('keyword'))
            $this->filterSuffix = "&keyword=" . $this->input->get('keyword');
        if ($this->input->get('perpage'))
            $this->perpageSuffix = "?perpage=" . $this->input->get('perpage');

        $this->suffix = $this->perpageSuffix . $this->filterSuffix;
    }

    /**
     * Delete User by Id
     * @param type $id
     */
    public function deleteRecord($id, $table, $label) {
        if ($id != NULL) {
            $this->common_model->delete($id, $table);
            $this->session->set_flashdata('success', "$label has been deleted successfully");
            redirect($this->agent->referrer());
        } else {
            $this->load->view('error404');
        }
    }

    /**
     *  Delete Multiple 
     */
    public function deleteAll($table) {
        $ids = $this->input->post('ids');
        $this->common_model->deleteAll($ids, 'id', $table);
    }

}
