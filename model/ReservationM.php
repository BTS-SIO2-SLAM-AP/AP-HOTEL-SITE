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
        try {
            $requete =  "select noresglobale, nohotel, nores, datedeb, datefin, nom, email, codeacces from reservation " .
            "where noresglobale = :noresglobale";

        $result = parent::getDb()->prepare($requete);
        $result->bindParam(":noresglobale", $noresglobale, PDO::PARAM_INT);
        $result->execute();

        // Check if a reservation was found
        $uneReservation = $result->fetch(PDO::FETCH_ASSOC);
        if (!$uneReservation) {
            return null; // Or handle as needed
        }

        $ChambreM = new ChambreM();
        $uneReservation["chambres"] = $ChambreM->getChambresReservation($noresglobale);

        return $uneReservation;
        }
        catch (Exception $ex) {
            return null;
        }
    }

    // Retourne si oui ou non une réservation existe
    public function isReservationExist($noresglobale, $codeacces)
    {
        try {
            $requete =  "select count(*) as nbRes from reservation " .
            "where noresglobale = :noresglobale and codeacces = :codeacces";

            $result = parent::getDb()->prepare($requete);
            $result->bindParam(":noresglobale", $noresglobale, PDO::PARAM_INT);
            $result->bindParam(":codeacces", $codeacces, PDO::PARAM_STR);
            $result->execute();

            return $result->fetch()["nbRes"] == 1;
        }
        catch (Exception $ex) {
            return null;
        }
    }

    // Retourne toutes les réservations d'un hôtel
    public function getReservationsHotel($nohotel)
    {
        try {
            $requete =  "select noresglobale, nohotel, nores, datedeb, datefin, nom, email, codeacces from reservation " .
            "where nohotel = :nohotel";

            $result = parent::getDb()->prepare($requete);
            $result->bindParam(":nohotel", $nohotel, PDO::PARAM_INT);
            $result->execute();

            $lesReservations = $result->fetchAll();
            foreach ($lesReservations as &$uneReservation) {
                $ChambreM = new ChambreM();
                $uneReservation["chambres"] = $ChambreM->getChambresReservation($uneReservation["noresglobale"]);
            }

            return $lesReservations;
        }
        catch (Exception $ex)
        {
            return null;
        }        
    }

    // Retourne toutes les réservations d'une chambre
    public function getReservationsChambre($nohotel, $nochambre)
    {
        try {
            $requete =  "select reservation.noresglobale, reservation.nohotel, nores, datedeb, datefin, nom, email, codeacces from reservation " .
            "inner join reserver on reservation.noresglobale = reserver.noresglobale " .
            "where reservation.nohotel = :nohotel and nochambre = :nochambre;";

            $result = parent::getDb()->prepare($requete);
            $result->bindParam(":nohotel", $nohotel, PDO::PARAM_INT);
            $result->bindParam(":nochambre", $nochambre, PDO::PARAM_INT);
            $result->execute();

            return $result->fetchAll();
        }
        catch (Exception $ex)
        {
            return null;
        }   
     }

    // Retourne tous les numéros de réservation
    public function getAllIdReservation()
    {
        try {
            $requete = "select noresglobale from reservation";

            $result = parent::getDb()->prepare($requete);
            $result->execute();
    
            return $result->fetchAll(PDO::FETCH_COLUMN);
        }
        catch (Exception $ex)
        {
            return null;
        }   
     }

    // Retourne le numéro de réservation suivant
    public function getNewNoRes($nohotel = 0)
    {
        try {
            if ($nohotel != 0) {
                $requete =  "select MAX(nores) as nores from reservation " .
                    "where nohotel = :nohotel";
    
                $result = parent::getDb()->prepare($requete);
                $result->bindParam(":nohotel", $nohotel, PDO::PARAM_INT);
                $result->execute();
    
                $newNoRes = $result->fetch()["nores"] + 1;
            } else {
                $newNoRes = null;
            }
    
            return $newNoRes;
        }
        catch (Exception $ex) {
            return null;
        }

    }

    //Retourne la liste complète des hôtels
    public function saveReservation($nohotel, $lesChambres, $datedebut, $datefin, $nom, $email, $codeacces)
    {
        try {
            if ($nohotel != null) {
                try {
                    $requete =  "insert into reservation(nohotel, nores, datedeb, datefin, nom, email, codeacces) " .
                        "values (:nohotel, :nores, :datedeb, :datefin, :nom, :email, :codeacces)";
    
                    $result = parent::getDb()->prepare($requete);
                    $result->bindParam(":nohotel", $nohotel, PDO::PARAM_INT);
                    $newNoRes = $this->getNewNoRes($nohotel);
                    $result->bindParam(":nores", $newNoRes, PDO::PARAM_INT);
                    $datedebut = date("d-m-Y", strtotime($datedebut));
                    $result->bindParam(":datedeb", $datedebut, PDO::PARAM_STR);
                    $datefin = date("d-m-Y", strtotime($datefin));
                    $result->bindParam(":datefin", $datefin, PDO::PARAM_STR);
                    $result->bindParam(":nom", $nom, PDO::PARAM_STR);
                    $result->bindParam(":email", $email, PDO::PARAM_STR);
                    $result->bindParam(":codeacces", $codeacces, PDO::PARAM_STR);
                    $result->execute();
    
                    $noResGlobale = parent::getDb()->lastInsertId();
                    $reqChambreHasWorked = $this->saveChambresReservation($nohotel, $lesChambres, $noResGlobale);
                } catch (Exception $e) {
                    return false;
                }
    
                return $reqChambreHasWorked ? $noResGlobale : 0;
            }
            return 0;
        }
        catch (Exception $ex) {
            return null;
        }
    }

    public function saveChambresReservation($nohotel = 0, $lesChambres = [], $noResGlobale = 0)
    {
        try {
            // si la liste de chambres n'est pas vide
            if (count($lesChambres) != 0) {
                foreach ($lesChambres as $uneChambre) {
                    $requete = "insert into reserver values (:nohotel, :nochambre, :noresglobale)";

                    $result = parent::getDb()->prepare($requete);
                    $result->bindParam(":nohotel",$nohotel,PDO::PARAM_INT);
                    $result->bindParam(":nochambre",$uneChambre,PDO::PARAM_INT);
                    $result->bindParam(":noresglobale",$noResGlobale,PDO::PARAM_INT);
                    $result->execute();
                }

            } else return false;
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    // Supprime une réservation
    public function deleteReservation($noresglobale, $codeacces)
    {
        try {
            if ($this->isReservationExist($noresglobale, $codeacces)){
                $deleteHasWork = $this->deleteChambresReservation($noresglobale);

                $requete = "delete from reservation where noresglobale = :noresglobale";

                $result = parent::getDb()->prepare($requete);
                $result->bindParam(":noresglobale", $noresglobale, PDO::PARAM_INT);
                $result->execute();
            }
        } catch (Exception $e) {
            return false;
        }

        return $deleteHasWork;
    }

    // Supprime les chambres d'une réservation
    public function deleteChambresReservation($noresglobale)
    {
        try {
            $requete = "delete from reserver where noresglobale = :noresglobale";

            $result = parent::getDb()->prepare($requete);
            $result->bindParam(":noresglobale", $noresglobale, PDO::PARAM_INT);
            $result->execute();
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}
