<?php
namespace ASCII\Controller;

use ASCII\Http\Response;

abstract class Controller
{
    
    protected $response;
    
    protected $isSuperAdmin = false;
    protected $isAdmin = false;
    protected $isUser = false;
    
    public function __construct()
    {
        $this->response = new Response();
        session_start();
        
        if(!array_key_exists("token", $_SESSION)) {
            $_SESSION["token"] = password_hash(uniqid(), PASSWORD_DEFAULT);
        } elseif (
            array_key_exists("user", $_SESSION)
                && $_SESSION["user"]["ip"] !== filter_input(INPUT_SERVER, "REMOTE_ADDR")
                && $_SESSION["user"]["userAgent"] !== filter_input(INPUT_SERVER, "HTTP_USER_AGENT")
            ) {
           echo("Do not try to rob one's user session.");
        }
    }
    
    // protected est accessible uniquement par cette class ET ses heritiers
    protected function getTemplateName(string $templateName): string
    {
        return __DIR__ . "/../../app/views/" . $templateName . ".php";
    }
    
    protected function render(string $templateName, array $data): Response
    {
        $template = $this->getTemplateName($templateName);
        
        if (is_file($template)) {
            // permet d'utiliser $data (le modele, $model) dans le php affiche par le render
            extract($data);
            // on declare un tampon
            ob_start();
            // on peut inclure sans affichage non controle de la page
            include $template;
            // on recupere le contenu du tampon
            $output = ob_get_contents();
            // on ferme le tampon (sans afficher le reste du tampon)
            // pour fermer le tampon en affichant le reste : flush
            ob_end_clean();
            $this->response->setBody($output);
            return $this->response;
        }
        throw new \Exception("Erreur : . $templateName . is not a file");
    }
    
    protected function initializePrivilege(){
        if (array_key_exists("user", $_SESSION)) {
            switch ($_SESSION["user"]["level"]) {
                case "superadmin":
                    $this->isSuperAdmin = true;
                    break;
                case "admin":
                    $this->isAdmin = true;
                    break;
                case "user":
                    $this->isUser = true;
                    break;
            }
        }
    }
    
    protected function userRedirection() {
        // si on n'est pas admin ou superadmin, on est redirige vers l'authentification
        if(! $this->isSuperAdmin && ! $this->isAdmin) {
            $this->response->addHeader("location", "/ASCII/web/auth?action=auth");
            return $this->response;
        }
    }
}
