<?php
@include 'includes/header.php';
@include 'includes/sidebar.php';
@include 'includes/connection.php';
?>

<title>Add Salary Slab - 5G Infotech</title>

<div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
                <h1>
                Add Salary Slab
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="index.php"><i class="fa fa-dashboard"></i> Home</a>
                    </li>
                    <li class="active">Add Salary Slab</li>
                </ol>
            </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Salary Slab</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="metaTitle">Select Employee</label>
                                    <select name="employee" class="form-control">
                                        <option selected>Select..</option>
                                        <?php
                                            $s="SELECT emp_id,emp_name FROM employee_details WHERE status='active'";
                                            $result=mysqli_query($conn,$s);
                                            while($row=mysqli_fetch_assoc($result)) {
                                        ?>
                                        <option value="<?php echo $row['emp_id']; ?>"><?php echo $row['emp_id'] .  " - " . $row['emp_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                
        <div class="form-group">
            <label for="monthlySalary">Monthly Salary</label>
            <input type="text" class="form-control" id="monthlySalary" name="monthly" required>
        </div>
        <div class="form-group">
            <label for="dailySalary">Daily Salary</label>
            <input type="text" class="form-control" id="dailySalary" name="daily" readonly required>
        </div>
        <div class="form-group">
            <label for="hourlySalary">Hourly Salary</label>
            <input type="text" class="form-control" id="hourlySalary" name="hourly" readonly required>
        </div>
    
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
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
                    var dailySalary = (monthlySalary / 26).toFixed(2); // Assuming 26 working days in a month
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

if($_SERVER['REQUEST_METHOD']=="POST")
{
    if(!empty($_POST['employee']) && !empty($_POST['monthly']) && !empty($_POST['daily']) && !empty($_POST['hourly']))
    {
        $date=date("Y-m-d H:i:s");
        echo "<script>console.log('All data recieved');</script>";
        $s="INSERT INTO salary (monthly, daily, hourly_rate, created_at, emp_id) VALUES (?,?,?,?,?)";
        $stmt=mysqli_prepare($conn,$s);
        mysqli_stmt_bind_param($stmt,"dddsi",$_POST['monthly'],$_POST['daily'],$_POST['hourly'],$date,$_POST['employee']);
        if(mysqli_stmt_execute($stmt))
        {
            echo "<script>alert('Salary for employee added Successfully');</script>";
        }
    }
}


@include 'includes/footer.php';
?>