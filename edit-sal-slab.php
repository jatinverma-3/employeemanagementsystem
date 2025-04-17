<?php
@include 'includes/header.php';
@include 'includes/sidebar.php';
@include 'includes/connection.php';

// Fetch the current salary details based on the provided ID
$salaryId = $_GET['id'];
$salaryDetails = mysqli_query($conn, "SELECT * FROM salary WHERE salary_id='$salaryId'");
$salary = mysqli_fetch_assoc($salaryDetails);

// Fetch employee details for the dropdown
$employees = mysqli_query($conn, "SELECT emp_id, emp_name FROM employee_details WHERE status='active'");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $empId = $_POST['employee'];
    $monthlySalary = $_POST['monthly'];
    $dailySalary = $_POST['daily'];
    $hourlySalary = $_POST['hourly'];

    $updateQuery = "UPDATE salary SET emp_id='$empId', monthly='$monthlySalary', daily='$dailySalary', hourly_rate='$hourlySalary' WHERE salary_id='$salaryId'";
    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Salary updated successfully!');
        window.location.href='view-sal-slab.php';</script>";
    } else {
        echo "<script>alert('Error updating record: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<title>Edit Salary Slab - 5G Infotech</title>

<div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Edit Salary Slab</h1>
            <ol class="breadcrumb">
                <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Edit Salary Slab</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Edit Salary Slab</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form" method="post" action="">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="metaTitle">Select Employee</label>
                                    <select name="employee" class="form-control" required>
                                        <option value="">Select...</option>
                                        <?php while($row = mysqli_fetch_assoc($employees)) { ?>
                                            <option value="<?php echo $row['emp_id']; ?>" <?php echo $row['emp_id'] == $salary['emp_id'] ? 'selected' : ''; ?>>
                                                <?php echo $row['emp_id'] . " - " . $row['emp_name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="monthlySalary">Monthly Salary</label>
                                    <input type="text" class="form-control" id="monthlySalary" name="monthly" value="<?php echo $salary['monthly']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="dailySalary">Daily Salary</label>
                                    <input type="text" class="form-control" id="dailySalary" name="daily" value="<?php echo $salary['daily']; ?>" readonly required>
                                </div>
                                <div class="form-group">
                                    <label for="hourlySalary">Hourly Salary</label>
                                    <input type="text" class="form-control" id="hourlySalary" name="hourly" value="<?php echo $salary['hourly_rate']; ?>" readonly required>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('#monthlySalary').on('input', function() {
            var monthlySalary = parseFloat($(this).val());

            if (!isNaN(monthlySalary) && monthlySalary > 0) {
                var dailySalary = (monthlySalary / 22).toFixed(2); // Assuming 22 working days in a month
                var hourlySalary = (dailySalary / 8).toFixed(2);   // Assuming 8 working hours in a day

                $('#dailySalary').val(dailySalary);
                $('#hourlySalary').val(hourlySalary);
            } else {
                $('#dailySalary').val('');
                $('#hourlySalary').val('');
            }
        });
    });
</script>

<?php
@include 'includes/footer.php';
?>
