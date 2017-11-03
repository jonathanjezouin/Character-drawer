<?php
namespace ASCII\Controller\Admin;

use ASCII\Controller\Controller;
use ASCII\Model\CharsFontModel;
use ASCII\Model\FontsModel;

class FontsController extends Controller
{
    public function read()
    {
        $this->initializePrivilege();
        $this->userRedirection();
        
        $model = new FontsModel();
        $model->autorisation = ($this->isSuperAdmin) ? "OK" : "KO";
        $model->select();
        
        $url = filter_input(INPUT_SERVER, "REDIRECT_URL");

        return $this->render("fonts/read", [
            "token" => array_key_exists("token", $_SESSION) ? $_SESSION["token"] : null,
            "userLevel" => array_key_exists("user", $_SESSION) ? $_SESSION["user"]["level"] : null,
            "model" => $model
        ]);
    }

    public function create()
    {
        $this->initializePrivilege();
        $this->userRedirection();
        
        $model = new FontsModel();
        $model->autorisation = ($this->isSuperAdmin) ? "OK" : "KO";
        
        if($this->isSuperAdmin) {
            $model->create((string) filter_input(INPUT_POST, "fonts_name"), (int) filter_input(INPUT_POST, "fonts_height"));
        }
        
        return $this->render("fonts/create", [
            "token" => array_key_exists("token", $_SESSION) ? $_SESSION["token"] : null,
            "userLevel" => array_key_exists("user", $_SESSION) ? $_SESSION["user"]["level"] : null,
            "model" => $model
        ]);
    }
    
    public function manage()
    {
        $this->initializePrivilege();
        $this->userRedirection();
        
        $model = new FontsModel();
        $model->autorisation = ($this->isSuperAdmin) ? "OK" : "KO";
        
        // on recupere le nom de la font
        // dans l'url (propriete REDIRECT_URL de la superglobale $_SERVER
        // on retranche toute la partie fixe : /ASCII/.../fonts/
        $fontId = preg_split("/\/ASCII\/web\/admin\/fonts\//", filter_input(INPUT_SERVER, "REDIRECT_URL"))[1];
        
        $model->selectFontInfo((int) $fontId);
        
        $modelCharsFont = new CharsFontModel();
        if($this->isSuperAdmin) {
            $modelCharsFont->create((int) $fontId, (int) filter_input(INPUT_GET, "char_id"));
            $modelCharsFont->delete((int) $fontId, (int) filter_input(INPUT_GET, "delete_char_id"));
        }
        $modelCharsFont->selectCharsLinkedToFont((int) $fontId);
        $modelCharsFont->selectCharsNotLinkedToFont((int) $fontId);
        
        return $this->render("fonts/showFont", [
            "token" => array_key_exists("token", $_SESSION) ? $_SESSION["token"] : null,
            "userLevel" => array_key_exists("user", $_SESSION) ? $_SESSION["user"]["level"] : null,
            "model" => $model,
            "charsFont" => $modelCharsFont,
        ]);
    }
}
