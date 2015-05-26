$(document).ready( function() {
	$("#form_rel").validate({
		/* REGRAS DE VALIDAÇÃO DO FORMULÁRIO */
		rules:{
			
                        rel:{
				required: true, /* Campo obrigatório */
                                
			},
                        mesano:{
				required: true, /* Campo obrigatório */
                                
			},
			medico:{
				required: true, /* Campo obrigatório */
                                
			},
			especialidade:{
				required: true, /* Campo obrigatório */
                                
			}
                },
                        /* DEFINIÇÃO DAS MENSAGENS DE ERRO */
		messages:{
			
                        rel:{
				required: "Selecione algum <u>Relatório</u>"
                                
			},
                        mesano:{
				required: "Selecione o campo <u>Mes/Ano</u>"
                                
			},
                        medico:{
				required: "Selecione o campo <u>Medico</u>"
                                
			},
			especialidade:{
				required: "Selecione o campo <u>Especialidade</u>"
                                
			}
                        
		}
	});
});
