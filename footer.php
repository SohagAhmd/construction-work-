<?php
// Place session_start() at the very beginning of your script


include 'config.php';

$subscriptionMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST["email"];
  $checkQuery = "SELECT * FROM subscribe_email WHERE email = '$email'";
  $checkResult = mysqli_query($conn, $checkQuery);

  if (mysqli_num_rows($checkResult) > 0) {
    $subscriptionMessage = "You are already subscribed.";
  } else {

    $insertQuery = "INSERT INTO subscribe_email (email) VALUES ('$email')";
    if (mysqli_query($conn, $insertQuery)) {
      $_SESSION['subscribed'] = true; // Set a session variable to track subscription
      $subscriptionMessage = "Thank you for subscribing!";
    } else {
      $subscriptionMessage = "An error occurred. Please try again later.";
    }
  }
  mysqli_close($conn);
} else {
  // Check if the user is already subscribed via session
  if (isset($_SESSION['subscribed']) && $_SESSION['subscribed'] === true) {
    $subscriptionMessage = "You are already subscribed.";
  }
}
?>
<!-- <section class="blog-section padding">
  <div class="container">
    <div class="section-heading text-center mb-40 wow fadeInUp" data-wow-delay="100ms">
      <span>From Blog</span>
      <h2>Speciallized news</h2>
    </div>
    <div class="row blog-wrap">
      <div class="col-lg-4 col-sm-6 sm-padding">
        <div class="blog-item box-shadow">
          <div class="blog-thumb">
            <img src="img/post-1.jpg" alt="post">
            <span class="category"><a href="#">interior</a></span>
          </div>
          <div class="blog-content">
            <h3><a href="#">Minimalist trending in modern architecture 2019</a></h3>
            <p>Building first evolved out dynamics between needs means available building materials attendant skills.</p>
            <a href="#" class="read-more">Read More</a>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-sm-6 sm-padding">
        <div class="blog-item box-shadow">
          <div class="blog-thumb">
            <img src="img/post-2.jpg" alt="post">
            <span class="category"><a href="#">Architecture</a></span>
          </div>
          <div class="blog-content">
            <h3><a href="#">Terrace in the town yamazaki kentaro design workshop.</a></h3>
            <p>Building first evolved out dynamics between needs means available building materials attendant skills.</p>
            <a href="#" class="read-more">Read More</a>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-sm-6 sm-padding">
        <div class="blog-item box-shadow">
          <div class="blog-thumb">
            <img src="img/post-3.jpg" alt="post">
            <span class="category"><a href="#">Design</a></span>
          </div>
          <div class="blog-content">
            <h3><a href="#">W270 house são paulo arquitetos fabio jorge architeqture.</a></h3>
            <p>Building first evolved out dynamics between needs means available building materials attendant skills.</p>
            <a href="#" class="read-more">Read More</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section> -->
<section class="widget-section padding">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-sm-6 sm-padding">
        <div class="widget-content">
          <a href="#"><img src="img/logo.png" alt="brand"></a>
          <p>Discover our exceptional services designed to transform your projects. From timeless brownstone restoration to efficient waterproofing solutions, we bring expertise and innovation to every endeavor. Explore our offerings and elevate
            your vision with us.</p>
        </div>
      </div>
      <div class="col-lg-2 col-sm-6 sm-padding">
        <div class="widget-content">
          <h4>Company</h4>
          <ul class="widget-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="about-company.php">About Us</a></li>
            <li><a href="services-1.php">Our Services</a></li>
            <li><a href="contact.php">Contact Us</a></li>
          </ul>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6 sm-padding">
        <div class="widget-content">
          <h4>Headquaters</h4>
          <p>Addres will update</p>
          <span>info@denebconst.com</span>
          <span>+19296313448</span>
        </div>
      </div>
      <div class="col-lg-4 col-sm-6 sm-padding">
        <div class="widget-content">
          <!-- <h4>Newslatter Subscription</h4>
                        <p>Subscribe and get 10% off from our <br>architecture company.</p> -->
          <div class="subscribe-box clearfix">
            <div class="subscribe-form-wrap">
              <form action="#" class="subscribe-form" method="post">
                <input type="email" name="email" id="subs-email" class="form-input" placeholder="Enter Your Email Address...">
                <button type="submit" class="submit-btn">Subscribe</button>
                <div id="subscribe-result">
                  <p class="subscription-success"><?php echo $subscriptionMessage; ?></p>
                  <p class="subscription-error"></p>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<footer class="footer-section align-center">
  <span>Developed by <a href="#">Sohag Ahmed</a></span>
</footer>