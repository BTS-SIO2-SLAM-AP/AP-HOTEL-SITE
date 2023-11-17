<?php
//MODELE DB
//Permet l'accès à la base de données
//Classe mère commune à l'ensemble des modèles

class DBModel
{
    private $db;
	
    public function __construct()
    {
		try
		{
			$server = true ? "VGTom\\SQLSERVEREXPRESS" : "DESKTOP-DOBTUVE";
			$dbname = "bdhotel_lepers-vieillard";
			$user = "sa";
			$password = "mdpsa";
			$this->db = new PDO("sqlsrv:Server=$server;Database=$dbname", $user, $password);
		} 
		catch(Exception $e) 
		{
			die('Erreur : '.$e->getMessage());
		}		

		
	}
	
	public function getDb()
    {
        return $this->db;
	}
}
//Absence volontaire de la balise fermeture php