<?php
namespace ASCII\Model;

use ASCII\Manager\Manager;
use PDO;

class SymbsModel
{

    public function select()
    {
        try {
            $sql = "SELECT `symbols_id`, `symbols_unicode_name`, `symbols_unicode_value` FROM `symbols`";
            
            // on prépare la requete, a partir d'un singleton du manager
            $sth = Manager::getPDO()->prepare($sql);
            $sth->execute();
            $this->results = $sth->fetchAll(PDO::FETCH_OBJ);
        } catch (\Throwable $e) {
            $this->error = "Error de select";
        }
    }

    public function create(string $symbsUniName, string $symbsUniValue)
    {
        if (! $symbsUniName || ! $symbsUniValue) {
            return;
        }
        
        try {
            // on utilise des cles pour agir sur la requete
            $sql = "INSERT INTO `symbols` (`symbols_unicode_name`, `symbols_unicode_value`) VALUES (:cle_name,:cle_value)";
            
            // on prépare la requete, a partir d'un singleton du manager
            $sth = Manager::getPDO()->prepare($sql);
            $sth->bindValue(":cle_name", $symbsUniName);
            $sth->bindValue(":cle_value", $symbsUniValue);
            $sth->execute();
            $this->success = "Success : " . $symbsUniName . " has been created.";
        } catch (\Throwable $e) {
            $this->error = "Error : " . $symbsUniName . " insertion has failed - " . $e->getMessage();
        }
    }

    public function delete(string $symbsId)
    {
        if (! $symbsId) {
            return;
        }
        
        try {
            // on utilise des cles pour agir sur la requete
            $sql = "DELETE FROM `symbols` WHERE `symbols_id` = :cle_id";
            
            // on prépare la requete, a partir d'un singleton du manager
            $sth = Manager::getPDO()->prepare($sql);
            $sth->bindValue(":cle_id", $symbsId);
            $sth->execute();
            
            $this->success = "Success !";
        } catch (\Throwable $e) {
            $this->error = "Error : symbole id " . $symbsId . " delete has failed - " . $e->getMessage();
        }
    }
}
