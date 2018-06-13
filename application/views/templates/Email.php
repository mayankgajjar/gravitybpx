<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Email extends CI_Controller{

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        }
        $canect = $this->email_connection();
        if(!empty($canect)){
            $this->load->library('mails', $canect);
        } else{
            redirect(site_url('emailconfiguration/index'));
        }
        $this->load->model('emailclient_m');
        $this->load->helper('email_client_helper');
        $this->mails->getDefaultFolderList();
        $this->data['sysFolders'] = $this->mails->sysFolders;
        $this->data['inboxUnseenCount'] = $this->mails->oMailClient->InboxUnreadCount();
    }

    public function email_connection(){
        $con = array(
            'user_id' => $this->session->userdata("user")->id,
            'config_type' => 'Email_Client',
            'is_delete' => 'NO',
        );

        return $this->db->get_where('email_configuration',$con)->row_array();
    }
    public function smtp_connection(){
        $con = array(
            'user_id' => $this->session->userdata("user")->id,
            'config_type' => 'SMTP',
            'is_delete' => 'NO',
        );

        return $this->db->get_where('email_configuration',$con)->row_array();
    }

    public function index(){
        $this->data['email'] = TRUE;
        $this->data['title'] = 'Agent | Email';
        $this->template->load('agent','email/index', $this->data);
    }

    public function inbox(){
        $this->data['email'] = TRUE;
        $this->data['title'] = 'Agent | Email';
        $messageList = $this->mails->getMessageList('INBOX');
        $this->data['offset'] = $messageList->Offset;
        $this->data['end'] = $messageList->Offset + 10;
        $this->data['limit'] = $messageList->Limit;
        $this->data['total'] = $messageList->MessageCount;
        $this->data['msglist'] = $messageList->MapList('foreachlist');
        $this->template->load('agent','email/index', $this->data);


    }

    public function openEmail(){
       $uid = $this->input->post('id');
       $aIndexRange = array($uid);
       $folder = 'INBOX';
       if($this->input->post('folder')){
           $folder = $this->input->post('folder');
       }
       $mailBody = $this->mails->getMessageBody($folder, $uid);
       $this->mails->MessageRead($folder,$aIndexRange,$bIndexIsUid=TRUE);
       $mailBody = $this->mails->getMessageBody($folder,$uid);
       if($mailBody->Attachments()){
           $this->data['atachments'] = $mailBody->Attachments()->MapList('foreachlist');
       }
       $this->data['data'] = $mailBody;
       $this->data['uid'] = $uid;
       echo $this->load->view("email/viewmassage", $this->data, TRUE);
    }

    public function pagination_inibox(){
        $offset = $this->input->post('off');
        $status = $this->input->post('status');
        if($status == 'Next'){
            $NewOffset = $offset + 10;
        } else {
            $NewOffset = $offset - 10;
        }
        $messageList = $this->mails->getMessageList('INBOX',$NewOffset);
        $this->data['offset'] = $messageList->Offset;
        $this->data['end'] = $messageList->Offset + 10;
        $this->data['limit'] = $messageList->Limit;
        $this->data['total'] = $messageList->MessageCount;
        $this->data['msglist'] = $messageList->MapList('foreachlist');
        echo $this->load->view("email/pagination_inibox", $this->data, TRUE);
    }


    public function deleteEmail(){
        $uid = $this->input->post('id');
        $del = $this->mails->MailDelete('INBOX','Trash',array($uid), $bIndexIsUid=TRUE);
        if($del){
            echo $this->session->set_flashdata('success', "Email is successfully deleted.");
        } else {
            echo $this->session->set_flashdata('error', "Email is Not deleted.");
        }
    }

    public function delete_selected_mail() {
        $idlist = $this->input->post('id');
        $del = $this->mails->MailDelete('INBOX','Trash',$idlist,$bIndexIsUid=TRUE);
        if($del){
            echo $this->session->set_flashdata('success', "Email is successfully deleted.");
        } else {
            echo $this->session->set_flashdata('error', "Email is Not deleted.");
        }
    }

    public function compose_mail() {
        $config = $this->smtp_connection();
        if($config){
            $this->data['test'] = 'test';
            echo $this->load->view("email/compose_mail", $this->data, TRUE);
        } else {
            echo 'First Set SMTP configuration On Email Configuration.';
        }
    }

    public function read_selected_mail(){
        $idlist = $this->input->post('id');
        $aIndexRange = $idlist;
        $this->mails->MessageRead('INBOX',$aIndexRange,$bIndexIsUid=TRUE);
        echo 'read';
    }

    public function send_mail(){
        $post = $this->input->post();

        if ($_FILES['attachmentfile'] != '') {
            foreach ($_FILES['attachmentfile']['name'] as $key => $attachmentTemp) {
                $temp = explode(".", $_FILES['attachmentfile']['name'][$key]);
                $extension = end($temp);
                $newname = $_FILES['attachmentfile']["tmp_name"][$key] . "." . $extension;
                rename($_FILES['attachmentfile']["tmp_name"][$key], $newname);
                $attachmentsFile[$key] = $newname;
            }
        }

        $attachments = $attachmentsFile;

        $smtp_data = $this->smtp_connection();
            if(isset($post['cc_email']) && $post['cc_email'] != ''){
                $cc = $post['cc_email'];
            } else {
                $cc= '';
            }
            if(isset($post['bcc_email']) && $post['bcc_email'] != ''){
                $bcc = $post['bcc_email'];
            } else {
                $bcc= '';
            }
        $send = $this->emailclient_m->send_new_email($post['to_email'], $post['subject'], $post['message'], $post['subject'], $cc, $bcc, $attachments, $smtp_data);
        if($send == 1){
            $data = $this->emailclient_m->array_from_post(array('to_email', 'subject', 'cc_email', 'bcc_email'));
            $data['massage_body'] = serialize($post['message']);
            $data['user_id'] = $this->session->userdata('agent')->user_id;
            $data['email_status'] = 'New';
            $this->emailclient_m->save($data, $id);
            $this->session->set_flashdata('success', "Email is sent successfully.");
            redirect(site_url('email/inbox'));
        } else {
            $this->session->set_flashdata('error', "Email is not sent.");
            redirect(site_url('email/inbox'));
        }

    }

   public function getFolderJson(){
        $sysFolders = $this->mails->sysFolders;
        $ofolder = array();
        foreach($sysFolders as $folder){
            $ofolder[] = array(
                'name' => $folder->Name(),
                'fullname' => $folder->FullNameRaw(),
                'unseen' => $this->mails->getFolderUnseenCount($folder->FullNameRaw()),
                'namesis' => array(
                    'name' => $folder->Name(),
                    'unseen' => $this->mails->getFolderUnseenCount($folder->FullNameRaw()),
                )
            );
        }
        $output['oFolders'] = $ofolder;
        return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($output));
    }

    public function getMessageJson(){
        $folder = 'INBOX';
        if($this->input->get('folder')){
            $folder = urldecode($this->input->get('folder'));
        }
        $start = 0;
        $end = 20;

        if($this->input->get('offset') && $this->input->get('offset') > 0){
            $start = $this->input->get('offset');
            $end = $start + $end;
        }

        $messageList = $this->mails->getMessageList($folder, intval($start));
        if($messageList->MessageCount <= $end){
            $end = $messageList->MessageCount;
        }
        $messqages = $messageList->MapList('foreachlist');
        $output = array();
        foreach($messqages as $message){
            $output[] = array(
                'Uid' => $message->Uid(),
                'subject' => $message->Subject(),
                'fromname' => $message->From()->MapList('fromnamereturn'),
                'fromEmailList' => $message->From()->MapList('fromEmailListReturn'),
                'date' =>  substr($message->HeaderDate(), 0, 25),
                'flags' => (sizeof($message->Flags()) > 0) ? sizeof($message->Flags()) : null,
            );
        }

        return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(array('messages' => $output, 'total' => $messageList->MessageCount, 'count' => $end)));
    }

    public function download_attachment(){
        $uid = $this->input->post('id');
        $file =  $this->input->post('filename');

        $config = $this->email_connection();

        $hostname = strval('{'.$config['host'].':143/novalidate-cert}INBOX');
         $username = $config['username'];
         $password = base64_decode($config['password']);

        $inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());
        $msgNo = imap_msgno($inbox , $uid);

        /* get all new emails. If set to 'ALL' instead
        * of 'NEW' retrieves all the emails, but can be
        * resource intensive, so the following variable,
        * $max_emails, puts the limit on the number of emails downloaded.
        *
        */
       $emails = imap_search($inbox,'ALL');

       /* useful only if the above search is set to 'ALL' */
       $max_emails = 16;

       /* if any emails found, iterate through each email */
       if($emails) {

           $count = 1;

           /* put the newest emails on top */
           rsort($emails);

           /* for every email... */

           foreach($emails as $email_number)
           {


               /* get information specific to this email */
               $overview = imap_fetch_overview($inbox,$email_number,0);
               pr($overview);
               /* get mail message, not actually used here.
                  Refer to http://php.net/manual/en/function.imap-fetchbody.php
                  for details on the third parameter.
                */
               $message = imap_fetchbody($inbox,$email_number,2);

               /* get mail structure */
               $structure = imap_fetchstructure($inbox, $email_number);

               $attachments = array();

               /* if any attachments found... */
               if(isset($structure->parts) && count($structure->parts))
               {
                   for($i = 0; $i < count($structure->parts); $i++)
                   {
                       $attachments[$i] = array(
                           'is_attachment' => false,
                           'filename' => '',
                           'name' => '',
                           'attachment' => ''
                       );

                       if($structure->parts[$i]->ifdparameters)
                       {
                           foreach($structure->parts[$i]->dparameters as $object)
                           {
                               if(strtolower($object->attribute) == 'filename')
                               {
                                   $attachments[$i]['is_attachment'] = true;
                                   $attachments[$i]['filename'] = $object->value;
                               }
                           }
                       }

                       if($structure->parts[$i]->ifparameters)
                       {
                           foreach($structure->parts[$i]->parameters as $object)
                           {
                               if(strtolower($object->attribute) == 'name')
                               {
                                   $attachments[$i]['is_attachment'] = true;
                                   $attachments[$i]['name'] = $object->value;
                               }
                           }
                       }

                       if($attachments[$i]['is_attachment'])
                       {
                           $attachments[$i]['attachment'] = imap_fetchbody($inbox, $email_number, $i+1);

                           /* 3 = BASE64 encoding */
                           if($structure->parts[$i]->encoding == 3)
                           {
                               $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
                           }
                           /* 4 = QUOTED-PRINTABLE encoding */
                           elseif($structure->parts[$i]->encoding == 4)
                           {
                               $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                           }
                       }
                   }
               }

               /* iterate through each attachment and save it */
               foreach($attachments as $attachment)
               {
                   if($attachment['is_attachment'] == 1)
                   {
                       $filename = $attachment['name'];
                       if(empty($filename)) $filename = $attachment['filename'];

                       if(empty($filename)) $filename = time() . ".dat";

                       /* prefix the email number to the filename in case two emails
                        * have the attachment with the same file name.
                        */
                       $fp = fopen("./" . $email_number . "-" . $filename, "w+");
                       fwrite($fp, $attachment['attachment']);
                       fclose($fp);
                   }

               }

               if($count++ >= $max_emails) break;
           }

       }

       /* close the connection */
       imap_close($inbox);

        echo "Done";



           }

}

