<?php
 include("conecta.php");
                    $estado = $_POST['estado'];
                    
                    abreconexao();      
                            $sql = "SELECT cd_especialidade FROM medico WHERE crm='".$estado."' ORDER BY cd_especialidade ASC";
                            $query = pg_query($sql);
                    
                            if(pg_num_rows($query) == 0){
                            echo  '<option value="0">'.htmlentities('Nao existe especialidade').'</option>';
                            }
                    
                            else{
                                while($tbl = pg_fetch_object($query)){
                                echo "<option value='".$tbl->cd_especialidade."'>".$tbl->cd_especialidade."</option>";
                                }                     
                            }
                    fechaconexao();
                ?>
