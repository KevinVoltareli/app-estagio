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
        <title>Demonstrativo de vendas</title>

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

                                   <div class="col-md-4 ">
                                        <div class="form-group">  
                                            <label>Selecione a filial</label><br>
                                                <select class="col-md-12" id="filiais" name="filial">
                                                    <option value="">--SELECIONE--</option>
                                                    <option value="2">Galao</option>
                                                    <option value="4">Aggio</option>
                                                    <option value="5">E-commerce</option>     
                                                </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 ">
                                        <div class="form-group">  
                                            <label>Selecione o tipo de cliente</label><br>
                                                <select class="col-md-12" id="clinovos" name="tipcli">
                                                    <option value="">--SELECIONE--</option>
                                                    <option value="20279">Novo</option>
                                                    <option value="20281">Antigo</option>  
                                                </select>
                                        </div>
                                    </div>

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
                                    <th>Nome</th>                  
                                    <th>nº</th> 
                                    <th>Total de compras</th>
                                    <th>Valor da compra</th> 

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
            $where = "WHERE a.LCTDATALANCAMENTO >=  '" . $post['fdate'] . "'";
            if(!empty($post['tdate'])):
            $where .= " and a.LCTDATALANCAMENTO <=  '". $post['tdate'] ."'";          
            
            endif;

             if(!empty($post['filial'])):
             $where .= " AND e.FILID_FILIAL = '" . $post['filial'] . "'";
              endif;

              
                
            $read = $conn->prepare("SELECT DISTINCT g.PESNOME AS NOME, a.LCTVALOR AS TOTAL,m.TELNUMERO AS CELULAR,COUNT(a.LCTVALOR) AS CLIENTENOVO
                           FROM TB_LCT_LANCAMENTOS a
                           INNER JOIN TB_LTV_LANCAMENTOVENDA b ON b.LCTID = a.LCTID 
                           INNER JOIN TB_VEN_VENDA c ON c.VENID = b.VENID 
                           INNER JOIN TB_VPE_VENDAPEDIDOS d ON d.VENID_VENDA = c.VENID 
                           INNER JOIN TB_PED_PEDIDO e ON e.PEDID = d.PEDID_PEDIDO 
                           INNER JOIN TB_CLI_CLIENTE f ON f.CLIID = c.CLIID_PAGADOR 
                           INNER JOIN TB_PES_PESSOA g ON g.PESID = f.PESID 
                           INNER JOIN TB_USU_USUARIO h ON h.USUID = a.USUID
                           INNER JOIN TB_VND_VENDEDOR i ON i.VNDID = e.VNDID_PRIMEIRO  
                           INNER JOIN TB_NIVEL_ACESSO k ON k.PESID = i.PESID 
                           INNER JOIN TB_INT_INTERNET l ON l.PESID = f.PESID 
                           INNER JOIN TB_TEL_TELEFONE m ON m.PESID = g.PESID
                           {$where}
                           AND e.MCVID IS NULL     
                           AND m.TELTIPO = 'C'
                           GROUP BY NOME,CELULAR,TOTAL
                           ORDER BY  TOTAL DESC");
                            
                            
            $read->setFetchMode(PDO::FETCH_ASSOC);
            $read->execute();
            $array = $read->fetchAll();
            if (count($array) == 0):
                echo "Nenhum registro localizado";
            endif;
            $qtd = 0;
            $qtd1 = 0;
            ?>
            
                <?php 
                foreach ($array as $dados): 
                    ?>
                    <tr>
                        <td><?= $dados["NOME"]; ?></td>
                        <td><?= $dados["CELULAR"]; ?></td>
                        <td><?= $dados["CLIENTENOVO"]; ?></td>
                        <td><?= number_format( $dados["TOTAL"],2,',',''); ?></td>
                        
                    </tr>
                <?php
                endforeach; 
                ?>
            </table>
            <?php
           echo "Total geral cliente novo: {$qtd}";
           echo '<br>';
           echo "Total geral cliente antigo: {$qtd1}";
        endif;
        ?>


    </body>
</html>