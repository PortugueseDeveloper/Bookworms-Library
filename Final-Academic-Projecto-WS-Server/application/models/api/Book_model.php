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

    function getBooks()
    {
		$this->db->select("b.id, b.name, b.author, b.description ,b.isbn, b.cover");
		$this->db->from("Book as b");

		$query = $this->db->get();

		$books = array();
		foreach ($query->result() as $t)
			$books[] = (array) $t;

		return $books;
    }

    function getApprovedBooks()
    {
		$this->db->select("b.id, b.name, b.author, b.description ,b.isbn, b.cover");
        $this->db->from("Book as b");
        $this->db->where("b.admin_id IS NOT NULL");

		$query = $this->db->get();

		$books = array();
		foreach ($query->result() as $t)
			$books[] = (array) $t;

		return $books;
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
/** alzheimer */
    function setOwned($id_user, $id_book)
    {
        $setowned = array (
            'user_id' => $id_user,
            'book_id' => $id_book
        );

        $ret = $this->db->insert('User_has_Book', $setowned);
        return $ret = 0;
    }

    function setWished($id_user, $id_book)
    {
        $setwished = array (
            'user_id' => $id_user,
            'book_id' => $id_book
        );

        $ret = $this->db->insert('User_has_Wished_Book', $setwished);
        return $ret = 0;
    }

    function setRead($id_user, $id_book)
    {
        $setread = array (
            'user_id' => $id_user,
            'book_id' => $id_book
        );

        $ret = $this->db->insert('User_has_Read_Book', $setread);
        return $ret = 0;
    }

    function bookValidate($book_id, $admin_id)
	{
        $this->db->update('Book');
		$this->db->set('Book.admin_id = '.$admin_id.'');
		$this->db->where('Book.id = '.$book_id.'');

		return $ret = 0;
    }
}
