<?php
 class Conexion{
     public static function Conectar(){
         define('servidor','localhost');
         define('nombre_bd','sistema_gerencial');
         define('usuario','root');
         define('password','');         
         $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');/*Establece los caracteres de la conexion a TF-8 */
        
         try{
            $conexion = new PDO("mysql:host=".servidor.";dbname=".nombre_bd, usuario, password, $opciones);             
            return $conexion; 
         }catch (Exception $e){/*Manejo de errores de conexion*/
             die("El error de Conexión es :".$e->getMessage());/* */
         }         
     }
     
 }

 
?>