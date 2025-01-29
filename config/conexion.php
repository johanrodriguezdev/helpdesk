<?php

session_start();

class Conectar{
    protected $databasehd;

    protected function Conexion(){
        try {
            $conectar = $this->databasehd = new PDF("mysql:local:localhost;dbname=helpdesk","root","");
            return $conectar;
        } catch (Exception $e) {
            print "!Error DB!: " . $e->getMessage(). "<br/>";
            die();
        }
    }

    public function set_names(){
        return $this->databasehd->query("SET NAMES 'utf8'");
    }

}