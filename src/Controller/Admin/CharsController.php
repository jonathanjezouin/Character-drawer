<?php
namespace ASCII\Controller\Admin;

use ASCII\Controller\Controller;
use ASCII\Model\CharsModel;

class CharsController extends Controller
{
    public function manage()
    {
        $this->initializePrivilege();
        $this->userRedirection();
        
        $model = new CharsModel();
        $model->autorisation = ($this->isSuperAdmin) ? "OK" : "KO";
        // Action autorisees pour le superAdmin
        if ($this->isSuperAdmin) {
            $model->create((string) filter_input(INPUT_POST, "chars_uni_name"), (string) filter_input(INPUT_POST, "chars_uni_value"));
            $model->delete((string) filter_input(INPUT_GET, "unicode_to_delete"));
            // on definit sa possibilite a supprimer les caractes
        }
        $model->select();
        
        return $this->render("characters/manage", [
            "token" => array_key_exists("token", $_SESSION) ? $_SESSION["token"] : null,
            "userLevel" => array_key_exists("user", $_SESSION) ? $_SESSION["user"]["level"] : null,
            "model" => $model
        ]);
    }
}
