<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Description of Admin
 *
 * @author Meet
 */
class Category extends CI_Controller {

    public $data;

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            /* if($this->session->userdata("user")->group_name != 'Admin')
              {
              redirect('/Forbidden');
              } */
        }
    }

    public function index() {
        $this->data['title'] = 'Dashboard';
        $this->template->load("admin", "dashboard", $this->data);
    }

    /*
     * manage_company is used to perform all functionality related to company
     *
     * @param $operation string specify what type of operation is performed on comapny
     * @param $id int specify unique id of company
     *
     * return
     *      If $operation == 'add'
     *          If request is post
     *              Insert into company
     */

    public function manage_category($operation = "view", $id = "") {
        $this->load->model('Common_model');
        $this->load->model('Category_model');
        $table_name = "category";
        $limit = "";
        if ($operation == "add") {
             $this->data['validation'] = TRUE;
            if ($this->input->post()) {
                $post = $this->input->post();
                $this->form_validation->set_rules('category_name', 'Category Name', 'trim|required');
                $this->form_validation->set_rules('is_active', 'Status', 'trim|required');

                if ($this->form_validation->run() == TRUE) {
                    if ($this->input->post('id') == "") {
                        $categories = array(
                            'category_name' => $post['category_name'],
                            'is_active' => $post['is_active'],
                            'created_at' => date('Y-m-d H:i:s'),
                            'modified_at' => date('Y-m-d H:i:s')
                        );
                        $this->Common_model->add($categories, $table_name);
                        $this->session->set_flashdata('msg', 'Category is successfully inserted.');
                    } else {
                        $categories = array(
                            'category_name' => $post['category_name'],
                            'is_active' => $post['is_active'],
                            'modified_at' => date('Y-m-d H:i:s')
                        );
                        $this->Common_model->edit($post['id'], $categories, $table_name);
                        $this->session->set_flashdata('msg', 'Category is successfully updated.');
                    }
                }
                redirect('category/manage_category/view');
            } else {
                $this->data['title'] = 'Add Category';
                $this->template->load("admin", "category/add_category", $this->data);
            }
        } else if ($operation == 'delete') {
            if ($this->Common_model->delete($id, $table_name)) {
                $this->data['title'] = 'View Categories';
                $this->data['categories'] = $this->Common_model->viewAll($table_name, $limit);
                $this->session->set_flashdata('msg', 'Category is successfully deleted.');
                $this->template->load("admin", "category/view_category", $this->data);
            }
        } else if ($operation == 'multipledelete') {
            if ($this->input->post()) {
                /* echo '<pre>';
                  print_r($this->input->post());
                  echo '</pre>';
                  die; */
                if ($this->input->post('massaction') == "") {
                    $this->session->set_flashdata('error', 'Please select an action');
                } else if ($this->input->post('delete_ids') == "") {
                    $this->session->set_flashdata('error', 'No record selected');
                } else {
                    $ids = implode(",", $this->input->post('delete_ids'));
                    $this->Common_model->deleteMultiple($ids, $table_name);
                    $this->session->set_flashdata('msg', 'Category is successfully deleted.');
                }
                redirect('category/manage_category/view');
            }

            $this->data['title'] = 'View Categories';
            $this->data['categories'] = $this->Common_model->viewAll($table_name, $limit);
            $this->session->set_flashdata('msg', 'Category is successfully deleted.');
            $this->template->load("admin", "category/view_category", $this->data);
        } else if ($operation == 'view') {
            $this->data['title'] = 'View Categories';
            $this->data['datatable'] = TRUE;
            $this->data['sweetAlert'] = TRUE;
            $this->data['categories'] = $this->Common_model->viewAll($table_name, $limit);
            $this->template->load("admin", "category/view_category", $this->data);
        } else if ($operation == 'edit') {
            $this->data['validation'] = TRUE;
            $this->data['title'] = 'Edit Category';
            $this->data['categories'] = $this->Common_model->view($id, $table_name);
            $this->template->load("admin", "category/add_category", $this->data);
        } else if ($operation == 'filter_option') {
            $filter_option_array = array('text' => "Product Type");
            $filter_option_array['children'] = $this->Category_model->viewAllCategoryObject($table_name, $limit);
            echo json_encode(array($filter_option_array));
            die;
        }
    }

}
