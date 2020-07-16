<?php
class User
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
        
        $result = $conn->prepare("SELECT * FROM user WHERE id=:id");
        $result->execute( [ ':id' => $id ]);
        return $result->fetch();
    }
    
    public static function delete($id)
    {
        $conn = self::getConnection();
        
        $result = $conn->prepare("DELETE FROM user WHERE id=:id");
        $result->execute( [ ':id' => $id ]);
    }
    
    public static function all($initial = null)
    {
        $conn = self::getConnection();
        
        if($initial != null)
        {
            $result = $conn->query("SELECT * FROM user WHERE name like '{$initial}%' ORDER BY name");
        }
        else
        {
            $result = $conn->query("SELECT * FROM user WHERE name like 'A%' ORDER BY name");
        }
        

        return $result->fetchAll();
    }
    
    public static function save($user)
    {
        $conn = self::getConnection();

        //email validator
        if ( !filter_var($user['email'], FILTER_VALIDATE_EMAIL) ) 
        {
            $error = 'This email is not valid';
            print $error;
        }
        else
        {

            //unique email validator
            $result = $conn->prepare("SELECT * FROM user WHERE email = '{$user['email']}'");
            $result->execute( [ ':email' => $user['email'] ]);

            if($result->fetch())
            {
                $error = 'Theres another user with this email';
                print $error;
            }
            else
            {
                //insert data into user table
                if (empty($user['id']))
                {
            
                    $sql = "INSERT INTO user (id, name, address, email)
                                    VALUES ( :id, :name, :address,
                                             :email )";
                }
                else
                {
                    $sql = "UPDATE user SET name  = :name,
                                      address  = :address,
                                      email    = :email
                            WHERE id = :id";
                }
            
                $result = $conn->prepare($sql);
                $result->execute( [ ':id'   => $user['id'],
                                ':name'   => $user['name'],
                                ':address'   => $user['address'],
                                ':email'   => $user['email']
                             ]);

                print "Record saved";
            }

        }

    }

}



