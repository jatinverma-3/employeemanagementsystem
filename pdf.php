<?php
require_once('TCPDF-main/tcpdf.php');
// Custom TCPDF class with watermark
class MYPDF extends TCPDF {
    public function Header() {
        // Set font for watermark
        $this->SetFont('helvetica', 'B', 50);
        // Set color for watermark
        $this->SetTextColor(230, 230, 230);
        // Add watermark text
        $this->RotatedText(35, 190, 'PAY SLIP', 45);
        // Reset font and color for the rest of the page content
        $this->SetFont('helvetica', '', 12);
        $this->SetTextColor(0, 0, 0);
    }
    
    // Rotate text function
    function RotatedText($x, $y, $txt, $angle) {
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }
}
// Check if POST data is received
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payslipid = $_POST['payslipid'] ?? null;
    $empname = $_POST['empname'] ?? null;
    $loginid = $_POST['loginid'] ?? null;
    $total_hours_worked = $_POST['total_hours_worked'] ?? null;
    $basic_pay = $_POST['gross_salary'] ?? null;
    $total_deductions = $_POST['total_deductions'] ?? null;
    $net_salary = $_POST['net_salary'] ?? null;
    $date_generated = $_POST['date_generated'] ?? null;

    // Default values for allowances
    $travel_allowance = 0;
    $medical_allowance = 0;
    $rent_allowance = 0;
    $other_allowance = 0;

    // Calculate total earnings
    $total_earnings = $basic_pay + $travel_allowance + $medical_allowance + $rent_allowance + $other_allowance;

    // Validate received data
    if ($payslipid && $empname && $loginid && $total_hours_worked && $basic_pay && $total_deductions && $net_salary && $date_generated) {
        // Create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Employee System');
        $pdf->SetTitle('Pay-Slip ' . $loginid);
        $pdf->SetSubject('Sample PDF Document');

        // Add a page
        $pdf->AddPage();

        // Set title
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell(0, 10, 'Contractual Work Pay Slip', 0, 1, 'C');
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 10, 'EMPLOYEE SYSTEM', 0, 1, 'C');
        $pdf->Cell(0, 10, 'NESS WADIA COLLEGE, PUNE', 0, 1, 'C');
        // $pdf->Cell(0, 10, 'Pay Period : Apr 2024 - May 2024', 0, 1, 'C');

        $pdf->Ln(10); // Line break

        // Employee details in two columns without borders
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(40, 10, 'Pay Date:', 0, 0);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(60, 10, $date_generated, 0, 0);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(40, 10, 'Employee Id:', 0, 0);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 10, $loginid, 0, 1);

        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(40, 10, 'Employee Name:', 0, 0);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(60, 10, $empname, 0, 0);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(40, 10, 'Total Working Hrs:', 0, 0);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 10, $total_hours_worked . ' hours', 0, 1);

        $pdf->Ln(10); // Line break

        // Set header color
        $pdf->SetFillColor(6,0,51); // Grey background
        $pdf->SetTextColor(255, 255, 255); // White text

        // Table headers
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(47.5, 10, 'Earnings', 1, 0, 'C', 1);
        $pdf->Cell(47.5, 10, 'Amount (INR)', 1, 0, 'C', 1);
        $pdf->Cell(47.5, 10, 'Deductions', 1, 0, 'C', 1);
        $pdf->Cell(47.5, 10, 'Amount (INR)', 1, 1, 'C', 1);

        // Reset text color for table content
        $pdf->SetTextColor(0, 0, 0);

        // Earnings and deductions rows
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(47.5, 10, 'Basic Pay', 1, 0, 'C');
        $pdf->Cell(47.5, 10, $basic_pay, 1, 0, 'C');
        $pdf->Cell(47.5, 10, 'Total Deductions', 1, 0, 'C');
        $pdf->Cell(47.5, 10, $total_deductions, 1, 1, 'C');

        $pdf->Cell(47.5, 10, 'Travel Allowance', 1, 0, 'C');
        $pdf->Cell(47.5, 10, $travel_allowance, 1, 0, 'C');
        $pdf->Cell(47.5, 10, '', 1, 0, 'C');
        $pdf->Cell(47.5, 10, '', 1, 1, 'C');

        $pdf->Cell(47.5, 10, 'Medical Allowance', 1, 0, 'C');
        $pdf->Cell(47.5, 10, $medical_allowance, 1, 0, 'C');
        $pdf->Cell(47.5, 10, '', 1, 0, 'C');
        $pdf->Cell(47.5, 10, '', 1, 1, 'C');

        $pdf->Cell(47.5, 10, 'Rent Allowance', 1, 0, 'C');
        $pdf->Cell(47.5, 10, $rent_allowance, 1, 0, 'C');
        $pdf->Cell(47.5, 10, '', 1, 0, 'C');
        $pdf->Cell(47.5, 10, '', 1, 1, 'C');

        $pdf->Cell(47.5, 10, 'Other Allowance', 1, 0, 'C');
        $pdf->Cell(47.5, 10, $other_allowance, 1, 0, 'C');
        $pdf->Cell(47.5, 10, '', 1, 0, 'C');
        $pdf->Cell(47.5, 10, '', 1, 1, 'C');
        $pdf->SetFillColor(6,0,51); // Grey background
        $pdf->SetTextColor(255, 255, 255); // White text
        // Total Earnings and Deductions
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(47.5, 10, 'Total Earnings', 1, 0, 'C', 1);
        $pdf->Cell(47.5, 10, $total_earnings, 1, 0, 'C', 1);
        $pdf->Cell(47.5, 10, 'Total Deductions', 1, 0, 'C', 1);
        $pdf->Cell(47.5, 10, $total_deductions, 1, 1, 'C', 1);

        $pdf->Ln(10); // Line break

       $pdf->SetFillColor(6,0,51); // Grey background
        $pdf->SetTextColor(255, 255, 255); // White text
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(95, 10, 'Net Salary', 1, 0, 'C', 1);
        $pdf->Cell(95, 10, $net_salary, 1, 1, 'C', 1);

        $pdf->Ln(10); // Line break

        // Total working hours
        $pdf->SetTextColor(0, 0, 0); // Reset text color
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(60, 10, 'Total Working Hours:', 0, 0);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(40, 10, $total_hours_worked . ' hours', 0, 1);

        $pdf->Ln(20); // Line break

        // Authorized signature
        $pdf->Cell(0, 10, '______________________', 0, 1, 'R');
        $pdf->Cell(0, 10, 'Authorized Signature', 0, 1, 'R');

        $pdf->Ln(10); // Line break

        // Footer
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 10, 'This is an automated slip', 0, 1, 'C');

        // Output the PDF
        $pdf->Output('payslip.pdf', 'I'); // 'I' means inline display, 'D' means download
    } else {
        echo 'Invalid data received';
    }
} else {
    echo 'No data received';
}
?>
