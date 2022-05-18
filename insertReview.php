<?php

    $con=mysqli_connect("127.0.0.1","root","root","WhatAReview",8889);

    $originalReview = $_POST['originalReview'];
    $summarisedReview = $_POST['summarisedReview'];
    $sarcasmDetected = $_POST['sarcasmDetected'];
    $ourRating = $_POST['ourRating'];

    $insert="INSERT INTO `reviews`(`review_id`, `original_review`, `summarised_review`, `sarcasm_detected`, `rating_generated`) VALUES (null,'$originalReview','$summarisedReview','$sarcasmDetected','$ourRating')";
    echo $originalReview.$summarisedReview.$sarcasmDetected.$ourRating;
    try {
        mysqli_query($con,$insert);
        header("Location: reviews.php?");
    } catch (Exception $e){
        echo "ERROR: Could not able to execute $insert. " . mysqli_error($con);
    }
    
?>