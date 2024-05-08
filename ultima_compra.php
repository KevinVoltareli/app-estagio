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

       button a {
        text-decoration: none;

        color: white;
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
                <li><a href="consulta_quantidade_produtos.php"><i class="fa-solid fa-sack-dollar"></i>Venda produto</a></li>
                <li><a href="consulta_quantidade_produtos_detalhada.php"><i class="fa-solid fa-circle-info"></i>Venda detalhado</a></li>
                <li><a href="estoque.php"><i class="fa-solid fa-warehouse"></i>Estoque</a></li>
                <li><a href="curva_abc.php"><i class="fa-solid fa-shapes"></i>Curva ABC</a></li>
                <li><a href="curva_abc_detalhado.php"><i class="fa-solid fa-shapes"></i>ABC Detalhado</a></li>
                <li><a href="venda_por_vendedor.php"><i class="fa-sharp fa-solid fa-person"></i>Venda vendedor</a></li>                
                <li><a href="home2.php"><i class="fa-solid fa-x"></i>Sair</a></li>
            </ol>        
    </div>  
        <!-- FIM TOGGLE MENU -->

    <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card mt-5">
                        <div class="card-header">
                            <h4>Estoque</h4>
                        </div>

                        <div class="container">                        

                           <div class="col-12"> 

                        <div class="card-body">                        
                            <form action="" method="post">
                                <div class="row">

                                    <!--<div class="col-6 ">
                                        <div class="form-group">  
                                            <label for="lista">Selecione o mês</label><br>
                                                <select class="col-md-4" id="lista" name="DATAS" >
                                                    <option ><?php if(isset($_POST['DATAS'])){echo $_POST['DATAS'];}?></option>
                                                    <option value="2022-01">Janeiro</option>
                                                    <option value="2022-02">Fevereiro</option>
                                                    <option value="2022-03">Março</option>
                                                    <option value="2022-04">Abril</option>
                                                    <option value="2022-05">Maio</option>
                                                    <option value="2022-06">Junho</option>
                                                    <option value="2022-07">Julho</option>
                                                    <option value="2022-08">Agosto</option>
                                                    <option value="2022-09">Setembro</option>
                                                    <option value="2022-10">Outubro</option>
                                                    <option value="2022-11">Novembro</option>
                                                    <option value="2022-12">Dezembro</option>
                                                </select>
                                        </div>
                                    </div>-->                          
                                    
                                    <div class="col-6 ">
                                        <div class="form-group">  
                                            <label>Selecione a filial (estoque)</label><br>
                                                <select class="col-md-12" id="filiais" name="filial">
                                                    <option  value="">
                                                        <?php 
                                                        if(isset($_POST['filial'])){
                                                            if($_POST['filial'] == '20279') {
                                                                echo 'Galao';
                                                            } elseif($_POST['filial'] == '20281') {
                                                                echo 'Aggio';
                                                            } elseif($_POST['filial'] == '31823') {
                                                                echo 'E-commerce';
                                                            } elseif($_POST['filial'] == '74061') {
                                                                echo 'Site';
                                                            }
                                                        }
                                                        ?>
                                                            
                                                        </option>
                                                    <option value="">--Selecione para todos--</option>    
                                                    <option value="20279">Galao</option>
                                                    <option value="20281">Aggio</option>
                                                    <option value="31823">E-commerce</option>
                                                    <option value="74061">Site</option>
                                                </select>
                                        </div>
                                    </div>    

                                      <div class="col-md-4 pb-0">
                                        <div  class="form-group">                                     
                                          <button type="submit" class="btn btn-md btn-warning">Pesquisar</button>
                                        </div>   

                                       <form>
                                            <a href="curva_abc.php">
                                                <input type="button" class="btn btn-md btn-success"  value="Ir para curva abc">
                                            </a>
                                        </form>                                                        
                                    </div>
                                </div>
                            </form>                            
                        </div>
                    </div>
                    </div> </div> 

                    <div class="card mt-4">
                    <div class="card-body">
                        <table class="table table-borderd">
                            <thead>
                                <tr>
                                    <th>Produto</th>                                
                                    <th>Data da ultima reposição</th>
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
            $where = "WHERE a.MECDATALOTE  >= '2022-07-01'";            
            $where .= " and a.MECDATALOTE <=  '2022-12-31'";
             if($post['filial'] == '20281' || $post['filial'] == '31823' || $post['filial'] == '20279' || $post['filial'] == '20279'):
            @$where .= " AND c.PESID = '" . $post['filial'] . "'";   
            endif;

            
            
            $read = $conn->prepare("SELECT e.NOME_APELIDO as APELIDO, f.MVMDATAMOV AS ULTIMAENTRADA
                                    FROM TB_MEC_MATESTCONTROLE a 
                                    INNER JOIN TB_MAT_MATERIAL b ON b.MATID = a.MATID
                                    INNER JOIN TB_FIL_FILIAL c ON c.FILID = a.FILID
                                    INNER JOIN TB_PES_PESSOA d ON d.PESID = c.PESID 
                                    INNER JOIN TB_DRIP_APELIDO e ON e.MATFANTASIA = b.MATFANTASIA
                                    INNER JOIN TB_MVM_MOVMATITEM f ON f.MATID = b.MATID 
                                    {$where}
                                    AND NOT b.NCMID = '56' 
                                    AND NOT b.NCMID = '65'
                                    AND NOT b.NCMID = '66'
                                    AND NOT b.NCMID = '68'
                                    AND NOT b.NCMID = '71'
                                    AND NOT b.NCMID = '75'
                                    AND f.COPID = '32'
                                    AND d.PESID = '31823'
                                    AND NOT e.NOME_APELIDO LIKE '%NOMEAR%'
                                    AND NOT e.NOME_APELIDO LIKE '%STARCK%'
                                    GROUP BY e.NOME_APELIDO,f.MVMDATAMOV
                                    ORDER BY ULTIMAENTRADA DESC ");

            $read->bindParam(':buscar', $buscar, PDO::PARAM_STR);
            $read->setFetchMode(PDO::FETCH_ASSOC);            
            $read->execute();   
            $array = $read->fetchAll();       
        
            $qtd = 0;

            ?>
            
                <?php 
                foreach ($array as $dados): 
                //$qtd += $dados["QTD"];
                    ?>
                    <tr>
                        <td><?= $dados["APELIDO"]; ?></td>
                        <td><?= date("d/m/Y",strtotime($dados["ULTIMAENTRADA"])); ?></td>
                    </tr>
                <?php
                endforeach; 

                //echo "Total geral: {$qtd}";
                ?>
            </table>
            <?php
           
        endif;
        ?>


    </body>
</html>
