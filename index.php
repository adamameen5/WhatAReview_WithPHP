<!DOCTYPE html>
<html lang="en">

<?php

    $con=mysqli_connect("127.0.0.1","root","root","WhatAReview",8889);
    $query="select count(*) from reviews";
    $result=mysqli_query($con,$query) or die( mysqli_error($con));
    $row = mysqli_fetch_array($result);

    $query1="select * from reviews";
    $result1=mysqli_query($con,$query1) or die( mysqli_error($con));

    $result2=mysqli_query($con,$query1) or die( mysqli_error($con));
    $all_rows = mysqli_fetch_all($result2, MYSQLI_ASSOC);
    
    
?>

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>What A Review</title>
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
        <!-- Navigation-->
        <nav class="navbar navbar-light bg-light static-top">
            <div class="container">
                <a class="navbar-brand" href="#!">What A Review!</a>
                <a class="btn btn-primary" href="#writeReview">Write A Review</a>
            </div>
        </nav>

        <main class="container" id="writeReview">
            <div class="bg-light p-5 mt-5 rounded">
                <h2>Type Your Review Here</h2>
                <p class="lead">Once you type your review, click the submit button to perform text-summarization and sarcasm detection.</p>
                <textarea name="message" id="message" style="width:100%" rows="11"></textarea>
                <button onclick="summarizeReview()" class="btn btn-primary">Submit</button>
            </div>
        </main>

        <main class="container">
            <div class="row m-1">
                <div class="bg-light p-5 mt-4 rounded col-md-7">
                    <h2>Summary of the text you typed</h2>
                    <p class="lead">This is not the actual summary. This is based on NLP algorithms. So there can be mistakes.</p>
                    <textarea disabled id="summarizedReview" style="width:100%;" rows="10" placeholder="Please enter your review."></textarea>
                </div>
                <div class="bg-light p-5 mt-4 rounded col-md-5">
                    <h2>Sarcasm Detector</h2>
                    <p id="sarcasmDetectedTitle">This detector is based on Machine Learning algorithms. Therefore, the prediction would not be 100% accurate.</p>
                    <button disabled class="btn-success" id="sarcasmDetectedButton" style="width:100%;height:auto">Please enter your review.</button>
                    <br><br>
                    <h2>Our Rating For Your Review</h2>
                    <p>This rating is based on Machine Learning algorithms. Therefore, the prediction would not be 100% accurate.</p>
                    <h4 id="ratingDetected" style="border: 1px rgb(179, 179, 179) solid;">No Review Posted Yet!</h4>
                </div>
            </div>

            <div class="row m-1">
                <div class="card-body table-responsive">
                    <table class="table table-hover">
                        <thead class="text-primary">
                            <th>ID</th>
                            <th>Original Review</th>
                            <th>Summarized Review</th>
                            <th>Sarcasm Detected</th>
                            <th>Rating</th>
                        </thead>
                        <tbody>
                            <?php
                        while($rows=mysqli_fetch_array($result1))
                        {
                    ?>
                                <tr>
                                    <td>
                                        <?php echo $rows['review_id']; ?> </td>
                                    <td>
                                        <?php echo $rows['original_review']; ?> </td>
                                    <td>
                                        <?php echo $rows['summarised_review']; ?> </td>
                                    <td>
                                        <?php echo $rows['sarcasm_detected']; ?> </td>
                                    <td>
                                        <?php echo $rows['rating_generated']; ?> </td>
                                </tr>
                                <?php
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php foreach($all_rows as $rowd) {
                if ($rowd['sarcasm_detected'] == 1) {
                    $d = "Detected";
                } else {
                    $d = "Not Detected";
                }
                print   '<div class="row m-1">
                            <div class="card" style="width: 100%; margin:2px;">
                                <div class="card-body">
                                    <!-- <span class="heading">Our Rating</span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="hiColor">Hi</span>
                                    <a class="btn btn-primary">Go somewhere</a> -->
                                    <h3 class="card-title">Original Review</h3>
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
        </main>



        <script>
            async function summarizeReview() {
                let summarizedReview = await sendReviewToSummarize();
                var textSum = document.getElementById("message").value;
                if (summarizedReview.length == 0) {
                    document.getElementById("summarizedReview").innerHTML = "Your review is too small to be summarized.";
                } else {
                    document.getElementById("summarizedReview").innerHTML = summarizedReview;
                }

                console.log(summarizedReview)
                detectSarcasm();
                getRating();
            }


            async function sendReviewToSummarize() {
                var actualReview = document.getElementById("message").value;
                let url = 'http://127.0.0.1:8000/summarize/';
                try {
                    let res = await fetch(url + actualReview);
                    return await res.json();
                } catch (error) {
                    console.log(error);
                }
            }


            //sarcasm detection
            async function sendReview() {
                var actualReview = document.getElementById("message").value;
                let url = 'http://127.0.0.1:8000/detectSarcasm/';
                try {
                    let res = await fetch(url + actualReview);
                    return await res.json();
                } catch (error) {
                    console.log(error);
                }
            }

            async function detectSarcasm() {
                let sarcasmIdentifier = await sendReview();
                if (sarcasmIdentifier == "It's a sarcasm!") {
                    $("#sarcasmDetectedButton").html("Sarcasm Detected");
                    $("#sarcasmDetectedButton").removeClass('btn-success').addClass('btn-warning');
                } else {
                    $("#sarcasmDetectedButton").html("Sarcasm Not Detected");
                    $("#sarcasmDetectedButton").removeClass('btn-warning').addClass('btn-success');
                }
                console.log(sarcasmIdentifier)
            }


            //rating calculation
            async function sendReviewToGetRating() {
                var actualReview = document.getElementById("message").value;
                let url = 'http://127.0.0.1:8000/getRating/';
                try {
                    let res = await fetch(url + actualReview);
                    return await res.json();
                } catch (error) {
                    console.log(error);
                }
            }

            async function getRating() {
                let ratingGenerated = await sendReviewToGetRating();
                console.log(ratingGenerated)
                document.getElementById("ratingDetected").innerHTML = ratingGenerated;
            }

            // $(function() {
            //     $("div").slice(0, 10).show(); // select the first ten
            //     $("#load").click(function(e) { // click event for load more
            //         e.preventDefault();
            //         $("div:hidden").slice(0, 10).show(); // select next 10 hidden divs and show them
            //         if ($("div:hidden").length == 0) { // check if any hidden divs still exist
            //             alert("No more divs"); // alert if there are none left
            //         }
            //     });
            // });
        </script>
    </body>

</html>