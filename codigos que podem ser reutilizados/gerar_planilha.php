<?php

  session_start();
  if(!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] != 'SIM'){
    header('Location: index.php?login=erro2');
  }

?>   

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <title>Planilha de vendas</title>
  <head>
  <body>
    <?php
    // Definimos o nome do arquivo que será exportado
    $arquivo = 'vendas.xls';
    // Criamos uma tabela HTML com o formato da planilha
    $html = '';
    $html .= '<table border="1">';
    $html .= '<tr>';
    $html .= '<td colspan="5">Total vendas</td>';
    $html .= '</tr>';
    
    $html .= '<tr>';
    $html .= '<td><b>ID</b></td>';
    $html .= '<td><b>Produto</b></td>';
    $html .= '<td><b>Valor</b></td>';
    $html .= '<td><b>Total</b></td>';
    $html .= '</tr>'; ?>
    
    $html .= '<tr>';
    $html .= '<td>1</td>';
    $html .= '<td>Cesar</td>';
    $html .= '<td>cesar@celke.com.br</td>';
    $html .= '<td>Dúvida sobre o curso</td>';
    $html .= '<td>01/01/2016</td>';
    $html .= '</tr>';
    
    <?php
    $html .= '</table>';
    
    // Configurações header para forçar o download
    header ("Expires: Mon, 07 Jul 2016 05:00:00 GMT");
    header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
    header ("Cache-Control: no-cache, must-revalidate");
    header ("Pragma: no-cache");
    header ("Content-type: application/x-msexcel");
    header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
    header ("Content-Description: PHP Generated Data" );
    // Envia o conteúdo do arquivo
    echo $html;
    exit;?>
  </body>
</html>