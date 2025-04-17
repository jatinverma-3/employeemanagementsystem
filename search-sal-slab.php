<?php
@include 'includes/header.php';
@include 'includes/sidebar.php';
@include 'includes/connection.php';
?>

<title>Search Salary Slab - 5G Infotech</title>

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
                    <li class="active">Search Salary Slab</li>
                </ol>
            </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Search Salary Slab</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="box-body">
                                <div class="form-group">
                                   <label for="metaTitle">Enter Start Amount</label>
                                    <input type="text" class="form-control" name="start" required>
                                </div>
                                <div class="form-group">
                                    <label for="metaTitle">Enter End Amount</label>
                                    <input type="text" class="form-control" name="end" required>
                                </div>
                                <div class="form-group">
                                    <label for="metaTitle">Salary Type:  </label>
                                    <input type="radio" name="type" value="monthly" required> Monthly
                                    <input type="radio" name="type" value="daily" required> Daily
                                    <input type="radio" name="type" value="Hourly" required> Hourly
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
    if(!empty($_POST['start']) && !empty($_POST['end']) && !empty($_POST['type']))
    {
        echo "<script>
            window.location.href='view-sal-slab.php?start=".$_POST['start']."&end=".$_POST['end']."&type=".$_POST['type']."';
        </script>";
    }
}

@include 'includes/footer.php';
?>