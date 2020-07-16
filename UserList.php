<?php

require_once 'classes/User.php';

class UserList
{
    private $html;
    
    /**
     * Class constructor
     * Creates the listing
     */
    public function __construct()
    {
        $this->html = file_get_contents('html/list.html');
        
    }
    
    /**
     * Delete a record
     */
    public function delete($param)
    {
        try
        {
            $id = (int) $param['id'];
            User::delete($id);
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

            $initial = $param['initial'];

            $users = User::all($initial);
            
            $items = '';
            foreach ($users as $user)
            {  
                $item = file_get_contents('html/item.html');
                $item = str_replace( '{id}',    $user['id'], $item);
                $item = str_replace( '{name}',    $user['name'], $item);
                $item = str_replace( '{address}',    $user['address'], $item);
                $item = str_replace( '{email}',    $user['email'], $item);
                
                
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
