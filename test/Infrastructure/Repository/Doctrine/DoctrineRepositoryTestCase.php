<?php

namespace Fradoos\Infrastructure\Repository\Doctrine;

use Fradoos\Domain\Repository\Repositories;

abstract class DoctrineRepositoryTestCase extends \PHPUnit\Framework\TestCase
{
    private static $database;
    private static $baseInitialisee = false;
    protected $entityManager;
    protected $entrepots;

    private static function executeFlyway($requete)
    {
        exec(static::currentDirForExec() . "/../../../../../etc/flyway/flyway " . $requete . " -url=jdbc:mysql://" . self::$database["host"] . "/" . self::$database["dbname"] . " -user=" . self::$database["user"] . " -password=" . self::$database["password"] . " -locations=filesystem:" . static::currentDirForExec() . "/../../../../../etc/database", $output, $returnVar);
        if ($returnVar) {
            foreach ($output as $log) {
                echo "\n$log";
            }
            echo "\n";
        }
    }

    protected function setUp(): void
    {
        parent::setUp();
        $_SERVER["APP_ENV"] = "test";
        self::$database = parse_ini_file(__DIR__ . "/../../../../config/application.test.ini", true)['database'];

        if (!self::$baseInitialisee) {
            self::initializeDatabase();
        }
        $this->entityManager = DoctrineRepositories::createEntityManager(
            [
                'driver' => 'pdo_mysql',
                'host' => self::$database["host"],
                'user' => self::$database["user"],
                'password' => self::$database["password"],
                'dbname' => self::$database["dbname"],
            ]
        );

        $this->entityManager->beginTransaction();

        $this->entrepots = $this->getMockBuilder(Repositories::class)->getMock();
        Repositories::initialize($this->entrepots);
    }

    private static function initializeDatabase()
    {
        self::executeSql("DROP DATABASE IF EXISTS " . self::$database["dbname"]);
        self::executeSql("CREATE DATABASE " . self::$database["dbname"]);
        exec("mysql -h" . self::$database["host"] . " -u" . self::$database["user"] . " -p" . self::$database["password"] . " " . self::$database["dbname"] . " < " . static::currentDirForExec() . "/../../../../etc/database.sql");
        //self::executeFlyway("baseline -baselineVersion=2.11.0");
        //self::executeFlyway("migrate");
        self::$baseInitialisee = true;
    }

    private static function executeSql($requete)
    {
        $connexion = new \mysqli(self::$database["host"], self::$database["user"], self::$database["password"]);
        $connexion->query($requete);
        $connexion->close();
    }

    private static function currentDirForExec()
    {
        return escapeshellarg(__DIR__);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->rollback();
        $this->entityManager->getConnection()->close();
    }

    protected function createAndPersistEntity($objet, $libelle)
    {
        $objet = new $objet($libelle);
        $this->persistInDatabase($objet);
        return $objet;
    }

    protected function persistInDatabase($objet)
    {
        $this->entityManager->persist($objet);
        $this->entityManager->flush($objet);
        return $objet;
    }
}