<?php
@include 'includes/header.php';
@include 'includes/sidebar.php';
@include 'includes/connection.php';

if(!isset($_GET['id']))
{
    echo "<script>window.location.href='view-all-emp.php';</script>";
}

?>

<title>Employee Details - 5G Infotech</title>

<div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                View Employee Details
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="index.php"><i class="fa fa-dashboard"></i> Home</a>
                </li>
                <li class="active">View Employee Details</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Employee Details</h3>
                        </div>
                        <div class="box-body">
                            <?php
                            $sql = "SELECT resume,image,emp_id, dpt_id, emp_name, email, phone, address, type, status, login_id, created_at FROM employee_details WHERE emp_id=" . $_GET['id'] . "";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<div class='employee-details'>";
                                    echo "<p><img src='../user/images/" . $row['image'] . "' style='height:200px;width:200px' class='img-fluid'></p>";
                                    echo "<p><strong>Employee ID:</strong> {$row['emp_id']}</p>";
                                    echo "<p><strong>Department ID:</strong> {$row['dpt_id']}</p>";
                                    echo "<p><strong>Employee Name:</strong> {$row['emp_name']}</p>";
                                    echo "<p><strong>Email:</strong> {$row['email']}</p>";
                                    echo "<p><strong>Phone:</strong> {$row['phone']}</p>";
                                    echo "<p><strong>Address:</strong> {$row['address']}</p>";
                                    echo "<p><strong>Type:</strong> {$row['type']}</p>";
                                    echo "<p><strong>Status:</strong> {$row['status']}</p>";
                                    echo "<p><strong>Resume:</strong> <a href='../user/resume/".$row['resume']."'>Click Here</a></p>";
                                    echo "<p><strong>Login ID:</strong> {$row['login_id']}</p>";
                                    echo "<p><strong>Created At:</strong> {$row['created_at']}</p>";
                                    echo "<hr>";
                                    echo "</div>";
                                }
                            } else {
                                echo "<p>No employee details found.</p>";
                            }
                            ?>
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
