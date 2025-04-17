<?php
@include 'includes/header.php';
@include 'includes/sidebar.php';
@include 'includes/connection.php';
?>

<div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
                <h1>
                Add Department
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="index.php"><i class="fa fa-dashboard"></i> Home</a>
                    </li>
                    <li class="active">Add Department</li>
                </ol>
            </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Department</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="metaTitle">Department ID:</label>
                                    <input type="text" class="form-control" name="dpt_id" value="<?php echo rand(1,999); ?>" readonly required>
                                </div>
                                <div class="form-group">
                                    <label for="metaTitle">Department Name:</label>
                                    <input type="text" class="form-control" name="dpt_name" placeholder="Ex. Sales Department" required>
                                </div>
                                <div class="form-group">
                                    <label for="metaTitle">Department Location:</label>
                                    <input type="text" class="form-control" name="dpt_loc" placeholder="Ex. Rohtak" required>
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

if($_SERVER['REQUEST_METHOD']=="POST")
{
    if(!empty($_POST['dpt_id']) && !empty($_POST['dpt_name']) && !empty($_POST['dpt_loc']))
    {
        $date=date("Y-m-d H:i:s");
        echo "<script>console.log('All data recieved');</script>";
        $s="INSERT INTO department (dpt_id, dpt_name, location, created_at) VALUES (?,?,?,?)";
        $stmt=mysqli_prepare($conn,$s);
        mysqli_stmt_bind_param($stmt,"isss",$_POST['dpt_id'],$_POST['dpt_name'],$_POST['dpt_loc'],$date);
        if(mysqli_stmt_execute($stmt))
        {
            echo "<script>alert('Department Added Successfully');</script>";
        }
    }
}


@include 'includes/footer.php';
?>