<?php 
  if (!isset($_SESSION)):
    session_start();
endif;
  if(!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] != 'SIM'){
    header('Location: index.php?login=erro2');
  }

        //"CN=sistema_relatorios,OU=TI,OU=SantoGrau,DC=santograu,DC=local"
         //var_dump($_SESSION['membros']);  

  $data = date('Y-m-t');
   
   
   $data = explode('-', $data);  

    $dia = $data [2];
    $mes = $data [1];
    $ano = $data [0]; 
    
$vendaInicio = $ano."-".$mes."-"."01";
$vendaFim = $ano."-".$mes."-".$dia;


 ?>  

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Demonstrativo de vendas</title>

        <!--Bootstrap-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <!--Icone pagina-->
        <link rel="icon" type="text/css" href="image/logo_santo_grau_todo.png">
        <!--Font awesome-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
        <!--Css -->
        <link rel="stylesheet" type="text/css" href="css/estiloRelatorios.css">

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

        <!-- TOGGLE MENU -->
        <input style="-webkit-appearance: none;
                       visibility: hidden;
                       display: none;" type="checkbox" id="check" name="">

        
    <div class="container_toggle">
        <label for="check">
            <span class="fas fa-times" id="times"></span>
            <span class="fas fa-bars" id="bars"></span>
        </label>
        <div class="head">Menu</div>
            <ol>
                <li><a href="consulta_quantidade_produtos.php"><i class="fa-solid fa-sack-dollar"></i>Vendas Macro</a></li>
                <li><a href="consulta_quantidade_produtos_detalhada.php"><i class="fa-solid fa-circle-info"></i>Venda detalhado</a></li>
                <li><a href="curva_abc.php"><i class="fa-solid fa-shapes"></i>Estoque</a></li>
                <li><a href="curva_abc_detalhado.php"><i class="fa-solid fa-shapes"></i>Estoque detalhado</a></li>
                
                <li><a href="curva_abc_outlet.php"><i class="fa-solid fa-shapes"></i>Estoque outlet</a></li>
                <li><a href="curva_abc_acessorio.php"><i class="fa-solid fa-shapes"></i>Acessórios</a></li>
                <li><a href="venda_por_vendedor.php"><i class="fa-sharp fa-solid fa-person"></i>Venda vendedor</a></li>

                <?php if($_SESSION['login'] == 'kevin.voltareli') { ?>
                    <li><a href="cadastro_antigo.php"><i class="fa-solid fa-person-cane"></i>Cadastro antigo</a></li>  
                <?php } ?>    
                
                <li><a href="home2.php"><i class="fa-solid fa-x"></i>Sair</a></li>        
            </ol>        
    </div> 
        <!-- FIM TOGGLE MENU -->
  

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
                                            <input class="form-control" name="fdate" type="date" maxlength="10" size="10" required value="<?php if(isset($_POST['fdate'])){echo $_POST['fdate'];} else{ echo $vendaInicio; }?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">  
                                            <label>Data final</label>
                                            <input class="form-control" name="tdate" type="date" maxlength="10" size="10" required value="<?php if(isset($_POST['tdate'])){echo $_POST['tdate'];} else{ echo $vendaFim; }?>" />
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">  
                                            <label>Receituário</label>
                                            <input type="checkbox" name="receituario" value="ARMACAO P/ OCULOS">
                                            
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">  
                                            <label>Oculos de sol</label>
                                            <input type="checkbox" name="oculosDeSol" value="OCULOS DE SOL">
                                            
                                        </div>
                                    </div>

                                    <div class="col-lg-8 ">
                                        <div class="form-group">  
                                            <label>Pesquisar por produto</label><br>
                                                <input  value="<?php if(isset($_POST['buscar'])){echo $_POST['buscar'];}?>" type="text" id="buscar" name="buscar" not>
                                        </div>
                                    </div>

                                    <div class="col-md-4 ">
                                        <div class="form-group">  
                                            <label>Selecione a filial</label><br>
                                                <select class="col-md-12" id="filiais" name="filial">
                                                    <option value="">--SELECIONE--</option>
                                                    <option value="">Todos</option>
                                                    <option value="2">Galao</option>
                                                    <option value="4">Aggio</option>
                                                    <option value="5">E-commerce</option>     
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
                                    <th>Cor</th>
                                    <th>Loja</th> 
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>

       
        <?php
        $post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        @$buscar = strtoupper("%".($_POST['buscar'])."%");

        if (is_array($post)):
            try {
                $conn = new PDO("firebird:dbname=C:\SavWinRevo\Servidor\DataBase\BDSAVWINREVO.FDB", "SYSDBA", "masterkey");
            } catch (PDOException $e) {
                echo '<pre>';
                print_r($e);
                echo '</pre>';
                die(); //deu ruim
            }
            $where = "WHERE a.VENDATAHORAFATURAMENTO >=  '" . $post['fdate'] . "'";
            if(!empty($post['tdate'])):
            $where .=  "and a.VENDATAHORAFATURAMENTO <=  '". $post['tdate'] ." 23:59'";
            //$where .= " AND l.PESID = '" . $post['filial'] . "'";            
            endif;

            if(!empty($post['receituario'])):
            @$where .= "AND d.MATDESCRICAO = '" . $post['receituario'] . "' ";            
            endif;
          
            if(!empty($post['oculosDeSol'])):
            @$where .= "AND d.MATDESCRICAO = '" . $post['oculosDeSol'] . "' ";            
            endif;

            if(!empty($post['receituario']) && !empty($post['oculosDeSol'])):
                echo '<h5 style="color: red;">Para buscar todos produtos, mantenha as caixas selecionadas vazias.</h5>';
            endif;

            if(!empty($post['buscar'])):
            @$where .= "AND h.NOME_APELIDO LIKE :buscar ";            
            endif;
              
            if(!empty($post['filial'])):
            $where .= " AND i.FILID_FILIAL = '" . $post['filial'] . "'";
            endif;
            
            
            $read = $conn->prepare("SELECT  h.NOME_APELIDO AS NOME, h.COR AS COR, sum(l.PICQTDE) AS TOTAL, n.PESNOME AS PESNOME 
                            FROM TB_VEN_VENDA a
                            INNER JOIN TB_VPE_VENDAPEDIDOS b ON b.VENID_VENDA = a.VENID 
                            INNER JOIN TB_IPD_ITEMPEDIDO c ON c.PEDID_PEDIDO = b.PEDID_PEDIDO 
                            INNER JOIN TB_MAT_MATERIAL d ON c.MATID_PRODUTO = d.MATID 
                            INNER JOIN TB_NCM_NCM e ON e.NCMID = d.NCMID 
                            INNER JOIN TB_AAT_ATRIBUTOS f ON f.MATID = d.MATID  
                            INNER JOIN TB_DRIP_APELIDO h ON h.MATFANTASIA  = d.MATFANTASIA
                            INNER JOIN TB_PED_PEDIDO i ON i.PEDID = c.PEDID_PEDIDO
                            INNER JOIN TB_TVN_TIPOVENDA j ON j.TVNID = i.TVNID
                            INNER JOIN TB_PIC_PEDIDOITEMCLIENTE l ON l.IPDID  = c.IPDID
                            INNER JOIN TB_FIL_FILIAL m ON m.FILID = i.FILID_FILIAL
                            INNER JOIN TB_PES_PESSOA n ON n.PESID = m.PESID
                            {$where}
                            AND i.PEDDATACANCELAMENTO IS NULL
                            AND NOT e.NCMID = '56' 
                            AND NOT e.NCMID = '65'
                            AND NOT e.NCMID = '66'
                            AND NOT e.NCMID = '68'
                            AND NOT e.NCMID = '71'
                            AND NOT e.NCMID = '73'  
                            AND NOT e.NCMID = '75'
                            GROUP BY  h.NOME_APELIDO, l.PICQTDE, h.COR, n.PESNOME
                            ORDER BY total DESC");

            $read->bindParam(':buscar', $buscar, PDO::PARAM_STR);
            $read->setFetchMode(PDO::FETCH_ASSOC);
            $read->execute();
            $array = $read->fetchAll();
            if (count($array) == 0):
                echo "Nenhum registro localizado <br/>";
            endif;
            $qtd = 0;

            ?>
            
                <?php 
                foreach ($array as $dados): 
                $qtd += $dados["TOTAL"];
                    ?>
                    <tr>
                        <td><?= $dados["NOME"]; ?></td>
                        <td><?= $dados["COR"]; ?></td>
                        <td><?= $dados["PESNOME"]; ?></td>
                        <td><?= number_format($dados["TOTAL"], 0, ",", "."); ?></td>

                    </tr>
                <?php
                endforeach; 
                 echo "<h5>Total geral: {$qtd}</h5>";
                ?>
            </table>
            <?php
          
        endif;
        ?>


    </body>
</html>
