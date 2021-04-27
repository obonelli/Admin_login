<?php require_once "vistas/parte_superior.php"?>

<!--INICIO del cont principal-->
<div class="container">
<?php

if($_SESSION["s_tipousuario"] === 'Admin'){
    require_once "slider.php";
}else{ 
 echo '<h1 style="text-align: center;">Bienvenido Usuario: '.$_SESSION["s_usuario"].'</h1>';
}

?> 
    
</div>
<!--FIN del cont principal-->
<?php require_once "vistas/parte_inferior.php"?>