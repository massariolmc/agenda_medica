<?php
require_once("conecta.php"); //OBS: FOI RETIRADO PORQUE SEI FICAR DA ERRO, POIS ESTA FUNÇÃO JÁ FOI INSERIDA NO INDEX.PHP

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>RELATORIOS</title>
        <link href="css/estilo_form.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="js/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.min.css" />            
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js"></script>
        <script type="text/javascript" src="js/jquery.validate.js"></script>        
        <script type="text/javascript" src="js/mostraoculta_rel.js"></script>
        <script type="text/javascript" src="js/valida_rel_marcacoes.js"></script>
    </head>
    <body>
        
        <div id="rel"> 
             
        <form id="form_rel" name="form_rel" method="POST" action="rel.php">
            <fieldset name="incluir">
                <legend>RELATÓRIOS DAS CONSULTAS</legend>
                <p id="rel">ESCOLHA SUA OPÇÃO</p>                
                                       
                <label id="rel">RELATÓRIO DE CONSULTAS ATENDIDAS</label><br/>
                <input type="radio" name="rel" value="1" id="rel">RELATÓRIO DE TODAS AS CONSULTAS ATENDIDAS<br/>
                <input type="radio" name="rel" value="2" id="rel">RELATÓRIO DE CONSULTAS ATENDIDAS POR MÉDICO<br/>
                <input type="radio" name="rel" value="3" id="rel">RELATÓRIO DE CONSULTAS ATENDIDAS POR ESPECIALIDADE<br/>
                <br/><br>
                <label id="rel">RELATÓRIO DE MARCAÇÕES CANCELADAS</label><br/>
                <input type="radio" name="rel" value="4" id="rel">RELATÓRIO DE TODAS AS MARCAÇÕES CANCELADAS<br/>
                <input type="radio" name="rel" value="5" id="rel">RELATÓRIO DAS MARCAÇÕES CANCELADAS POR MÉDICO<br/>
                <input type="radio" name="rel" value="6" id="rel">RELATÓRIO DAS MARCAÇÕES CANCELADAS POR ESPECIALIDADE<br/>
                <br/><br>
                <label id="rel">RELATÓRIO DE ABSETEISMO</label><br/>
                <input type="radio" name="rel" value="7" id="rel">RELATÓRIO DE ABSENTEÍSMO<br/>
                <input type="radio" name="rel" value="8" id="rel">RELATÓRIO DE ABSENTEÍSMO POR MÉDICO<br/>
                <input type="radio" name="rel" value="9" id="rel">RELATÓRIO DE ABSENTEÍSMO POR ESPECIALIDADE<br/>
                <br/><br>
                <label id="rel">RELATÓRIO DAS QUANTIDADES DE MARCAÇÕES</label><br/>
                <input type="radio" name="rel" value="10" id="rel">RELATÓRIO DAS QUANTIDADES SEPARADO POR TIPO<br/>
                <br/><br>
                <label id="rel">RELATÓRIO DAS QUANTIDADES DE CID</label><br/>
                <input type="radio" name="rel" value="11" id="rel">RELATÓRIO DAS QUANTIDADES DE CID<br/>
                <br/><br>
                <label id="rel">RELATÓRIO DOS PACIENTES COM DETERMINADO CID</label><br/>
                <input type="radio" name="rel" value="12" id="rel">RELATÓRIO DOS PACIENTES COM DETERMINADO CID<br/>                
                <br/><br>
                <label id="rel">RELATÓRIO DOS PACIENTES POR GRUPO (IDADE)</label><br/>
                <input type="radio" name="rel" value="13" id="rel">RELATÓRIO DOS PACIENTES POR GRUPO<br/>
                <br/><br>
                
                <label>ESCOLHA O MES/ANO:*</label>
                <select name="mesano" id="mesano">
                    <option value="">SELECIONAR</option>                    
                     <?php                        
                            abreconexao();                            
                            $sql = "SELECT LPAD(DATE_PART('MONTH', dt_consulta)::TEXT,2,'0')||'/'||DATE_PART('YEAR', dt_consulta) AS \"MESANO\"
                                    FROM consultas GROUP BY LPAD(DATE_PART('MONTH', dt_consulta)::TEXT,2,'0')||'/'||DATE_PART('YEAR', dt_consulta)";
                            $query = pg_query($sql);
                            $cont = pg_affected_rows($query);
                            echo"cont".$cont;
                            if($cont > 0){                                
                                while($tbl = pg_fetch_object($query)){
                                    echo "<option value='".$tbl->MESANO."'>".$tbl->MESANO."</option>";
                                } 
                            }
                           fechaconexao();
                    ?>                   
                </select>  
                <br/><br/>
                <div id="medico">
                <label>SELECIONE O MEDICO*:</label>
                <select name="medico" id="medico">
                    <option value="">SELECIONAR</option>                    
                     <?php                        
                            abreconexao();                            
                            $sql = "SELECT distinct m.crm,nome_med FROM consultas c INNER JOIN medico m ON (c.crm=m.crm AND c.especialidade=m.cd_especialidade) ORDER BY nome_med";
                            $query = pg_query($sql);
                            $cont = pg_affected_rows($query);
                            echo"cont".$cont;
                            if($cont > 0){                                
                                while($tbl = pg_fetch_object($query)){
                                    echo "<option value='".$tbl->crm."'>".$tbl->nome_med."</option>";
                                } 
                            }
                           fechaconexao();
                    ?>                   
                </select>              
                </div>
                <br/><br/>
                <div id="especialidade">
                <label>SELECIONE A ESPECIALIDADE*:</label>
                <select name="especialidade" id="especialidade">
                    <option value="">SELECIONAR</option>                    
                     <?php                        
                            abreconexao();                            
                            $sql = "SELECT distinct especialidade FROM consultas c INNER JOIN medico m ON (c.crm=m.crm AND c.especialidade=m.cd_especialidade) ORDER BY especialidade";
                            $query = pg_query($sql);
                            $cont = pg_affected_rows($query);
                            echo"cont".$cont;
                            if($cont > 0){                                
                                while($tbl = pg_fetch_object($query)){
                                    echo "<option value='".$tbl->especialidade."'>".$tbl->especialidade."</option>";
                                } 
                            }
                           fechaconexao();
                    ?>                   
                </select>              
                </div>        
                            
                <br/><br/>                
                <input type="submit" value="OK" class="botaoForm">
                           
            </fieldset>
            
        </form>
          </div>
        
        <?php
        // put your code here
        ?>
    </body>
</html>

