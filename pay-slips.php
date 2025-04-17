<?php
session_start();
if (!isset($_SESSION['userid']) && !isset($_SESSION['username'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}
include("includes/header.php");
include("includes/sidebar.php");
include("includes/connection.php");

$s="SELECT * FROM `pay_slip` WHERE emp_id=" . $_SESSION['userid'] . "";
$result=mysqli_query($conn,$s);

?>

<title>My Pay Slips - 5G Infotech</title>

<main class="main-wrapper">
    <div class="main-content">

        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Pay Slips</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo "Hello, " . $_SESSION['username']; ?></li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- end breadcrumb -->


        <?php if ($result && $result->num_rows > 0) { ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Sr</th>
                                            <th>Month & Year</th>
                                            <th>Total Hours Worked</th>
                                            <th>Gross Salary</th>
                                            <th>Deductions</th>
                                            <th>Net Salary</th>
                                            <th>Date Generated</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; while ($data = mysqli_fetch_assoc($result)) { ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td>
                                                <?php
                                                switch ($data['month']) {
                                                    case 1:
                                                        echo "January " . $data['year'];
                                                        break;
                                                    case 2:
                                                        echo "February " . $data['year'];
                                                        break;
                                                    case 3:
                                                        echo "March " . $data['year'];
                                                        break;
                                                    case 4:
                                                        echo "April ". $data['year'];
                                                        break;
                                                    case 5:
                                                        echo "May ". $data['year'];
                                                        break;
                                                    case 6:
                                                        echo "June " . $data['year'];
                                                        break;
                                                    case 7:
                                                        echo "July " . $data['year'];
                                                        break;
                                                    case 8:
                                                        echo "August " . $data['year'];
                                                        break;
                                                    case 9:
                                                        echo "September " . $data['year'];
                                                        break;
                                                    case 10:
                                                        echo "October " . $data['year'];
                                                        break;
                                                    case 11:
                                                        echo "November " . $data['year'];
                                                        break;
                                                    case 12:
                                                        echo "December " . $data['year'];
                                                        break;
                                                    default:
                                                        echo "Invalid month number";
                                                }
                                                ?>
                                                </td>
                                                <td><?php echo $data['total_hours_worked']; ?></td>
                                                <td><?php echo $data['gross_salary']; ?></td>
                                                <td><?php echo $data['total_deductions']; ?></td>
                                                <td><?php echo $data['net_salary']; ?></td>
                                                <td><?php echo $data['date_generated']; ?></td>
                                                <td>
                                                    <button type="button" onclick="window.location.href='pay-slips.php?id=<?php echo $data['payslip_id']; ?>';" class="btn btn-info px-4 raised d-flex gap-2"><i class="material-icons-outlined">cloud_download</i>Download PDF</button>
                                                </td>
                                            </tr>
                                            <form id="pdfForm" action="../admin/pdf.php" method="POST"></form>
                                        <?php $i++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="alert alert-success">No Data found</div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>
</main>

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


<?php include("includes/footer.php"); ?>