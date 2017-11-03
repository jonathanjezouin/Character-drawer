<?php
use ASCII\Entity\User;
use ASCII\Http\Response;
use ASCII\Manager\Manager;
use ASCII\Entity\UserLevel;

require_once "./../vendor/autoload.php";

// Paragraphe pour insertion facile

// $user = Manager::getDoctrine()->getRepository(User::class)->findOneBy([
//     "userMail" => "toto@gmail.com"
// ]);

// $user = new User();
// $user->setUserMail("totoSuperAdm@adm.com");
// $user->setUserPassword("pswd");

// $lvl = new UserLevel();
// $lvl->setUserLevelName("superadmin");
// $user->setUserLevel($lvl);

// Manager::getDoctrine()->persist($user);
// Manager::getDoctrine()->flush();

// exit;

// Fin paragraphe pour insertion facile

try {
    
    // on recupere la variable redirect_url de la supervariable INPUT_SERVER
    $url = (string) filter_input(INPUT_SERVER, "REDIRECT_URL");
    
    // on associe des url a des classes controller
    // on recupere la valeur de action depuis la supervariable INPUT_GET
    // ici, on ne recupere que des string
    // on cast en string pour plus de securite
    $action = (string) filter_input(INPUT_GET, "action");
    
    $pathJson = __DIR__ . "/../app/routes.json";
    // on lit le json ou sont enregistrees les routes
    if (! ($jsonText = file_get_contents($pathJson))) {
        echo "<h1>Erreur : Pas de json " . $pathJson . "</h1>";
        exit();
    }
    if (! ($jsonObj = json_decode($jsonText))) {
        echo "<h1>Erreur : Probleme de formatage du json " . $pathJson . "</h1>";
        exit();
    }
    $route = $jsonObj;
    
    // quand on trouve une url, on instancie le controller correspondant
    foreach ($route as $routeUrl => $className) {
        $routeUrlPropre = str_replace("/", "\/", $routeUrl);
        $classNamePropre = str_replace("/", "\\", $className);
        if (preg_match("/" . $routeUrlPropre . "/", $url)) {
            $controller = new $classNamePropre();
            if (method_exists($controller, $action)) {
                $response = $controller->{$action}();
                // ici on appelle la methode "$action" de controller
                break;
            }
        }
    }
    if (! isset($response)) {
        $response = new Response();
        $response->setStatus(404, "Not Found");
        $response->setBody("Aucune route ne correspond");
    }
    header($response->getStatus());
    foreach ($response->getHeader() as $key => $value) {
        header($key . ": " . $value);
    }
    echo $response->getBody();
} catch (Throwable $e) {
    header("HTTP/1.1 500 Internal Server Error");
    echo "<h1>Erreur : </h1>" . $e;
}
