<?php

    $con=mysqli_connect("127.0.0.1","root","root","WhatAReview",8889);

    $originalReview = mysqli_real_escape_string($con,$_POST['originalReview']);
    $summarisedReview = mysqli_real_escape_string($con,$_POST['summarisedReview']);
    $sarcasmDetected = mysqli_real_escape_string($con,$_POST['sarcasmDetected']);
    $ourRating = mysqli_real_escape_string($con,$_POST['ourRating']);

    $insert="INSERT INTO `reviews`(`review_id`, `original_review`, `summarised_review`, `sarcasm_detected`, `rating_generated`) VALUES (null,'$originalReview','$summarisedReview','$sarcasmDetected','$ourRating')";
    
    try {
        mysqli_query($con,$insert) or die(mysqli_error($con));
        header("Location: reviews.php?");
    } catch (Exception $e){
        echo "ERROR: Unable to execute $insert. " . mysqli_error($con);
    }
    
?>