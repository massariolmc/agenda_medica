$(document).ready(function(){//FUNÇÃO QUE EXIBE OU OCULTA ALGUMAS DIV'S
   
        $('#vespertino').hide();
        $('#matutino').hide();
   
        $('input[name=turno]:radio').click(function() {

        if($(this).val()=="outro") {
        $('#matutino').show();
        $('#vespertino').show();
        
        } 
        //else if($(this).val()=="vespertino") {
        //$('#vespertino').show();
        //$('#matutino').hide();
        
        //}
        else {
        $('#matutino').hide();
        $('#vespertino').hide();
        
        }

        });
    });

