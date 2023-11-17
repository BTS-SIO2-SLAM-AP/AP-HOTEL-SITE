<?php
//MODELE EtuManager
//Permettant la gestion de la table ETUDIANT

require_once("DBModele.php"); 

class EtuManager extends DBModele
{
	//Retourne la liste des étudiants d'une classe
	public function getAllEtu($uncodcla)
	{
		$reqresult = parent::getDb()->prepare("select etunum, etunom, etupre, clacod from etudiant where clacod= :cla order by etunom, etupre");
		$reqresult->bindParam("cla",$uncodcla,PDO::PARAM_STR);
		$reqresult->execute();
		return $reqresult->fetchAll();
    }
	
	//Retourne un étudiant
    public function getEtu($unnum)
	{
		$reqresult = parent::getDb()->prepare("select etunum, etunom, etupre, clacod from etudiant where etunum= :num ");
		$reqresult->bindParam("num",$unnum,PDO::PARAM_INT);
		$reqresult->execute();
		return $reqresult->fetch();
    }
	
	//Ajoute un étudiant
	public function insertEtu($unnom, $unprenom, $uncodcla)
	{
		$reqresult = parent::getDb()->prepare("insert into etudiant (etunom,etupre,clacod) values (:nom, :prenom, :cla) ");
		$reqresult->bindParam("nom",$unnom,PDO::PARAM_STR);
		$reqresult->bindParam("prenom",$unprenom,PDO::PARAM_STR);
		$reqresult->bindParam("cla",$uncodcla,PDO::PARAM_STR);
		$res = $reqresult->execute();
		return $res;
    }
	
	//Supprime un étudiant
	public function deleteEtu($unnum)
	{
		$reqresult = parent::getDb()->prepare("delete from etudiant where etunum=:num");
		$reqresult->bindParam("num",$unnum,PDO::PARAM_INT);
		$res = $reqresult->execute();
		return $res;
    }
	
	//Modifie un étudiant
	public function updateEtu($unnum, $unnom, $unprenom, $uncodcla)
	{
		$reqresult = parent::getDb()->prepare("update etudiant set etunom=:nom, etupre=:prenom, clacod=:cla where etunum=:num ");
		$reqresult->bindParam("nom",$unnom,PDO::PARAM_STR);
		$reqresult->bindParam("prenom",$unprenom,PDO::PARAM_STR);
		$reqresult->bindParam("cla",$uncodcla,PDO::PARAM_STR);
		$reqresult->bindParam("num",$unnum,PDO::PARAM_STR);
		$res = $reqresult->execute();
		return $res;
    }
}
//Absence volontaire de la balise fermeture php