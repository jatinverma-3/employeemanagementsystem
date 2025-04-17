<?php
require_once('TCPDF-main/tcpdf.php');

$date = $_POST['date'];
$name = $_POST['name'];
$position = $_POST['position'];
$joindate = $_POST['joindate'];
$workinghours = $_POST['workinghours'];
$payment = $_POST['payment'];

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Employee System');
$pdf->SetTitle('offer-letter-' . $name);
$pdf->SetSubject('ID Card');

// Add a page
$pdf->AddPage();

// Get the width and height of the page
$pageWidth = $pdf->getPageWidth();
$pageHeight = $pdf->getPageHeight();

// Set header image (assuming it's a PNG file)
// $headerImagePath = 'dist/o-header.png';
// $pdf->Image($headerImagePath, 0, 0, $pageWidth, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false);


$pdf->SetY(50);
// Set font size and style for the employee name
$pdf->SetFont('helvetica', 'B', 15);
$pdf->Cell(-10, 20, "Date: $date", 0, 1, 'L');

$pdf->SetFont('helvetica', 'B', 20);
$pdf->Cell(-5, 10, "JOINING CUM OFFER LETTER", 0, 1, 'C');
$pdf->SetFont('helvetica', 'B', 18);
$pdf->Cell(0, 0, "TO WHOM IT MAY CONCERN", 0, 1, 'C');

$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(-20, 25, "Dear $name,", 0, 1, 'L');

$htmlcontent = "
<p>
We are thrilled to extend our warmest welcome as you join our company Ltd. as a $position. 
It brings us great joy to have you as part of our team. At our company, we hold our team in high 
regard, recognizing that our collective strength lies in the talent and dedication of each member. We are committed 
to fostering an environment where learning, growth, and excellence thrive.
</p>
";

$pdf->writeHTML($htmlcontent, true, false, true, false, '');

$pdf->SetY(145); 

$htmlContent = "
<br>
<b>Joining Date:</b> $joindate | <b>Working Hours:</b> $workinghours | Net Pay: $payment INR / Month
";

$pdf->writeHTML($htmlContent, true, false, true, false, '');

$pdf->SetY(155); 

$htmlcontent="
<p>
Your role as a $position is pivotal to our company's success, and we are confident that your skills 
and enthusiasm will contribute significantly to our endeavors. We are dedicated to providing you with a fulfilling
and enriching corporate experience, filled with valuable learning opportunities and meaningful projects.
<br><br>
Please find attached a duplicate of this offer letter for your acceptance. Kindly sign and return it to us at 
info@employee.com at your earliest convenience.
<br><br>
Should you have any questions or require further information, please do not hesitate to contact us. We are here to support you in every possible way.
Once again, congratulations on joining our company. We are excited to embark on this journey together and look forward to your valuable contributions.
<br><br>
Warm regards,<br>
<b>HR Department</b><br>
</p>";

$pdf->writeHTML($htmlcontent, true, false, true, false, '');


// $pdf->SetY(220); 
// $footerImagePath = 'dist/o-footer.png';
// $pdf->Image($footerImagePath, 0, 254.5, $pageWidth, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false);

// Output the PDF directly to the browser ('I' opens it in the browser, 'D' forces a download)
$pdf->Output('id_card.pdf', 'I');

?>
