<?php
require_once('TCPDF-main/tcpdf.php');

// Retrieve data from the request
$emp_id = $_POST['empid'];
$dpt_name = $_POST['dptname'];
$emp_name = $_POST['empname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$type = $_POST['type'];
$status = $_POST['status'];
$photo = $_POST['photo'];

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('XYZ_COM');
$pdf->SetTitle('idcard-' . $emp_id);
$pdf->SetSubject('ID Card');

// Add a page
$pdf->AddPage();

// Set font for the entire document
$pdf->SetFont('helvetica', '', 12);

// Get the width and height of the page
$pageWidth = $pdf->getPageWidth();
$pageHeight = $pdf->getPageHeight();

// Set header image (assuming it's a PNG file)
$imagePath = 'dist/id-header.png';
$pdf->Image($imagePath, 0, 0, $pageWidth, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false);

// Check if photo file exists before adding it
$imagePath1 = '../user/images/' . $photo;
if (file_exists($imagePath1)) {
    // Set image below the header
    $pdf->Image($imagePath1, 70, 90, 75, 90, '', '', '', false, 300, '', false, false, '--', false, false);
}

// Set Y position for content below the image and employee name
$pdf->SetY(180);

// Set font size and style for the employee name
$pdf->SetFont('helvetica', 'B', 20);
$pdf->Cell(-10, 20, $emp_name , 0, 1, 'C');

$pdf->SetFont('helvetica', 'B', 17);
$pdf->Cell(-10, 11, strtoupper($type), 0, 1, 'C');


// Set font size and style for the details
$pdf->SetFont('helvetica', '', 15);

// Add other content
$pdf->Cell(0, 10, "Employee ID: $emp_id", 0, 1, 'C');
$pdf->Cell(0, 10, "Department: $dpt_name", 0, 1, 'C');
$pdf->Cell(0, 10, "Email: $email", 0, 1, 'C');
$pdf->Cell(0, 12, "Phone: $phone", 0, 1, 'C');


// Generate barcode for emp_id and emp_name
$barcodeValue = $emp_id . '-' . $emp_name;

// Set the barcode style
$style = array(
    'position' => '',
    'align' => 'C',
    'stretch' => false,
    'fitwidth' => true,
    'cellfitalign' => '',
    'border' => false,
    'hpadding' => 'auto',
    'vpadding' => 'auto',
    'fgcolor' => array(0, 0, 0),
    'bgcolor' => false, //array(255,255,255)
    'text' => true,
    'font' => 'helvetica',
    'fontsize' => 8,
    'stretchtext' => 10
);

$barcodeWidth = 100; // Adjust this width based on your requirements
$x = ($pageWidth - $barcodeWidth) / 2;

$pdf->write1DBarcode($barcodeValue, 'C128', $x, '', '', 18, 0.4, $style, 'N');



// Output the PDF directly to the browser ('I' opens it in the browser, 'D' forces a download)
$pdf->Output('id_card.pdf', 'I');
?>
