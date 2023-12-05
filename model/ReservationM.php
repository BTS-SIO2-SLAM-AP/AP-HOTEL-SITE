<?php
//MODELE HotelM
//Permettant la gestion de la table HOTEL

require_once("DBModel.php"); 
require_once("ChambreM.php");

class ReservationM extends DBModel
{
    // Retourne toutes les informations d'une réservation en fonction de son numéro
    public function getReservation($noresglobale)
    {
        $requete =  "select noresglobale, nohotel, nores, datedeb, datefin, nom, email, codeacces from reservation ".
                    "where noresglobale = :noresglobale";

        $result = parent::getDb()->prepare($requete);
        $result->bindParam(":noresglobale",$noresglobale,PDO::PARAM_INT);
        $result->execute();

        $uneReservation = $result->fetch();
        $ChambreM = new ChambreM();
        $uneReservation["chambres"] = $ChambreM->getChambresReservation($noresglobale);

        return $uneReservation;
    }

    // Retourne toutes les réservations d'un hôtel
	public function getReservationsHotel($nohotel) {
        $requete =  "select noresglobale, nohotel, nores, datedeb, datefin, nom, email, codeacces from reservation ".
                    "where nohotel = :nohotel";

		$result = parent::getDb()->prepare($requete);
        $result->bindParam(":nohotel",$nohotel,PDO::PARAM_INT);
		$result->execute();

		$lesReservations = $result->fetchAll();
		foreach ($lesReservations as &$uneReservation) {
            $ChambreM = new ChambreM();
			$uneReservation["chambres"] = $ChambreM->getChambresReservation($uneReservation["noresglobale"]);
		}

		return $lesReservations;
	}

    // Retourne toutes les réservations d'une chambre
	public function getReservationsChambre($nohotel, $nochambre) 
    {
        $requete =  "select reservation.noresglobale, reservation.nohotel, nores, datedeb, datefin, nom, email, codeacces from reservation ".
                    "inner join reserver on reservation.noresglobale = reserver.noresglobale ".
                    "where reservation.nohotel = :nohotel and nochambre = :nochambre;";
		
        $result = parent::getDb()->prepare($requete);
        $result->bindParam(":nohotel",$nohotel,PDO::PARAM_INT);
        $result->bindParam(":nochambre",$nochambre,PDO::PARAM_INT);
		$result->execute();

		return $result->fetchAll();
	}

    // Retourne tous les numéros de réservation
    public function getAllIdReservation()
    {
        $requete = "select noresglobale from reservation";

        $result = parent::getDb()->prepare($requete);
        $result->execute();

        return $result->fetchAll(PDO::FETCH_COLUMN);
    }

    // Retourne le numéro de réservation suivant
    public function getNewNoRes($nohotel=0)
	{
        if ($nohotel != 0) {
            $requete =  "select MAX(nores) as nores from reservation ".
                        "where nohotel = :nohotel";

            $result = parent::getDb()->prepare($requete);
            $result->bindParam(":nohotel",$nohotel,PDO::PARAM_INT);
            $result->execute();

            $newNoRes = $result->fetch()["nores"] + 1;
        } else {
            $newNoRes = null;
        }

		return $newNoRes;
    }

	//Retourne la liste complète des hôtels
    public function saveReservation($nohotel, $lesChambres, $datedebut, $datefin, $nom, $email, $codeacces)
	{
        if ($nohotel != null) {
            try {
                $requete =  "insert into reservation(nohotel, nores, datedeb, datefin, nom, email, codeacces) ".
                            "values (:nohotel, :nores, :datedeb, :datefin, :nom, :email, :codeacces)";
                
                $result = parent::getDb()->prepare($requete);
                $result->bindParam(":nohotel",$nohotel,PDO::PARAM_INT);
                $newNoRes = $this->getNewNoRes($nohotel);
                $result->bindParam(":nores",$newNoRes,PDO::PARAM_INT);
                $datedebut = date("d-m-Y", strtotime($datedebut));
                $result->bindParam(":datedeb",$datedebut,PDO::PARAM_STR);
                $datefin = date("d-m-Y", strtotime($datefin));
                $result->bindParam(":datefin",$datefin,PDO::PARAM_STR);
                $result->bindParam(":nom",$nom,PDO::PARAM_STR);
                $result->bindParam(":email",$email,PDO::PARAM_STR);
                $result->bindParam(":codeacces",$codeacces,PDO::PARAM_STR);
                $result->execute();

                $noResGlobale = parent::getDb()->lastInsertId();
                $reqChambreHasWorked = $this->saveChambresReservation($nohotel, $lesChambres, $noResGlobale);
            }catch (Exception $e) {
                return false;
            }

            return $reqChambreHasWorked ? $noResGlobale : 0;
        }
        return 0;
    }

    public function saveChambresReservation($nohotel = 0, $lesChambres = [], $noResGlobale = 0)
	{
        try {
            // si la liste de chambres n'est pas vide
            if (count($lesChambres) != 0) {
                $requete = "insert into reserver values ";
                foreach ($lesChambres as $uneChambre) {
                    $requete .= "($nohotel, $uneChambre, $noResGlobale),";
                }
                $requete = substr($requete,0,-1);

                $result = parent::getDb()->prepare($requete);
                // $result->bindParam(":nohotel",$nohotel,PDO::PARAM_INT);
                // $result->bindParam(":noresglobale",$noResGlobale,PDO::PARAM_INT);
                $result->execute();
            } 
            else return false;
        }catch (Exception $e) {
            return false;
        }

        return true;
    }
}