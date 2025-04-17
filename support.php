<?php
session_start();
if (!isset($_SESSION['userid']) && !isset($_SESSION['username'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}
include("includes/header.php");
include("includes/sidebar.php");
include("includes/connection.php");
?>

<title>Employee Support - 5G Infotech</title>

<main class="main-wrapper">
    <div class="main-content">

        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Employee Support</div>
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

        <div class="row">
					<div class="col-12 col-lg-9 mx-auto">
						<div class="text-center">
							<h5 class="mb-0 text-uppercase">Frequently Asked Questions (FAQs)</h5>
							<hr>
						</div>
						<div class="card">
							<div class="card-body">
								<div class="accordion" id="accordionExample">
									<div class="accordion-item">
										<h2 class="accordion-header" id="headingOne">
						  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
							How do I request time off?
						  </button>
						</h2>
										<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
											<div class="accordion-body">
												<p>To request time off, please fill out the Time Off Request form available on the Employee Portal. Submit the form to your department manager for approval.</p>
												<p><strong>Example:</strong> Remember to submit your request at least two weeks in advance to ensure proper scheduling.</p>
											</div>
										</div>
									</div>
									<div class="accordion-item">
										<h2 class="accordion-header" id="headingTwo">
						  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
							How can I update my personal information?
						  </button>
						</h2>
										<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
											<div class="accordion-body">
												<p>To update your personal information such as address, phone number, or emergency contacts, please visit the Employee Profile section on the Employee Portal.</p>
												<p><strong>Example:</strong> Ensure all information is accurate to receive important updates and communications.</p>
											</div>
										</div>
									</div>
									<div class="accordion-item">
										<h2 class="accordion-header" id="headingThree">
						  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
							How do I report an IT issue?
						  </button>
						</h2>
										<div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
											<div class="accordion-body">
												<p>To report an IT issue, please contact the IT Help Desk at [IT Help Desk Number] or submit a ticket through the IT Support section on the Employee Portal.</p>
												<p><strong>Example:</strong> Provide detailed information about the issue for faster resolution.</p>
											</div>
										</div>
									</div>
									<div class="accordion-item">
										<h2 class="accordion-header" id="headingFour">
						  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
							Where can I find the employee handbook?
						  </button>
						</h2>
										<div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
											<div class="accordion-body">
												<p>The employee handbook is available for download in PDF format on the Employee Portal under the Resources section.</p>
												<p><strong>Example:</strong> Familiarize yourself with company policies and procedures outlined in the handbook.</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

    </div>
</main>

<?php include("includes/footer.php"); ?>
