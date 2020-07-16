<?php
require_once 'classes/Phone.php';

class PhoneForm
{

	private $html;

	/**
     * Form constructor
     */
	public function __construct($param)
	{
		$this->html = file_get_contents('html/form_phone.html');

		if(isset($param['user_id']))
		{
			$user_id = $param['user_id'];
		}
		else
		{
			$user_id = null;
		}

		$this->data = [ 'id'        => null,
			 			'user_id'      => $user_id,
			 			'phone'  => null];	

	}

	/**
     * Load object to form data
     */
	public function edit($param)
	{
		try
		{
			$id = (int) $param['id'];
			$this->data = Phone::find($id);
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
			Phone::save($param);
			$this->data = $param;
			print "Record saved";
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
		$this->html = str_replace('{user_id}', $this->data['user_id'], $this->html);
		$this->html = str_replace('{phone}', $this->data['phone'], $this->html);

		print $this->html;
	}

}

