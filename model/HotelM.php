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
		$requete = "select nohotel, nom, adr1, adr2, cp, ville, tel, descourt, deslong, prix from hotel order by nom";
		
		$reqresult = parent::getDb()->prepare($requete);
		$reqresult->execute();
		$lesHotels = $reqresult->fetchAll();
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

	//Retourne les photos d'un hôtel
	public function getPhotosHotel($nohotel) {
		$requete = "select nophoto, nomfichier from photo where nohotel = $nohotel";

		$reqresult = parent::getDb()->prepare($requete);
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

		$ChambreM = new ChambreM();
		$unHotel["chambres"] = $ChambreM->getChambresHotel($noHotel);
		$EquipementM = new EquipementM();
		$unHotel["equipements"] = $EquipementM->getEquipementsHotel($noHotel);
		$ReservationM = new ReservationM();
		$unHotel["reservations"] = $ReservationM->getReservationsHotel($noHotel);
		$unHotel["photos"] = $this->getPhotosHotel($noHotel);

		return $unHotel;
    }

	// Retourne tous les id des hotels
	public function getAllIdHotel() {
		$requete = "select nohotel from hotel";
		
		$reqresult = parent::getDb()->prepare($requete);
		$reqresult->execute();

		return $reqresult->fetchAll(PDO::FETCH_COLUMN);
	}

	// Retourne le prix d'hotel le plus élévé
	public function getMaxPrice() {
		$requete = "select max(prix) as maxprice from hotel";

		$reqresult = parent::getDb()->prepare($requete);
		$reqresult->execute();

		return $reqresult->fetch()["maxprice"];
	}
}
//Absence volontaire de la balise fermeture php