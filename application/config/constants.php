<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  |--------------------------------------------------------------------------
  | Display Debug backtrace
  |--------------------------------------------------------------------------
  |
  | If set to TRUE, a backtrace will be displayed along with php errors. If
  | error_reporting is disabled, the backtrace will not display, regardless
  | of this setting
  |
 */
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
  |--------------------------------------------------------------------------
  | File and Directory Modes
  |--------------------------------------------------------------------------
  |
  | These prefs are used when checking and setting modes when working
  | with the file system.  The defaults are fine on servers with proper
  | security, but you may wish (or even need) to change the values in
  | certain environments (Apache running a separate process for each
  | user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
  | always be used to set the mode correctly.
  |
 */
defined('FILE_READ_MODE') OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE') OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE') OR define('DIR_WRITE_MODE', 0755);

/*
  |--------------------------------------------------------------------------
  | File Stream Modes
  |--------------------------------------------------------------------------
  |
  | These modes are used when working with fopen()/popen()
  |
 */
defined('FOPEN_READ') OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE') OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE') OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESCTRUCTIVE') OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE') OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE') OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT') OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT') OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
  |--------------------------------------------------------------------------
  | Exit Status Codes
  |--------------------------------------------------------------------------
  |
  | Used to indicate the conditions under which the script is exit()ing.
  | While there is no universal standard for error codes, there are some
  | broad conventions.  Three such conventions are mentioned below, for
  | those who wish to make use of them.  The CodeIgniter defaults were
  | chosen for the least overlap with these conventions, while still
  | leaving room for others to be defined in future versions and user
  | applications.
  |
  | The three main conventions used for determining exit status codes
  | are as follows:
  |
  |    Standard C/C++ Library (stdlibc):
  |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
  |       (This link also contains other GNU-specific conventions)
  |    BSD sysexits.h:
  |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
  |    Bash scripting:
  |       http://tldp.org/LDP/abs/html/exitcodes.html
  |
 */
defined('EXIT_SUCCESS') OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR') OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG') OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE') OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS') OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT') OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE') OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN') OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX') OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code
// NEW ADDED
defined('default_group_id') OR define('default_group_id', 2); // highest automatically-assigned error code
defined('CSS_ADMIN_URL') OR define('CSS_ADMIN_URL', 'assets/admin/stylesheets/');
defined('JS_ADMIN_URL') OR define('JS_ADMIN_URL', 'assets/admin/javascripts/');
defined('IMGS_ADMIN_URL') OR define('IMGS_ADMIN_URL', 'assets/admin/images/');
defined('FONTS_ADMIN_URL') OR define('FONTS_ADMIN_URL', 'assets/admin/fonts/');
defined('ADMIN_URL') OR define('ADMIN_URL', 'admin/');

defined('FB_APP_ID') OR define('FB_APP_ID', '156376204736766');
defined('FB_APP_SECRET') OR define('FB_APP_SECRET', '420665a474da9597e7d08a9ee79e8947');
define ("TABLE_NAME", serialize (array ("notifications" => "notifications","category" => "category","notifications_type" => "notifications_type","notifications_message" => "notifications_message","theme_options" => "theme_options","register_link" => "register_link","agencies" => "agencies","agents" => "agents")));
define ("REGISTER_TYPE", serialize (array ("agency" => "Agency","agent" => "Agent")));
define ("PAYMENT_OPTION", serialize (array ("1" => "Bank Draft","2" => "Credit Card")));
define ("AGENT_TYPE", serialize (array ("1" => "Sales Agent","2" => "Verification Agent","3" => "Processing Agent")));
define ("CREDIT_CARD_TYPE", serialize (array ("visa" => "Visa","master_card" => "Master Card","american_express" => "American Express")));
define ("VICIDIAL_SERVER_IP",'173.254.218.90');

defined('ACTIVE')      	 OR define('ACTIVE', 1);
defined('DEACTIVE')      OR define('DEACTIVE', 0);

defined('AUCTION_TYPE_DATA')      	 OR define('AUCTION_TYPE_DATA', 'data');
defined('AUCTION_TYPE_LIVE_TRANSFER')      OR define('AUCTION_TYPE_LIVE_TRANSFER', 'live_transfer');

/* settings */
defined('PHONE_FORMAT')      	 OR define('PHONE_FORMAT', '(999) 999-9999');


/* FIlter Group Name */
defined('FILTER_GROUPS')      	 OR define ("FILTER_GROUPS", serialize(array ("precision" => "Precision Targeting", "affordability"=> "Affordability Filters")));

/* credit card */
defined('CREDIT_CARDS')			 OR define ("CREDIT_CARDS", serialize(array ("VI" => "Visa", "MC"=> "MasterCard", "AX" => "American Express")));

defined('LEADSTORE_FILTER_PHONE_OPTIONS') OR define("LEADSTORE_FILTER_PHONE_OPTIONS", serialize(array('Include phone on each lead' => 0, 'Include landline on each lead' => 1, 'Include phone only where available' => 2, 'Include cellphone on each lead' => 3)));
/* PLIVO API URL */
defined('PLIVO_API') OR define('PLIVO_API','https://api.plivo.com/v1/Account/');