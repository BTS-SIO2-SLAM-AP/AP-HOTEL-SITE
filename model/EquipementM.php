<?php
//MODELE EquipementM
//Permettant la gestion de la table EQUIPEMENT

require_once("DBModel.php"); 
require_once("HotelM.php");

class EquipementM extends DBModel
{
    //Retourne la liste complète des equipements
    public function getAllEquipement()
	{
		$reqresult = parent::getDb()->prepare("select noequ, lib, imgequ from equipement order by noequ");
		$reqresult->execute();
		$lesEquipements = $reqresult->fetchAll();
		foreach ($lesEquipements as &$unEquipement) {
			$unEquipement["hotels"] = $this->getHotelsEquipement($unEquipement["noequ"]);
		}
		return $lesEquipements;
    }

    //Retourne les hotels d'un equipement
    public function getHotelsEquipement($noequ)
    {
        $reqresult = parent::getDb()->prepare("select hotel.nohotel from hotel inner join equiper on hotel.nohotel = equiper.nohotel where noequ = $noequ");
        $reqresult->execute();
        $lesHotels = $reqresult->fetchAll();
		return $lesHotels;
    }
}