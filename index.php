<?php
session_start();
if(!isset($_SESSION['userid']) && !isset($_SESSION['username']))
{
  echo "<script>window.location.href='login.php';</script>";
  exit;
}
include("includes/header.php");
include("includes/connection.php");
include("includes/sidebar.php");
$quotes = array(
    "The only way to do great work is to love what you do. – Steve Jobs",
    "Success is not the key to happiness. Happiness is the key to success. If you love what you are doing, you will be successful. – Albert Schweitzer",
    "The best way to predict the future is to create it. – Peter Drucker",
    "Individual commitment to a group effort: That is what makes a team work, a company work, a society work, a civilization work. – Vince Lombardi",
    "Quality means doing it right when no one is looking. – Henry Ford",
    "Believe you can and you're halfway there. – Theodore Roosevelt",
    "Alone we can do so little; together we can do so much. – Helen Keller",
    "Hard work beats talent when talent doesn't work hard. – Tim Notke",
    "The only limit to our realization of tomorrow is our doubts of today. – Franklin D. Roosevelt",
    "The way to get started is to quit talking and begin doing. – Walt Disney",
    "Success usually comes to those who are too busy to be looking for it. – Henry David Thoreau",
    "Don’t watch the clock; do what it does. Keep going. – Sam Levenson",
    "Opportunities don't happen. You create them. – Chris Grosser",
    "What lies behind us and what lies before us are tiny matters compared to what lies within us. – Ralph Waldo Emerson",
    "The future depends on what you do today. – Mahatma Gandhi"
);
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<title>Employee Dashboard - XYZ Company</title>

<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Dashboard</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Hello there</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class='card-body' id='workdonemessage' hidden='true'>

                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class='card-body' id='quicktasksfortom' hidden='true'>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <img src="assets/images/gallery/15.png" style="height:350px" class="card-img" alt="...">
                    <div class="card-img-overlay">
                        <p class="mb-4 text-white text-uppercase"><?php echo $greeting . " - " . $_SESSION['username']; ?></p>
                        <h5 class="card-title text-white">QUOTE FOR THE DAY</h5>
                        <h2 id="quote" class="mb-0 text-white">It was popularised in the 1960s with the release of Letraset sheets containing. <br>
                            Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-none bg-dark-blue mb-0">
                    <div class="card-body">
                        <h5 class="mb-0 text-white">Current Time is:</h5>
                        <br>
                        <h3 class="mb-0 text-white" id='clock'></h3>
                    </div>
                </div>
                <br>
                <div class="card shadow-none bg-dark-blue mb-0">
                    <div class="card-body">
                        <h5 class="mb-0 text-white">Have you checked your Tasks yet?</h5>
                        <br>
                        <p class="mb-0 text-white">If not, then quickly do it!</p>
                        <br>
                        <button type="button" onclick='window.location.href="#tasks";' class="btn btn-dark px-5 raised">Check It Out</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="card p-4 border-start rounded bg-light">
                    <div class="card-body">
                        <h3>Welcome Onboard, <?php echo $_SESSION['username']; ?></h3>
                        <p>We're thrilled to have you on board! This dashboard is your gateway to all the tools and resources you 
                            need to thrive at XYZ Company. Whether you're tracking your projects, exploring benefits, or 
                            staying updated on company news, everything is designed to make your experience seamless and productive.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h1>Start off your work</h1>
                        <p>Check In Now with the button below to begin your work shift</p>
                        <br><br>
                        <div class="alert alert-info border-0 bg-info alert-dismissible fade show">
                            <div class="d-flex align-items-center">
                                <div class="font-35 text-dark"><span class="material-icons-outlined fs-2">info</span>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0 text-dark">Information</h6>
                                    <div class="text-dark" id="checkinalerts">You have not checked in yet!</div>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <center><button id="checkin-btn" type="button" class="btn btn-success px-5 raised">Check In</button></center>
                            </div>
                            <div class="col-md-6">
                                <center><button id="checkout-btn" type="button" class="btn btn-danger px-5 raised">Check Out</button></center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4" id="tasks">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Your Tasks</h4>
                        <ul class="list-group" id="task-list">
                            <?php
                            $s="SELECT task_description,task_status FROM tasks WHERE task_status='pending' AND emp_id=" . $_SESSION['userid'] . "";
                            $result=mysqli_query($conn,$s); 
                            $i=1;
                            while($row=mysqli_fetch_row($result)) {
                            ?>
                            <li class="list-group-item" style='padding:5px'>
                                <p><?php echo $i . " - " . $row[0]; ?> <span class="badge rounded-pill bg-danger" style='float:right'>Pending</span></p>
                            </li>
                            <?php $i++; } 
                            ?>
                        </ul>
                        <button class="btn btn-primary mt-3" onclick="window.location.href='my-tasks.php';">View All Tasks</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card p-4 border-start rounded bg-light">
                    <div class="card-body">
                        <h3>Need Support?</h3>
                        <p>
                            Don't hesitate to contact us at our verified mail: <a href='mailto:info@5ginfotech.net'>info@xyz.com</a>
                        </p>
                        <br>
                        <button onclick='window.location.href="support.php";' type="button" class="btn btn-success px-5 raised">Proceed to FAQ</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
