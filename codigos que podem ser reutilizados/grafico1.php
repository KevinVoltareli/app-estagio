<?php $conexao = new PDO("firebird:dbname=C:\SavWinRevo\Servidor\DataBase\BDSAVWINREVO.FDB", "SYSDBA", "masterkey"); ?>

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
                            <h4>Relatório de vendas em gráfico</h4>
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
                                    <div class="col-md-4">
                                        <div  class="form-group">                                     
                                          <button type="submit" class="btn btn-md btn-warning">Pesquisar</button>
                                          <a href="teste.php"><button type="button" class=" btn btn-md btn-info">Voltar</button></a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                     <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                     <script type="text/javascript">
                      google.charts.load('current', {'packages':['bar']});
                      google.charts.setOnLoadCallback(drawChart);

                      function drawChart() {
                        var data = google.visualization.arrayToDataTable([   

                          <?php 
                           $post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                           
                            $where = "WHERE MVMDATAMOV >=  '" . $_POST['fdate'] . "'";
                            if(!empty($post['tdate'])):
                            $where .= " and MVMDATAMOV <=  '" . $_POST['tdate'] . "'";
                            
                            endif;

                            $sql = "SELECT e.apelido AS modelo , sum(a.MVMQUANTIDADE) AS total "
                                    . "FROM TB_MVM_MOVMATITEM a "
                                    . "INNER JOIN TB_MAT_MATERIAL b ON a.MATID = b.MATID "
                                    . "INNER JOIN TB_AAT_ATRIBUTOS c ON a.matid = c.MATID "
                                    . "INNER JOIN TB_ARM_ATRMODELO d ON c.ARMID = d.ARMID "
                                    . "INNER JOIN ARM_APELIDO e ON d.ARMDESCRICAO = e.ARMDESCRICAO  "
                                    . "{$where} GROUP BY e.APELIDO ORDER BY modelo, total desc";
                            $busca = mysqli_query($conexao, $sql);        

                            while($dados = mysqli_fetch_array($busca)) {
                                $modelo = $dados['modelo'];
                                $total = $dados['total'];

                            if(mysqli_fetch_array($busca) > 0)
                                    {
                                        foreach($busca as $dados)
                                       {                                            
                                               echo $dados['modelo'];
                                               echo $dados['total'];                                           
                                        } 
                                    }
                                    else
                                    {
                                        echo "No Record Found";
                                    }

                          ?>

                          ["<?php echo $modelo ?>", "<?php echo $total ?>"]
                          <?php  } ?>
                          
                        ]);

                        var options = {
                          chart: {
                            title: 'Company Performance',
                            subtitle: 'Sales, Expenses, and Profit: 2014-2017',
                          }
                        };

                        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                        chart.draw(data, google.charts.Bar.convertOptions(options));
                    </script>


        <div id="columnchart_material" style="width: 800px; height: 500px;"></div>

    </body>
</html>
