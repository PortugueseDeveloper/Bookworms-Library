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

class Book_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    function addBook($book, $genders)
    {
        $ret = $this->db->insert('Book', $book);
        if (!$ret)
            return -1;

        $book_id = $this->db->insert_id();
        $genders_arr = explode(',', $genders);
        foreach ($genders_arr as $g) {
            if ($g != '') {
                $ret = $this->db->insert('book_has_gender',
                    array('book_id' => $book_id,
                    'gender_id' => $g));

                if (!$ret)
                    return -2;
            }
        }

        return $book_id;
    }

    function getBook($id = 0)
    {

    }

	// TODO: NEEDS WORK
	public function editBook($id_user, $id_profile, $name, $email, $password)
	{
		$this->db->update('User');
		$this->db->set('user.id_profile = '.$id_profile.'');
		$this->db->set('user.name = '.$name.'');
		$this->db->set('user.email = '.$email.'');
		$this->db->set('user.password = '.$password.'');
		$this->db->where('u.id = '.$id_user.'');

		return $ret = 0;
	}

}
