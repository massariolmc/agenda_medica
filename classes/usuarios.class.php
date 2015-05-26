<?php
include("base.class.php");
include('../conecta.php');
class usuarios extends base{

	public function __construct($campos=array()){
		parent::__construct();
		$this->tabela = "usuarios";
		if(sizeof($campos)<=0){
			$this->campos_valores = array(
                            //"cd_acesso"     => NULL,
                            "usuario"       => NULL,
                            "senha"         => NULL,
                            "tp_acesso"     => NULL,
                            "nome_acesso"   => NULL

			);
		}//termina IF
		else{
		$this->campos_valores = $campos;

		}
		$this->campopk = "cd_acesso";
	}       
        
}//classe usuarios

?>