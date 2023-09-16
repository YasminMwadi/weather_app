<?php  include 'get_weather.php'; ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">
		
		<title>Weather App </title>

		<!-- Loading third party fonts -->
		<link href="http://fonts.googleapis.com/css?family=Roboto:300,400,700|" rel="stylesheet" type="text/css">
		<link href="fonts/font-awesome.min.css" rel="stylesheet" type="text/css">

		<!-- Adding the favicon -->
		<link rel="icon" type="image/png" href="images/logo.png">

		<!-- Loading main css file -->
		<link rel="stylesheet" href="style.css">

	</head>

	<body>
		<div class="site-content">
			<div class="site-header">
				<div class="container">
					<a href="index.html" class="branding">
						<img src="images/logo.webp" alt="" class="logo">
					</a>
				</div>
			</div> <!-- .site-header -->

			<div class="hero" data-bg-image="images/4.jpg">
				<div class="container">
					<div class="post">
						<h2 class="entry-title">CHECK WEATHER </h2>
					</div>
					<form action="#" method ="POST" class="find-location">
						<input type="text" name="location" class='city-input' placeholder="Find your location...">
						<input type="submit" class="search-btn" value="Find">
					</form>
				</div>
			</div>
			<div class="forecast-table">
				<div class="container">
					<div class="forecast-container current-weather">
						
					</div>
				</div>
			</div>

			<footer class="site-footer">
				<div class="container" style="text-align: center;">
					<div class="social-links">
						<a href="https://www.facebook.com/jasminehilary.ndoko"><i class="fa fa-facebook"></i></a>
						<a href="https://twitter.com/yasmine_ndoko"><i class="fa fa-twitter"></i></a>
						<a href="https://www.linkedin.com/in/yasminmwadi/"><i class="fa fa-linkedin"></i></a>
					</div>
					<p class="colophon">Copyright 2023 RSAWEB. Designed by Yasmin Mwadi. All rights reserved</p>
				</div>
			</footer> <!-- .site-footer -->
		</div>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/plugins.js"></script>
		<script src="js/app.js"></script>
		
	</body>
	<script>
        $(document).ready(function() {
            // Handle form submission using AJAX
            $('form.find-location').on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                // Get the user-entered location
                var location = $('.city-input').val();

                // Make an AJAX request to get_weather.php
                $.ajax({
                    url: 'get_weather.php',
                    method: 'POST',
                    data: { location: location },
                    success: function(data) {
                        // Update the weather content on success
                        $('.current-weather').html(data);
                    },
                    error: function() {
                        // Handle AJAX error
                        alert('An error occurred while fetching weather data.');
                    }
                });
            });
        });
    </script>
</html>
   