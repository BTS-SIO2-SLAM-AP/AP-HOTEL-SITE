<?php
//MODELE HotelM
//Permettant la gestion de la table HOTEL

require_once("DBModel.php"); 
require_once("ReservationM.php");
require_once("ChambreM.php");
require_once("EquipementM.php");

class HotelM extends DBModel
{
	// Retourne la liste complète des hôtels
    public function getAllHotel()
	{
		try {
			$requete = "select nohotel, nom, adr1, adr2, cp, ville, tel, descourt, deslong, prix from hotel order by nom";
		
			$result = parent::getDb()->prepare($requete);
			$result->execute();
	
			$lesHotels = $result->fetchAll();
			
			foreach ($lesHotels as &$unHotel) {
				$ChambreM = new ChambreM();
				$unHotel["chambres"] = $ChambreM->getChambresHotel($unHotel["nohotel"]);
				$EquipementM = new EquipementM();
				$unHotel["equipements"] = $EquipementM->getEquipementsHotel($unHotel["nohotel"]);
				$ReservationM = new ReservationM();
				$unHotel["reservations"] = $ReservationM->getReservationsHotel($unHotel["nohotel"]);
				$unHotel["photos"] = $this->getPhotosHotel($unHotel["nohotel"]);
			}
	
			return $lesHotels;
		}
		catch (Exception $ex) {
			return null;
		}
    }

	//Retourne les photos d'un hôtel
	public function getPhotosHotel($nohotel) {
		try {
			$requete = 	"select nophoto, nomfichier from photo ".
			"where nohotel = :nohotel";

			$result = parent::getDb()->prepare($requete);
			$result->bindParam(":nohotel",$nohotel,PDO::PARAM_INT);
			$result->execute();

			return $result->fetchAll();
		}
		catch (Exception $ex) {
			return null;
		}
		
	}

	//Retourne les informations d'un hôtel
	public function getHotel($nohotel)
	{
		try {
			$requete = 	"select distinct hotel.nohotel, nom, adr1, adr2, cp, ville, tel, descourt, deslong, prix from hotel ".
			"inner join equiper on equiper.nohotel=hotel.nohotel ".
			"where hotel.nohotel = :nohotel";

			$result = parent::getDb()->prepare($requete);
			$result->bindParam(":nohotel",$nohotel,PDO::PARAM_INT);
			$result->execute();

			$unHotel = $result->fetch();

			$ChambreM = new ChambreM();
			$unHotel["chambres"] = $ChambreM->getChambresHotel($nohotel);
			$EquipementM = new EquipementM();
			$unHotel["equipements"] = $EquipementM->getEquipementsHotel($nohotel);
			$ReservationM = new ReservationM();
			$unHotel["reservations"] = $ReservationM->getReservationsHotel($nohotel);
			$unHotel["photos"] = $this->getPhotosHotel($nohotel);

			return $unHotel;			
		}
		catch (Exception $ex) {
			return null;
		}
		
    }

	// Retourne tous les id des hotels
	public function getAllIdHotel() {
		try {
			$requete = "select nohotel from hotel";
		
			$result = parent::getDb()->prepare($requete);
			$result->execute();
	
			return $result->fetchAll(PDO::FETCH_COLUMN);
		}
		catch (Exception $ex) {
			return null;
		}
	}

	// Retourne la liste des villes
	public function getAllVille() {
		try{
			$requete = "select distinct ville from hotel order by ville";
			
			$result = parent::getDb()->prepare($requete);
			$result->execute();

			return $result->fetchAll(PDO::FETCH_COLUMN);
		} catch (Exception $ex) {
			return null;
		}
	}

	// Retourne le prix d'hotel le plus élévé
	public function getMaxPrice() {
		try {
			$requete = "select max(prix) as maxprice from hotel";

			$result = parent::getDb()->prepare($requete);
			$result->execute();
	
			return $result->fetch()["maxprice"];
		}
		catch (Exception $ex) {
			return null;
		}
	}
}
//Absence volontaire de la balise fermeture php