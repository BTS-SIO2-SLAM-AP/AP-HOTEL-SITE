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
    public function saveReservation($nohotel = 0, $lesChambres = [], $mail = "", $datedebut = "", $datefin="")
	{
        if ($nohotel != 0) {
            try {
                $newNoRes = $this->getNewNoRes($nohotel);
                $reqsql = "insert into reservation values ()";
            
                $req = parent::getDb()->prepare($reqsql);
                $req->execute();

                $noResGlobale = $this->getNoResGlobale();
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
            $reqsql = "insert into reserve values(";
            foreach ($lesChambres as $uneChambre) {
                $reqsql .= "($noResGlobale, $nohotel, $uneChambre),";
            }
            $reqsql = substr($reqsql,0,-1).")";

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
        return $noRes;
    }
}