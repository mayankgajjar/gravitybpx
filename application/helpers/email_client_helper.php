<?php
    function foreachlist($o){
        return $o;
    }

    function fromEmailList($msg){
        echo $msg->GetEmail();
    }

    function fromEmailListReturn($msg){
        return $msg->GetEmail();
    }

    function fromemail($data){
        echo ($data->GetEmail());
    }

    function fromname($data){
        echo ($data->GetDisplayName());
    }

    function findatta($data){
        pr($data->InitByBodyStructure());
    }

    function fromnamereturn($data){
        return ($data->GetDisplayName());
    }
    /*function unreadmail($data){
        echo ($data->GetDisplayName());
    } */

?>

