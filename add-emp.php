<?php
@include 'includes/header.php';
@include 'includes/sidebar.php';
@include 'includes/connection.php';

function enum_type($conn, $tableName, $enumColumnName) {
    // SQL query to retrieve the ENUM definition
    $sql = "SELECT COLUMN_TYPE 
            FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_NAME = ? 
            AND COLUMN_NAME = ?";

    // Prepare the statement to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $tableName, $enumColumnName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $columnType = $row['COLUMN_TYPE'];

        // Extract the ENUM values from the COLUMN_TYPE string
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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dpt_id = $_POST['dpt_id'];
    $img = $_FILES['image']['name'];
    $resume = $_FILES['resume']['name'];
    $dept = $_POST['dept'];
    $emp_name = $_POST['emp_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $type = $_POST['type'];
    $status = $_POST['status'];
    $login_id = $_POST['login_id'];
    $password = $_POST['password']; // Hashing the password
    $created_at = date('Y-m-d H:i:s');

    // Check if all fields are filled
    if (empty($dpt_id) || empty($dept) || empty($emp_name) || empty($email) || empty($phone) || empty($resume) ||
    empty($address) || empty($type) || empty($status) || empty($login_id) || empty($password) || empty($img)) {
        echo '<script>alert("Please fill all the fields.");</script>';
    } else {
        echo '<script>console.log("All fields are entered.");</script>';

        // Handle image upload
        $target_dir = "../user/images/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo '<script>alert("File is not an image.");</script>';
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["image"]["size"] > 500000) {
            echo '<script>alert("Sorry, your file is too large.");</script>';
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo '<script>alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");</script>';
            $uploadOk = 0;
        }

        //upload resume
        $target_dir_r = "../user/resume/";
        $target_file_r = $target_dir_r . basename($_FILES["resume"]["name"]);

        // Prepare SQL to insert data into employee_details table
        $sql = "INSERT INTO employee_details (emp_id, dpt_id, emp_name, email, phone, address, type, status, login_id, password, created_at, image, resume) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisssssssssss", $dpt_id, $dept, $emp_name, $email, $phone, $address, $type, $status, $login_id, $password, $created_at, $_FILES['image']['name'],$_FILES["resume"]["name"]);

        if ($stmt->execute()) {
            // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo '<script>alert("Sorry, your file was not uploaded.");</script>';
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                echo '<script>console.log("The file '. basename( $_FILES["image"]["name"]). ' has been uploaded.");</script>';
            } else {
                echo '<script>console.log("Sorry, there was an error uploading your file.");</script>';
            }
            if (move_uploaded_file($_FILES["resume"]["tmp_name"], $target_file_r)) {
                echo '<script>console.log("The resume file '. basename( $_FILES["resume"]["name"]). ' has been uploaded.");</script>';
            } else {
                echo '<script>console.log("Sorry, there was an error uploading your resume file.");</script>';
            }
        }
            echo '<script>alert("Employee added successfully.");</script>';
        } else {
            echo '<script>alert("Error adding employee: ' . $stmt->error . '");</script>';
        }
    }
}
?>

<title>Add Employee - 5G Infotech</title>

<div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Add Employee
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="index.php"><i class="fa fa-dashboard"></i> Home</a>
                </li>
                <li class="active">Add Employee</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Employee</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="metaTitle">Employee ID:</label>
                                    <input type="text" class="form-control" name="dpt_id" value="<?php echo rand(1000,999999); ?>" readonly required>
                                </div>

                                <div class="form-group">
                                    <label for="metaTitle">Upload Employee Image:</label>
                                    <input type="file" class="form-control" name="image" required>
                                </div>

                                <div class="form-group">
                                    <label for="metaTitle">Upload Employee Resume:</label>
                                    <input type="file" class="form-control" name="resume" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="metaTitle">Department:</label>
                                    <select name="dept" class="form-control" required>
                                        <option selected disabled>Select..</option>
                                        <?php 
                                        $s="SELECT dpt_id,dpt_name FROM department";
                                        $result=mysqli_query($conn,$s);
                                        while($row=mysqli_fetch_assoc($result))
                                        {
                                        ?>
                                        <option value="<?php echo $row['dpt_id'] ?>"><?php echo $row['dpt_id'] . " - " . $row['dpt_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="metaTitle">Employee Name:</label>
                                    <input type="text" class="form-control" name="emp_name" placeholder="Ex. Arun Kumar" required>
                                </div>
                                <div class="form-group">
                                    <label for="metaTitle">Email Address:</label>
                                    <input type="email" class="form-control" name="email" placeholder="Ex. abc@gmail.com" required>
                                </div>
                                <div class="form-group">
                                    <label for="metaTitle">Phone Number:</label>
                                    <input type="text" class="form-control" name="phone" placeholder="Ex. 1234567890" required>
                                </div>
                                <div class="form-group">
                                    <label for="metaTitle">Address:</label>
                                    <textarea name="address" class="form-control" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="metaTitle">Employee Type:</label>
                                    <select name="type" class="form-control" required>
                                        <option selected disabled>Select..</option>
                                        <?php 
                                        $enumValues = enum_type($conn, "employee_details", "type");
                                        foreach ($enumValues as $value) {
                                        ?>
                                        <option value="<?php echo $value; ?>"><?php echo ucfirst($value); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="metaTitle">Employee Status:</label>
                                    <select name="status" class="form-control" required>
                                        <option selected disabled>Select..</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <h1>Set Login Credentials for Employee</h1>
                                    <label for="metaTitle">Login ID:</label>
                                    <input type="text" class="form-control" name="login_id" value="<?php echo "5G" . rand(1000,9999); ?>" placeholder="Ex. ABCD1234" required>
                                </div>
                                <div class="form-group">
                                    <label for="metaTitle">Password:</label>
                                    <input type="text" class="form-control" name="password" placeholder="Ex. ABCD1234" required>
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
