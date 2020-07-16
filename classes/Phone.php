<?php
class Phone
{
    private static $conn;
    
    public static function getConnection()
    {
        if (empty(self::$conn))
        {
            $ini = parse_ini_file('config/schedule.ini');
            $host = $ini['host'];
            $name = $ini['name'];
            $user = $ini['user'];
            $pass = $ini['pass'];
            
            self::$conn = new PDO("mysql:host={$host};dbname={$name}","{$user}","{$pass}");
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$conn;
    }
    
    public static function find($id)
    {
        $conn = self::getConnection();
        
        $result = $conn->prepare("SELECT * FROM phone WHERE id=:id");
        $result->execute( [ ':id' => $id ]);
        return $result->fetch();
    }
    
    public static function delete($id)
    {
        $conn = self::getConnection();
        
        $result = $conn->prepare("DELETE FROM phone WHERE id=:id");
        $result->execute( [ ':id' => $id ]);
    }
    
    public static function all($user_id)
    {
        $conn = self::getConnection();


        //var_dump($pessoa_id);die;
        $result = $conn->query("SELECT * FROM phone WHERE user_id = '{$user_id}'");
        
       
        return $result->fetchAll();
    }
    
    public static function save($phone)
    {
        $conn = self::getConnection();
        
        if (empty($phone['id']))
        {
            
            
            $sql = "INSERT INTO phone (id, user_id, phone)
                                VALUES ( :id, :user_id, :phone)";
        }
        else
        {
            $sql = "UPDATE phone SET id  = :id,
                                  user_id  = :user_id,
                                  phone    = :phone
                        WHERE id = :id";
        }
        
        $result = $conn->prepare($sql);
        $result->execute( [ ':id'   => $phone['id'],
                            ':user_id'   => $phone['user_id'],
                            ':phone'   => $phone['phone']
                         ]);
    }
}



