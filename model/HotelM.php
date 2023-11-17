<?php
//MODELE HotelM
//Permettant la gestion de la table HOTEL

require_once("DBModel.php"); 

class HotelM extends DBModel
{
	//Retourne la liste complète des hôtels
    public function getAllHotel($columnNameOrderBy)
	{
		$columnNameOrderBy = $this->ColumnNameIsValid($columnNameOrderBy);
		$reqresult = parent::getDb()->prepare("select nohotel, nom, adr1, adr2, cp, ville, tel, descourt, deslong, prix, password from hotel order by $columnNameOrderBy");
		$reqresult->execute();
		$lesHotels = $reqresult->fetchAll();
		foreach ($lesHotels as &$unHotel) {
			$unHotel["chambres"] = $this->getChambersHotel($unHotel["nohotel"]);
			$unHotel["equipements"] = $this->getEquipementsHotel($unHotel["nohotel"]);
			$unHotel["reservations"] = $this->getReservationsHotel($unHotel["nohotel"]);
		}
		return $lesHotels;
    }
	
	//Retourne toutes les chambres d'un hôtel
	public function getChambersHotel($nohotel) {
		$reqresult = parent::getDb()->prepare("select nochambre from chambre where nohotel=$nohotel");
		$reqresult->execute();
		$lesChambres = $reqresult->fetchAll();
		foreach ($lesChambres as &$uneChambre) {
			$uneChambre["equipements"] = $this->getReservationsChambre($nohotel, $uneChambre["nochambre"]);
		}
		return $lesChambres;
	}

	//Retourne toutes les chambres d'un hôtel
	public function getChambersReservation($noHotel, $noResGlobale) {
		$reqresult = parent::getDb()->prepare("select chambre.nochambre from chambre inner join reserver on chambre.nochambre = reserver.nochambre where chambre.nohotel=$noHotel and noresglobale=$noResGlobale;");
		$reqresult->execute();
		return $reqresult->fetchAll();
	}

	// Retourne tous les équipements d'un hôtel
	public function getEquipementsHotel($nohotel) {
		$reqresult = parent::getDb()->prepare("select equipement.noequ as noequ, lib from equiper inner join equipement on equiper.noequ = equipement.noequ where nohotel = $nohotel");
		$reqresult->execute();
		return $reqresult->fetchAll();
	}

	// Retourne toutes les réservations d'un hôtel
	public function getReservationsHotel($nohotel) {
		$reqresult = parent::getDb()->prepare("select noresglobale, nohotel, nores, datedeb, datefin, nom, email, codeacces from reservation where nohotel = $nohotel");
		$reqresult->execute();
		$lesReservations = $reqresult->fetchAll();
		foreach ($lesReservations as &$uneReservation) {
			$uneReservation["chambres"] = $this->getChambersReservation($nohotel, $uneReservation["noresglobale"]);
		}
		return $lesReservations;
	}

	// Retourne toutes les réservations d'une chambre
	public function getReservationsChambre($nohotel, $nochambre) {
		$reqresult = parent::getDb()->prepare("select reservation.noresglobale, reservation.nohotel, nores, datedeb, datefin, nom, email, codeacces from reservation inner join reserver on reservation.noresglobale = reserver.noresglobale where reservation.nohotel = $nohotel and nochambre = $nochambre;");
		$reqresult->execute();
		return $reqresult->fetchAll();
	}


	//Retourne les informations d'un hôtel
	public function getHotel($listHotel, $noHotel)
	{
		foreach ($listHotel as $unHotel) {
			if ($unHotel["nohotel"] == $noHotel) {
				return $unHotel;
			}
		}
		return null;
    }



	
	public function ColumnNameIsValid($columnName){
		// Vérifier si la colonne spécifiée est valide
		$allowedColumns = ["nohotel", "nom", "adr1", "adr2", "cp", "ville", "tel", "descourt", "deslong", "prix", "password"];

		if (in_array($columnName, $allowedColumns)) {
			return $columnName;
		}
		return "nohotel";
	}
}
//Absence volontaire de la balise fermeture php