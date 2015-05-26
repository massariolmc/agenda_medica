<?php
  include("conecta.php");
                    $estado = $_POST['estado'];
                    
                    abreconexao();                                    
                            
                            $sql = "SELECT crm,nome_med FROM medico WHERE situacao=1 AND cd_especialidade='".$estado."' ORDER BY nome_med ASC";
                            $query = pg_query($sql);
                    
                            if(pg_num_rows($query) == 0){
                            echo  '<option value="0">'.htmlentities('Nao existe medico').'</option>';
                            }
                    
                            else{
                                while($tbl = pg_fetch_object($query)){
                                echo "<option value='".$tbl->crm."'>".$tbl->nome_med."</option>";
                                }                     
                            }
                    fechaconexao();
                ?>
