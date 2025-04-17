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

if($_SERVER['REQUEST_METHOD']=="POST")
{
    if(!empty($_FILES['resume']['name']))
    {
        $resume = $data['resume'];

        if(isset($_FILES['resume']['name']) && !empty($_FILES['resume']['name'])) {
            $target_dir_r = "resume/";
            $resume = basename($_FILES["resume"]["name"]);
            $target_file_r = $target_dir_r . $resume;
            if (move_uploaded_file($_FILES['resume']['tmp_name'], $target_file_r)) {
                if (!empty($employee['resume'])) {
                    $old_path = "../user/resume/" . $employee['resume'];
                    if (file_exists($old_path)) {
                        unlink($old_path);
                    }
                }
            } else {
                echo '<script>alert("Error uploading resume file.");</script>';
            }
        }

        $s="UPDATE employee_details SET resume=? WHERE emp_id=?";
        $stmt=mysqli_prepare($conn,$s);
        mysqli_stmt_bind_param($stmt,"si",$resume,$_SESSION['userid']);
        if(mysqli_stmt_execute($stmt))
        {
            echo "<script>alert('Resume updated successfully');
            window.location.href='documents.php';</script>";   
        }

    }else{
        echo "<script>alert('Please upload a file');</script>";
    }
}

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
                <h1>My Documents</h1>
                <br>
                <p>View my documents which are available.</p>
                <br>
                <table class="table mb-0 table-hover table-responsive">
                    <tr>
                        <th><b>Heading</b></th>
                        <th><b>Buttons</b></th>
                    </tr>
                    <tr>
                        <td><b>My ID Card</b></td>
                        <td>
                        <button onclick='window.location.href="documents.php?idid=<?php echo $data["emp_id"] ?>"' class="btn btn-inverse-primary px-5">View ID Card</button>
                        </td>
                    </tr>
                    <?php
                    if(isset($data['resume'])):
                    ?>
                    <tr>
                        <td><b>Resume</b></td>
                        <td>
                            <br>
                            <a href="resume/<?php echo $data['resume']; ?>" class="btn btn-inverse-primary px-5">View Uploaded Resume</a>
                            <br><br>
                            <h6>Update Your Resume</h6>
                            <br>
                            <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="mb-3">
									<label for="formFile" class="form-label">Upload New Resume</label>
									<input class="form-control" type="file" name="resume" id="formFile"><br>
                                    <br><?php echo $data['resume']; ?>
								</div>
                                <div class="mb-3">
                                    <button type="Submit" class="btn btn-warning px-4 raised d-flex gap-2"><i class="material-icons-outlined">cloud_upload</i>Upload</button>
								</div>
                            </form>
                            <!-- ID CARD FORM --> 
                            <form id="idcard" action="../admin/idcardpdf.php" method="POST"></form>
                        </td>
                    </tr>
                    <?php endif; ?>
				</table>
            </div>
          </div>
        </div>
        </div>

    </div>
</main>


<?php 

if(isset($_GET['idid']))
{
    $s="SELECT e.*, d.dpt_name
    FROM employee_details e,department d 
    WHERE e.dpt_id=e.dpt_id
    AND emp_id=" . $_GET['idid'] . "";
    $result=mysqli_query($conn,$s);
    $iddata=mysqli_fetch_assoc($result);
    ?>

    <script
    src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"></script>
    <script>
    $(document).ready(function() {
        var datatosend = {
            photo: <?php echo json_encode($iddata['image']); ?> ,
            empid: <?php echo json_encode($iddata['emp_id']); ?> ,
            dptname: <?php echo json_encode($iddata['dpt_name']); ?> ,
            empname: <?php echo json_encode($iddata['emp_name']); ?> ,
            email: <?php echo json_encode($iddata['email']); ?> ,
            phone: <?php echo json_encode($iddata['phone']); ?> ,
            type: <?php echo json_encode($iddata['type']); ?> ,
            status: <?php echo json_encode($iddata['status']); ?> 
        };

        console.log(datatosend);

        // Populate the hidden form with data
        $.each(datatosend, function(key, value) {
            $('#idcard').append('<input type="hidden" name="' + key + '" value="' + value + '">');
        });

        // Submit the form
        $('#idcard').submit();

    });
    </script>
    <?php 
}


include("includes/footer.php"); 
?>