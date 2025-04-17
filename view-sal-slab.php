<?php
@include 'includes/header.php';
@include 'includes/sidebar.php';
@include 'includes/connection.php';

$result = null; // Initialize the $result variable

if(isset($_GET['start']) && isset($_GET['end']) && isset($_GET['type']))
{
    $start = mysqli_real_escape_string($conn, $_GET['start']);
    $end = mysqli_real_escape_string($conn, $_GET['end']);
    $type = mysqli_real_escape_string($conn, $_GET['type']);
    
    switch($type)
    {
        case "monthly":
            $query = "SELECT s.*, d.emp_name 
                      FROM salary s, employee_details d
                      WHERE s.emp_id = d.emp_id 
                      AND monthly > $start AND monthly < $end";
            break;
        case "daily":
            $query = "SELECT s.*, d.emp_name 
                      FROM salary s, employee_details d
                      WHERE s.emp_id = d.emp_id 
                      AND daily > $start AND daily < $end";
            break;
        case "hourly":
            $query = "SELECT s.*, d.emp_name 
                      FROM salary s, employee_details d
                      WHERE s.emp_id = d.emp_id 
                      AND hourly_rate > $start AND hourly_rate < $end";
            break;
        default:
            $query = null;
            break;
    }
    
    if($query) {
        $result = mysqli_query($conn, $query);
        if(!$result) {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
else
{
    $query = "SELECT s.*, d.emp_name 
              FROM salary s, employee_details d
              WHERE s.emp_id = d.emp_id";
    $result = mysqli_query($conn, $query);
    if(!$result) {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<title>View Salary Slabs - 5G Infotech</title>

<div class="content-wrapper">
    <section class="content-header">
        <h1>View Salary Slabs</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">View Salary Slabs</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr</th>
                                        <th>Employee Name</th>
                                        <th>Monthly Salary</th>
                                        <th>Daily Salary</th>
                                        <th>Hourly Salary</th>
                                        <th>Created at</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $sno = 0; ?>
                                    <?php if($result && $result->num_rows > 0): ?>
                                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                            <?php $sno++; ?>
                                            <tr>
                                                <td><?php echo $sno; ?></td>
                                                <td><?php echo $row['emp_name']; ?></td>
                                                <td><?php echo $row['monthly']; ?></td>
                                                <td><?php echo $row['daily']; ?></td>
                                                <td><?php echo $row['hourly_rate']; ?></td>
                                                <td><?php echo $row['created_at']; ?></td>
                                                <td>
                                                    <button onclick="window.location.href='edit-sal-slab.php?id=<?php echo $row['salary_id']; ?>';" class="btn btn-primary">Edit</button>
                                                    <button onclick="deleterecord(<?php echo htmlspecialchars(json_encode($row['salary_id'])); ?>)" class="btn btn-danger">Delete</button>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7">No records found</td>
                                        </tr>
                                    <?php endif; ?>
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
    var c = confirm('Are you sure you want to delete this salary slab?');
    if(c)
    {
        window.location.href='view-sal-slab.php?action=delete&id=' + oid;
    }
}
</script>

<?php
if(isset($_GET['action']) && isset($_GET['id']))
{
    echo "<script>console.log('Get Attributes set');</script>";
    if($_GET['action'] == "delete")
    {
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        $deleteQuery = "DELETE FROM salary WHERE salary_id = $id";
        if(mysqli_query($conn, $deleteQuery))
        {
            echo "<script>alert('Salary Slab deleted successfully');
            window.location.href='view-sal-slab.php';</script>";
        }
        else
        {
            echo "<script>alert('Error deleting record: " . mysqli_error($conn) . "');</script>";
        }
    }
}

@include 'includes/footer.php';
?>
