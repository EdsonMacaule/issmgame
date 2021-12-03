<?php
require_once "../Librarys/fpdf183/fpdf.php";
require_once "../includes/user.php";
//Criando a instancia
$objUs = new Usuario();

$pdf = new FPDF('L');
$pdf->AddPage();
//Nome do Arquivo
$arquivo = "Dados-dos-usuarios.pdf";
//Definindo formacoes do PDF
$fonte="Arial";
$style="";
$border="1";
$LinhaC="C";
$tipo_pdf = "I";
$pdf->SetTitle('Dados dos Usuários',true);

$pdf->Header();
$pdf->SetFont($fonte,'B',9);
$pdf->Cell(40,5,"Nome",$border,0,"L");
$pdf->Cell(40,5,"Apelido",$border,0,"L");
$pdf->Cell(63,5,"Email",$border,0,"L");
$pdf->Cell(20,5,"Telefone",$border,0,"L");
$pdf->Cell(70,5,utf8_decode("Instituição de Ensino"),$border,0,"L");
$pdf->Cell(17,5,"N/Ac",$border,0,"L");
$pdf->Cell(8,5,"C/A",$border,0,$LinhaC);
$pdf->Cell(20,5,"Nascimento",$border,1,"L");
foreach ($objUs->studety() as $rstUs){
    $pdf->SetFont($fonte,$style, 9);
    $pdf->Cell(40,5,utf8_decode($rstUs["nome_aluno"]),$border,0,"L");
    $pdf->Cell(40,5,utf8_decode($rstUs["apelido_aluno"]),$border,0,"L");
    $pdf->Cell(63,5,$rstUs["email_aluno"],$border,0,"L");
    $pdf->Cell(20,5,$rstUs["numero_telefone"],$border,0,"L");
    $pdf->Cell(70,5,utf8_decode($rstUs["escola_aluno"]),$border,0,"L");
    $pdf->Cell(17,5,utf8_decode($rstUs["nome_nivel"]),$border,0,"L");
    $pdf->Cell(8,5,$rstUs["ano_aluno"],$border,0,$LinhaC);
    $pdf->Cell(20,5,$rstUs["data_nasc_aluno"],$border,1,"L");
}

$pdf->Footer();
$pdf->SetFont($fonte,'BI',12);
$pdf->Cell(0,10,utf8_decode('Página').$pdf->PageNo().'/{nb}',0,0,'C');
$pdf->AliasNbPages();
$pdf->SetAuthor('ISSM',true);
//Fechando o Arquivo
$pdf->Output($arquivo,$tipo_pdf);








?>