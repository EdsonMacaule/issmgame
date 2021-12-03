<?php
//require_once "../Librarys/fpdf183/fpdf.php";
//require_once "../includes/user.php";
////Criando a instancia
//$objUs = new Usuario();
//
//$pdf = new FPDF('L');
//$pdf->AddPage();
////Nome do Arquivo
//$arquivo = "informacoes-do-challenge.pdf";
////Definindo formacoes do PDF
//$fonte="Arial";
//$style="";
//$border="1";
//$LinhaC="C";
//$tipo_pdf = "I";
//$pdf->SetTitle('Dados do Challenge',true);
////$id="";
//$pdf->Header();
//$pdf->SetFont($fonte,'B',9);
//$pdf->Cell(40,5,"Nivel do Jogo",$border,0,"L");
//$pdf->Cell(40,5,utf8_decode("Pontuação"),$border,0,"L");
//$pdf->Cell(63,5,"Nome do Estudate",$border,0,"L");
//$pdf->Cell(20,5,"Nome do Challenge",$border,0,"L");
//$pdf->Cell(20,5,"Data&Hora",$border,1,"L");
//foreach ($objUs->challenge_status('id') as $rstUs){
//    $pdf->SetFont($fonte,$style, 9);
//    $pdf->Cell(40,5,$rstUs["numero_nivel_jogo"],$border,0,"L");
//    $pdf->Cell(40,5,$rstUs["pontuacao"],$border,0,"L");
//    $pdf->Cell(63,5,$rstUs["nome_aluno"],$border,0,"L");
//    $pdf->Cell(20,5,$rstUs["apelido_aluno"],$border,0,"L");
//    $pdf->Cell(70,5,$rstUs["nome_challenge"],$border,0,"L");
//    $pdf->Cell(20,5,$rstUs["data"],$border,1,"L");
//}
//
//$pdf->Footer();
//$pdf->SetFont($fonte,'BI',12);
//$pdf->Cell(0,10,utf8_decode('Página').$pdf->PageNo().'/{nb}',0,0,'C');
//$pdf->AliasNbPages();
//$pdf->SetAuthor('ISSM',true);
////Fechando o Arquivo
//$pdf->Output($arquivo,$tipo_pdf);
//
//
//?>