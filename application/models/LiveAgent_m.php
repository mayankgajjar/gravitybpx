<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LiveAgent_m
 *
 * @author dhareen
 */
class LiveAgent_m extends My_Model {

    protected $_table_name = 'live_agents';
    protected $_primary_key = 'live_agent_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'live_agent_id';
    protected $_timestamps = FALSE;

}
