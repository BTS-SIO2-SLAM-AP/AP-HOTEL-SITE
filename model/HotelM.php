<?php
//MODELE HotelM
//Permettant la gestion de la table HOTEL

require_once("DBModel.php"); 

class HotelM extends DBModel
{

	public function ColumnNameIsValid($columnName){
		// Vérifier si la colonne spécifiée est valide
		$allowedColumns = ["nohotel", "nom", "adr1", "adr2", "cp", "ville", "tel", "descourt", "deslong", "prix", "password"];

		if (in_array($columnName, $allowedColumns)) {
			return $columnName;
		}
		return "nohotel";
	}

	//Retourne la liste complète des hôtels
    public function getAllHotel($columnNameOrderBy)
	{
		$columnNameOrderBy = $this->ColumnNameIsValid($columnNameOrderBy);
		$reqresult = parent::getDb()->prepare("select nohotel, nom, adr1, adr2, cp, ville, tel, descourt, deslong, prix, password from hotel order by $columnNameOrderBy");
		$reqresult->execute();
		$lesHotels = $reqresult->fetchAll();
		foreach ($lesHotels as $unHotel) {
			$unHotel["chambres"] = $this->getChambers($unHotel["nohotel"]);
			$unHotel["equipements"] = $this->getEquip($unHotel["nohotel"]);
		}

		return $lesHotels;
    }
	
	//Retourne toutes les chambres d'un hôtel
	public function getChambers($nohotel) {
		$reqresult = parent::getDb()->prepare("select nochambre from chambre where nohotel=$nohotel");
		$reqresult->execute();
		return $reqresult->fetchAll();
	}

	public function getEquip($nohotel) {
		$reqresult = parent::getDb()->prepare("select noequ from equiper where nohotel = $nohotel");
		$reqresult->execute();
		return $reqresult->fetchAll();
	}
	//Retourne une classe
	public function getCla($noHotel)
	{
		$reqresult = parent::getDb()->prepare("select clacod, clalib from classe where clacod= :noHotel");
        $reqresult->bindParam("noHotel",$noHotel,PDO::PARAM_INT);
		$reqresult->execute();
		return $reqresult->fetchAll();
    }

	
}
//Absence volontaire de la balise fermeture php