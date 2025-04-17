<?php
@include 'includes/header.php';
@include 'includes/sidebar.php';
@include 'includes/connection.php';

// Function to retrieve ENUM values from a table column
function enum_type($conn, $tableName, $enumColumnName) {
    $sql = "SELECT COLUMN_TYPE 
            FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_NAME = ? 
            AND COLUMN_NAME = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $tableName, $enumColumnName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $columnType = $row['COLUMN_TYPE'];

        preg_match("/^enum\((.*)\)$/", $columnType, $matches);
        $enumValues = explode(",", $matches[1]);
        $enumValues = array_map(function($value) {
            return trim($value, "'");
        }, $enumValues);

        return $enumValues;
    } else {
        return [];
    }
}

if(isset($_GET['id'])) {
    $emp_id = $_GET['id'];

    $sql = "SELECT * FROM employee_details WHERE emp_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $emp_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
    } else {
        echo '<script>alert("Employee not found.");</script>';
        exit;
    }
}

if($_SERVER['REQUEST_METHOD']=="POST") {
    $updated_at = date("Y-m-d H:i:s");
    $image = $employee['image']; // Default to existing image
    $resume = $employee['resume']; // Default to existing resume

    // Handle image upload if a new image is selected
    if(isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
        $target_dir = "../user/images/";
        $image = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            if (!empty($employee['image'])) {
                $old_path = "../user/images/" . $employee['image'];
                if (file_exists($old_path)) {
                    unlink($old_path);
                }
            }
        } else {
            echo '<script>alert("Error uploading image file.");</script>';
        }
    }

    // Handle resume upload if a new resume is selected
    if(isset($_FILES['resume']['name']) && !empty($_FILES['resume']['name'])) {
        $target_dir_r = "../user/resume/";
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

    // Update employee details
    $sql = "UPDATE employee_details 
            SET dpt_id = ?, image = ?, resume = ?, emp_name = ?, email = ?, phone = ?, address = ?, type = ?, status = ?, login_id = ?, password = ?, updated_at = ? 
            WHERE emp_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssssssssi", $_POST['dpt_id'], $image, $resume, $_POST['emp_name'], $_POST['email'], $_POST['phone'], $_POST['address'], $_POST['type'], $_POST['status'], $_POST['login_id'], $_POST['password'], $updated_at, $_GET['id']);

    if ($stmt->execute()) {
        echo '<script>alert("Employee updated successfully.");
        window.location.href="edit-emp-detail.php?id='.$_GET['id'].'";</script>';
    } else {
        echo '<script>alert("Error updating employee: ' . $stmt->error . '");</script>';
    }
}

?>

<title>Edit Employee Details - 5G Infotech</title>

<div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Edit Employee Details
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="index.php"><i class="fa fa-dashboard"></i> Home</a>
                </li>
                <li class="active">Edit Employee Details</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Edit Employee Details</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form enctype="multipart/form-data" method="post" action="edit-emp-detail.php?id=<?php echo $_GET['id'] ?>">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="metaTitle">Employee ID:</label>
                                    <input type="text" class="form-control" name="dpt_id" value="<?php echo $employee['emp_id']; ?>" readonly required>
                                </div>
                                <div class="form-group">
                                    <label for="metaTitle">Upload Employee Image:</label>
                                    <input type="file" class="form-control" name="image">
                                    <?php if (!empty($employee['image'])): ?>
                                        <?php echo $employee['image']; ?>
                                        <br>
                                        <img src="../user/images/<?php echo $employee['image']; ?>" style="max-width: 200px; margin-top: 10px;" />
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="metaTitle">Upload Employee Resume:</label>
                                    <input type="file" class="form-control" name="resume">
                                    <?php if (!empty($employee['resume'])): ?>
                                        <?php echo $employee['resume']; ?>
                                        <br>
                                        <a href='../user/resume/<?php echo $employee['resume']; ?>'>Click Here to view Resume</a>
                                    <?php endif; ?> 
                                </div>
                                <div class="form-group">
                                    <label for="metaTitle">Department:</label>
                                    <select name="dpt_id" class="form-control" required>
                                        <option selected disabled>Select..</option>
                                        <?php 
                                        $s = "SELECT dpt_id, dpt_name FROM department";
                                        $result = mysqli_query($conn, $s);
                                        while($row = mysqli_fetch_assoc($result)) {
                                            $selected = ($row['dpt_id'] == $employee['dpt_id']) ? 'selected' : '';
                                        ?>
                                        <option value="<?php echo $row['dpt_id']; ?>" <?php echo $selected; ?>><?php echo $row['dpt_id'] . " - " . $row['dpt_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="metaTitle">Employee Name:</label>
                                    <input type="text" class="form-control" name="emp_name" value="<?php echo $employee['emp_name']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="metaTitle">Email Address:</label>
                                    <input type="email" class="form-control" name="email" value="<?php echo $employee['email']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="metaTitle">Phone Number:</label>
                                    <input type="text" class="form-control" name="phone" value="<?php echo $employee['phone']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="metaTitle">Address:</label>
                                    <textarea name="address" class="form-control" required><?php echo $employee['address']; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="metaTitle">Employee Type:</label>
                                    <select name="type" class="form-control" required>
                                        <option selected disabled>Select..</option>
                                        <?php 
                                        $enumValues = enum_type($conn, "employee_details", "type");
                                        foreach ($enumValues as $value) {
                                            $selected = ($value == $employee['type']) ? 'selected' : '';
                                        ?>
                                        <option value="<?php echo $value; ?>" <?php echo $selected; ?>><?php echo $value; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="metaTitle">Employee Status:</label>
                                    <select name="status" class="form-control" required>
                                        <option selected disabled>Select..</option>
                                        <option value="active" <?php echo ($employee['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                                        <option value="inactive" <?php echo ($employee['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <h1>Set Login Credentials for Employee</h1>
                                    <label for="metaTitle">Login ID:</label>
                                    <input type="text" class="form-control" name="login_id" value="<?php echo $employee['login_id']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="metaTitle">Password:</label>
                                    <input type="text" class="form-control" name="password" value="<?php echo $employee['password']; ?>" required>
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

<?php
@include 'includes/footer.php';
?>
