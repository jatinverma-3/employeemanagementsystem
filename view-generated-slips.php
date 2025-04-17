<?php
@include 'includes/header.php';
@include 'includes/sidebar.php';
@include 'includes/connection.php';

$s="SELECT p.*, d.emp_name, d.login_id
FROM pay_slip p,employee_details d
WHERE p.emp_id=d.emp_id
ORDER BY p.date_generated DESC";
$result=mysqli_query($conn,$s);

?>

<title>View Generated Pay Slips - 5G Infotech</title>

<div class="content-wrapper">
    <section class="content-header">
        <h1>View Generated Pay Slips</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">View Generated Pay Slips</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr</th>
                                        <th>Employee Name</th>
                                        <th>Month and Year</th>
                                        <th>Total Hours Worked</th>
                                        <th>Gross Salary</th>
                                        <th>Total Deductions</th>
                                        <th>Net Salary</th>
                                        <th>Date Generated</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $sno = 0; ?>
                                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                        <?php $sno++; ?>
                                        <tr>
                                            <td>
                                                <?php echo $sno; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['emp_name']; ?>
                                            </td>
                                            <td>
                                                <?php
                                                switch ($row['month']) {
                                                    case 1:
                                                        echo "January " . $row['year'];
                                                        break;
                                                    case 2:
                                                        echo "February " . $row['year'];
                                                        break;
                                                    case 3:
                                                        echo "March " . $row['year'];
                                                        break;
                                                    case 4:
                                                        echo "April ". $row['year'];
                                                        break;
                                                    case 5:
                                                        echo "May ". $row['year'];
                                                        break;
                                                    case 6:
                                                        echo "June " . $row['year'];
                                                        break;
                                                    case 7:
                                                        echo "July " . $row['year'];
                                                        break;
                                                    case 8:
                                                        echo "August " . $row['year'];
                                                        break;
                                                    case 9:
                                                        echo "September " . $row['year'];
                                                        break;
                                                    case 10:
                                                        echo "October " . $row['year'];
                                                        break;
                                                    case 11:
                                                        echo "November " . $row['year'];
                                                        break;
                                                    case 12:
                                                        echo "December " . $row['year'];
                                                        break;
                                                    default:
                                                        echo "Invalid month number";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php echo $row['total_hours_worked']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['gross_salary']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['total_deductions']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['net_salary']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['date_generated']; ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-primary" onclick="window.location.href='view-generated-slips.php?id=<?php echo $row['payslip_id']; ?>';">Generate PDF</button>
                                            </td>
                                        </tr>
                                        <form id="pdfForm" action="pdf.php" method="POST"></form>
                                    <?php endwhile; ?>
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

if(isset($_GET['id']))
{
    $s="SELECT p.*, d.emp_name, d.login_id
    FROM pay_slip p,employee_details d
    WHERE p.emp_id=d.emp_id AND payslip_id=" . $_GET['id'] . "";
    $result=mysqli_query($conn,$s);
    $data=mysqli_fetch_assoc($result);
}
?>

    <script src='https://code.jquery.com/jquery-3.7.1.min.js'></script>
    <script>
    $(document).ready(function() {
            var datatosend = {
                payslipid: <?php echo json_encode($data['payslip_id']); ?>,
                empname: <?php echo json_encode($data['emp_name']); ?>,
                loginid: <?php echo json_encode($data['login_id']); ?>,
                total_hours_worked: <?php echo json_encode($data['total_hours_worked']); ?>,
                gross_salary: <?php echo json_encode($data['gross_salary']); ?>,
                total_deductions: <?php echo json_encode($data['total_deductions']); ?>,
                net_salary: <?php echo json_encode($data['net_salary']); ?>,
                date_generated: <?php echo json_encode($data['date_generated']); ?>
            };
            console.log(datatosend);

            // Populate the hidden form with data
            $.each(datatosend, function(key, value) {
                $('#pdfForm').append('<input type="hidden" name="' + key + '" value="' + value + '">');
            });

            // Submit the form
            $('#pdfForm').submit();
        });
    </script>
    </script>

<?php
@include 'includes/footer.php';
?>