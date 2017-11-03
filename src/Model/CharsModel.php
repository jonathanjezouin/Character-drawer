<?php
namespace ASCII\Model;

use ASCII\Manager\Manager;
use PDO;

class CharsModel
{

    public function select()
    {
        try {
            $sql = "SELECT `characters_id`, `characters_unicode_name`, `characters_unicode_value` FROM `characters` ORDER BY `characters_unicode_name`";
            
            // on prépare la requete, a partir d'un singleton du manager
            $sth = Manager::getPDO()->prepare($sql);
            $sth->execute();
            $this->results = $sth->fetchAll(PDO::FETCH_OBJ);
        } catch (\Throwable $e) {
            $this->error = "Error de select " . $e->getMessage();
        }
    }

    public function create(string $charsUniName, string $charsUniValue)
    {
        if (! $charsUniName || ! $charsUniValue) {
            return;
        }
        
        try {
            // on utilise des cles pour agir sur la requete
            $sql = "INSERT INTO `characters` (`characters_unicode_name`, `characters_unicode_value`) VALUES (:cle_name,:cle_value)";
            
            // on prépare la requete, a partir d'un singleton du manager
            $sth = Manager::getPDO()->prepare($sql);
            $sth->bindValue(":cle_name", $charsUniName);
            $sth->bindValue(":cle_value", $charsUniValue);
            $sth->execute();
            $this->success = "Success : " . $charsUniName . " has been created.";
        } catch (\Throwable $e) {
            $this->error = "Error : " . $charsUniName . " insertion has failed - " . $e->getMessage();
        }
    }

    public function delete(string $charsId)
    {
        if (! $charsId) {
            return;
        }
        
        try {
            // on utilise des cles pour agir sur la requete
            $sql = "DELETE FROM `characters` WHERE `characters_id` = :cle_id";
            
            // on prépare la requete, a partir d'un singleton du manager
            $sth = Manager::getPDO()->prepare($sql);
            $sth->bindValue(":cle_id", $charsId);
            $sth->execute();
            $this->success = "Success !";
        } catch (\Throwable $e) {
            $this->error = "Error : character id " . $charsId . " delete has failed - " . $e->getMessage();
        }
    }
}
