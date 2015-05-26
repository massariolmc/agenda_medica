$(document).ready( function() {
	$("#form_agenda").validate({
		/* REGRAS DE VALIDAÇÃO DO FORMULÁRIO */
		rules:{
			
                        comp:{
				required: true, /* Campo obrigatório */
                                
			},
                        cid:{
				required: true, /* Campo obrigatório */
                                minlength:3
                                
			}
                        
                        
                },
                        /* DEFINIÇÃO DAS MENSAGENS DE ERRO */
		messages:{
			
                        comp:{
				required: "Selecione uma opção"
                                
			},
                        cid:{
				required: "Escolha uma opção no campo <u>Especilidade</u>",
                                minlength:"O campo não contém 3 caracteres"
                                
			}
                             
		}
	});
        
});

