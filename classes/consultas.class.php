<?php

include("base.class.php");
class consultas extends base{

	public function __construct($campos=array()){
		parent::__construct();
		$this->tabela = "consultas";
		if(sizeof($campos)<=0){
			$this->campos_valores = array(
			//"cd_consulta"           => NULL,                        
                        "cd_prontuario"         => NULL,        
                        "crm"                   => NULL,
                        "especialidade"         => NULL,
			"dt_consulta"           => NULL,
                        "hr_consulta"           => NULL,
                        "dt_cad"                => NULL,                        
                        "hr_cad"                => NULL,        
                        "status"                => NULL,
                        "cid"                   => NULL,
                        "cd_acesso"             => NULL,
                        "obs"                   => NULL

			);
		}//termina IF
		else{
		$this->campos_valores = $campos;

		}
		$this->campopk = "cd_consulta";
	}
}//classe consulta

?>
