<!DOCTYPE html>
<html lang="en">

<?php

    $con=mysqli_connect("127.0.0.1","root","root","WhatAReview",8889);
    $query="select count(*) from reviews";
    $result=mysqli_query($con,$query) or die( mysqli_error($con));
    $row = mysqli_fetch_array($result);

    $query1="select * from reviews order by review_id DESC";
    $result1=mysqli_query($con,$query1) or die( mysqli_error($con));

    $result2=mysqli_query($con,$query1) or die( mysqli_error($con));
    $all_rows = mysqli_fetch_all($result2, MYSQLI_ASSOC);
    
    
?>

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>What A Review | All Reviews</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" type="text/css" />
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />

        <!-- Bootstrap core CSS -->
        <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/features/">

        <script src='https://code.jquery.com/jquery-3.1.1.min.js'></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/myStyle.css" />

    </head>

    <body>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">What A Review!</a>
                <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">View All Reviews</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">How Does it Work?</a>
                        </li>
                    </ul>
                </div>
                <a class="btn btn-primary" href="index.php#writeReview">Write A Review</a>
            </div>
        </nav>

        <main class="container">

            <div class="bg-light p-5 mt-4 rounded col-md-12" id="allReviews">
                <h2>Reviews<span class="totalNumberOfReviews"> Total: <?php echo $row[0];?> | Most recent on top</span></h2>

                <?php foreach($all_rows as $rowd) {
                if ($rowd['sarcasm_detected'] == 1) {
                    $d = "Detected";
                } else {
                    $d = "Not Detected";
                }
                print   '<div class="row m-1">
                            <div class="card" style="width: 100%;">
                                <div class="card-body">
                                    <h4 class="card-title">Original Review</h4>
                                    <p>' .$rowd['original_review']. '</p>
                                    <h4 class="card-title">Summarized Review</h4>
                                    <p>' .$rowd['summarised_review']. '</p>
                                    <span>Sarcasm:</span>
                                    <span>' . $d . '</span>
                                    <div class="tooltip">i
                                        <span class="tooltiptext">This detector is based on Machine Learning algorithms. Therefore, the prediction would not be 100% accurate.</span>
                                    </div>
                                    <span class="border-right"></span>     
                                    <span class="border-left-space">Our Rating:</span>
                                    <span>' .$rowd['rating_generated']. '/5</span>
                                    <div class="tooltip">i
                                        <span class="tooltiptext">This rating is based on Machine Learning algorithms. Therefore, the prediction would not be 100% accurate.</span>
                                    </div>      
                                </div>
                            </div>
                        </div>';
            }
            ?>
            </div>


        </main>


        <script>
        </script>
    </body>

</html>