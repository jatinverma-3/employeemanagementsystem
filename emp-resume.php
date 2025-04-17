<?php
@include 'includes/header.php';
@include 'includes/sidebar.php';
@include 'includes/connection.php';


$s="SELECT e.emp_id,e.emp_name,e.created_at,e.resume,d.dpt_name
FROM employee_details e,department d
WHERE e.dpt_id=d.dpt_id 
ORDER BY created_at DESC";
$result=mysqli_query($conn,$s);

?>

<title>View Employee Resume - 5G Infotech</title>

<div class="content-wrapper">
    <section class="content-header">
        <h1>View Employee Resume</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">View Employee Resume</h3>
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
                                                <a href="../user/resume/<?php echo $row['resume']; ?>" class="btn btn-primary">View</a>
                                                <a href="edit-emp-detail.php?id=<?php echo $row['emp_id']; ?>" class="btn btn-primary">Edit</a>
                                            </td>
                                        </tr>
                                    <?php $s++; endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
@include 'includes/footer.php';
?>