
<?php

include("base.class.php");
class especialidade extends base{

	public function __construct($campos=array()){
		parent::__construct();
		$this->tabela = "especialidade";
		if(sizeof($campos)<=0){
			$this->campos_valores = array(
			//"cd_especialidade"    => NULL,                        
                        "especialidade"       => NULL
                       );
		}//termina IF
		else{
		$this->campos_valores = $campos;

		}
		$this->campopk = "cd_especialidade";
	}
}//classe endereco

?>