<?php
@include 'includes/header.php';
@include 'includes/sidebar.php';
@include 'includes/connection.php';
?>

<title>Generate Offer Letter - 5G Infotech</title>

<div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
            Generate Offer Letter
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="index.php"><i class="fa fa-dashboard"></i> Home</a>
                </li>
                <li class="active">Generate Offer Letter</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Generate Offer Letter</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start  enctype="multipart/form-data"-->
                        <form method="post" action="offerpdf.php">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="metaTitle">Date</label>
                                    <input type="date" class="form-control" name="date" value="<?php echo date("Y-m-d"); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="metaTitle">Name (as to appear on letter)</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="metaTitle">Position (as to appear on letter)</label>
                                    <input type="text" class="form-control" name="position" required>
                                </div>
                                <div class="form-group">
                                    <label for="metaTitle">Joining Date (as to appear on letter)</label>
                                    <input type="date" class="form-control" name="joindate" required>
                                </div>
                                <div class="form-group">
                                    <label for="metaTitle">Working Hours (as to appear on letter)</label>
                                    <input type="text" class="form-control" name="workinghours" required>
                                </div>
                                <div class="form-group">
                                    <label for="metaTitle">Payment (as to appear on letter)</label>
                                    <input type="text" class="form-control" name="payment" required>
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