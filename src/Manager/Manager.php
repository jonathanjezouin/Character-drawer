<?php

namespace ASCII\Manager;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use stdClass;
use PDO;
use Exception;

class Manager
{

    private static $instance;

    private $doctrine;

    private function __construct()
    { 
    }

    private function getConfiguration(): stdClass
    {
        $fileName = __DIR__ . "/../../app/config.json";
        if (!is_file($fileName)) {
            throw new Exception("config.json must exists in app");
        } else if (!($jsonText = file_get_contents($fileName))) {
            throw new Exception("Can't read config.json");
        } else if (!($json = json_decode($jsonText))) {
            throw new Exception("config.json mal formed");
        } else if (!isset($json->dsn)
            || !isset($json->user)
            || !isset($json->pswd)) {
                throw new Exception("config.json must have dsn, user and pswd");
        }
       return $json;
    }

    public static function getInstance(): Manager
    {
        if (null === Manager::$instance) {
            Manager::$instance = new Manager;
        }
        return Manager::$instance;
    }

    public static function getPDO(): PDO
    {
        return Manager::getDoctrine()
               ->getConnection()
               ->getWrappedConnection();
    }

    public static function getDoctrine(): EntityManager
    {
        if (Manager::getInstance()->doctrine) {
            return Manager::$instance->doctrine;
        }
        $path = [__DIR__."/../Entity"];
        $config = Manager::$instance->getConfiguration();
        Manager::$instance->doctrine = EntityManager::create(
            [
                'driver'   => 'pdo_mysql',
                'user'     => $config->user,
                'password' => $config->pswd,
                'host'     => $config->host,
                'dbname'   => $config->dbname,
                "enum"     => "string",
            ],
//             Setup::createXMLMetadataConfiguration($path, false)
            Setup::createAnnotationMetadataConfiguration(
                $path,
                false,
                null,
                null,
                false
            )
        );
        return Manager::getDoctrine();
    }

}
