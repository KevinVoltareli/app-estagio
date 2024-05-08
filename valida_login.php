<?php
 
     if(!isset($_SESSION)):
                  session_start();
              endif;

/*print_r($_SESSION);
echo '<hr/>';
print_r($_SESSION['y']);*/


//VARIAVEL QUE VERIFICA SE A AUTENTICAÇÃO FOI REALIZADA
$usuario_autenticado = false;

//USUARIOS DO SISTEMA

//$usuarios_app = array(
 //   array($_SESSION['login'], $_SESSION['senha']));

/*echo '<pre>';
print_r($usuarios_app);
echo '</pre>';*/

                echo '<pre>';
                print_r($_SESSION['membros']);
                echo '</pre>';
                echo '<pre>';
                print_r($_SESSION['login']);
                echo '</pre>';
                echo '<pre>';
                print_r($_SESSION['senha']);
                echo '</pre>';




    
    echo 'Usuario app: ' . $_SESSION['login'] . '/' . $_SESSION['senha'];
    echo '<br />';
    echo 'Usuario form: ' . $_POST['username'] . '/' . $_POST['password'];
    echo '<hr />';
    
    if($_SESSION['login'] == $_POST['username'] && $_SESSION['senha'] == $_POST['password']){
        $usuario_autenticado = true;
    }

    if($usuario_autenticado){
        echo 'Usuário autenticado.';
        //header('Location: home2.php');

        $_SESSION['autenticado'] = 'SIM';
    }else{  
        echo 'NÃO FOI autenticado';
        $_SESSION['autenticado'] = 'NAO';
        //header('Location: index.php?login=erro2');
      }



?>