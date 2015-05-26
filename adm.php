<?php require_once("valida_login.php");     valida_login();?>
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>ADMINISTRADOR</title>
        <link href="css/estilo_form.css" rel="stylesheet" type="text/css"/>
        <link href="css/estilo_tabela.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        
        <p id="tabelas">ADMNISTRAÇÃO DO SISTEMA</p>
        <table>
        <tr>
                        <th>CADASTRO</th>
                        <th>ALTERAR/CONSULTAR/EXCLUIR</th>                
                        <th>OUTRAS OPÇÕES</th>
                        <th>RELATORIOS</th>
        </tr>
        
        <tr>
            <td><a href="index.php?p=cadastra_paciente">CADASTRA PACIENTE</a></td>
            <td><a href="index.php?p=busca&i=paciente">ALTERAR/CONSULTAR/EXCLUIR DADOS DO PACIENTE</a></td>
            <td><a href="index.php?p=busca_alt_consultas&i=alt_cancelar_consultas">DESFAZER CANCELAMENTO CONSULTA</a></td>
            <td><a href="index.php?p=rel_marcacoes">RELATÓRIO DE COMPARECIMENTO</a></td>
        </tr>
        
        <tr>
            <td><a href="index.php?p=cadastra_medico">CADASTRA MEDICO</a></td>            
            <td><a href="index.php?p=busca&i=medico">ALTERAR/CONSULTAR/EXCLUIR DADOS DO MEDICO</a></td> 
            <td><a href="index.php?p=busca_alt_consultas&i=alt_confirmar_consultas">ALTERAR CONFIRMAÇÃO CONSULTA</a></td>
            
       </tr>
        
        <tr>
            <td><a href="index.php?p=agenda">AGENDA DO MEDICO</a></td>  
            <td><a href="index.php?p=busca&i=agenda">ALTERAR/CONSULTAR/EXCLUIR AGENDA DO MEDICO</a></td>
            <td><a href="index.php?p=busca_exibe">EXIBE TODOS OS PACIENTES MARCADOS POR DIA</a></td>
                               
        </tr>
        <tr>             
            <td><a href="index.php?p=cadastra_especialidade">CADASTRA ESPECIALIDADE</a></td>
            <td><a href="index.php?p=busca&i=especialidade">ALTERAR/CONSULTAR/EXCLUIR ESPECIALIDADE</a></td>
            <td><a href="upload/form_upload.php">IMPORTAR ARQUIVO DA DIRSA</a></td>
            
                       
        </tr>     
        <tr>             
            
            <td><a href="index.php?p=cadastra_usuario">CADASTRA USUARIO</a></td>
            <td><a href="index.php?p=busca&i=usuario">ALTERAR/CONSULTAR/EXCLUIR DADOS DO USUARIO</a></td>
            <td><a href="index.php?p=saram">CONSULTA DIRSA</a></td>
            
        </tr>
       </table>         
       
    </body>
</html>
