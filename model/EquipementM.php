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
        $requete = "select noequ, lib, imgequ from equipement order by noequ";

		$result = parent::getDb()->prepare($requete);

		$result->execute();

		$lesEquipements = $result->fetchAll();

		foreach ($lesEquipements as &$unEquipement) {
			$unEquipement["hotels"] = $this->getHotelsEquipement($unEquipement["noequ"]);
		}

		return $lesEquipements;
    }

    // Retourne tous les équipements d'un hôtel
	public function getEquipementsHotel($nohotel) {
        $requete =  "select equipement.noequ as noequ, lib, imgequ from equiper ".
                    "inner join equipement on equiper.noequ = equipement.noequ ".
                    "where nohotel = :nohotel";

		$result = parent::getDb()->prepare($requete);
        $result->bindParam(":nohotel",$nohotel,PDO::PARAM_INT);
		$result->execute();

		return $result->fetchAll();
	}

    //Retourne les hotels d'un equipement
    public function getHotelsEquipement($noequ)
    {
        $requete =  "select hotel.nohotel from hotel ".
                    "inner join equiper on hotel.nohotel = equiper.nohotel ".
                    "where noequ = :noequ";
        
        $result = parent::getDb()->prepare($requete);
        $result->bindParam(":noequ",$noequ,PDO::PARAM_INT);
        $result->execute();

		return $result->fetchAll();
    }
}