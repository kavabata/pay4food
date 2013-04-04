<?php
App::uses('AppHelper', 'View/Helper');
App::uses('CakeSession', 'Model/Datasource');

class DateHelper extends AppHelper {
  
  public function emailTime($datetime, $shorten = false) {
    $timestamp = is_integer($datetime) ? $datetime : strtotime($datetime);
    
    if ($timestamp < strtotime('-3 months')) {
      return date('m/d/Y',$timestamp);
    }elseif($timestamp < strtotime('-14 days')){
      return date('d M',$timestamp);
    }elseif($timestamp < strtotime('-24 hours')){
      $ago = floor((time()-$timestamp)/86400);
      return date('d M',$timestamp).($shorten?'':' ('.$ago.' day'.($ago>1?'s':'').' ago)');
    }elseif($timestamp < strtotime('-1 hour')){
      $ago = floor((time()-$timestamp)/3600);
      return date('H:i',$timestamp).($shorten?'':' ('.$ago.' hour'.($ago>1?'s':'').' ago)');
    }else{
      $ago = floor((time()-$timestamp)/60);
      return date('H:i',$timestamp).($shorten?'':' ('.$ago.' min. ago)');
    }
    
    return date('m/d/Y \a\t H:i \E\D\T',$timestamp);
  }
}