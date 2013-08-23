<?php
/*
Planning Biblio, Version 1.5.2
Licence GNU/GPL (version 2 et au dela)
Voir les fichiers README.txt et COPYING.txt
Copyright (C) 2011-2013 - Jérôme Combes

Fichier : personnel/class.personnel.php
Création : 16 janvier 2013
Dernière modification : 23 juillet 2013
Auteur : Jérôme Combes, jerome@planningbilbio.fr

Description :
Classe personnel : contient la fonction personnel::fetch permettant de rechercher les agents. 
personnel::fetch prend en paramètres $tri (nom de la colonne), $actif (string), $name (string, nom ou prenom de l'agent)

Page appelée par les autres fichiers du dossier personnel
*/

// pas de $version=acces direct aux pages de ce dossier => redirection vers la page index.php
if(!$version){
  header("Location: ../index.php");
}

class personnel{
  public $elements=array();

  public function personnel(){
  }

  public function fetch($tri="nom",$actif=null,$name=null){
    //	Select All with filter "actif"
    $actif=htmlentities($actif,ENT_QUOTES|ENT_IGNORE,"UTF-8",false);
    $actif=$actif?"`actif`='$actif'":null;
    $filter=$actif?"supprime<>'1' AND $actif":"supprime<>'1'";
    $db=new db();
    $db->select("personnel",null,$filter,"ORDER BY $tri");
    $all=$db->result;
    if(!$db->result)
      return false;

    //	By default $result=$all
    $result=array();
    foreach($all as $elem){
      $result[$elem['id']]=$elem;
    }

    //	If name, keep only matching results
    if($name){
      $result=array();
      foreach($all as $elem){
	if(pl_stristr($elem['nom'],$name) or pl_stristr($elem['prenom'],$name)){
	  $result[$elem['id']]=$elem;
	}
      }
    }
  
    //	Suppression de l'utilisateur "Tout le monde"
    if(!$GLOBALS['config']['toutlemonde']){
      unset($result[2]);
    }

    $this->elements=$result;
  }


  public function fetchById($id){
    $db=new db();
    $db->select("personnel",null,"id='$id'");
    $this->elements=$db->result;
  }
}
?>