<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/
$hook['pre_controller'] = array(  
            'class' => 'security',  
            'function' => 'firwall',  
            'filename' => 'security.php',  
            'filepath' => 'hooks',    
            'params'=>array('vrgt.infosharesystems.com','localhost','192.168.56.1','192.168.0.121'),
            );
