<?php
include 'config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    // SQL query to insert data into the database
    $sql = "INSERT INTO client_email (name, email, message) VALUES ('$name', '$email', '$message')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to the home page
        header('Location: index.php'); // Replace 'home.php' with your actual home page URL
        exit; // Make sure to exit after redirecting
    } else {
        echo '<script>alert("Error: ' . $conn->error . '");</script>';
    }
}
?>


<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Construction">
    <title>denebConst</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/fibcon.png">
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/elegant-line-icons.css">
    <link rel="stylesheet" href="css/elegant-font-icons.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="css/slider.css">
    <link rel="stylesheet" href="css/odometer.min.css">
    <link rel="stylesheet" href="css/venobox/venobox.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/responsive.css">
    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
</head>

<body>
    <div class="site-preloader-wrap">
        <div class="spinner"></div>
    </div>
    <?php include 'header.php'; ?>

    <div class="mapouter">
        <div class="gmap_canvas">
            <iframe width="100%" height="350" id="gmap_canvas" src="https://maps.google.com/maps?q=Bajitpur%20Kishoregonj%20Dhaka%20Bangladesh&amp;t=&amp;z=11&amp;ie=UTF8&amp;iwloc=&amp;output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
            <a href="https://www.emojilib.com/"></a>
        </div>
        <style>
            .mapouter {
                position: relative;
                text-align: right;
                height: 350px;
                width: 100%;
            }

            .gmap_canvas {
                overflow: hidden;
                background: none !important;
                height: 350px;
                width: 100%;
            }
        </style>
    </div>

    <section class="contact-section bg-grey padding">
        <div class="dots"></div>
        <div class="container">
            <div class="contact-wrap d-flex align-items-center row">
                <div class="col-md-6 padding-15">
                    <div class="contact-info">
                        <h2>Get in touch with us & <br>send us message today!</h2>
                        <p>At DenebConst, we offer a comprehensive range of high-quality construction and building services to bring your dreams to life. Our expertise includes "Side Walk," "Brownstone," "Shed Rocking," "Water Roofing," "Painting," "Stucco," "Tiles Work," and "Roofing." With a commitment to excellence, we deliver exceptional results that stand the test of time.</p>

                        <h3></h3>
                        <h4><span>Email:</span> info@denebConst.com <br> <span>Phone:</span>+19296313448 <br></h4>
                    </div>
                </div>
                <div class="col-md-6 padding-15">
                    <div class="contact-form">
                        <form action="" method="post" id="ajax_form" class="form-horizontal">
                            <div class="form-group colum-row row">
                                <div class="col-sm-6">
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Name" required>
                                </div>
                                <div class="col-sm-6">
                                    <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <textarea id="message" name="message" cols="30" rows="5" class="form-control message" placeholder="Message" required></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <button id="submit" class="default-btn" type="submit">Send Message</button>
                                </div>
                            </div>
                            <div id="form-messages" class="alert" role="alert"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include 'footer.php'; ?>
    <a data-scroll href="#header" id="scroll-to-top"><i class="arrow_carrot-up"></i></a>
    <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/vendor/tether.min.js"></script>
    <script src="js/vendor/headroom.min.js"></script>
    <script src="js/vendor/owl.carousel.min.js"></script>
    <script src="js/vendor/smooth-scroll.min.js"></script>
    <script src="js/vendor/venobox.min.js"></script>
    <script src="js/vendor/jquery.ajaxchimp.min.js"></script>
    <script src="js/vendor/slick.min.js"></script>
    <script src="js/vendor/waypoints.min.js"></script>
    <script src="js/vendor/odometer.min.js"></script>
    <script src="js/vendor/wow.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>