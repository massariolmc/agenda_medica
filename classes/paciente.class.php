
<?php

include("base.class.php");
class pacientes extends base{

	public function __construct($campos=array()){
		parent::__construct();
		$this->tabela = "paciente";
		if(sizeof($campos)<=0){
			$this->campos_valores = array(
			//"cd_paciente"      => NULL,                        
                        "cd_acesso"        => NULL,        
                        "nome_paciente"    => NULL,    
			"dt_nasc"          => NULL,
                        "dt_cad"           => NULL,
                        "sexo"             => NULL,                        
                        "est_civil"        => NULL,        
                        "nr_tel"           => NULL,    
			"nr_cel"           => NULL,
                        "op_cel"           => NULL,
                        "email"            => NULL,                        
                        "cd_prontuario"    => NULL,        
                        "endereco"         => NULL,      
                        "cidade"           => NULL,      
                        "bairro"           => NULL,      
                        "uf"               => NULL,      
                        "numero"           => NULL,          
                        "cep"              => NULL,
                        "tipo"             => NULL,
                        "saram"            => NULL,

			);
		}//termina IF
		else{
		$this->campos_valores = $campos;

		}
		$this->campopk = "cd_paciente";
	}
}//classe paciente

?>



