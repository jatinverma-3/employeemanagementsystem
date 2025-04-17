<?php
@include 'includes/header.php';
@include 'includes/sidebar.php';
@include 'includes/connection.php';

if($_SERVER['REQUEST_METHOD']=="POST")
{
    if(isset($_POST['date']))
    {
        $date=$_POST['date'];
        echo "<script>console.log('".$date."');</script>";
    }
}else{
$date=date("Y-m-d");
echo "<script>console.log('".$date."');</script>";
}

//Fetch screenshots based on the selected date
$sql = "SELECT s.*,d.emp_name 
FROM work_log s,employee_details d
WHERE s.emp_id=d.emp_id AND DATE(s.date) = ?
ORDER BY s.date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $date);
$stmt->execute();
$result = $stmt->get_result();

?>

<title>Employee Work Log - 5G Infotech</title>

<div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Employee Work Log</h1>
            <ol class="breadcrumb">
                <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Employee Work Log</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Employee Work Log</h3>
                        </div>
                        <!-- form start -->
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="date">Select Date:</label>
                                    <input type="date" class="form-control" id="date" name="date" value="<?php echo $date; ?>">
                                </div>
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title" id="heading">Work Log</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr</th>
                                        <th>Employee Name</th>
                                        <th>Check In Time</th>
                                        <th>Check Out Time</th>
                                        <th>Hours worked</th>
                                        <th>Remarks</th>
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
                                                <?php echo $row['check_in_time']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['check_out_time']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['hours_worked']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['remarks']; ?>
                                            </td>
                                        </tr>
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
</div>

<?php
@include 'includes/footer.php';
?>
