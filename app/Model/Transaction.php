<?php
App::uses('AppModel', 'Model');
/**
 * Transaction Model
 *
 */
class Transaction extends AppModel {

  public $hasMany = array('Debt');

  public function getPayout($users_list) {
    if(empty($users_list)) return false;
    
    $users = $usernames = array();
    foreach( $users_list as $user ){
      $users[$user['User']['id']] = (float)$user['GroupUser']['balance'];
      $usernames[$user['User']['id']] = $user['User']['name'];
    }
    
    $payout = $this->getOnePayout($users);
    if(empty($payout)) return array();
    foreach($payout as $k=>$pay) {
      $payout[$k]['userfrom'] = $usernames[$payout[$k]['userfrom_id']];
      $payout[$k]['userto'] = $usernames[$payout[$k]['userto_id']];
    }
    return $payout;
  }
  
  private function getOnePayout($users, $payout = array()) {
    //finish him

    if(empty($users)) return $payout;
    foreach($users as $kid => $total) if($total == 0) unset($users[$kid]);
    if(empty($users)) return $payout;

    //check summ
    $total = 0;
    foreach($users as $id=>$sum){
      $total = round($total + round($sum,2),2);
    }
    
    if($total != 0) return false;

    if(sizeof($payout) > 4) return $payout;
    //get minimum and maximum
    arsort($users);
    $maximum_id = key($users);
    $maximum = current($users);

    asort($users);
    $minimum_id = key($users);
    $minimum = current($users); 

    if ( ($maximum + $minimum) > 0 ) {
      //minimum should gave all money
      $payout[] = array(
        'userfrom_id'=>$minimum_id,
        'userto_id'=>$maximum_id,
        'money'=>-$minimum);
      $users[$minimum_id] = round($users[$minimum_id] - $minimum,2);
      $users[$maximum_id] = round($users[$maximum_id] + $minimum,2);
    } else {
      //maximum will be covered
      $payout[] = array(
        'userfrom_id'=>$minimum_id,
        'userto_id'=>$maximum_id,
        'money'=>$maximum);
      $users[$minimum_id] = round($users[$minimum_id] + $maximum,2);
      $users[$maximum_id] = round($users[$maximum_id] - $maximum,2);
    }
    foreach($users as $kid => $total) if($total == 0) unset($users[$kid]);


    return $this->getOnePayout($users, $payout);    
  }
}