function updateClock() {
    var now = new Date();
    var hours = now.getHours();
    var minutes = now.getMinutes();
    var seconds = now.getSeconds();
    
    hours = hours < 10 ? '0' + hours : hours;
    minutes = minutes < 10 ? '0' + minutes : minutes;
    seconds = seconds < 10 ? '0' + seconds : seconds;
    
    var time = hours + ':' + minutes + ':' + seconds;
    
    document.getElementById('clock').innerText = time;
    
    setTimeout(updateClock, 1000); // Update every second
}

updateClock(); // Initial call to start clock

function fetchQuote() {
    var quotes = <?php echo json_encode($quotes); ?>;
    var randomIndex = Math.floor(Math.random() * quotes.length);
    var quote = quotes[randomIndex];
    document.getElementById('quote').innerText = quote;
}

fetchQuote();
</script>

<script
  src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
  crossorigin="anonymous"></script>
<script>
        let screenshotInterval;
        let checkInTime;
        let mediaStream;
        let isCheckedOut = true;

        // Function to store check-in time in localStorage
        function storeCheckInTime(time) {
            localStorage.setItem('checkInTime', time);
        }

        // Function to retrieve check-in time from localStorage
        function getStoredCheckInTime() {
            return localStorage.getItem('checkInTime');
        }

        // Function to format date to HH:mm:ss format
        function formatToTime(date) {
            return date.toLocaleTimeString([], { hour12: false });
        }


        async function startScreenCapture() {
            try {
                mediaStream = await navigator.mediaDevices.getDisplayMedia({ video: true });
                return true;
            } catch (err) {
                console.error("Error: " + err);
                return false;
            }
        }

        function stopScreenCapture() {
            if (mediaStream) {
                let tracks = mediaStream.getTracks();
                tracks.forEach(track => track.stop());
                mediaStream = null;
            }
        }

        async function captureScreenshot() {
            if (!mediaStream) {
                let accessGranted = await startScreenCapture();
                if (!accessGranted) {
                    $("#checkinalerts").text("Screen capture permission denied.");
                    alert("Screen capture permission denied.");
                    return;
                }
            }

            let videoTrack = mediaStream.getVideoTracks()[0];
            let imageCapture = new ImageCapture(videoTrack);
            let bitmap = await imageCapture.grabFrame();

            let canvas = document.createElement('canvas');
            canvas.width = bitmap.width;
            canvas.height = bitmap.height;
            let context = canvas.getContext('2d');
            context.drawImage(bitmap, 0, 0, bitmap.width, bitmap.height);

            let dataURL = canvas.toDataURL('image/png');
            $.ajax({
                type: 'POST',
                url: 'save_screenshot.php',
                data: { 
                    imgBase64: dataURL,
                    empid: <?php echo $_SESSION['userid']; ?>
                },
                success: function(response) {
                    console.log('Screenshot saved successfully!');
                    console.log(response);
                },
                error: function(err) {
                    console.error('Error saving screenshot:', err);
                }
            });
        }

        $(document).ready(function() {
            // Check if there's a stored check-in time
            let storedCheckInTime = getStoredCheckInTime();
            if (storedCheckInTime) {
                isCheckedOut = false;
                // Disable check-in button and enable check-out button
                $('#checkin-btn').prop('disabled', true);
                $('#checkout-btn').prop('disabled', false);
                $("#checkinalerts").text("You are currently checked in.");

                // Restore the check-in time
                checkInTime = new Date(storedCheckInTime);

                // Start taking screenshots every 5 minutes
                screenshotInterval = setInterval(async function() {
                    $('#notification').fadeIn().delay(3000).fadeOut();
                    await captureScreenshot();
                }, 180000); // 180000 ms = 3 minutes
            }
        });

        $('#checkin-btn').on('click', async function() {
            if (!isCheckedOut) {
                alert("You are already checked in. Please check out before checking in again.");
                return;
            }
             
            // Record the check-in time
            checkInTime = new Date();
            storeCheckInTime(checkInTime);
            isCheckedOut = false;

            // Enable the Check Out button
            $('#checkout-btn').prop('disabled', false);
            $('#checkin-btn').prop('disabled', true);

            $("#checkinalerts").text("You have now checked in, click the checkout button to stop your work");

            // Start taking screenshots every 5 minutes
            screenshotInterval = setInterval(async function() {
                $('#notification').fadeIn().delay(3000).fadeOut();
                await captureScreenshot();
            }, 180000); // 180000 ms = 3 minutes

            $('#notification').fadeIn().delay(3000).fadeOut();
            await captureScreenshot();
        });

        $('#checkout-btn').on('click', function() {
            // Record the check-out time and calculate the duration
            let checkOutTime = new Date();
            let duration = checkOutTime - checkInTime; // Duration in milliseconds

            // Convert duration to hours, minutes, and seconds
            let hours = Math.floor(duration / 3600000);
            let minutes = Math.floor((duration % 3600000) / 60000);
            let seconds = Math.floor((duration % 60000) / 1000);

            let minutesInHours = minutes / 60;
            let secondsInHours = seconds / 3600;

            // Total hours in decimal format
            let totalHours = hours + minutesInHours + secondsInHours;

            // Stop taking screenshots
            clearInterval(screenshotInterval);
            stopScreenCapture();

            // Reset buttons
            $('#checkout-btn').prop('disabled', true);
            $('#checkin-btn').prop('disabled', false);
            isCheckedOut = true;

            // Remove check-in time from localStorage
            localStorage.removeItem('checkInTime');

            //unhide remarks box
            $("#remarks").attr("hidden",false);

            //get remarks
            var remarks = prompt('Enter Remarks (compulsory after checkout)');

            alert('You have checked out. Remarks: '+remarks);

            $.ajax({
                type: 'POST',
                url: 'save_screenshot.php',
                data: { 
                    empid: <?php echo $_SESSION['userid']; ?> ,
                    checkintime: formatToTime(checkInTime),
                    checkouttime: formatToTime(checkOutTime),
                    duration: totalHours,
                    remarks: remarks
                },
                success: function(response) {
                    console.log(response);
                    //window.location.href='index.php';
                },
                error: function(err) {
                    console.error('Error:', err);
                }
            });
        });
