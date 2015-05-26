$(document).ready(function(){
            $("#selecionarTodos").click(function(){ 
                
                    if ($("input[type='checkbox']").prop("checked")) {  
                    $(':checkbox').prop('checked', '');  
                    $(this).text('Selecionar todos');  
                } 
                else {  
                    $(':checkbox').prop('checked', 'checked');  
                    $(this).text('Deselecionar todos');  
                } 
                     
            });
            
            $("#Matutino").click(function(){ 
                
                    if ($('.mat').prop("checked")) {  
                    $('.mat').prop('checked', false);  
                    $(this).text('Selecionar todos matutinos');  
                } 
                else {  
                    $('.mat').prop('checked', true);  
                    $(this).text('Deselecionar todos matutinos');  
                } 
                     
            });
            
            $("#Vespertino").click(function(){ 
                
                    if ($('.ves').prop("checked")) {  
                    $('.ves').prop('checked', false);   
                    $(this).text('Selecionar todos vespertinos');  
                } 
                else {  
                    $('.ves').prop('checked', true);  
                    $(this).text('Deselecionar todos vespertinos');  
                } 
                     
            });
            $("#Noturno").click(function(){ 
                
                    if ($('.not').prop("checked")) {  
                    $('.not').prop('checked', false);   
                    $(this).text('Selecionar todos noturnos');  
                } 
                else {  
                    $('.not').prop('checked', true);  
                    $(this).text('Deselecionar todos noturnos');  
                } 
                     
            });
            
        });
/* ORIGINAL
 $(document).ready(function(){
            $("#selecionarTodos").click(function(){  
                
                    if ($("input[type='checkbox']").prop("checked")) {  
                    $(':checkbox').prop('checked', '');  
                    $(this).text('Selecionar todos');  
                } 
                else {  
                    $(':checkbox').prop('checked', 'checked');  
                    $(this).text('Deselecionar todos');  
                } 
              });
        });    


 * */