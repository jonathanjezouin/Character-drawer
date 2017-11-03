<?php
namespace ASCII\Controller\Admin;

use ASCII\Controller\Controller;
use ASCII\Model\SymbsModel;

class SymbsController extends Controller
{
    public function manage()
    {
        $this->initializePrivilege();
        $this->userRedirection();
        
        $model = new SymbsModel();
        $model->autorisation = ($this->isSuperAdmin) ? "OK" : "KO";
        
        if($this->isSuperAdmin) {
            $model->create((string) filter_input(INPUT_POST, "symbs_uni_name"), (string) filter_input(INPUT_POST, "symbs_uni_value"));
            $model->delete((string) filter_input(INPUT_GET, "unicode_to_delete"));
        }
        $model->select();
        
        return $this->render("symbols/manage", [
            "token" => array_key_exists("token", $_SESSION) ? $_SESSION["token"] : null,
            "userLevel" => array_key_exists("user", $_SESSION) ? $_SESSION["user"]["level"] : null,
            "model" => $model
        ]);
    }
}
