<?php

class MySQL{
    private $conexion = "";   
    private $host = "";   
    private $usuario = "";   
    private $pass = "";   
    private $base_de_datos = "";   
    private $charset = "";
    
    public function __construct() {
        $this->host = 'localhost';
        $this->usuario = 'root';
        $this->pass = '';
        $this->base_de_datos = 'laboratorio_clinico';
        $this->charset = 'utf8mb4';
                
    }
    
    public function conectar() {
        try {
            //url
            $connection = "mysql:host=" . $this->host . 
                          ";dbname=" . $this->base_de_datos . 
                          ";charset=" . $this->charset;
            //manejo de errores
           $options =[
           PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
           PDO::ATTR_EMULATE_PREPARES=> false,
           ];
           //se crea la conexion
           $pdo = new PDO($connection, $this->usuario,
           $this->pass,
                   $options);
          // echo "conectado";
           $this->conexion = $pdo;
           return $pdo;
        } catch (PDOException $e) {
            print_r('error connecton: ' . $e->getMessage());
        }
        
    }
    
    public function cerrarsesion() {
        $this->conexion = null;
    }
    
}