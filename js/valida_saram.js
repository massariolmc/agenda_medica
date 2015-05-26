$(document).ready( function() {
	$("#form_saram").validate({
		/* REGRAS DE VALIDAÇÃO DO FORMULÁRIO */
		rules:{
			
                        saram:{
				required: true, /* Campo obrigatório */
                                digits:true,     /* Só aceita numero */
                                minlength: 6
                                
			}
                },
                        /* DEFINIÇÃO DAS MENSAGENS DE ERRO */
		messages:{
			
                        saram:{
				required: "Preencha o campo <u>SARAM</u>",
                                digits: "Preencha o campo <u>SARAM</u> apenas com numeros",
                                minlength:"O campo não contém 6 caracteres"
                                
			}
                        
                        
		}
	});
});
