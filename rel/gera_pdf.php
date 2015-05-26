<?php
define('MPDF_PATH', '../../classes/MPDF56/');
include(MPDF_PATH.'../../classes/MPDF56/mpdf.php');
$mpdf=new mPDF();
$mpdf->allow_charset_conversion=true;
$mpdf->charset_in='UTF-8';
$mpdf->SetFooter('{DATE j/m/Y H:i}|{PAGENO}/{nb}|ES / ETI');
//$mpdf->SetDisplayMode('fullpage');
//$stylesheet = file_get_contents('../../css/estilo_rel.css');
//$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML($html);
$mpdf->Output();
exit();
?>

