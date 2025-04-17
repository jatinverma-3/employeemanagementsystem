<?php
session_start();
if (!isset($_SESSION['userid']) && !isset($_SESSION['username'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}
include("includes/header.php");
include("includes/sidebar.php");
include("includes/connection.php");

//fetch the tasks of user
$s="SELECT * FROM `tasks` WHERE emp_id=? ORDER BY created_at DESC";
$stmt = mysqli_prepare($conn, $s);
mysqli_stmt_bind_param($stmt, "i", $_SESSION['userid']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

?>

<title>My Tasks - 5G Infotech</title>

<main class="main-wrapper">
    <div class="main-content">

        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">My Tasks</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo "Hello, " . $_SESSION['username']; ?></li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- end breadcrumb -->

        <?php if ($result && $result->num_rows > 0) { ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        
                        <div class="card-body">
                        <h1>My Tasks</h1>
                            <p id="alertbox"><?php if(isset($alert)) { echo $alert; } ?></p>
                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Sr.</th>
                                            <th>Task Description</th>
                                            <th>Task Status</th>
                                            <th>Deadline</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; while ($data = mysqli_fetch_assoc($result)) { ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $data['task_description']; ?></td>
                                                <td><?php echo $data['task_status']; ?></td>
                                                <td><?php echo $data['task_deadline']; ?></td>
                                                <td><?php echo $data['created_at']; ?></td>
                                                <td>
                                                <?php 
switch($data['task_status'])
{
    case 'pending':
        echo '<div class="col">
        <button type="button" onclick="update(\'in_progress\','.$data['task_id'].')" class="btn btn-warning px-5 raised">Set as In Progress</button>
        </div>';
        echo '<div class="col">
        <button type="button" onclick="update(\'completed\','.$data['task_id'].')" class="btn btn-success px-5 raised">Set As Completed</button>
        </div>';
        break;
    case 'completed':
        echo '<div class="col">
        <button type="button" onclick="update(\'delete\','.$data['task_id'].')" class="btn btn-danger px-5 raised">Delete</button>
        </div>';
        break;
    case 'in_progress':
        echo '<div class="col">
        <button type="button" onclick="update(\'completed\','.$data['task_id'].')" class="btn btn-success px-5 raised">Set As Completed</button>
        </div>';
        break;
}
?>

                                                </td>
                                            </tr>
                                        <?php $i++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="alert alert-success">No Data found</div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5>Add a task quickly:</h5>
                        <br>
                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="mb-3">
                                <label class="form-label">Task Description</label>
                                <textarea class="form-control" name="text_description" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Task Status:   </label>
                                <input type='radio' name='status' value='pending' required>  Pending
                                <input type='radio' name='status' value='in_progress' required>  In Progress
                                <input type='radio' name='status' value='completed' required>  Completed
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Task Deadline</label>
                                <input type='date' name='deadline' class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <input type="submit" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<script>
    function update(action,id)
    {
        switch(action)
        {
            case "in_progress":
                console.log('In Progress');
                window.location.href='my-tasks.php?action='+action+'&id='+id;
            break;
            case "completed":
                console.log('completed');
                window.location.href='my-tasks.php?action='+action+'&id='+id;
            break;
            case "delete":
                console.log('delete');
                var c = confirm('Are you sure you want to delete this task?');
                if(c)
                {
                    window.location.href='my-tasks.php?action='+action+'&id='+id;
                }
            break;
        }
    }
</script>

<?php 

//for inserting data into database
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['text_description']) && isset($_POST['status']) && isset($_POST['deadline'])) {
        $task_description = $_POST['text_description'];
        $task_status = $_POST['status'];
        $task_deadline = $_POST['deadline'];
        $emp_id = $_SESSION['userid']; // Assuming emp_id is stored in session

        // Insert data into tasks table
        $query = "INSERT INTO tasks (emp_id, task_description, task_status, task_deadline, created_at)
                  VALUES (?, ?, ?, ?, NOW())";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "isss", $emp_id, $task_description, $task_status, $task_deadline);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Task added successfully.');
            window.location.href='my-tasks.php';</script>";
        } else {
            echo "<script>alert('Error adding task: " . mysqli_error($conn) . "');</script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Please fill in all required fields.');</script>";
    }
}

if (isset($_GET['action']) && isset($_GET['id'])) {
    switch ($_GET['action']) {
        case "in_progress":
            $s = "UPDATE tasks SET task_status='in_progress' WHERE task_id=" . $_GET['id'];
            if (mysqli_query($conn, $s)) {
                $alert = '<div class="alert alert-secondary border-0 bg-warning alert-dismissible fade show">
                        <div class="d-flex align-items-center">
                            <div class="font-35 text-dark"><span class="material-icons-outlined fs-2">report_problem</span></div>
                            <div class="ms-3">
                                <h6 class="mb-0 text-white">Task Updated</h6>
                                <div class="text-white">Task status set to In Progress.</div>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                echo "<script>window.location.href='my-tasks.php';</script>";
            }
            break;
        case "completed":
            // Handle completion logic
            $s = "UPDATE tasks SET task_status='completed' WHERE task_id=" . $_GET['id'];
            if (mysqli_query($conn, $s)) {
                $alert = '<div class="alert alert-secondary border-0 bg-success alert-dismissible fade show">
                        <div class="d-flex align-items-center">
                            <div class="font-35 text-white"><span class="material-icons-outlined fs-2">check_circle</span></div>
                            <div class="ms-3">
                                <h6 class="mb-0 text-white">Task Completed</h6>
                                <div class="text-white">Task status set to Completed.</div>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                echo "<script>window.location.href='my-tasks.php';</script>";
            }
        break;
        case "delete":
            // Handle deletion logic
            $s = "DELETE FROM tasks WHERE task_id=" . $_GET['id'];
            if (mysqli_query($conn, $s)) {
                $alert = '<div class="alert alert-secondary border-0 bg-danger alert-dismissible fade show">
                        <div class="d-flex align-items-center">
                            <div class="font-35 text-white"><span class="material-icons-outlined fs-2">report_gmailerrorred</span></div>
                            <div class="ms-3">
                                <h6 class="mb-0 text-white">Task Deleted</h6>
                                <div class="text-white">Task status set to Completed.</div>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';   
                echo "<script>window.location.href='my-tasks.php';</script>";
            }
        break;
    }
}


include("includes/footer.php"); 
?>