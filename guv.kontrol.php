<?php

    function post($par, $guv=true){
        if($guv){
            return @htmlspecialchars(addslashes(strip_tags(trim($_POST[$par]))));
            
        }
        else{
            return @trim($_POST[$par]);
           
        }
    }
    
    function get($par, $guv=true){
        if($guv){
            return @htmlspecialchars(addslashes(strip_tags(trim($_GET[$par]))));
            
        }
        else{
            return @trim($_GET[$par]);
           
        }
    }

    function sYap($par){
        if($par!=""){
    
        foreach ($par as $p => $v){
            $_SESSION[$p] = $v;
        }
        return true;
        }
    else{
        return false;
    }
    }
    

    function sGet($par){
        if($_SESSION[$par]){
            return $_SESSION[$par];
            
        }
        else{
            return false;
        }
    }
    
    function go ($par, $time=0){
        if($time==0){
            header("Location: {$par}");
        }
        else{
            header("Refresh: {$time}; url={$par}");
        }
    }


    function ping2($host, $port, $timeout) { 
      $tB = microtime(true); 
      $fP = fSockOpen($host, $port, $errno, $errstr, $timeout); 
      if (!$fP) { return false; } 
      $tA = microtime(true); 
      return round((($tA - $tB) * 1000), 0)." ms"; 
    }