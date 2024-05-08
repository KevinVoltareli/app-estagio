<?php

//session_start();
$_SESSION['x'] = 'Oi, eu sou um valor de sessão!';
/*print_r($_SESSION);
echo '<hr/>';
print_r($_SESSION['y']);*/


//VARIAVEL QUE VERIFICA SE A AUTENTICAÇÃO FOI REALIZADA
$usuario_autenticado = false;

//USUARIOS DO SISTEMA
$usuarios_app = array(
    array('username' => 'adm@teste.com.br', 'password' => '123456'),
    array('username' => 'user@teste.com.br', 'password' => 'abcd')
);
/*

echo '<pre>';
print_r($usuarios_app);
echo '</pre>';

*/

foreach($usuarios_app as $user){
    /*
    echo 'Usuario app: ' . $user['email'] . '/' . $user['senha'];
    echo '<br />';
    echo 'Usuario form: ' . $_POST['email'] . '/' . $_POST['senha'];
    echo '<hr />';
    */
    if($user['username'] == $_POST['username'] && $user['password'] == $_POST['password']){
        $usuario_autenticado = true;
    }
}
    // ************ VERIFICA SE FOI AUTENTICADO E REDIRECIONA ********************
    if($usuario_autenticado){
        echo 'Usuário autenticado.';
        header('Location: home2.php');

        $_SESSION['autenticado'] = 'SIM';
    }else{  
        $_SESSION['autenticado'] = 'NAO';
        header('Location: index.php?login=erro2');
      }


/*
print_r($_GET)

echo '<br />'
echo $_GET['email']
echo '<br />'
echo $_GET['senha']
print_r($_POST);
*/

?>