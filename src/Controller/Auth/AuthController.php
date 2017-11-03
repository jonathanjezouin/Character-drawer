<?php
namespace ASCII\Controller\Auth;

use ASCII\Controller\Controller;
use ASCII\Entity\User;
use ASCII\Manager\Manager;

class AuthController extends Controller
{

    public function auth()
    {
        try {
            $model = new \stdClass();
            
            $this->initializePrivilege();
            
            $dest = "auth/auth";
            
            // si c'est un user existant
            if(array_key_exists("user", $_SESSION) && ! $this->isSuperAdmin && ! $this->isAdmin) {
                throw new \Exception("Vous devez vous connecter en tant qu'admin ou superAdmin");
            }
            // on teste l'existence d'une saisie de login/password/toke
            // on teste aussi si le token envoye est bien celui fourni par la page
            // et pas un faux token
            if (
                    !($mail = filter_input(INPUT_POST, "user_login"))
                    || !($pswd = filter_input(INPUT_POST, "user_password"))
                    || !($token = filter_input(INPUT_POST, "token"))
                    || ($token !== $_SESSION["token"])
                )
            {
                throw new \RuntimeException;
            }
            
            // enfin on recherche le user correspondant au mail
            if (!($user = Manager::getDoctrine()
                            ->getRepository(User::class)
                            ->findOneBy(["userMail" => $mail])))
            {
                throw new \OutOfBoundsException;
            }
            
            // verification si le mot de passe est KO
            if(!password_verify($pswd, $user->getUserPassword())) {
                throw new \OutOfBoundsException;
            }
            
            // sinon affectation des privileges pour la session
            // on affecte dans la session les infos du server
            // HTTP_USER_AGENT : les infos sur le user (version navigateur,...)
            // REMOTE_ADDR : l'adresse ip du user
            // l'heure            
            $_SESSION["user"] = [
                "userAgent" => filter_input(INPUT_SERVER, "HTTP_USER_AGENT"),
                "ip" => filter_input(INPUT_SERVER, "REMOTE_ADDR"),
                "time" => time(),
                "id" => $user->getUserMail(),
                "level" => $user->getUserLevel()->getUserLevelName()
            ];
            $model->success = "Vous etes connecte";
            
            $dest = "auth/accueil";
            
//             return $this->render("auth/accueil", [
//                 "token" => array_key_exists("token", $_SESSION) ? $_SESSION["token"] : null,
//                 "userLevel" => array_key_exists("user", $_SESSION) ? $_SESSION["user"]["level"] : null,
//                 "model" => $model
//             ]);
            
        } catch (\OutOfBoundsException $out) {
            $erreur = "Bad credentials";
        } catch (\RuntimeException $runExc) {
            // si une saisie manque, on vient ici, mais on ne fait rien
        } catch (\Throwable $e) {
            $erreur = $e->getMessage();
        } finally {
            $model->error = isset($erreur) ? $erreur : null;
            // on passe dans le model :
            // le token
            // le level du user (permet juste de deteriner si un user est present)
            // le model, portant l'erreur
            return $this->render($dest, [
                "token" => array_key_exists("token", $_SESSION) ? $_SESSION["token"] : null,
                "userLevel" => array_key_exists("user", $_SESSION) ? $_SESSION["user"]["level"] : null,
                "model" => $model
            ]);
        }
    }

    public function destroy()
    {
        try {
            $model = new \stdClass();
            if(!array_key_exists("token", $_SESSION))
            {
                // on ne kill pas la session si le jeton n'est pas le bon
                throw new \Exception("You should not try");
            }
            
            // on kill la session
            // on en redemarre une de suite, on lui regenere un jeton
            // car le user est redirige vers la page d'auth
            // et il a donc besoin d'une session et d'un jeton lorsque cette page est creee
            if(array_key_exists("user", $_SESSION)) {
                session_destroy();
                $_SESSION = [];
                session_start();
                $_SESSION["token"] = password_hash(uniqid(), PASSWORD_DEFAULT);
                $model->success = "Deconnexion reussie";
            }
        } catch (\Throwable $e) {
            $model->error = $e->getMessage();
        } finally {
            return $this->render("auth/auth", [
                "token" => array_key_exists("token", $_SESSION) ? $_SESSION["token"] : null,
                "userLevel" => array_key_exists("user", $_SESSION) ? $_SESSION["user"]["level"] : null,
                "model" => $model
            ]);
        }
    }
    
    public function accueil()
    {
        $this->initializePrivilege();
        $this->userRedirection();
        return $this->render("auth/accueil", [
            "token" => array_key_exists("token", $_SESSION) ? $_SESSION["token"] : null,
            "userLevel" => array_key_exists("user", $_SESSION) ? $_SESSION["user"]["level"] : null
        ]);
    }
}
