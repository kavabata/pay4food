<?php
App::uses('AppModel', 'Model');
/**
 * GroupsUser Model
 *
 */
class GroupsUser extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'user_id';

    public function save($data) {
        $sql = "INSERT INTO groups_users (group_id,user_id,confirmed) 
        VALUES (".(int)$data['GroupsUser']['group_id'].",".(int)$data['GroupsUser']['user_id'].",".($data['GroupsUser']['confirmed'] == '1'? '1' :'0').")
        ON DUPLICATE KEY UPDATE confirmed='".($data['GroupsUser']['confirmed'] == '1'? '1' :'0')."'".(!empty($data['GroupsUser']['balance'])?", balance='".$data['GroupsUser']['balance']."'":"");
        
        $this->query($sql);
        return true;
    } 
    
    public function checkExist($user_id, $group_id) {
        return $this->find('first',array('conditions'=>array('GroupsUser.user_id'=>$user_id,'GroupsUser.group_id'=>$group_id)));
    }
}
