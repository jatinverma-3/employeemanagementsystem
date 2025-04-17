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
                Search Department
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="index.php"><i class="fa fa-dashboard"></i> Home</a>
                    </li>
                    <li class="active">Search Department</li>
                </ol>
            </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Search Department</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="metaTitle">Department Name:</label>
                                    <input type="text" class="form-control" name="dpt_name" required>
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
    if(!empty($_POST['dpt_name']))
    {
        echo "<script>
            window.location.href='view-dept.php?dptname=".$_POST['dpt_name']."';
        </script>";
    }
}

@include 'includes/footer.php';
?>