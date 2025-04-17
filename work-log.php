<?php
session_start();
if (!isset($_SESSION['userid']) && !isset($_SESSION['username'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}
include("includes/header.php");
include("includes/sidebar.php");
include("includes/connection.php");

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['date'])) {
    $date = $_POST['date'];
    echo "<script>console.log('" . $date . "');</script>";

    $s = "SELECT * FROM work_log WHERE emp_id=? AND date=?";
    $stmt = mysqli_prepare($conn, $s);
    mysqli_stmt_bind_param($stmt, "is", $_SESSION['userid'], $date);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    $s = "SELECT * FROM work_log WHERE emp_id=? ORDER BY date DESC";
    $stmt = mysqli_prepare($conn, $s);
    mysqli_stmt_bind_param($stmt, "i", $_SESSION['userid']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
}
?>

<title>My Work Log - 5G Infotech</title>

<main class="main-wrapper">
    <div class="main-content">

        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Work Log</div>
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

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5>Filter:</h5>
                        <br>
                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="mb-3">
                                <label class="form-label">Date:</label>
                                <input type="date" class="form-control" name="date" required>
                            </div>
                            <div class="mb-3">
                                <input type="submit" class="btn btn-primary" value="Filter">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($result && $result->num_rows > 0) { ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Check In Time</th>
                                            <th>Check Out Time</th>
                                            <th>Hours Worked</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        while ($data = mysqli_fetch_assoc($result)) {
                                        if($data['remarks']!="dummy record"):
                                        ?>
                                            <tr>
                                                <td><?php echo $data['date']; ?></td>
                                                <td><?php echo $data['check_in_time']; ?></td>
                                                <td><?php echo $data['check_out_time']; ?></td>
                                                <td><?php echo $data['hours_worked']; ?></td>
                                                <td><?php echo $data['remarks']; ?></td>
                                            </tr>
                                        <?php endif; } ?>
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

<?php include("includes/footer.php"); ?>