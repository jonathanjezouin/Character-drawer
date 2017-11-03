<?php
namespace ASCII\Manager;

use PDO;

// Class singleton pour stocker la requête en base (dbh)
// et eviter qu'elle ne multiplie les threads
class Manager
{

    private static $instance;

    private $dbh;

    private function __construct()
    {}

    public static function getInstance(): Manager
    {
        // Si l'instance n'est pas instanciee, on le fait
        if (null === Manager::$instance) {
            Manager::$instance = new Manager();
        }
        // Dans tous les cas, on retourne une instance
        return Manager::$instance;
    }

    public static function getPDO()
    {
        // si une instance existe deja, on la retourne
        if (Manager::getInstance()->dbh) {
            return Manager::$instance->dbh;
        }
        
        // sinon, on la cree a partir d'un json config.json
        // apres verification que le json existe
        if (! ($jsonText = file_get_contents(__DIR__ . "/../../app/config.json"))) {
            throw new \Exception("Le fichier " . __DIR__ . "/../../app/config.json est introuvable ou vide.");
        }
        // apres verification que json existe et est bien convertible en objet json
        if (! ($jsonObj = json_decode($jsonText))) {
            throw new \Exception("Le fichier " . __DIR__ . "/../../app/config.json est incorrect (json attendu avec dsn, user et pswd.");
        }
        
        // PDO : point de connection à la base
        // 4 arguments :
        // - driver et host
        $dsn = $jsonObj->dsn;
        // - (optionnel) user
        $user = $jsonObj->user;
        // - (optionnel) password
        $password = $jsonObj->pswd;
        // - (optionnel) options
        // $options = "?";
        
        var_dump($user);
        
        Manager::getInstance()->dbh = new PDO($dsn, $user, $password);
        
        // on configure l'objet PDO pour qu'il remonte des exceptions
        // (à faire à chaque fois qu'on utilise PDO)
        Manager::getInstance()->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        return Manager::$instance->dbh;
    }
}
