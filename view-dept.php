<?php
@include 'includes/header.php';
@include 'includes/sidebar.php';
@include 'includes/connection.php';

if(isset($_GET['dptname']))
{
    $dptname = mysqli_real_escape_string($conn, $_GET['dptname']);
    $s="SELECT * FROM department WHERE dpt_name LIKE '%$dptname%'";
    $result=mysqli_query($conn,$s);
}else{

$s="SELECT * FROM department";
$result=mysqli_query($conn,$s);
}

?>

<title>View Departments - 5G Infotech</title>

<div class="content-wrapper">
    <section class="content-header">
        <h1>View Departments</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">View Departments</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr</th>
                                        <th>Department Name</th>
                                        <th>Location</th>
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
                                                <?php echo $row['dpt_name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['location']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['created_at']; ?>
                                            </td>
                                            <td>
                                                <button onclick="deleterecord(<?php echo htmlspecialchars(json_encode($row['dpt_id'])); ?>)" class="btn btn-danger btn-sm">Delete</button>
                                            </td>
                                        </tr>
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

<script>
function deleterecord(oid)
{
    var c = confirm('Are you sure you want to delete this department?');
    if(c)
    {
        window.location.href='view-dept.php?action=delete&id=' +oid;
    }
}
</script>


<?php

if(isset($_GET['action']) && isset($_GET['id']))
{
    echo "<script>console.log('Get Attributes set');</script>";
    if($_GET['action']=="delete")
    {
        $s="DELETE FROM department WHERE dpt_id=" . $_GET['id'] . "";
        if(mysqli_query($conn,$s))
        {
            echo "<script>alert('Department deleted successfully');
            window.location.href='view-dept.php';</script>";
        }
    }
}

@include 'includes/footer.php';
?>