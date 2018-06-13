<?php

defined('BASEPATH') or exit('No direct script access allowed');

include 'MailSo/MailSo.php';


class Mails {

    var $oLogger;
    var $oMailClient;
    var $oSmtpClient;
    var $sysFolders = array();

    /**
     *
     * @param type $config
     */
    public function __construct($config = array()) {
        $this->oMailClient = \MailSo\Mail\MailClient::NewInstance();
        $this->oSmtpClient = \MailSo\Smtp\SmtpClient::NewInstance();
        $this->getConnection($config['host'], $config['port'], $config['ssl_type'], $config['username'], $config['password']);
    }

    public function getConnection($hostname, $eport, $ssltype, $username, $password) {
        $host = $hostname;
        $port = intval($eport);
        if($ssltype == 'Yes'){
            $ctype = \MailSo\Net\Enumerations\ConnectionSecurityType::SSL;
        } else {
            $ctype = \MailSo\Net\Enumerations\ConnectionSecurityType::STARTTLS;
        }
        $connectionType = $ctype;
        $sLogin = $username;
        $sPassword = base64_decode($password);

        try{
            $this->oMailClient->connect($host, $port, $connectionType)->Login($sLogin, $sPassword);
        }catch(Exception $ex){
             $ex->getMessage();
        }
    }

    public function getDefaultFolderList() {
        try {
            $foldarArray = array();
            $folders = $this->oMailClient->Folders();
            if($this->oMailClient->IsGmail()){
                $folders->ForeachList([$this, 'folderlist']);
            }else{
                $folders->ForeachList([$this, 'folderlistOther']);
            }
        } catch (Exception $ex) {
            return false;
        }
    }

    function folderlist($f) {
        if(count($f->SubFolders()) > 0){
            $subFolders = $f->SubFolders();
            $subFolders->ForeachList([$this, 'folderlist']);
            //$this->folderlist($f);
        }else{
            $this->sysFolders[] = $f;
        }
    }

    function folderlistOther($f) {
        $this->sysFolders[] = $f;
        if(count($f->SubFolders()) > 0){
            $subFolders = $f->SubFolders();
            $subFolders->ForeachList([$this, 'folderlist']);
            //$this->folderlist($f);
        }
    }

    public function getFolderUnseenCount($folderName) {
        return $this->oMailClient->InboxUnreadCountFolder($folderName);
    }

    public function getMessageList($folderName,$Offset = 0, $limit = 20) {
        return $this->oMailClient->MessageList($folderName, $Offset, $limit);
    }

    public function getMessageBody($sFolderName, $iIndex) {
        return $this->oMailClient->Message($sFolderName, $iIndex);
    }

    public function foreachlist($o) {
        return $o;
    }

    public function MessageRead($sFolderName, $aIndexRange, $bIndexIsUid) {
        return $this->oMailClient->MessageSetSeen($sFolderName, $aIndexRange, $bIndexIsUid);
    }

    function MailDelete($sFromFolder, $sToFolder, $aIndexRange, $bIndexIsUid) {
        return $this->oMailClient->MessageMove($sFromFolder, $sToFolder, $aIndexRange, $bIndexIsUid);
    }

    function mailform($sFrom) {
        return $this->oSmtpClient->MailTo($sFrom);
    }



}
