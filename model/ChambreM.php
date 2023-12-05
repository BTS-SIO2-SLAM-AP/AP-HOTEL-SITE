<?php
//MODELE ChambreM
//Permettant la gestion de la table Chambre

require_once("DBModel.php"); 
require_once("HotelM.php");

class ChambreM extends DBModel
{
    //Retourne toutes les chambres d'un hôtel
	public function getChambresHotel($nohotel) {
        $requete =  "select nochambre from chambre ".
                    "where nohotel = :nohotel order by nochambre";

		$result = parent::getDb()->prepare($requete);
        $result->bindParam(":nohotel",$nohotel,PDO::PARAM_INT);
		$result->execute();

		$lesChambres = $result->fetchAll();

		foreach ($lesChambres as &$uneChambre) {
            $ReservationM = new ReservationM();
			$uneChambre["reservations"] = $ReservationM->getReservationsChambre($nohotel, $uneChambre["nochambre"]);
		}

		return $lesChambres;
	}

    // Retourne toutes les chambres d'une réservation en fonction de son numéro
    public function getChambresReservation($noresglobale)
    {
        $requete =  "select reserver.nochambre from reserver ".
                    "inner join reservation on reserver.noresglobale = reservation.noresglobale ".
                    "where reservation.noresglobale = :noresglobale order by nochambre;";

        $result = parent::getDb()->prepare($requete);
        $result->bindParam(":noresglobale",$noresglobale,PDO::PARAM_INT);
        $result->execute();

        return $result->fetchAll();
    }

    // Retourne la liste complète des chambres disponibles pour une date donnée (début et fin de séjour) de l'hotel passé en paramètre
    public function getChambresDispo($nohotel, $datedebut, $datefin)
    {
        $requete =  "select nochambre from chambre ".
                    "where nohotel = :nohotel order by nochambre";

        $result = parent::getDb()->prepare($requete);
        $result->bindParam(":nohotel",$nohotel,PDO::PARAM_INT);
        $result->execute();

        $lesChambres = $result->fetchAll();

        foreach ($lesChambres as &$uneChambre) {
            $ReservationM = new ReservationM();
            $uneChambre["reservations"] = $ReservationM->getReservationsChambre($nohotel, $uneChambre["nochambre"]);
        }

        return $lesChambres;
    }
}