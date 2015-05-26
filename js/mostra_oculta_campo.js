$(document).ready(function(){//FUNÇÃO QUE EXIBE OU OCULTA ALGUMAS DIV'S
   
        $('#espec').hide();
   
        $('#especialidade').click(function() {

        if($(this).val()=="outro") {
        $('#espec').show();
        
        } 
        else {
        $('#espec').hide();
        
        }

        });
    });
