<?php
require('../ticketpdf/fpdf186/fpdf.php');

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Factura', 0, 1, 'C');
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
    }

    function ChapterTitle($title)
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, $title, 0, 1);
        
    }

    function ChapterBody($body)
    {
        $this->SetFont('Arial', '', 12);
        $this->MultiCell(0, 10, $body);
        $this->Ln();
    }

    function Table($header, $data)
    {
        $this->SetFont('Arial', 'B', 12);
        foreach ($header as $col) {
            $this->Cell(39, 7, $col, 1);
        }
        $this->Ln();
        $this->SetFont('Arial', '', 6);
        foreach ($data as $row) {
            foreach ($row as $item) {
                $this->Cell(39, 7, $item, 1);
            }
            $this->Ln();
        }
    }
}

// Create PDF object
$pdf = new PDF();
$pdf->AddPage();

// Add "Factura para:"
$pdf->SetXY(10, 30); // Set position X, Y
$pdf->Cell(0, 10, 'Factura para:', 0, 1, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 10, "Yahir Rocha\n121 E Parkview St, IN 45240\nToronto, Ontario\nCanada");

// Add "Pagar a:"
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Pagar a:', 0, 1, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 10, "Digital Invoico\n4510 E Dolphine St, IN 3456\nHill Road, New York\nUnited States");

// Add service table
$header = ['Service', 'Description', 'Qty', 'Price', 'Total'];
$data = [
    ['Marketing', 'Digital Marketing & SEO', '2', '$120', '$240.00'],
    ['Web Design & Development', 'Desktop & Mobile Web App Design', '2', '$250', '$500.00'],
    ['UI/UX Design', 'Mobile Android & iOS App Design', '1', '$80', '$80.00']
];

$pdf->Table($header, $data);

// Add additional information

$additional_info = "This is a sample text used for fill the space with nothing, i like to see the sky all days when we eat a big hamburger or a big piece of roasted chicken with a lot of spicy sauce, my house is very enormous. Too many people in the United States, think that the milk with chocolate comes from brown cows, this is crazy, I do not believe that this is real.";

   // Add totals
$totals = [
    ['SubTotal', '$820.00'],
    ['Tax: (18%)', '$147.60'],
    ['Grand Total:', '$967.60']
];



$pdf->ChapterTitle('Totales');
$pdf->Table([], $totals);
$pdf->Ln(40); // Salta 10 unidades de altura
$pdf->Ln(40); // Salta 10 unidades de altura
$pdf->Ln(40); // Salta 10 unidades de altura
$pdf->ChapterTitle('Additional information');
$pdf->ChapterBody($additional_info);



// Output the PDF to download
$pdf->Output('D', 'factura.pdf');
?>
