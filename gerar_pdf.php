<?php
require('fpdf.php');

class PDF extends FPDF
{
    function Header()
    {

        // Logo
        $this->Image('logo.png',10,6,30);
        // Título
        $this->SetFont('Arial','B',15);
        $this->Cell(80);
        $this->Cell(30,10, iconv('UTF-8', 'windows-1252','Título do Documento'),0,0,'C');
        $this->SetFont('Arial','I',10);
        $this->Cell(50);
        $this->Cell(30,10, iconv('UTF-8', 'windows-1252', date("d/m/y h:i")),0,0,'C');
        $this->Ln(30);
        // Cabeçalho
        $this->SetFont('Arial','B',14);
        $this->SetFillColor(196, 196, 196); // cor de fundo do cabeçalho
        $this->Cell(90,10,'Nome',0,0,'L', true);
        $this->Cell(40,10,'Idade',0,0,'L', true);
        $this->Cell(60,10,'Cidade',0,0,'L', true);
        $this->Ln();
    }

    function Footer()
    {
        // Rodapé
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10, iconv('UTF-8', 'windows-1252','Página ').$this->PageNo().'/{nb}',0,0,'C');
    }

    function ChapterTitle($num, $label)
    {
        // Título do capítulo
        $this->SetFont('Arial','',12);
        $this->SetFillColor(200,220,255);
        $this->Cell(0,6,"Capítulo $num : $label",0,1,'L',true);
        $this->Ln(4);
    }

    function ChapterBody($file)
    {
        // Lê o arquivo de texto
        $txt = file_get_contents($file);
        $this->SetFont('Times','',12);
        // Saída do texto justificado
        $this->MultiCell(0,5,$txt);
        $this->Ln();
        // Citação em itálico
        $this->SetFont('','I');
        $this->Cell(0,5,'(end of excerpt)');
    }

    function PrintChapter($num, $title, $file)
    {
        // Adiciona um capítulo
        $this->AddPage();
        $this->ChapterTitle($num,$title);
        $this->ChapterBody($file);
    }


    // Função para calcular o número de linhas do texto
    function NbLines($w, $txt) {
        $cw = &$this->CurrentFont['cw'];
        if($w == 0) {
            $w = $this->w - $this->rMargin - $this->x;
        }
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $wmax = intval($wmax);
        $s = str_replace("\r", "", $txt);
        $s = wordwrap($s, $wmax, "\n", false);
        $nb = substr_count($s, "\n") + 1;
        return $nb;
    }

    function SetCellHeight($pdf, $altura) {
        $pdf->SetY($pdf->GetY() - $altura);
        $pdf->SetX($pdf->GetX() + 60);
        $pdf->Cell(60, $altura, '', 1);
        $pdf->SetY($pdf->GetY() - $altura);
        $pdf->SetX($pdf->GetX() + 60);
        $pdf->Cell(60, $altura, '', 1);
    }
}


$registros = json_decode($_POST['registros'], true);

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Definição do estilo das células
$pdf->SetFont('Arial','',12);
$zebrado = true; // variável para alternar entre as cores de fundo das células
foreach ($registros as $registro) {
    $pdf->SetFillColor($zebrado ? 240 : 255); // cor de fundo das células
    $nome_h = $pdf->NbLines(90, $registro['nome']) * 10;
    $idade_h = $pdf->NbLines(40, $registro['idade']) * 10;
    $cidade_h = $pdf->NbLines(50, $registro['cidade']) * 10;

    $pdf->MultiCell(90, $nome_h, iconv('UTF-8', 'windows-1252', $registro['nome']), 0, 'L', $zebrado);
    $pdf->SetY($pdf->GetY() - $nome_h);
    $pdf->SetX(100);
    $pdf->MultiCell(40, $idade_h, iconv('UTF-8', 'windows-1252', $registro['idade']), 0, 'L', $zebrado);
    $pdf->SetY($pdf->GetY() - $idade_h);
    $pdf->SetX(140);
    $pdf->MultiCell(60, $cidade_h, iconv('UTF-8', 'windows-1252', $registro['cidade']), 0, 'L', $zebrado);

  //  $pdf->Ln($altura);
    $zebrado = !$zebrado; // alterna a variável zebr
}
// Saída do PDF
$pdf->Output('tabela.pdf', 'I');
?>
