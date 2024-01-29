<?php

include 'errorreporting.php';
include_once 'partials/config.php';
$sql = "SELECT * FROM job_detail";
$result = mysqli_query($conn, $sql);
$row = mysqli_num_rows($result);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs-TechFindr</title>
</head>
<body>
<?php
include_once 'partials/header.php';
?> 

<div class="image">
    <img src="partials/images/apply.png" class="image" alt="...">
</div>

<section class="job-list" id="jobs">
                
        <div class="job-card">
            <div class="job-name">
                <img class="job-profile" src="partials/images/tesla.png">
                <div class="job-details">
                    
                <?php 
                if($row > 0)
                {
                    while ($row = mysqli_fetch_assoc ($result))
                    {
                        ?>

                        <h4>
                            <?php
                        echo $row['company_name'];
                        ?>
                        </h4>

                        <h3>
                        <?php
                        echo $row['designation'];
                        ?>
                        </h3>

                        <p>
                        <?php
                        echo $row['detail'];
                        ?>
                        </p>
                        <?php
                    }
                }
                ?>
            </div>
                   


                    
                </div>
            </div>
            <div class="job-label">
                <a class="label-1" href="#">

                </a>
                <a class="label-2" href="#">CSS</a>
                <a class="label-3" href="#">Javascript</a>
            </div>
            <div class="applynow-btn">
                <button class="applynow" onclick="location.href='applynow.php'">Apply Now</button>
            </div>
            <div class="appview-btn">
                <button class="appview" onclick="location.href='viewapplications.php'">View Applications</button>
            </div>
        

        <div class="job-card">
            <div class="job-name">
                <img class="job-profile" src="partials/images/facebook.png">
                <div class="job-details">
                    <h4>Facebook</h4>
                    <h3>Developer</h3>
                    <p>Facebook Company is looking for an employee.</p>
                </div>
            </div>
            <div class="job-label">
                <a class="label-1" href="#">Java</a>
                <a class="label-2" href="#">php</a>
                <a class="label-3" href="#">HTML</a>
            </div>
            <div class="applynow-btn">
                <button class="applynow" onclick="location.href='applynow.php'">Apply Now</button>
            </div>
            <div class="appview-btn">
                <button class="appview" onclick="location.href='viewapplications.php'">View Applications</button>
            </div>
        </div>
    </section>


    </body>

<?php
include_once 'partials/footer.php';
?>
</html>