<?php

include("base.class.php");
class agenda extends base{

	public function __construct($campos=array()){
		parent::__construct();
		$this->tabela = "agenda";
		if(sizeof($campos)<=0){
			$this->campos_valores = array(
			//"cd_agenda"             => NULL,                        
                        "crm"                   => NULL,        
                        "especialidade"         => NULL,    
			"dt"                    => NULL,
                        "hr"                    => NULL,
                        "dt_cad"                => NULL,                        
                        "hr_cad"                => NULL,
                        "cd_acesso"             => NULL,
			);
		}//termina IF
		else{
		$this->campos_valores = $campos;

		}
		$this->campopk = "cd_agenda";
	}
}//classe consulta

?>
