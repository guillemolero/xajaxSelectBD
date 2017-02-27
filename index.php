<?php
/**
 * Created by PhpStorm.
 * User: Guillermo
 * Date: 26/02/2017
 * Time: 14:41
 */

require ("xajax/xajax.inc.php");

$xajax = new xajax();

function procesar_formulario($form_entrada){
    //Creo el xajaxResponse para generar una salida
    $respuesta = new xajaxResponse('ISO-8859-1');

    //validacion
    $error_form = "";
    if($form_entrada["user"] == ""){
        $error_form = "Debes escribir tu usuario";
    }
    elseif($form_entrada["password"] == ""){
        $error_form = "Debes escribir tu contraseña";
    }
    elseif($form_entrada["password2"] == ""){
        $error_form = "Debes repetir la contraseña";
    }
    elseif($form_entrada["password"] != $form_entrada['password2']){
        $error_form = "Las contraseñas deben coincidir";
    }
    elseif($form_entrada["email"] == ""){
        $error_form = "Debes escribir tu email";
    }

    //compruebo resultado de la validacion
    if($error_form != ""){
        //Hubo un error en el formulario
        //en la capa donde se muestran mensajes, muestro el error
        $respuesta->addAssign("mensaje","innerHTML","<span style='color:red;'>$error_form</span>");
    }
    else{
        //es que no hubo error en el formulario
        $salida = "Hemos procesado esto:<p>";
        $salida .= "Nombre: " . $form_entrada["nombre"];
        $salida .= "<br>Apellidos: " . $form_entrada["apellidos"];

        //mostramos en capa mensaje el texto que está todo correcto
        $respuesta->addAssign("mensaje","innerHTML","<span style='color:blue;'>Todo correcto... Muchas gracias!</span>");
        //escribimos en la capa con id="capaformulario el texto que aparece en $salida
        $respuesta->addAssign("capaformulario","innerHTML",$salida);

        //tenemos que devolver la instanciación del objeto xajaxResponse
    }

    return $respuesta;
}

function procesar_select($form_entrada){
    //Conexion con BBDD
    $bbdd = new mysqli("localhost", "root", "", "xajax");
    $select = "select * from datos";
    $resultado = $bbdd->query($select);
    $datos = $resultado->fetch_row();

    //Creo el xajaxResponse para generar una salida
    $respuesta = new xajaxResponse('ISO-8859-1');

    if($form_entrada["provincia"] == "a"){
        while($datos[0] != "a"){
            $datos = $resultado->fetch_row();
        }
    }
    elseif($form_entrada["provincia"] == "b"){
        while($datos[0] != "b"){
            $datos = $resultado->fetch_row();
        }
    }
    elseif($form_entrada["provincia"] == "c"){
        while($datos[0] != "c"){
            $datos = $resultado->fetch_row();
        }
    }

    $respuesta->addAssign("select","innerHTML","Selecciona tu pueblo<select name='pueblos'>
                                                    <option>$datos[1]</option>
                                                    <option>$datos[2]</option>
                                                    <option>$datos[3]</option>
                                                    </select>");

    return $respuesta;
}

//Asociamos la funcion creada antoriormente al objeto xajax
$xajax->registerFunction("procesar_formulario");
$xajax->registerFunction("procesar_select");
//El objeto xajax tiene que procesar cualquier peticion
$xajax->processRequests();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>XAJAX Select BD</title>
    <?php $xajax->printJavascript("xajax/"); ?>
    <style>
        input {
            display: block;
            margin-top: 10px;
        }
        p {
            font-size: 12px;
            margin-top: 1px;
        }
    </style>
</head>
<body>
    <?php
        include "include/form.php";
    ?>
</body>
</html>