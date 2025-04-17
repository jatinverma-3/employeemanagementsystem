<?php
@include 'includes/connection.php';

// Assuming $_POST values are properly sanitized and validated before use
$array = array(
    "emp_id" => $_POST['emp_id'],
    "month" => $_POST['month'],
    "year" => $_POST['year'],
    "total_hours" => $_POST['total_hours'],
    "gross_salary" => "",
    "total_deductions" => "",
    "net_salary" => $_POST['net_salary']
);

// Query to fetch monthly salary based on emp_id
$s = "SELECT monthly FROM salary WHERE emp_id = " . $array['emp_id'];
$result = mysqli_query($conn, $s);

// Fetch the monthly salary from the result
while ($row = mysqli_fetch_row($result)) {
    $array['gross_salary'] = $row[0];
}

// Calculate total deductions
$array['total_deductions'] = $array['gross_salary'] - $array['net_salary'];

// Insert into pay_slip table
$insert_sql = "
    INSERT INTO pay_slip (emp_id, month, year, total_hours_worked, gross_salary, total_deductions, net_salary, date_generated)
    VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
";

// Prepare the statement
$stmt = $conn->prepare($insert_sql);

// Bind parameters
$stmt->bind_param("iisiiid", $array['emp_id'], $array['month'], $array['year'], $array['total_hours'], $array['gross_salary'], $array['total_deductions'], $array['net_salary']);

// Execute the statement
if ($stmt->execute()) {
    echo "Pay slip successfully inserted.";
} else {
    echo "Error inserting pay slip: " . $conn->error;
}

?>
