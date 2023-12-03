<?php
//MODELE HotelM
//Permettant la gestion de la table HOTEL

require_once("DBModel.php"); 

class ReservationM extends DBModel
{
    // Retourne toutes les informations d'une réservation en fonction de son numéro
    public function getReservation($noresglobale)
    {
        $reqresult = parent::getDb()->prepare("select noresglobale, nohotel, nores, datedeb, datefin, nom, email, codeacces from reservation where noresglobale = $noresglobale");
        $reqresult->execute();
        $uneReservation = $reqresult->fetch();
        $uneReservation["chambres"] = $this->getChambresReservation($noresglobale);
        return $uneReservation;
    }

    // Retourne toutes les chambres d'une réservation en fonction de son numéro
    public function getChambresReservation($noresglobale)
    {
        $reqresult = parent::getDb()->prepare("select reserver.nochambre from reserver inner join reservation on reserver.noresglobale = reservation.noresglobale where reservation.noresglobale=$noresglobale;");
        $reqresult->execute();
        return $reqresult->fetchAll();
    }

    // Retourne tous les numéros de réservation
    public function getAllIdReservation()
    {
        $reqresult = parent::getDb()->prepare("select noresglobale from reservation");
        $reqresult->execute();
        return $reqresult->fetchAll(PDO::FETCH_COLUMN);
    }

    // Retourne le numéro de réservation suivant
    public function getNewNoRes($nohotel=0)
	{
        $newNoRes = null;
        if ($nohotel != 0) {
            $req = parent::getDb()->prepare("select MAX(nores) as nores from reservation where nohotel=$nohotel");
            $req->execute();
            $result = $req->fetch();
            $newNoRes = $result["nores"] + 1;
        }
		return $newNoRes;
    }

	//Retourne la liste complète des hôtels
    public function saveReservation($nohotel, $lesChambres, $datedebut, $datefin, $nom, $mail, $codeacces)
	{
        if ($nohotel != null) {
            try {
                $newNoRes = $this->getNewNoRes($nohotel);

                $reqsql = "insert into reservation(nohotel, nores, datedeb,datefin, nom, email, codeacces) values ($nohotel, $newNoRes, '$datedebut', '$datefin', '$nom', '$mail', '$codeacces')";
                $req = parent::getDb()->prepare($reqsql);
                $req->execute();

                $noResGlobale = parent::getDb()->lastInsertId();
                $reqChambreHasWorked = $this->saveChambresReservation($noResGlobale, $nohotel, $lesChambres);
            }catch (Exception $e) {
                return false;
            }
            return $reqChambreHasWorked ? $noResGlobale : 0;
        }
        return 0;
    }

    public function saveChambresReservation($noResGlobale = 0, $nohotel = 0, $lesChambres = [])
	{
        try {
            // si la liste de chambres n'est pas vide
            if (count($lesChambres) != 0) {
                $reqsql = "insert into reserver values ";
                foreach ($lesChambres as $uneChambre) {
                    $reqsql .= "($nohotel, $uneChambre, $noResGlobale),";
                }
                $reqsql = substr($reqsql,0,-1);
                $req = parent::getDb()->prepare($reqsql);
                $req->execute();
            } 
            else return false;
        }catch (Exception $e) {
            return false;
        }
        return true;
    }

    public function getNoResGlobale(){
        $noRes = parent::getDb()->prepare("SELECT SCOPE_IDENTITY() AS last_id");
        $noRes->execute();
        $noRes = $noRes->fetch();
        return $noRes["last_id"];
    }
}