<?php

    if($_SERVER["REMOTE_ADDR"]=='95.239.208.246'){
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
        
    include ('config/config.php');
    
    $a = new mainClass();
    $a->main();
        

    
    
    