<?php
session_start();
if (!isset($_SESSION['userid']) && !isset($_SESSION['username'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}
include("includes/header.php");
include("includes/sidebar.php");
include("includes/connection.php");

$s="SELECT * FROM `employee_details` WHERE emp_id=" . $_SESSION['userid'] . "";
$result=mysqli_query($conn,$s);
$data=mysqli_fetch_assoc($result);

?>

<title>My Profile - 5G Infotech</title>

<main class="main-wrapper">
    <div class="main-content">

        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Profile</div>
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
        <div class="col-12">
          <div class="card w-100">
            <div class="card-body">
              <div class="position-relative">
                <div class="position-absolute top-100 start-50 translate-middle">
                  <img src="images/<?php echo $data['image']; ?>" width="100" height="100"
                    class="rounded-circle raised p-1 bg-white" alt="">
                </div>
              </div>
              <div class="text-center mt-5 pt-4">
                <h4 class="mb-1"><?php echo $data['emp_name']; ?></h4>
                <p><b>Added On:</b> <?php echo $data['created_at']; ?></p>
                <a href='edit-user-profile.php?id=<?php echo $data['emp_id']; ?>' class="btn btn-primary">Edit Profile</a>
              </div>
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item border-top">
                <b>Address</b>
                <br>
                <?php echo $data['address']; ?>
              </li>
              <li class="list-group-item">
                <b>Email</b>
                <br>
                <?php echo $data['email']; ?>
              </li>
              <li class="list-group-item">
                <b>Phone</b>
                <br>
                <?php echo $data['phone']; ?>
              </li>
              <li class="list-group-item">
                <b>Employee Type</b>
                <br>
                <?php echo $data['type']; ?>
              </li>
              <li class="list-group-item">
                <b>Status</b>
                <br>
                <?php echo $data['status']; ?>
              </li>
            </ul>


          </div>
        </div>
        </div>

        
    </div>
</main>


<?php include("includes/footer.php"); ?>