<?php

include("banco.class.php");
abstract class base extends banco{

	//propriedades
	public $tabela		= "";
	public $campos_valores	= array();
	public $campopk		= NULL;
	public $valorpk		= NULL;
	public $extras_select	= "";

        
	//metodos
	public function addCampo($campo=NULL,$valor=NULL){
		if($campo!=NULL)
		$this->campos_valores[$campo] = $valor;
	}//addCampo
	
	public function delCampo($campo=NULL){
		if(array_key_exists($campo, $this->campos_valores))
		unset($this->campos_valores[$campo]);
	}//delCampo

	public function setValor($campo=NULL,$valor=NULL){
		if($campo!=NULL && $valor!=NULL){
                    if(is_numeric($valor))//CONDIÇÃO PARA DEIXAR TUDO MAIUSCULO PARA SER INSERIDO NO BANCO
                        $this->campos_valores[$campo] = $valor;
                    else if (strpos($valor, "@")!==false){//SE FOR EMAIL TEM QUE SER MINUSCULO
                        $this->campos_valores[$campo] = $valor;
                    }
                    else if($campo == 'usuario'){//SE FOR LOGIN TEM QUE SER MINUSCULO OS NOMES
                        $this->campos_valores[$campo] = strtolower($valor);
                    }
                    else{
                        $valor = mb_strtoupper($valor, 'UTF-8');
                        $this->campos_valores[$campo] = strtoupper($valor);
                    }
                }
		
	}//setValor	

	public function getValor($campo=NULL){

		if($campo!=NULL && array_key_exists($campo,$this->campos_valores))
			return $this->campos_valores[$campo];
		else
			return FALSE;
	}//getValor
        
        


}// FIM classe base


?>
