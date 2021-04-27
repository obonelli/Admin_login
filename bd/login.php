<?php
session_start();

include_once 'conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

//recepción de datos enviados mediante POST desde ajax
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$password = (isset($_POST['password'])) ? $_POST['password'] : '';

$pass = md5($password); //encripto la clave enviada por el usuario para compararla con la clava encriptada y almacenada en la BD

$consulta = "SELECT * FROM usuarios WHERE usuario='$usuario' AND password='$pass' ";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$row = $resultado->fetch();

if ($resultado->rowCount() >= 1) {
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION["s_usuario"] = $usuario;
    $_SESSION["s_tipousuario"] = $row['tipousuario'];

    $consulta = "INSERT INTO bitacora (usuario)
    VALUES('$usuario') ";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
} else {
    $_SESSION["s_usuario"] = null;
    $data = null;
}

print json_encode($data);
$conexion = null;

//usuarios de prueba en la base de datos 
// Usuario Admin
//usuario:Oscar pass:123

// Usuario Basic
//usuario:Jorge pass:123