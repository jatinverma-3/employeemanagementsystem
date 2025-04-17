<?php 
session_start();

include("includes/connection.php");

$activity="logout";
$date=date("Y-m-d H:i:s");
$s="INSERT INTO login_activity (emp_id,	activity, time) VALUES (?,?,?)";
$stmt=mysqli_prepare($conn,$s);
mysqli_stmt_bind_param($stmt,"iss",$_SESSION['userid'],$activity,$date);
mysqli_stmt_execute($stmt);


session_unset();
session_destroy();
echo " <script> 
    window.location.href = 'login.php';
</script>  ";

?>