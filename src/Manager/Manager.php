<?php

namespace ASCII\Manager;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use PDO;

class Manager
{

    private static $instance;
    
    private $doctrine;

    private function __construct()
    {
        
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
        return $this->getDoctrine();
    }

}
