<?php

namespace AppBundle\Entity\Repository;

//define('sfMain', dirname($_SERVER['DOCUMENT_ROOT']) . '/');


class Connection
{
//require_once(sfMain.'vendor/symfony/symfony/src/Symfony/Component/Yaml/Parser.php');
//require_once(Classes."auth/Auth_class.php");

//require_once(Functions . "Fixcoding.php");

    private $localhostSrv = array('127.0.0.1', '::1');
    private $devSrv = array('dev.marinemammals.be');
    private $prodSrv = array('www.marinemammals.be');

    private $dbParameters = array();

    public $user;
    public $pass;
    public $alias;

    public function __construct()
    {
        try {
            if (in_array($_SERVER['REMOTE_ADDR'], $this->localhostSrv)) {
                $this->dbParameters = yaml_parse_file(sfMain . "app/config/parameters_dev.yml");
            } elseif
            (in_array($_SERVER['SERVER_NAME'], $this->devSrv)) {
                $this->dbParameters = yaml_parse_file(sfMain . "app/config/parameters_dev.yml");
            } elseif (in_array($_SERVER['SERVER_NAME'], $this->prodSrv)) {
                $this->dbParameters = yaml_parse_file(sfMain . "app/config/parameters_prod.yml");
            }
        } catch (Exception $e) {
            printf("Unable to parse the YAML string: %s", $e->getMessage());
        }

        $this->user = $this->dbParameters['parameters']['database_user'];
        $this->pass = $this->dbParameters['parameters']['database_password'];
        $this->alias = $this->dbParameters['parameters']['database_host'] . ':' . $this->dbParameters['parameters']['database_port'] . '/' . $this->dbParameters['parameters']['database_name'];

    }


}

?>