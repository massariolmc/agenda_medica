<?php

abstract class banco {
        public $servidor	= 'localhost';
	public $porta		= '5432';
	public $usuario		= 'postgres';
	public $senha		= '123456';
	public $nomebanco	= 'agenda_medica';
	public $conexao		= NULL;
	public $dataset		= NULL;
	public $linhasafetadas	= -1;
       

//metodos

	public function __construct(){
                
                $this->conecta();
}//construct

	public function __destruct(){
             
		if($this->conexao != NULL){
		pg_close($this->conexao);
                }
}//destruct

	public function conecta(){            
           
            $this->conexao = pg_connect("host=$this->servidor port=$this->porta dbname=$this->nomebanco user=$this->usuario password=$this->senha") or die ($this->trataerro(__FILE__,__FUNCTION__,  NULL,TRUE));
        
           
}//conecta


public function inserir($objeto){

	$sql = "INSERT INTO ".$objeto->tabela." (";
	for($i=0; $i<count($objeto->campos_valores); $i++){
		$sql.= key($objeto->campos_valores);
		if($i < (count($objeto->campos_valores)-1))
                    $sql.= ", ";
		else
                    $sql.= ") ";
                    next($objeto->campos_valores);
		}
		reset($objeto->campos_valores);
		$sql.= "VALUES (";
		
		for($i=0; $i<count($objeto->campos_valores); $i++){
                    $sql.= is_numeric($objeto->campos_valores[key($objeto->campos_valores)]) ?
                    $objeto->campos_valores[key($objeto->campos_valores)] :
                    "'".$objeto->campos_valores[key($objeto->campos_valores)]."'";

                    if($i < (count($objeto->campos_valores)-1))
                        $sql.= ", ";
                    else
			$sql.= ") ";
			next($objeto->campos_valores);
		}
                reset($objeto->campos_valores);		
		return $this->executaSql($sql);
		
	}//inserir
        
        
public function atualiza($objeto){
    $sql = "UPDATE ".$objeto->tabela." SET " ;
	for($i=0; $i<count($objeto->campos_valores); $i++){
		$sql.= key($objeto->campos_valores)."=";                
                $sql.= is_numeric($objeto->campos_valores[key($objeto->campos_valores)]) ?
                $objeto->campos_valores[key($objeto->campos_valores)] :
                "'".$objeto->campos_valores[key($objeto->campos_valores)]."'";
		if($i < (count($objeto->campos_valores)-1))
                    $sql.= ", ";
		else
                    $sql.= " ";
                    next($objeto->campos_valores);
		}                
		
                $sql .= "WHERE ".$objeto->campopk."=";
                $sql .= is_numeric($objeto->valorpk) ? $objeto->valorpk : "'".$objeto->valorpk."'";
                reset($objeto->campos_valores);                
		return $this->executaSql($sql);    
    
}//atualiza

public function deletar($objeto){
    
        $sql = "DELETE FROM ".$objeto->tabela;             
	$sql .= " WHERE ".$objeto->campopk."=";
        $sql .= is_numeric($objeto->valorpk) ? $objeto->valorpk : "'".$objeto->valorpk."'";
	//echo $sql;
        return $this->executaSql($sql);    
    
}//deletar

public function selecionaTudo($objeto){

	$sql = "SELECT * FROM ".$objeto->tabela;
	if($objeto->extras_select!=NULL)
		$sql .= " ".$objeto->extras_select;
        
	return $this->executaSql($sql);

}//selecionaTudo

public function selecionaCampos ($objeto){

	$sql .= "SELECT ";
	for($i=0; $i<count($objeto->campos_valores);$i++){
			$sql.= key($objeto->campos_valores);
			if($i < (count($objeto->campos_valores)-1))
			$sql.= ", ";
			else
			$sql.= " ";
			next($objeto->campos_valores);
		}
	$sql .= " FROM ".$objeto->tabela;
	if($objeto->extras_select!=NULL)
		$sql .= " ".$objeto->extras_select;
	return $this->executaSql($sql);

}//selecionaCampos

public function executaSql($sql=NULL){
       	if($sql != NULL){            
               	$query = pg_query($sql) or $this->trataerro(__FILE__,__FUNCTION__);                
		$this->linhasafetadas = pg_affected_rows($query);// no video mostra que tem ser pg_affect_rows($this_conexão), mas não funciona
                if(substr(trim(strtolower($sql)),0,6)=='select'){
                    $this->dataset = $query;
                    return $query;
                }
                else
                    return $this->linhasafetadas;
                
        }
	else{
	$this->trataerro(__FILES__,__FUNCTION__,NULL,'COMANDO SQL NÃO INFORMADO NA ROTINA', FALSE);
	}
}//executaSql

public function retornaDados ($tipo=NULL){
	switch (strtolower($tipo)):
		case "array":
		return pg_fetch_array($this->dataset);
		break;

		case "assoc":
		return pg_fetch_assoc($this->dataset);
		break;

		case "object":
		return pg_fetch_object($this->dataset);
		break;

		default:
		return pg_fetch_object($this->dataset);
		break;
	endswitch;
}//retornaDados

public function trataerro($arquivo=NULL, $rotina=NULL,$msgerro=NULL, $geraexcept=FALSE){
	if($arquivo==NULL) $arquivo	="não informado";
	if($rotina==NULL) $rotina	="nao informada";
	if($msgerro==NULL) $msgerro	=  pg_last_error($this->conexao);
	$resultado	=	'Ocorreu um erro com os seguintes detalhes: <br/>
	<strong>Arquivo:</strong> '.$arquivo.'<br/>
	<strong>Rotina:</strong> '.$rotina.'<br/>
	<strong>Mensagem:</strong> '.$msgerro;
	
	if($geraexcept==FALSE)	echo($resultado);
	else			die($resultado);
}//trataerro


}//banco

?>
