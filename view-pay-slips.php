<?php
@include 'includes/header.php';
@include 'includes/sidebar.php';
@include 'includes/connection.php';

// Get current month and year
$currentMonth = date('m');
$currentYear = date('Y');

// Define required working days
$totalWorkingDays = 26;

// Prepare the query to get employees without a pay slip for the current month and year
$sql = "
    SELECT e.emp_id, e.emp_name, 
           IFNULL(SUM(w.hours_worked), 0) AS total_hours_worked, 
           IFNULL(s.hourly_rate, 0) AS hourly_rate, 
           IFNULL(SUM(w.hours_worked) * s.hourly_rate, 0) AS gross_amount,
           (
               SELECT COUNT(w.date) 
               FROM work_log w 
               WHERE w.emp_id = e.emp_id 
               AND MONTH(w.date) = ? 
               AND YEAR(w.date) = ?
           ) AS days_worked,
           (
               $totalWorkingDays - (
                   SELECT COUNT(w.date) 
                   FROM work_log w 
                   WHERE w.emp_id = e.emp_id 
                   AND MONTH(w.date) = ? 
                   AND YEAR(w.date) = ?
               )
           ) AS days_off,
           (
               s.hourly_rate * 8 * (
                   $totalWorkingDays - (
                       SELECT COUNT(w.date) 
                       FROM work_log w 
                       WHERE w.emp_id = e.emp_id 
                       AND MONTH(w.date) = ? 
                       AND YEAR(w.date) = ?
                   )
               )
           ) AS deduction_amount,
           (
               IFNULL(SUM(w.hours_worked) * s.hourly_rate, 0) - (
                   s.hourly_rate * 8 * (
                       $totalWorkingDays - (
                           SELECT COUNT(w.date) 
                           FROM work_log w 
                           WHERE w.emp_id = e.emp_id 
                           AND MONTH(w.date) = ? 
                           AND YEAR(w.date) = ?
                       )
                   )
               )
           ) AS net_amount
    FROM employee_details e
    LEFT JOIN work_log w ON e.emp_id = w.emp_id AND MONTH(w.date) = ? AND YEAR(w.date) = ?
    LEFT JOIN salary s ON e.emp_id = s.emp_id
    WHERE e.emp_id NOT IN (
        SELECT emp_id FROM pay_slip WHERE month = ? AND year = ?
    )
    AND (
        SELECT COUNT(w.date) 
        FROM work_log w 
        WHERE w.emp_id = e.emp_id 
        AND MONTH(w.date) = ? 
        AND YEAR(w.date) = ?
    ) >= ?
    GROUP BY e.emp_id, s.hourly_rate
";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bind_param("iiiiiiiiiiiiiii", 
    $currentMonth, $currentYear, $currentMonth, $currentYear,
    $currentMonth, $currentYear, $currentMonth, $currentYear,
    $currentMonth, $currentYear, $currentMonth, $currentYear,
    $currentMonth, $currentYear, $totalWorkingDays
);

// Execute the query
$stmt->execute();

// Get the result
$result = $stmt->get_result();
?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    function senddata(emp_id, total_hours, net_salary) {
        var datatosend = {
            emp_id: emp_id,
            month: '<?php echo $currentMonth; ?>',
            year: '<?php echo $currentYear; ?>',
            total_hours: total_hours,
            net_salary: net_salary,
        };
        // AJAX request
        $.ajax({
            url: 'generate-pay-slip.php', // URL of your server-side PHP script
            type: 'POST', // HTTP method to send the data
                    data: datatosend, 
                    success: function(response) {
                        alert(response);
                        window.location.href='view-pay-slips.php';
                        // Handle success response here
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        // Handle error here
                    }
        });
        console.log(datatosend);
    }
</script>

<title>View Pay Slips - 5G Infotech</title>

<div class="content-wrapper">
    <section class="content-header">
        <h1>View Pay Slips</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Pay Slips Yet to be Generated</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr</th>
                                        <th>Employee Name</th>
                                        <th>Total Hours Worked</th>
                                        <th>Hourly Rate</th>
                                        <th>Gross Amount</th>
                                        <th>Days Worked</th>
                                        <th>Days Off</th>
                                        <th>Deduction Amount</th>
                                        <th>Net Amount</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $sno = 0; ?>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <?php $sno++; ?>
                                        <tr>
                                            <td><?php echo $sno; ?></td>
                                            <td><?php echo $row['emp_name']; ?></td>
                                            <td><?php echo $row['total_hours_worked']; ?></td>
                                            <td><?php echo $row['hourly_rate']; ?></td>
                                            <td><?php echo $row['gross_amount']; ?></td>
                                            <td><?php echo $row['days_worked']; ?></td>
                                            <td><?php echo $row['days_off']; ?></td>
                                            <td><?php echo $row['deduction_amount']; ?></td>
                                            <td><?php echo $row['net_amount']; ?></td>
                                            <td>
                                                <button onclick="senddata(<?php echo $row['emp_id']; ?>, <?php echo $row['total_hours_worked']; ?>, <?php echo $row['net_amount']; ?>)" class="btn btn-primary">Generate Pay Slip</button>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                    <?php if ($result->num_rows === 0): ?>
                                        <tr>
                                            <td colspan="10">No pay slips to generate</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
@include 'includes/footer.php';
?>
