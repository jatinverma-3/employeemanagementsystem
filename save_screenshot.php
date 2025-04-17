<?php
@include 'includes/connection.php';

//save screenshots in the screenshot table
if (isset($_POST['imgBase64']) && isset($_POST['empid'])) {
    $data = $_POST['imgBase64'];
    // Remove the data:image/png;base64, part
    $data = str_replace('data:image/png;base64,', '', $data);
    $data = str_replace(' ', '+', $data);
    $data = base64_decode($data);

    // Create a unique filename
    $filename = uniqid() . '.png';

    // Save the file to a directory
    $file = 'screenshots/' . $filename;

    file_put_contents($file, $data);

    $s="INSERT INTO screenshots (emp_id, image, created_at) VALUES (?,?,NOW())";
    $stmt=mysqli_prepare($conn,$s);
    mysqli_stmt_bind_param($stmt,"is",$_POST['empid'],$file);
    if(mysqli_stmt_execute($stmt))
    {
        echo "Screenshot inserted in database successfully at " . date("H:i:s");
    }

} else {
    echo "No image data received.";
}


//data inserted after checkout (in work log table)
if(isset($_POST['empid']) && isset($_POST['checkintime']) && isset($_POST['checkouttime']) 
&& isset($_POST['duration']) && isset($_POST['remarks']))
{
    $date=date("Y-m-d");

    //check for dummy records, if present, delete it and insert fresh one
    $remarks='dummy record';
    $s="SELECT * FROM work_log WHERE emp_id=? AND remarks=? AND date=?";
    $stmt=mysqli_prepare($conn,$s);
    mysqli_stmt_bind_param($stmt,"iss",$_POST['empid'],$remarks,$date);
    mysqli_stmt_execute($stmt);
    $result=mysqli_stmt_get_result($stmt);
    if($result->num_rows > 0)
    {
        echo 'Dummy record is present for ' . $date;
        echo 'Deleting DUMMY RECORD';
        $s="DELETE FROM work_log WHERE emp_id=? AND remarks=? AND date=?";
        $stmt=mysqli_prepare($conn,$s);
        mysqli_stmt_bind_param($stmt,"iss",$_POST['empid'],$remarks,$date);
        if(mysqli_stmt_execute($stmt))
        {
            echo "DUMMY RECORD DELETED";
        }
    }

    echo $_POST['checkintime'];
    echo $_POST['checkouttime'];

    $s = "INSERT INTO work_log 
    (`emp_id`, `date`, `check_in_time`, `check_out_time`, `hours_worked`, `remarks`) 
    VALUES (?,?,?,?,?,?)";
    $stmt = mysqli_prepare($conn, $s);
    mysqli_stmt_bind_param($stmt, "isssds", $_POST['empid'], $date, $_POST['checkintime'], $_POST['checkouttime'], $_POST['duration'], $_POST['remarks']);
    if (mysqli_stmt_execute($stmt)) {
        echo "Data entered in work log table";
    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
    }
}

?>
