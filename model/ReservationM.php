<?php
//MODELE HotelM
//Permettant la gestion de la table HOTEL

require_once("DBModel.php"); 

class ReservationM extends DBModel
{
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
                $this->saveChambresReservation($noResGlobale, $nohotel, $lesChambres);
            }catch (Exception $e) {
                return false;
            }
            return true;
        }
        return false;
    }

    public function saveChambresReservation($noResGlobale = 0, $nohotel = 0, $lesChambres = [])
	{
        try {
            $reqsql = "insert into reserver values ";
            foreach ($lesChambres as $uneChambre) {
                $reqsql .= "($nohotel, $uneChambre, $noResGlobale),";
            }
            $reqsql = substr($reqsql,0,-1);
            $req = parent::getDb()->prepare($reqsql);
            $req->execute();
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