<?php
namespace ASCII\Model;

use ASCII\Manager\Manager;
use PDO;

class FontsModel
{

    public function select()
    {
        try {
            $sql = "SELECT `font_id`, `font_name` FROM `font` ORDER BY `font_name`";
            
            // on prépare la requete, a partir d'un singleton du manager
            $sth = Manager::getPDO()->prepare($sql);
            $sth->execute();
            $this->results = $sth->fetchAll(PDO::FETCH_OBJ);
        } catch (\Throwable $e) {
            $this->error = "Error de select";
        }
    }

    public function create(string $fontsName, int $fontsHeight)
    {
        if (! $fontsName || ! $fontsHeight) {
            return;
        }
        
        try {
            
            // on utilise des cles pour agir sur la requete
            $sql = "INSERT INTO `font` (`font_name`, `font_height`) VALUES (:cle_name,:cle_height)";
            
            // on prépare la requete, a partir d'un singleton du manager
            $sth = Manager::getPDO()->prepare($sql);
            $sth->bindValue(":cle_name", $fontsName);
            $sth->bindValue(":cle_height", $fontsHeight);
            $sth->execute();
            $this->success = "Success : " . $fontsName . " has been created.";
        } catch (\Throwable $e) {
            $this->error = "Error : " . $fontsName . " insertion has failed - " . $e->getMessage();
        }
    }
    
    public function selectFontInfo(int $fontId)
    {
        try {
            $sql = "SELECT `font_id`, `font_name`, `font_height` FROM `font` WHERE `font_id` = :cle_id";
            
            // on prépare la requete, a partir d'un singleton du manager
            $sth = Manager::getPDO()->prepare($sql);
            $sth->bindValue(":cle_id", $fontId);
            $sth->execute();
            $this->results = $sth->fetchAll(PDO::FETCH_OBJ);
        } catch (\Throwable $e) {
            $this->error = "Error de select";
        }
    }
}
