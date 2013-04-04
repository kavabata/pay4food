<?php 
$out = array(
  'users'=>$users,
  'groups'=>$groups,
);
if(!empty($payouts))
  $out['payouts'] = $payouts;
  
echo json_encode($out);?>