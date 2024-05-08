<?php 
  if (!isset($_SESSION)):
    session_start();
endif;
  if(!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] != 'SIM'){
    header('Location: index.php?login=erro2');
  }

        //"CN=sistema_relatorios,OU=TI,OU=SantoGrau,DC=santograu,DC=local"
         //var_dump($_SESSION['membros']);  
 ?>  

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Demonstrativo de vendas</title><link rel="icon" type="text/css" href="image/logo_santo_grau_todo.png">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

       <style type="text/css">
       body {
        color:#6011a1;
       }
       tr {
        color:#6011a1;
       }
       button {
        margin-top: 30px ;
       
       }
     </style>
    </head>
    <body>

  

    <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card mt-5">
                        <div class="card-header">
                            <h4>Relatório de vendas</h4>
                        </div>
                        <div class="card-body">
                        
                            <form action="" method="post">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Data inicial</label>
                                            <input class="form-control" name="fdate" type="date" maxlength="10" size="10" required value="<?php if(isset($_POST['fdate'])){echo $_POST['fdate'];}?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">  
                                            <label>Data final</label>
                                            <input class="form-control" name="tdate" type="date" maxlength="10" size="10" required value="<?php if(isset($_POST['tdate'])){echo $_POST['tdate'];}?>" />
                                        </div>
                                    </div>

                                   <!-- <div class="col-md-4 ">
                                        <div class="form-group">  
                                            <label>Selecione a filial</label><br>
                                                <select class="col-md-12" id="filiais" name="filial">
                                                    <option value="">--SELECIONE--</option>
                                                    <option value="20279">Galao</option>
                                                    <option value="20281">Aggio</option>
                                                    <option value="31823">E-commerce</option>     
                                                </select>
                                        </div>
                                    </div>-->

                                    <div class="col-md-4">
                                        <div  class="form-group">                                     
                                          <button type="submit" class="btn btn-md btn-warning">Pesquisar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card mt-4">
                    <div class="card-body">
                        <table class="table table-borderd">
                            <thead>
                                <tr>
                                    <th>Data</th> 
                                    <th>Nome</th>                                   
                                    <th>Email</th>
                                    <th>Telefone</th>
                                    <th>Tipo telefone</th>



                                </tr>
                            </thead>
                            <tbody>

       
        <?php
        $post = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (is_array($post)):
            try {
                $conn = new PDO("firebird:dbname=C:\SavWinRevo\Servidor\DataBase\BDSAVWINREVO.FDB", "SYSDBA", "masterkey");
            } catch (PDOException $e) {
                echo '<pre>';
                print_r($e);
                echo '</pre>';
                die(); //deu ruim
            }
            $where = "WHERE c.CLIULTIMAATUALIZACAO >=  '" . $post['fdate'] . "'";
            if(!empty($post['tdate'])):
            $where .= " and c.CLIULTIMAATUALIZACAO <=  '". $post['tdate'] ."'";
            //$where .= " AND l.PESID = '" . $post['filial'] . "'";
            
            endif;

              
            
            $read = $conn->prepare("SELECT 
                                d.VENDATAHORAFATURAMENTO AS DATA,a.PESNOME AS NOME, b.INTENDERECO AS EMAIL, e.TELNUMERO AS TEL, e.TELTIPO AS TELTIPO "
                            . "FROM TB_PES_PESSOA a "
                            . "INNER JOIN TB_INT_INTERNET b ON b.PESID = a.PESID "
                            . "INNER JOIN TB_CLI_CLIENTE c ON c.PESID = b.PESID "
                            . "INNER JOIN TB_VEN_VENDA d ON d.CLIID_PAGADOR = c.CLIID "
                            . "INNER JOIN TB_TEL_TELEFONE e ON e.PESID = a.PESID "
                            . "{$where}");

            $read->setFetchMode(PDO::FETCH_ASSOC);
            $read->execute();
            $array = $read->fetchAll();
            if (count($array) == 0):
                echo "Nenhum registro localizado";
            endif;
            $qtd = 0;

            ?>
            
                <?php 
                foreach ($array as $dados): 
                //$qtd += $dados["ID"];
                    ?>
                    <tr>
                        <td><?= $dados["DATA"]; ?></td>
                        <td><?= $dados["NOME"]; ?></td>
                        <td><?= $dados["EMAIL"]; ?></td>
                        <td><?= $dados["TEL"]; ?></td>
                        <td><?= $dados["TELTIPO"]; ?></td>
                    </tr>
                <?php
                endforeach; 
                ?>
            </table>
            <?php
           // echo "Total geral: {$qtd}";
        endif;
        ?>


    </body>
</html>