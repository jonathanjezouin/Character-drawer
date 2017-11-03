<?php
namespace ASCII\Model;

use ASCII\Manager\Manager;
use PDO;

class CharsFontModel
{

    public function selectCharsLinkedToFont($fontId)
    {
        try {
            $sql = "SELECT `characters_id`, `characters_unicode_name`, `characters_unicode_value` "
                . "FROM `characters` "
                . "WHERE `characters_id` IN ("
                    . "SELECT `characters_id` FROM `character_font` "
                    . "WHERE `font_id` = :cle_font"
                . ") "
                . "ORDER BY `characters_unicode_name`";
            
            // on prepare la requete, a partir d'un singleton du manager
            $sth = Manager::getPDO()->prepare($sql);
            $sth->bindValue(":cle_font", $fontId);
            $sth->execute();
            $this->resultsLink = $sth->fetchAll(PDO::FETCH_OBJ);
        } catch (\Throwable $e) {
            $this->error = "Error de select " . $e->getMessage();
        }
    }
    
    public function selectCharsNotLinkedToFont($fontId)
    {
        try {
            $sql = "SELECT `characters_id`, `characters_unicode_name`, `characters_unicode_value` "
                . "FROM `characters` "
                . "WHERE `characters_id` NOT IN ("
                    . "SELECT `characters_id` FROM `character_font` "
                    . "WHERE `font_id` = :cle_font"
                . ") "
                . "ORDER BY `characters_unicode_name`";
                        
            // on prépare la requete, a partir d'un singleton du manager
            $sth = Manager::getPDO()->prepare($sql);
            $sth->bindValue(":cle_font", $fontId);
            $sth->execute();
            $this->resultsNoLink = $sth->fetchAll(PDO::FETCH_OBJ);
        } catch (\Throwable $e) {
            $this->error = "Error de select " . $e->getMessage();
        }
    }

    public function create(string $fontId, string $charId)
    {
        if (! $fontId || ! $charId) {
            return;
        }
        
        try {
            // on utilise des cles pour agir sur la requete
            $sql = "INSERT INTO `character_font` (`font_id`, `characters_id`) VALUES (:cle_font,:cle_char)";
            
            // on prepare la requete, a partir d'un singleton du manager
            $sth = Manager::getPDO()->prepare($sql);
            $sth->bindValue(":cle_font", $fontId);
            $sth->bindValue(":cle_char", $charId);
            $sth->execute();
            $this->success = "Success !";
        } catch (\Throwable $e) {
            $this->error = "Error : character_font insertion has failed - " . $e->getMessage();
        }
    }

    public function delete(string $fontId, string $charId)
    {
        if (! $fontId || ! $charId) {
            return;
        }
        
        try {
            // on utilise des cles pour agir sur la requete
            $sql = "DELETE FROM `character_font` WHERE `font_id` = :cle_font AND `characters_id` = :cle_char";
            
            // on prepare la requete, a partir d'un singleton du manager
            $sth = Manager::getPDO()->prepare($sql);
            $sth->bindValue(":cle_font", $fontId);
            $sth->bindValue(":cle_char", $charId);
            $sth->execute();
            $this->success = "Success !";
        } catch (\Throwable $e) {
            $this->error = "Error : character id " . $charsId . " delete has failed - " . $e->getMessage();
        }
    }
}
