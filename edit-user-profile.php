<?php
session_start();
include("includes/header.php");
include("includes/sidebar.php");
include("includes/connection.php");

// Initialize alert variable
$alert = "";

// Fetch user details based on $_GET['id']
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT `emp_id`, `dpt_id`, `image`, `emp_name`, `email`, `phone`, `address` FROM `employee_details` WHERE `emp_id` = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
    } else {
        $alert = "<script>alert('User not found!');</script>";
    }
} else {
    $alert = "<script>alert('User ID not provided!');</script>";
}

// Update user details
if($_SERVER['REQUEST_METHOD'] == "POST") {
    if(isset($_POST['emp_name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['address'])) {
        $emp_name = $_POST['emp_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        //$image=$user['image'];
        
        // Handle image upload if provided
        if(isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $image = $_FILES['image'];
            $image_name = $image['name'];
            $image_tmp_name = $image['tmp_name'];
            $image_size = $image['size'];
            $image_type = $image['type'];
            
            // Check file type
            $allowed_types = array('image/jpeg', 'image/png', 'image/gif');
            if(in_array($image_type, $allowed_types)) {
                $image_path = 'images/' . $image_name;
                if(move_uploaded_file($image_tmp_name, $image_path)) {

                    //unlink existing image
                    if (!empty($user['image'])) {
                        $old_image_path = "images/" . $user['image'];
                        if (file_exists($old_image_path)) {
                            unlink($old_image_path);
                        }
                    }

                    // Update database with image path
                    $query = "UPDATE `employee_details` SET `image` = ? WHERE `emp_id` = ?";
                    $stmt = mysqli_prepare($conn, $query);
                    mysqli_stmt_bind_param($stmt, "si", $_FILES['image']['name'], $id);
                    if(mysqli_stmt_execute($stmt)) {
                        $alert = "<script>alert('Image updated successfully!');</script>";
                    } else {
                        $alert = "<script>alert('Failed to update image!');</script>";
                    }
                } else {
                    $alert = "<script>alert('Failed to move uploaded file!');</script>";
                }
            } else {
                $alert = "<script>alert('Unsupported file type!');</script>";
            }
        }
        
        // Update other user details
        $query = "UPDATE `employee_details` SET `emp_name` = ?, `email` = ?, `phone` = ?, `address` = ? WHERE `emp_id` = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssssi", $emp_name, $email, $phone, $address, $id);
        if(mysqli_stmt_execute($stmt)) {
            $alert = "<script>alert('User details updated successfully!');
            window.location.href='user-profile.php';</script>";
        } else {
            $alert = "<script>alert('Failed to update user details!');</script>";
        }
    } else {
        $alert = "<script>alert('Please fill in all required fields!');</script>";
    }
}

?>

<main class="main-wrapper">
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5>Edit User Profile</h5>
                            <br>
                            <?php echo $alert; ?>
                            <form method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label class="form-label">Employee Name</label>
                                    <input type="text" class="form-control" name="emp_name" value="<?php echo isset($user['emp_name']) ? $user['emp_name'] : ''; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="<?php echo isset($user['email']) ? $user['email'] : ''; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" name="phone" value="<?php echo isset($user['phone']) ? $user['phone'] : ''; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control" name="address" rows="3" required><?php echo isset($user['address']) ? $user['address'] : ''; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Profile Image</label>
                                    <input type="file" class="form-control" name="image">
                                    Existing Image Name: <?php if(isset($user['image'])) { echo $user['image']; } ?>
                                </div>
                                <div class="mb-3">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include("includes/footer.php"); ?>
