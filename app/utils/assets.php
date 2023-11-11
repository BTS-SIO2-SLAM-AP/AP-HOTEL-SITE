<?php
class Asset{
    private static $indexPos;

    public static function init($indexDir){
        self::$indexPos = $indexDir;
    }

    public static function get($asset){
        if(str_starts_with($asset, "/")){$asset = substr($asset, 1);}
        $link = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https://'.$_SERVER['HTTP_HOST']."/".self::$indexPos.$asset : 'http://'.$_SERVER['HTTP_HOST']."/".self::$indexPos.$asset;
        return str_replace('\\' , '/', $link);//définit tout les séparateurs sur le même caractère ('/') et r'envoie le lien.
    }

    public static function url($link){// fait sensiblement la même chose que asset, mais cette fonction sera utilisée pour récupérer les liens menant à une page (getLink('/home') par exemple)
        if(str_starts_with($link, "/")){$link = substr($link, 1);}
        $link = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https://'.$_SERVER['HTTP_HOST']."/".self::$indexPos.$link : 'http://'.$_SERVER['HTTP_HOST']."/".self::$indexPos.$link;
        return str_replace('\\' , '/', $link);
    }
}
