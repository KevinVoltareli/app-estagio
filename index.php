<html>
  <head>
    <meta charset="utf-8" />
    <title>App demonstrativo de vendas</title>
    <link rel="icon" type="text/css" href="image/logo_santo_grau_todo.png">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style type="text/css">
      .card-login {
        padding: 30px 0 0 0;
        width: 350px;
        margin: 0 auto;
        
      }
      .card-header {
        background: #4d0c5f;
      }      
      navbard-brand {
        background: #4d0c5f;
        text-decoration: none;
      }
      nav.navbar {
        background: #4d0c5f;
      }


    </style>
  </head>

  <body>

    <nav  class="navbar">
        <a class="navbar-brand text-white" href="index.php">
          Santo Grau
        </a>
    </nav>

    <div class="container">    
      <div class="row">

        <div class="card-login navbar navbar-brand">
          <div class="card">
            <div class="card-header text-white">
              Login
            </div>
            <div class="card-body">

             <?php // ********************* AUTH LDAP *******************************
             $usuario_autenticado = false;

             $post = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (is_array($post)):
            $post = array_map('strip_tags', $post);
            $post = array_map('trim', $post);

        if(($_POST['username']) && ($_POST['password'])){

        $adServer = "ldap://santo-dc01.santograu.local";

        $ldap = ldap_connect($adServer);
        $username = $_POST['username'];
        $password = $_POST['password'];    


        $ldaprdn = 'santograu' . "\\" . $username;


        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

        $bind = @ldap_bind($ldap, $ldaprdn, $password);

        if ($bind) {
            $filter="(sAMAccountName={$username})";
            $result = ldap_search($ldap,"dc=santograu,dc=local",$filter);
            ldap_sort($ldap,$result,"sn");
            $info = ldap_get_entries($ldap, $result);

            for ($i=0; $i<$info["count"]; $i++)            {

              //*********INICIA SESSÃO PARA TESTE NIVEL DE USUARIO**************
              if (!isset($_SESSION)):
                  session_start();
              endif;

                $membros = $info[$i]["memberof"][0]; 
                $login = $info[$i]["samaccountname"][0]; 
                $senha = $password; 

                $_SESSION['membros'] = $membros; 
                $_SESSION['login'] = $login;
                $_SESSION['senha'] = $senha;  
                /*echo '<pre>';
                print_r($_SESSION['membros']);
                echo '</pre>';
                echo '<pre>';
                print_r($_SESSION['login']);
                echo '</pre>';
                echo '<pre>';
                print_r($_SESSION['senha']);
                echo '</pre>';*/

                // ***  FIM ***

                // ***********AUTH PAGINAS *************

                $_SESSION['pagRestrita1'] = 'CN=sistema_relatorios,OU=TI,OU=SantoGrau,DC=santograu,DC=local';

                if($info['count'] > 1)
                    break;
                
                //echo "<p>Bem vindo <strong> ". $info[$i]["sn"][0] .", " . $info[$i]["givenname"][0] ."</strong><br /> (" . $info[$i]["samaccountname"][0] .")</p>\n";
               

                $_SESSION['bemVindo'] = "<p>Bem vindo <strong> ". $info[$i]["givenname"][0] ." " . $info[$i]["sn"][0] ." ! </strong><br /> </p>\n";
            

                 if($_SESSION['login'] == $_POST['username'] && $_SESSION['senha'] == $_POST['password']){
                      $usuario_autenticado = true;
                  }

                if($usuario_autenticado){
                    echo 'Usuário autenticado.';
                    header('Location: home2.php');

                    $_SESSION['autenticado'] = 'SIM';
                } 

               // $_SESSION['autenticado'] = true;

                $userDn = $info[$i]["distinguishedname"][0]; 
                //header('Location: home2.php');
            }
            @ldap_close($ldap);
        } else {
                    session_start();
                     $_SESSION['autenticado'] = 'NAO';
                    //header('Location: index.php?login=erro2');
                   $_SESSION['autenticado'] = false;
                    $msg = "Usuario/Senha incorreto.";
            echo $msg;
           }

          }
        endif;
 ?>
 
 
        <form action="#" method="POST">
          <div class="form-group">
             <input id="username" type="text" name="username" placeholder="Login" class="form-control" /> 
                </div>
           <div class="form-group">
                   <input id="password" type="password" name="password" placeholder="Senha" class="form-control" />
                </div>  
    <button class="btn btn-lg btn-info btn-block btn-warning" type="submit" name="submit" value="Enviar">Entrar</button></form> 
    
            </div>
          </div>
        </div>
    </div>
  </body>
</html>