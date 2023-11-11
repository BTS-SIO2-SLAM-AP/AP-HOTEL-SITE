<?php

class DB
{
    private static $instance;

    public static function init($server, $dbname, $user, $password){
        self::$instance = new PDO("sqlsrv:Server=$server;Database=$dbname", $user, $password);
        self::$instance->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }

    public static function query($SQLrequest='', $values=null)
    {
        $statement=self::$instance->prepare($SQLrequest);
        $statement->execute($values);
        $data = $statement->fetchAll();
        if(!$data){return false;}
        foreach ($data as $key1=>$item1) {
            foreach ($item1 as $key2=>$item2) {
                if(is_numeric($key2)) unset($data[$key1][$key2]);
            }
        }
        return $data;
    }
}