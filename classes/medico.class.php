<?php


include("base.class.php");
class medicos extends base{

	public function __construct($campos=array()){
		parent::__construct();
		$this->tabela = "medico";
		if(sizeof($campos)<=0){
			$this->campos_valores = array(
			//"cd_med"            => NULL, 
                        "crm"               => NULL,     
                        "cd_acesso"         => NULL, 
                        "cd_agenda"         => NULL,
                        "nome_med"          => NULL,    
			"cd_especialidade"  => NULL,
                        "dt_nasc"           => NULL,
                        "sexo"              => NULL,
                        "nr_tel"            => NULL,
                        "nr_cel"            => NULL,                        
                        "op_cel"            => NULL,        
                        "dt_cad"            => NULL     

			);
		}//termina IF
		else{
		$this->campos_valores = $campos;

		}
		$this->campopk = "cd_med";
	}
}//classe medico

?>
