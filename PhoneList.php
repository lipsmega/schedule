<?php

require_once 'classes/Phone.php';
require_once 'classes/User.php';

class PhoneList
{
    private $html;
    
    /**
     * Class constructor
     * Creates the listing
     */
    public function __construct($param)
    {

        $user = User::find($param['user_id']);

        $this->html = file_get_contents('html/list_phone.html');
        $this->html = str_replace('{user_id}', $user['id'], $this->html);
        $this->html = str_replace('{user_name}', $user['name'], $this->html);
    }
    
    /**
     * Delete a record
     */
    public function delete($param)
    {
        try
        {
            $id = (int) $param['id'];
            Phone::delete($id);
            $this->load($param);
        }
        catch (Exception $e)
        {
            print $e->getMessage();
        }
    }
    
    /**
     * Load the table with data
     */
    public function load($param = null)
    {
        try
        {

            $user_id = $param['user_id'];

            $phones = Phone::all($user_id);
            
            $items = '';
            foreach ($phones as $phone)
            {  
                $item = file_get_contents('html/item_phone.html');
                $item = str_replace( '{id}',    $phone['id'], $item);
                $item = str_replace( '{user_id}',    $phone['user_id'], $item);
                $item = str_replace( '{phone}',    $phone['phone'], $item);
               
                
                $items .= $item;
            }
            $this->html = str_replace('{items}', $items, $this->html);
        }
        catch (Exception $e)
        {
            print $e->getMessage();
        }
    }
    
    /**
     * Shows the page
     */
    public function show()
    {
        $this->load();
        print $this->html;
    }
}
