<?php
//MODELE ChambreM
//Permettant la gestion de la table Chambre

require_once("DBModel.php");
require_once("HotelM.php");

class ChambreM extends DBModel
{
    //Retourne toutes les chambres d'un hôtel
    public function getChambresHotel($nohotel)
    {
        try {
            $requete =  "select nochambre from chambre " .
            "where nohotel = :nohotel order by nochambre";

        $result = parent::getDb()->prepare($requete);
        $result->bindParam(":nohotel", $nohotel, PDO::PARAM_INT);
        $result->execute();

        $lesChambres = $result->fetchAll();

        foreach ($lesChambres as &$uneChambre) {
            $ReservationM = new ReservationM();
            $uneChambre["reservations"] = $ReservationM->getReservationsChambre($nohotel, $uneChambre["nochambre"]);
        }

        return $lesChambres;
        }
        catch (Exception $ex) {
            return null;
        }
    }

    // Retourne toutes les chambres d'une réservation en fonction de son numéro
    public function getChambresReservation($noresglobale)

    {
        try {
            $requete =  "select reserver.nochambre from reserver " .
            "inner join reservation on reserver.noresglobale = reservation.noresglobale " .
            "where reservation.noresglobale = :noresglobale order by nochambre;";

        $result = parent::getDb()->prepare($requete);
        $result->bindParam(":noresglobale", $noresglobale, PDO::PARAM_INT);
        $result->execute();

        return $result->fetchAll();
        }
        catch (Exception $ex) {
           return null;
        }
    }

    // Retourne la liste complète des chambres disponibles pour une date donnée (début et fin de séjour) de l'hotel passé en paramètre
    public function getChambresDispo($nohotel, $datedebut, $datefin)
    {
        try{
            $requete =  " SELECT nochambre FROM chambre
            WHERE nohotel = :nohotel
            AND   nochambre NOT IN ( SELECT nochambre FROM reserver
                                                     WHERE nohotel=:nohotel
                                                     AND (         (datedeb<='$datedebut') AND (datefin>='$datedebut')
                                                                 OR (datedeb<'$datefin') AND (datefin>'$datefin')
                                                                 OR (datedeb>='$datedebut') AND (datefin<'$datefin')
                                                             )      )  ";
    
            $result = parent::getDb()->prepare($requete);
            $result->bindParam(":nohotel", $nohotel, PDO::PARAM_INT);
            $result->execute();
            return $result->fetchAll();
        }
        catch (Exception $ex)
        {
            return null;
        }        
    }

    // Retourne la liste complète des chambres de l'hotel passé en paramètre
    public function getAllChambres($nohotel)
    {
        try {
            $requete =  "select nochambre from chambre " .
            "where nohotel = :nohotel order by nochambre";

        $result = parent::getDb()->prepare($requete);
        $result->bindParam(":nohotel", $nohotel, PDO::PARAM_INT);
        $result->execute();

        $lesChambres = $result->fetchAll();

        // On parcourt les chambres
        foreach ($lesChambres as &$uneChambre) {
            $ReservationM = new ReservationM();
            $uneChambre["reservations"] = $this->getReservationsChambreDate($nohotel, $uneChambre["nochambre"]);
        }

        return $lesChambres;
        }
        catch (Exception $ex)
        {
            return null;
        }    
}

    // Retourne la date debut et la date fin des réservations d'une chambre
    public function getReservationsChambreDate($nohotel, $nochambre)
    {
        try {
            $requete =  "select datedeb, datefin from reserver " .
            "inner join reservation on reservation.noresglobale = reserver.noresglobale ".
            "where reservation.nohotel = :nohotel and nochambre = :nochambre";

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

}
