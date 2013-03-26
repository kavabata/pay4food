<?php
App::uses('AppModel', 'Model');
/**
 * Debt Model
 *
 */
class Debt extends AppModel {


  public function afterSave(){
    $sql = "
    UPDATE groups_users gu 
JOIN (SELECT SUM(debt) AS balance,user_id,group_id FROM debts GROUP BY `user_id`,`group_id`) AS jd ON jd.group_id = gu.group_id AND jd.user_id = gu.`user_id`
SET gu.balance = gu.balance - jd.balance
WHERE 1;";
    $this->query($sql);
    $sql = "
UPDATE groups_users gu 
JOIN (SELECT SUM(paid) AS balance,user_id,group_id FROM transactions GROUP BY `user_id`,`group_id`) AS jt ON jt.group_id = gu.group_id AND jt.user_id = gu.`user_id`
SET gu.balance = gu.balance + jt.balance
WHERE 1;";
    $this->query($sql);
  }
}
