<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
            $filename = "http://173.254.218.90/vicidial/sql/test.php?access=true&&filename=campaign.txt&tablename=vicidial_campaigns";
            $result = file_get_contents($filename);
            $result = json_decode($result);
            dump($result);
            if(is_object($result)){
                $flag =(bool) $result->success;
                dump('test 5');
            }else{
                $flag = false;
                dump('test ');
            }
            dump($flag);
            if($flag){
                echo $content = file_get_contents($result->msg);
                $myfile = fopen("/home/clayton/public_html/uploads/sql/file.txt", "w") or die("Unable to open file!");
                fwrite($myfile, $content);
                fclose($myfile); 
            }

            die;
            $this->load->library('vicidialdb');
            $query = "SELECT * INTO OUTFILE '/var/www/html/vicidial/sql/campaigns.txt' FROM vicidial_campaigns";
            $results = $this->vicidialdb->db->query($query);
            var_dump($results);
//            try{
//            //$query = "SELECT * FROM vicidial_campaigns";
//            //$query = "SELECT * INTO OUTFILE '/home/clayton/public_html/uploads/sql/file.txt' FROM dailer_campaigns";
//            //$result = $this->vicidialdb->db->query($query);
//            dump($result->result_array());
//            }catch(Exception $e){
//                echo $e->getMessage();
//            }
            //$this->template->load("admin","add_agency");
//            $this->load->view('login');
	}
}