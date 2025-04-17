<?php
@include 'includes/header.php';
@include 'includes/sidebar.php';
@include 'includes/connection.php';

// Set default date to current date if no date is selected
$date = isset($_POST['date']) ? $_POST['date'] : date('Y-m-d');

// Fetch screenshots based on the selected date
$sql = "SELECT s.*,d.emp_name 
  FROM screenshots s,employee_details d
WHERE s.emp_id=d.emp_id AND DATE(s.created_at) = ?
ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $date);
$stmt->execute();
$result = $stmt->get_result();
$screenshots = [];
while ($row = $result->fetch_assoc()) {
    $screenshots[] = $row;
}
?>

<title>Filter Screenshots - 5G Infotech</title>

<style>
.thumbnail {
    border: 1px solid #ddd;
    padding: 4px;
    border-radius: 4px;
    transition: 0.3s;
    margin-bottom: 20px;
}

.thumbnail:hover {
    box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.2);
}

.thumbnail img {
    width: 100%;
    height: auto;
}

.caption {
    text-align: center;
    font-size: 14px;
    padding: 10px 0;
}
</style>

<div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Filter Screenshots</h1>
            <ol class="breadcrumb">
                <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Filter Screenshots</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Filter Screenshots</h3>
                            <button onclick='window.location.href="view-screenshots.php?action=delete";' class='btn btn-danger' style='float:right'>Clear All Screenshots</button>
                        </div>
                        <!-- form start -->
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="date">Select Date:</label>
                                    <input type="date" class="form-control" id="date" name="date" value="<?php echo $date; ?>">
                                </div>
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Display Screenshots -->
            <div class="row">
                <?php if (empty($screenshots)): ?>
                    <div class="col-md-12">
                        <p>No screenshots found for the selected date.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($screenshots as $screenshot): ?>
    <div class="col-md-4">
        <div class="thumbnail">
            <!-- Thumbnail image with data-target set to the modal id -->
            <img src="<?php echo '../user/' . $screenshot['image']; ?>" alt="Screenshot" data-toggle="modal" data-target="#imageModal<?php echo $screenshot['id']; ?>">
            <div class="caption">
                <p>Employee Name: <?php echo $screenshot['emp_id'] . " - " . $screenshot['emp_name']; ?></p>
                <p>Uploaded on: <?php echo $screenshot['created_at']; ?></p>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="imageModal<?php echo $screenshot['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel<?php echo $screenshot['id']; ?>" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel<?php echo $screenshot['id']; ?>">Screenshot</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Full-size image -->
                    <img src="<?php echo '../user/' . $screenshot['image']; ?>" style='height:500px;width:870px' class="img-fluid" alt="Screenshot">
                </div>
                <div class="modal-footer">
                    <p>Employee Name: <?php echo $screenshot['emp_id'] . " - " . $screenshot['emp_name']; ?></p>
                    <p>Uploaded on: <?php echo $screenshot['created_at']; ?></p>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

                <?php endif; ?>
            </div>
        </section>
    </div>
</div>

<?php

if(isset($_GET['action']))
{
    if($_GET['action']=="delete")
    {
        echo "<script>console.log('".$date."');</script>";
        $s="SELECT image FROM screenshots";
        $result=mysqli_query($conn,$s);
        $images=array();
        $i=0;
        while($row=mysqli_fetch_assoc($result))
        {
            $images[$i]=$row['image'];
            $i++;
        }

        print_r($images);

        $s="DELETE FROM screenshots";
        if(mysqli_query($conn,$s))
        {
            //unlinking images
            $i=0;
            while($i < count($images))
            {
                $existing_image=$images[$i];
                if (!empty($existing_image)) {
                    $image_path = '../user/' . $existing_image;
                    if (file_exists($image_path)) {
                        unlink($image_path);
                    }
                }
                $i++;
            }
            echo "<script>alert('Screenshots deleted successfully');
            window.location.href='view-screenshots.php';</script>";
        }
    }
}
@include 'includes/footer.php';

/* //unlink existing image 
            $existing_image = $employee['image'];
            if (!empty($existing_image)) {
                $image_path = $existing_image;
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            } */


?>