</script>


<?php

$date=date("Y-m-d");
$s="SELECT * FROM work_log WHERE emp_id=? AND date=? AND remarks!='dummy record'";
$stmt=mysqli_prepare($conn,$s);
mysqli_stmt_bind_param($stmt,"is",$_SESSION['userid'],$date);
mysqli_stmt_execute($stmt);
$result=mysqli_stmt_get_result($stmt);

if($result->num_rows > 0)
{
    ?>
    <script>
    $(document).ready(function(){
      console.log('Data is present in work log table for this logged in user');
      var s='<h1>You are done with Today!</h1><p>Hope you performed well in your tasks today, See you again tomorrow with great enthusiasm and passion!</p>';
      var g='<h5>Add Tasks for tommorrow:</h5><br><a href="my-tasks.php" class="btn btn-secondary">Click here</a>';

      //disable buttons
      $('#checkin-btn').attr('disabled',true);
      $('#checkout-btn').attr('disabled',true);

      //add message 
      $('#checkinalerts').text('You are done with work for today, see you tomorrow!');

      //update divs on the top
      $('#workdonemessage').attr('hidden',false);
      $('#quicktasksfortom').attr('hidden',false);
      $('#workdonemessage').html(s);
      $('#quicktasksfortom').html(g);
    });
    </script>
    <?php 
}else{

    echo "<script>console.log('no real data found');</script>";

    $s="SELECT * FROM work_log WHERE emp_id=? AND date=? AND remarks='dummy record'";
    $stmt=mysqli_prepare($conn,$s);
    mysqli_stmt_bind_param($stmt,"is",$_SESSION['userid'],$date);
    mysqli_stmt_execute($stmt);
    $result1=mysqli_stmt_get_result($stmt);

    if($result1->num_rows > 0)
    {
        echo "<script>console.log('dummy data found');</script>";
    }else{
        echo "<script>console.log('no real or dummy data found, inserting dummy data');</script>";
    //insert dummy record
    $checkin='00:00:00';
    $checkout='00:00:00';
    $remarks='dummy record';
    $hoursworked=0.0;

    $s="INSERT INTO work_log 
    (`emp_id`, `date`, `check_in_time`, `check_out_time`, `hours_worked`, `remarks`) 
    VALUES (?,?,?,?,?,?)";
    $stmt=mysqli_prepare($conn,$s);
    mysqli_stmt_bind_param($stmt,"isssds",$_SESSION['userid'],$date,$checkin,$checkout,$hoursworked,$remarks);
    if(mysqli_stmt_execute($stmt))
    {
        echo "<script>console.log('Dummy data added to table');</script>";
    }
    }
}

echo "<script>console.log('".mysqli_get_server_info($conn)." , ".phpversion()."');</script>";

include("includes/footer.php"); 
?>
