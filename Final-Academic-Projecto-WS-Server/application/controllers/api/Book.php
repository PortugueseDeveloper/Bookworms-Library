<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Book extends REST_Controller
{

	function __construct()
	{
		// Construct the parent class
		parent::__construct();

		$this->load->model('api/book_model');
	}

	function getBooks_get()
	{
		$books = $this->book_model->getBooks();

		// Set the response and exit
		$this->response($books, REST_Controller::HTTP_OK); // OK (200)
	}

	//To get here
	//http://localhost/Bookworms-Library/Final-Academic-Projecto-WS-Server/index.php/api/book/addbook
	function addBook_post()
	{
		$book = array(
			'name' => $this->post('name'),
			'author' => $this->post('author'),
			'isbn' => $this->post('isbn'),
			'reader_id' => $this->post('reader_id'),
			'cover' => $this->post('bookCover')
		);
		$genders = $this->post('gender_id');

		if ($book['name'] == '' || $book['author'] == '' ||
			$book['isbn'] == '' || $book == 'reader_id' || $book == 'admin_id') {
			$message = [
				'id' => -1,
				'message' => 'The required fields were not given'
			];
			$this->set_response($message, REST_CONTROLLER::HTTP_NOT_FOUND);
			return;
		}

		$ret = $this->book_model->addBook($book, $genders);
		if ($ret < 0) {
			$message = [
				'id' => -2,
				'message' => 'it was not possible to register your book',
			];

			$this->set_response($message, REST_CONTROLLER::HTTP_NOT_FOUND);
		} else {
			$message = [
				'id' => 0,
				'message' => 'Book Registered'
			];
			$this->set_response($message, REST_CONTROLLER::HTTP_CREATED); // Create 201 (being the HTTP code)
		}

	}
/** FALTA AS VALIDAÇOES DA PARTE DA API AQUI !!! */
	function addRate_post()
	{
		$book = array(
			'reader_id' => $this->post('reader_id'),
			'book_id' => $this->post('book_id'),
			'rating_value' => $this->post('rating_value'),
			'rating_date' => $this->post('rating_date')
		);

	}
/**  alzheimer */
	function setOwned_post()
	{
		$id_user = $this->post('id_user');
		$id_book = $this->post('id_book');

		if ($id_user == '')
		{
			$message = [
				'id' => -2,
				'message' => 'The required fields were not introduced or they were impossible to execute'
			];
			$this->set_response($message, REST_CONTROLLER::HTTP_NOT_FOUND);
			return;
		}

		else
		{
			$ret = $this->book_model->setOwned($id_user, $id_book);

			if($ret == 0)
			{   
				 $message = [
				'id' => 0,
				'message' => 'Book added with sucess to user list'
				];

				$this->set_response($message, REST_CONTROLLER::HTTP_CREATED);
				return;
			}
		}

	function setWhished_post()
	{
	$id_user = $this->post('id_user');
	$id_book = $this->post('id_book');

	if ($id_user == '')
	{
		$message = [
			'id' => -2,
			'message' => 'The required fields were not introduced or they were impossible to execute'
		];
		$this->set_response($message, REST_CONTROLLER::HTTP_NOT_FOUND);
		return;
	}

	else
	{
		$ret = $this->book_model->setWhished($id_user, $id_book);

		if($ret == 0)
		{   
				$message = [
			'id' => 0,
			'message' => 'Book added with sucess to user list'
			];

			$this->set_response($message, REST_CONTROLLER::HTTP_CREATED);
			return;
		}
	}

}
