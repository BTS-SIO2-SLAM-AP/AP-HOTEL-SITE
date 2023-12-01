<?php
//MODELE HotelM
//Permettant la gestion de la table HOTEL

require_once("DBModel.php"); 

class HotelM extends DBModel
{
	//Retourne la liste complète des hôtels
    public function getAllHotel($columnNameOrderBy, $equiments = [], $ville = "", $prixMax = 9999)
	{
		$columnNameOrderBy = $this->ColumnNameIsValid($columnNameOrderBy);
		$requete = "select distinct hotel.nohotel, nom, adr1, adr2, cp, ville, tel, descourt, deslong, prix from hotel inner join equiper on equiper.nohotel=hotel.nohotel where ville like '%$ville%' AND prix BETWEEN 0 AND $prixMax";

		if (!empty($equiments)) {
			$requete .= "AND equiper.noequ in (".implode(",", $equiments).") ";
		}
		
		$requete .= "order by $columnNameOrderBy";
		
		$reqresult = parent::getDb()->prepare($requete);
		$reqresult->execute();
		$lesHotels = $reqresult->fetchAll();
		foreach ($lesHotels as &$unHotel) {
			$unHotel["chambres"] = $this->getChambersHotel($unHotel["nohotel"]);
			$unHotel["equipements"] = $this->getEquipementsHotel($unHotel["nohotel"]);
			$unHotel["reservations"] = $this->getReservationsHotel($unHotel["nohotel"]);
			$unHotel["photos"] = $this->getPhotosHotel($unHotel["nohotel"]);
		}
		return $lesHotels;
    }
	
	//Retourne toutes les chambres d'un hôtel
	public function getChambersHotel($nohotel) {
		$reqresult = parent::getDb()->prepare("select nochambre from chambre where nohotel=$nohotel");
		$reqresult->execute();
		$lesChambres = $reqresult->fetchAll();
		foreach ($lesChambres as &$uneChambre) {
			$uneChambre["reservations"] = $this->getReservationsChambre($nohotel, $uneChambre["nochambre"]);
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
		$reqresult = parent::getDb()->prepare("select equipement.noequ as noequ, lib, imgequ from equiper inner join equipement on equiper.noequ = equipement.noequ where nohotel = $nohotel");
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

	public function getPhotosHotel($nohotel) {
		$reqresult = parent::getDb()->prepare("select nophoto, nomfichier from photo where nohotel = $nohotel");
		$reqresult->execute();
		return $reqresult->fetchAll();
	}



	//Retourne les informations d'un hôtel
	public function getHotel($noHotel)
	{
		$requete = "select distinct hotel.nohotel, nom, adr1, adr2, cp, ville, tel, descourt, deslong, prix from hotel inner join equiper on equiper.nohotel=hotel.nohotel where hotel.nohotel=$noHotel";
		
		$reqresult = parent::getDb()->prepare($requete);
		$reqresult->execute();
		$unHotel = $reqresult->fetch();

		$unHotel["chambres"] = $this->getChambersHotel($noHotel);
		$unHotel["equipements"] = $this->getEquipementsHotel($noHotel);
		$unHotel["reservations"] = $this->getReservationsHotel($noHotel);
		$unHotel["photos"] = $this->getPhotosHotel($noHotel);
		return $unHotel;
    }

	// Retourne tous les id des hotels
	public function getAllIdHotel() {
		$reqresult = parent::getDb()->prepare("select nohotel from hotel");
		$reqresult->execute();
		return $reqresult->fetchAll(PDO::FETCH_COLUMN);
	}

	
	public function ColumnNameIsValid($columnName){
		// Vérifier si la colonne spécifiée est valide
		$allowedColumns = ["nohotel", "nom", "adr1", "adr2", "cp", "ville", "tel", "descourt", "deslong", "prix", "password"];

		if (in_array($columnName, $allowedColumns)) {
			return $columnName;
		}
		return "nohotel";
	}

	// Retourne les hotels d'une ville
	public function getHotelsVille($nomville) {
		$reqresult = parent::getDb()->prepare("select hotel.nohotel from hotel where ville like '%$nomville%'");
		$reqresult->execute();
		$lesHotels = $reqresult->fetchAll();
		return $lesHotels;
	}
}
//Absence volontaire de la balise fermeture php