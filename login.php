<?php
session_start();
if(isset($_SESSION['userid']) && isset($_SESSION['username']))
{
  echo "<script>window.location.href='index.php';</script>";
  exit;
}
?>
<!doctype html>
<html lang="en" data-bs-theme="light">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - XYZ Company</title>
  <!--favicon-->
	<link rel="icon" href="assets/images/logo.png" type="image/png">

  <!--plugins-->
  <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="assets/plugins/metismenu/metisMenu.min.css">
  <link rel="stylesheet" type="text/css" href="assets/plugins/metismenu/mm-vertical.css">
  <!--bootstrap css-->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">
  <!--main css-->
  <link href="assets/css/bootstrap-extended.css" rel="stylesheet">
  <link href="sass/main.css" rel="stylesheet">
  <link href="sass/dark-theme.css" rel="stylesheet">
  <link href="sass/responsive.css" rel="stylesheet">

  </head>

  <body class="bg-login">


    <!--authentication-->

     <div class="container-fluid my-5">
        <div class="row">
           <div class="col-12 col-md-8 col-lg-6 col-xl-5 col-xxl-4 mx-auto">
            <div class="card rounded-4">
              <div class="card-body p-5">
                  <center><img src="assets/images/logo.png" class="mb-4" width="145" alt=""></center>
                  <h4 class="fw-bold">Get Started Now</h4>
                  <p class="mb-0">Enter your credentials to login your account</p>
                  <br><br>
                  <p id="warningbox"></p>
                  <div class="form-body my-4">
										<form class="row g-3" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
											<div class="col-12">
												<label for="inputEmailAddress" class="form-label">Login ID</label>
												<input type="text" class="form-control" name="loginid" id="inputEmailAddress" placeholder="jhon@example.com" required>
											</div>
											<div class="col-12">
												<label for="inputChoosePassword" class="form-label">Password</label>
												<div class="input-group" id="show_hide_password">
													<input type="password" class="form-control border-end-0" name="password" id="inputChoosePassword" placeholder="Enter Password" required> 
                          <a href="javascript:;" class="input-group-text bg-transparent"><i class="bi bi-eye-slash-fill"></i></a>
												</div>
											</div>
											</div>
											<div class="col-12">
												<div class="d-grid">
													<button type="submit" class="btn btn-primary">Login</button>
												</div>
											</div>
											
										</form>
									</div>
              </div>
            </div>
           </div>
        </div><!--end row-->
     </div>
      
    <!--authentication-->


    <!--plugins-->
  <script
  src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
  crossorigin="anonymous"></script>

 <script>
      $(document).ready(function () {
        $("#show_hide_password a").on('click', function (event) {
          event.preventDefault();
          if ($('#show_hide_password input').attr("type") == "text") {
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass("bi-eye-slash-fill");
            $('#show_hide_password i').removeClass("bi-eye-fill");
          } else if ($('#show_hide_password input').attr("type") == "password") {
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass("bi-eye-slash-fill");
            $('#show_hide_password i').addClass("bi-eye-fill");
          }
        });
      });
    </script>
  
  </body>
</html>

<?php
@include 'includes/connection.php';

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $loginid = $_POST['loginid'];
    $password = $_POST['password'];

    $s = "SELECT emp_id, emp_name FROM employee_details WHERE login_id=? AND password=?";
    $stmt = mysqli_prepare($conn, $s);
    mysqli_stmt_bind_param($stmt, "ss", $loginid, $password);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $emp_id, $emp_name);
    mysqli_stmt_store_result($stmt);

    // Check if rows are returned
    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_fetch($stmt);
        $date = date("Y-m-d H:i:s");
        $activity = "login";

        $s = "INSERT INTO login_activity (emp_id, activity, time) VALUES (?,?,?)";
        $stmt2 = mysqli_prepare($conn, $s);
        mysqli_stmt_bind_param($stmt2, "iss", $emp_id, $activity, $date);
        mysqli_stmt_execute($stmt2);

        session_start();
        $_SESSION['loginid'] = $loginid;
        $_SESSION['userid'] = $emp_id;
        $_SESSION['username'] = $emp_name;
       

        echo "<script>
        console.log('Rows found, Session Variables set:" . $_SESSION['userid'] . " - " . $_SESSION['username'] . "');
        window.location.href='index.php';
        </script>";
    } else {
        echo "<script src='https://code.jquery.com/jquery-3.7.1.min.js'></script>
        <script>
        $(document).ready(function(){
            console.log('No rows found');
            $('#warningbox').html('Invalid Email or Password! Try again');
            $('#warningbox').addClass('alert alert-danger');
            console.log('Class added:', $('#warningbox').attr('class'));
        });
        </script>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
