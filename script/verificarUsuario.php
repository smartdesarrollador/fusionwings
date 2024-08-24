<?php
session_start();
error_reporting(0);
include '../class/ClienteClass.php';
include "../class/Cart.php";


if (isset($_POST['correo']) && isset($_POST['contrasena'])) {
    $userEmail = trim(strtolower($_POST['correo']));
    $userPassword = $_POST['contrasena'];

    //habil te crees caosa
    $passWordRham = $userPassword."".$userPassword[2];


 $objCliente = new ClienteClass();
 $cart = new Cart();
  $customerExists = $objCliente->getUserPasswordByEmail($userEmail);

    if (isset($customerExists['password'])) {

        if (password_verify($passWordRham, $customerExists['password'])) {
            $verifiedUser = $objCliente->getAllInformationUserByEmail($userEmail);
            $_SESSION['current_customer_idCliente'] = $verifiedUser['idCliente'];
            $_SESSION['current_customer_email'] = strtolower($verifiedUser['email']);
            $_SESSION['current_customer_nombre'] = $verifiedUser['nombre'];
            $_SESSION['current_customer_apellido'] = $verifiedUser['apellido'];
            $_SESSION['current_customer_DNI'] = $verifiedUser['DNI'];
            $_SESSION['current_customer_fechaNacimiento'] = $verifiedUser['fechaNacimiento'];
            $_SESSION['current_customer_telefono'] = $verifiedUser['celular'];
            $_SESSION['current_customer_direccion'] = $verifiedUser['direccion'];
            $_SESSION['current_customer_puntos'] = $verifiedUser['puntos'];



            $ir = $_SERVER['HTTP_REFERER'];
            header("location:$ir");

        }else{
            header("location:../fusionwings.php?code=incorrectPass");

        }

    }else {
        header("location:../fusionwings.php?code=notExistUser");
    }


}
