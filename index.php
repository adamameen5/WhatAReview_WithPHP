<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>What A Review | Home</title>
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
            <a class="navbar-brand" href="index.php">What A Review!</a>
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="reviews.php">View All Reviews</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="howItWorks.php">How Does it Work?</a>
                    </li>
                </ul>
            </div>
            <a class="btn btn-primary" href="index.php#writeReview">Write A Review</a>
        </div>
    </nav>

    <main class="container" id="writeReview">
        <div class="bg-light p-5 mt-5 rounded">
            <h2>Type Your Review Here</h2>
            <p class="lead">Once you type your review, click the submit button to perform text-summarization and sarcasm detection.</p>
            <textarea name="message" id="message" style="width:100%" rows="11"></textarea>
            <button onclick="summarizeReview()" class="btn btn-primary">Mine My Review</button>
        </div>
    </main>

    <main class="container">
        <div class="row m-1">
            <div class="bg-light p-5 mt-4 rounded col-md-7">
                <h2>Summary of the text you typed</h2>
                <p>This is not the actual summary. This is based on NLP algorithms which produces an extractive summary. So there can be mistakes.</p>
                <textarea disabled id="summarizedReview" style="width:100%;" rows="10" placeholder="Please type your review above to get the summary."></textarea>
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

        <div class="card-body" id="insertToDatabaseSection" style="display:none;">
            <form action="insertReview.php" method="POST">
                <div class="row" style="display:none;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">Original Review</label>
                            <input type="text" name="originalReview" id="originalReviewFormControl" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">Summarised Review</label>
                            <input type="text" name="summarisedReview" id="summarisedReviewFormControl" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row" style="display:none;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">Sarcasm Detected</label>
                            <input type="text" name="sarcasmDetected" id="sarcasmDetectedFormControl" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bmd-label-floating">Our Rating</label>
                            <input type="text" name="ourRating" id="ourRatingFormControl" class="form-control">
                        </div>
                    </div>
                </div>
                <h2>Would you like to insert your review to our database?</h2>
                <p id="warningHeading" style="display:none;">Please note the below fields are missing from your review:</p>
                <ul>
                    <li id="warningForSummary" style="display:none;">The summary of your review</li>
                    <li id="warningForSarcasm" style="display:none;">The sarcasm detected status of your review</li>
                    <li id="warningForRating" style="display:none;">The rating of your review</li>
                </ul>
                <button type="submit" class="btn btn-primary" name="submit">Yes Insert</button>
                <div class="clearfix"></div>
            </form>
        </div>
    </main>



    <script>
        async function summarizeReview() {
            var originalReview = document.getElementById("message").value;

            if (originalReview.length == 0) {
                alert("Please add a review to be mined.");
                return;
            } else if (originalReview.length < 50) {
                alert("Review is too small to be mined. Please add more content.");
                return;
            }

            //If the review is accepted to be mined, then show the section to add the review to the db.
            $("#insertToDatabaseSection").show();

            let summarizedReview = await sendReviewToSummarize();

            if (summarizedReview.length == 0) {
                document.getElementById("summarizedReview").innerHTML = "Sorry! We could not summarize your review.";
            } else {
                document.getElementById("summarizedReview").innerHTML = summarizedReview;
                $('#summarisedReviewFormControl').val(summarizedReview);
            }

            $('#originalReviewFormControl').val(originalReview);

            if (summarizedReview.length == 0) {
                $("#warningHeading").show();
                $("#warningForSummary").show();
            }
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
                $('#sarcasmDetectedFormControl').val("1");
            } else {
                $("#sarcasmDetectedButton").html("Sarcasm Not Detected");
                $("#sarcasmDetectedButton").removeClass('btn-warning').addClass('btn-success');
                $('#sarcasmDetectedFormControl').val("0");
            }
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

            document.getElementById("ratingDetected").innerHTML = ratingGenerated;
            var ratingToInsert = ratingGenerated.charAt(1);
            $('#ourRatingFormControl').val(ratingToInsert);

            if (ratingToInsert.length == 0) {
                $("#warningHeading").show();
                $("#warningForRating").show();
            }
        }
    </script>
</body>

</html>