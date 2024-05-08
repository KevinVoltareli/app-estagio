 $read = $conn->prepare("SELECT  h.NOME_APELIDO AS NOME, sum(l.PICQTDE) AS TOTAL 
                            FROM TB_VEN_VENDA a
                            INNER JOIN TB_VPE_VENDAPEDIDOS b ON b.VENID_VENDA = a.VENID 