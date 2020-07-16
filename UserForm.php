<?php
require_once 'classes/User.php';

class UserForm
{

	private $html;

	/**
     * Form constructor
     */
	public function __construct()
	{
		$this->html = file_get_contents('html/form.html');

		$this->data = [ 'id'        => null,
			 			'name'      => null,
			 			'address'  => null,
			 			'email'    => null];


	}

	/**
     * Load object to form data
     */
	public function edit($param)
	{
		try
		{
			$id = (int) $param['id'];
			$this->data = User::find($id);
		}
		catch(Exception $e)
		{
			print $e->getMessage();
		}
	}

	/**
     * Save form data
     */
	public function save($param)
	{
		try
		{
			User::save($param);
			$this->data = $param;
			
		}
		catch(Exception $e)
		{
			print $e->getMessage();
		}

	}

	/**
     * Shows the page
     */
	public function show()
	{
		$this->html = str_replace('{id}', $this->data['id'], $this->html);
		$this->html = str_replace('{name}', $this->data['name'], $this->html);
		$this->html = str_replace('{address}', $this->data['address'], $this->html);
		$this->html = str_replace('{email}', $this->data['email'], $this->html);
		
		print $this->html;
	}

}

