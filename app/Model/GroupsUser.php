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
        ON DUPLICATE KEY UPDATE confirmed=".($data['GroupsUser']['confirmed'] == '1'? '1' :'0');
        
        $this->query($sql);
        return true;
    } 
}
