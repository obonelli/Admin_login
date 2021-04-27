<?php
include_once '../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();
// Recepción de los datos enviados mediante POST desde el JS   

$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$tipousuario = (isset($_POST['tipousuario'])) ? $_POST['tipousuario'] : '';
$sexo = (isset($_POST['sexo'])) ? $_POST['sexo'] : '';
$password = (isset($_POST['password'])) ? $_POST['password'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';

switch($opcion){
    case 1: //alta
        $pass = md5($password); 
        $FechaRegistro = date("Y/m/d"); 
        $HoraRegistro = date("h:i:s"); 
        $consulta = "INSERT INTO usuarios (usuario, tipousuario, sexo, password, fecharegistro , horaregistro)
        VALUES('$nombre', '$tipousuario', '$sexo', '$pass', '$FechaRegistro', '$HoraRegistro') ";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT id, usuario, tipousuario, sexo, password FROM usuarios ORDER BY id DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        $pass = md5($password); 
        $FechaModificacion = date("Y/m/d h:i:s"); 
        $consulta = "UPDATE usuarios SET usuario='$nombre', tipousuario='$tipousuario', sexo='$sexo', password='$pass',
        fechamodificacion ='$FechaModificacion' WHERE id='$id'";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT id, usuario, tipousuario, sexo, password FROM usuarios WHERE id='$id'";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        
    case 3://baja
        $consulta = "DELETE FROM usuarios WHERE id='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();     
        
        $consulta = "SELECT id, usuario, tipousuario, sexo, password FROM usuarios ORDER BY id DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);                      
        break;        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
