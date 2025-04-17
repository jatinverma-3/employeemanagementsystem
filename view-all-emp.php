<?php
@include 'includes/header.php';
@include 'includes/sidebar.php';
@include 'includes/connection.php';

if(isset($_GET['empname']))
{
    $empname = mysqli_real_escape_string($conn, $_GET['empname']);
    $s="SELECT e.*,d.dpt_name 
    FROM employee_details e,department d
    WHERE e.dpt_id=d.dpt_id
    AND emp_name LIKE '%$empname%'";
    $result=mysqli_query($conn,$s);
}
else{ 
$s="SELECT e.*,d.dpt_name
FROM employee_details e,department d
WHERE e.dpt_id=d.dpt_id 
ORDER BY created_at DESC";
$result=mysqli_query($conn,$s);
}
 
?>

<title>View All Employees - 5G Infotech</title>

<div class="content-wrapper">
    <section class="content-header">
        <h1>View All Employees</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">View All Employees</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr</th>
                                        <th>Employee ID</th>
                                        <th>Employee Name</th>
                                        <th>Department Name</th>
                                        <th>Employee Type</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
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
                                                <?php echo $row['emp_id']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['emp_name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['dpt_name']; ?>
                                            </td>
                                            <td>
                                                <?php echo ucfirst($row['type']); ?>
                                            </td>
                                            <td>
                                                <?php echo $row['created_at']; ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-primary" onclick="window.location.href='edit-emp-detail.php?id=<?php echo $row['emp_id']; ?>';">Edit</button>
                                                <button class="btn btn-primary" onclick="window.location.href='view-emp-detail.php?id=<?php echo $row['emp_id']; ?>';">View Details</button>
                                                
                                                <?php 
                                                if($row['status']=="active") { ?>
                                                    <button onclick="setinactive(<?php echo htmlspecialchars(json_encode($row['emp_id'])); ?>)" class="btn btn-warning">Set Inactive</button>   
                                                <?php } else if($row['status']=="inactive") { ?>
                                                    <button onclick="setactive(<?php echo htmlspecialchars(json_encode($row['emp_id'])); ?>)" class="btn btn-success">Set Active</button>
                                                <?php } ?>

                                                <button onclick="deleterecord(<?php echo htmlspecialchars(json_encode($row['emp_id'])); ?>)" class="btn btn-danger">Delete</button>

                                                <button class='btn btn-success' onclick='window.location.href="view-all-emp.php?idid=<?php echo $row["emp_id"] ?>"'>Generate ID Card</button>
                                                <button class='btn btn-primary' onclick='window.location.href="../user/resume/<?php echo $row["resume"]; ?>";'>View Resume</button>
                                            </td>
                                        </tr>
                                        <!-- ID CARD FORM --> 
                                        <form id="idcard" action="idcardpdf.php" method="POST"></form>
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

<script src='https://code.jquery.com/jquery-3.7.1.min.js'></script>
<script>
function deleterecord(oid)
{
    var c = confirm('Are you sure you want to delete this employee?');
    if(c)
    {
        window.location.href='view-all-emp.php?action=delete&id=' +oid;
    }
}
function setinactive(oid)
{
    var c = confirm('Are you sure you want to set this user inactive?');
    if(c)
    {
        window.location.href='view-all-emp.php?action=inactive&id=' +oid;
    }
}
function setactive(oid)
{
    var c = confirm('Are you sure you want to set this user active?');
    if(c)
    {
        window.location.href='view-all-emp.php?action=active&id=' +oid;
    }
}
function idcard(){}
</script>



<?php

if(isset($_GET['id']) && isset($_GET['action']))
{
    switch($_GET['action'])
    {
        case "delete":
            echo "<script>console.log('Delete Request recieved');</script>";
            $s="SELECT image from employee_details where emp_id=" . $_GET['id'] . "";
            $result=mysqli_query($conn,$s);
            while($row=mysqli_fetch_row($result))
            {
                $existing_image=$row[0];
            }
            echo $existing_image;
            $s="DELETE FROM employee_details WHERE emp_id=" . $_GET['id'] . "";
            if(mysqli_query($conn,$s))
            {
                if (!empty($existing_image)) {
                    $image_path = "../user/images/" . $existing_image;
                    if (file_exists($image_path)) {
                        unlink($image_path);
                    }
                }
                echo "<script>alert('Employee Deleted Successfully');
                window.location.href='view-all-emp.php';</script>";
            }else{
                echo "<script>alert('Error:".mysqli_error($conn)."');</script>";
            }
        break;
        case "inactive":
            echo "<script>console.log('Inactive Request recieved');</script>";
            $s="UPDATE employee_details SET status='inactive' WHERE emp_id=" . $_GET['id'] . "";
            if(mysqli_query($conn,$s))
            {
                echo "<script>alert('Employee set as inactive');
                window.location.href='view-current-emp.php';</script>";
            }else{
                echo "<script>alert('Error:".mysqli_error($conn)."');</script>";
            }
        break;
        case "active":
            echo "<script>console.log('Active Request recieved');</script>";
            $s="UPDATE employee_details SET status='active' WHERE emp_id=" . $_GET['id'] . "";
            if(mysqli_query($conn,$s))
            {
                echo "<script>alert('Employee set as active');
                window.location.href='view-all-emp.php';</script>";
            }else{
                echo "<script>alert('Error:".mysqli_error($conn)."');</script>";
            }
        break;
    }
}

if(isset($_GET['idid']))
{
    $s="SELECT e.*, d.dpt_name
    FROM employee_details e,department d 
    WHERE e.dpt_id=e.dpt_id
    AND emp_id=" . $_GET['idid'] . "";
    $result=mysqli_query($conn,$s);
    $iddata=mysqli_fetch_assoc($result);
    ?>

    <script src='https://code.jquery.com/jquery-3.7.1.min.js'></script>
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


@include 'includes/footer.php';
?>