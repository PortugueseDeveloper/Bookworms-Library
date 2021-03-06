<?php
/**
 * Created by PhpStorm.
 * User: paulo
 * Date: 18-12-2018
 * Time: 15:37
 */

if (!defined('BASEPATH')) die();

/*
 * Common_model
 *
 */

class User_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    function addUser($user)
    {
        $ret = $this->db->insert('User', $user);
        
        $ret = 0;

        return $ret;
    }

    function getUsers()
    {
        $this->db->select("u.id,u.name, u.email");
        $this->db->from('User as u');
        
        $query = $this->db->get();

        $users = array();
        foreach ($query->result() as $t)
            $users[] = (array) $t;

        return $users;
    }

    function getUser($id)
    {
        $this->db->select("u.id, u.id_profile, u.name, u.email, u.password, u.birthdate, u.status");

        $this->db->from('User as u');

        $this->db->where('u.id', $id);
        
        $query = $this->db->get();

        $users = array();
        foreach ($query->result() as $t)
            $users[] = (array) $t;

        return $users;
    }

    function validate_user($id_user)
    {
        $this->db->select("u.id_profile");
        $this->db->from('User as u');
        $this->db->where('u.id = '.$id_user.'');

        $query = $this->db->get();

        $user = array();
        foreach($query->result() as $t)
            $user[] = (array) $t;

         $id_profile = $user[0]['id_profile'];

        return $id_profile;
      
    }

    function change_user_status($id_user, $status)
    {
        $this->db->update('User');
        $this->db->set('user.status = '.$status.'');
        $this->db->where('u.id = '.$id_user.'');

        return $ret = 0;
    }
//**** ADD FRIEND MODEL monkaS doesn't work */
    function addFriend($id_friend, $id_user)
    {
        $addFriend = array (
            'user_id' => $id_user,
            'friend_id' => $id_friend
        );

        $ret = $this->db->insert('User_has_Friend', $addFriend);
        return $ret = 0;
    }

	public function editUser($id_user, $id_profile, $name, $email, $password)
	{
		$this->db->update('User');
		$this->db->set('user.id_profile = '.$id_profile.'');
		$this->db->set('user.name = '.$name.'');
		$this->db->set('user.email = '.$email.'');
		$this->db->set('user.password = '.$password.'');
		$this->db->where('User.id = '.$id_user.'');

		return $ret = 0;
	}

}
