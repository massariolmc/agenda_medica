<?php

if($con!=-1)//verifica se já foi aberta uma conexao
include("conecta.php"); //OBS: FOI RETIRADO PORQUE SEI FICAR DA ERRO, POIS ESTA FUNÇÃO JÁ FOI INSERIDA NO INDEX.PHP

function verifica($crm,$aux,$mes, $espec){
abreconexao();       

$sql = "SELECT dt FROM agenda WHERE crm=".$crm." AND especialidade='".$espec."'";
                            $query = pg_query($sql);
                            $h = pg_affected_rows($query);
                            $marc = 0;
                            if($h > 0){
			    $cont = count($aux);                            
                            while($tbl = pg_fetch_object($query)){                                   
				for($i=0;$i<$cont;$i++){                       	
					if((date('d',strtotime($tbl->dt))) == $aux[$i] && (date('m',strtotime($tbl->dt))) == $mes){
						$k[] = date('d/m/Y',strtotime($tbl->dt));
                                                $marc = 1;
                                        }
				}
                            }
                            if($marc == 1){
                                $aux = 0;// ROTINA ABAIXO PARA NÃO REPETIR AS DATAS JA CADASTRADAS
                                $marc2 = 0;
                                $qtde = count($k);                              
                                    for($i=0; $i<$qtde; $i++){
                                        $aux2[] = $k[$i];
                                        if($aux == 0){
                                            echo"<br>A DATA ".$k[$i]." JÁ ESTÁ AGENDADA.";
                                            $aux = 1;
                                        }
                                        else{
                                            $qtde2 = count($aux2)-1;                                            
                                            for($j=0; $j<$qtde2;$j++){
                                                if($k[$i] == $aux2[$j]){
                                                    $marc2 = 1;
                                                }                                      
                                            }
                                            if($marc2 == 0){
                                                echo"<br>A DATA ".$k[$i]." JÁ ESTÁ AGENDADA.";                                        
                                            }
                                            $marc2 = 0;
                                        }
                                     }
                                     
                                            
                                echo "<br><p><a href=\"#\" onclick=\"history.go(-1)\">VOLTAR</a></p>";
                                fechaconexao();                            
                                exit();
                            }
                            }                            
                            
}
?>
