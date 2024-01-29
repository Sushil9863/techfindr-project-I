<?php
include 'partials/errorreporting.php';
include 'partials/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contactNumber = $_POST['contact_number'];
    $coverletter = $_POST['cover_letter'];

    if (isset($_FILES["resume"]) && $_FILES["resume"]["error"] == 0) {
        $allowedTypes = ["application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document"];
        $maxFileSize = 1048576; // 1MB

        $fileType = $_FILES["resume"]["type"];
        $fileSize = $_FILES["resume"]["size"];

        if (in_array($fileType, $allowedTypes)) {
            if ($fileSize <= $maxFileSize) {
                $uploadDir = "partials/images/";

                $filename = uniqid("resume_", true) . "." . pathinfo($_FILES["resume"]["name"], PATHINFO_EXTENSION);
                $destination = $uploadDir . $filename;

                if (move_uploaded_file($_FILES["resume"]["tmp_name"], $destination)) {
                    // Retrieve job ID based on selected job
                    $selectedJob = $_POST['selected_job'];
                    $query = "SELECT job_id FROM job_detail WHERE job_title = ?";
                    $stmt = mysqli_prepare($conn, $query);
                    mysqli_stmt_bind_param($stmt, "s", $selectedJob);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $jobID);
                    mysqli_stmt_fetch($stmt);
                    mysqli_stmt_close($stmt);

                    // Prepare the INSERT statement
                    $stmt = mysqli_prepare($conn, "INSERT INTO applicants (applicant_name, contact_number, email, cover_letter, resume, job_id) VALUES (?, ?, ?, ?, ?, ?)");

                    // Bind the parameters and execute the statement
                    mysqli_stmt_bind_param($stmt, "sssssi", $name, $contactNumber, $email, $coverletter, $destination, $jobID);

                    if (mysqli_stmt_execute($stmt)) {
                        echo "All Done!";
                        exit();
                    } else {
                        die('Error: Failed to execute the statement');
                    }
                } else {
                    echo "Failed to upload the file.";
                }
            } else {
                echo "File size exceeds the maximum limit (1MB).";
            }
        } else {
            echo "Invalid file type. Only PDF, DOC, and DOCX files are allowed.";
        }
    } else {
        echo "Error occurred during file upload.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


    <link rel="stylesheet" href="applystyle.css">

</head>

<body>
    <div class="container">
        <h2>Job Application</h2>

        <form enctype="multipart/form-data" method="POST" action="">
            <div class="form-group">
                <label for="fullName">Full Name</label>
                <input type="text" class="form-control" id="fullName" name="name" placeholder="Enter your full name"
                    required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email"
                    required>
            </div>
            <div class="form-group">
                <label for="contactNumber">Contact Number</label>
                <input type="tel" class="form-control" id="contactNumber" name="contact_number"
                    placeholder="Enter your contact number" required>
            </div>

            <div class="form-group">
                <label for="selectedJob">Select Job</label>
                <select class="form-control" id="selectedJob" name="selected_job" required>
                    <!-- Fetch job titles dynamically from the job_detail table -->
                    <?php
                    $query = "SELECT job_title FROM job_detail";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['job_title'] . "'>" . $row['job_title'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="resume">Resume</label>
                <div class="custom-file">
                    <label class="custom-file-label" for="resume">Choose file</label>
                    <input type="file" class="custom-file-input" id="resume" name="resume" required>
                    <?php
                    if (isset($err['resume'])) {
                        echo $err['resume'];
                    }
                    ?>

                </div>
            </div>

            <div class="form-group">
                <label for="coverLetter">Cover Letter</label>
                <textarea class="form-control" id="coverLetter" name="cover_letter" rows="5"
                    placeholder="Enter your cover letter" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Application</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
