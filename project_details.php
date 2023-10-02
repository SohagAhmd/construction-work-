<?php
// Include your database connection configuration
include 'config.php';

// Check if the project ID is provided in the URL
$project_id = null; // Initialize the variable

if (isset($_GET['id'])) {
  $project_id = $_GET['id'];

  // Retrieve project data
  $query = "SELECT id, title, description, image1, image2, image3 FROM projects WHERE id = $project_id";
  $result = mysqli_query($conn, $query);

  if ($result && mysqli_num_rows($result) > 0) {
    $project = mysqli_fetch_assoc($result);
  } else {
    // Handle the case when the project is not found
    echo "Project not found.";
    exit();
  }
} else {
  // Handle the case when the project ID is not provided in the URL
  echo "Project ID not provided.";
  exit();
}

// Inserting a new comment into the database
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment_submit'])) {
  // Retrieve form data
  $commenter_name = mysqli_real_escape_string($conn, $_POST['commenter_name']);
  $commenter_email = mysqli_real_escape_string($conn, $_POST['commenter_email']);
  $comment_text = mysqli_real_escape_string($conn, $_POST['comment_text']);
  $date_time = date('Y-m-d H:i:s'); // Current date and time

  // Insert the data into the 'comments' table with the current date and time
  $query = "INSERT INTO comments (project_id, client_name, client_email, comment, time) 
            VALUES ('$project_id', '$commenter_name', '$commenter_email', '$comment_text', '$date_time')";

  if (mysqli_query($conn, $query)) {
    // Comment inserted successfully
    header('location:project_details.php?id=' . $project_id);
  } else {
    // Error inserting comment
    echo "Error inserting comment: " . mysqli_error($conn);
  }
}

// Inserting a new reply into the database
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reply_submit'])) {
  // Retrieve form data
  $reply_id = mysqli_real_escape_string($conn, $_POST['reply_id']);
  $reply_name = mysqli_real_escape_string($conn, $_POST['reply_name']);
  $reply_text = mysqli_real_escape_string($conn, $_POST['reply_text']);
  $date_time = date('Y-m-d H:i:s'); // Current date and time

  // Insert the reply data into the 'replies' table with the current date and time
  $sql = "INSERT INTO replies (comment_id, client_name, reply, time) 
          VALUES ('$reply_id', '$reply_name', '$reply_text', '$date_time')";

  if (mysqli_query($conn, $sql)) {
    // Reply inserted successfully
    header('location: project_details.php?id=' . $project_id);
  } else {
    // Error inserting reply
    echo "Error inserting reply: " . mysqli_error($conn);
  }
  exit();
}

// Retrieve comments and their replies from the database
$commentsQuery = "SELECT * FROM comments WHERE project_id = $project_id";
$commentsResult = mysqli_query($conn, $commentsQuery);
$comments = [];

while ($row = mysqli_fetch_assoc($commentsResult)) {
  // Retrieve replies for each comment
  $comment_id = $row['id'];
  $repliesQuery = "SELECT * FROM replies WHERE comment_id = $comment_id";
  $repliesResult = mysqli_query($conn, $repliesQuery);
  $replies = [];

  while ($replyRow = mysqli_fetch_assoc($repliesResult)) {
    $replies[] = $replyRow;
  }

  // Add replies to the comment
  $row['replies'] = $replies;
  $comments[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Construction">
  <title><?php echo $project['title']; ?> - Project Details</title>
  <link rel="shortcut icon" type="image/x-icon" href="img/fibcon.png">

  <!-- Include Zoomify CSS and JS -->
  <link rel="stylesheet" href="path-to-zoomify/zoomify.min.css">
  <script src="path-to-zoomify/zoomify.min.js"></script>

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/fontawesome.min.css">
  <link rel="stylesheet" href="css/elegant-line-icons.css">
  <link rel="stylesheet" href="css/flaticon.css">
  <link rel="stylesheet" href="css/animate.min.css">
  <link rel="stylesheet" href="css/slick.css">
  <link rel="stylesheet" href="css/main.css">

  <style>
    /* Add your custom styles here */
    .card:hover {
      background-color: #ff7607;
      color: black;
      transition: background-color 0.3s ease;
    }

    .square-image {
      width: 100%;
      height: 400px;
      object-fit: cover;
    }

    .reviews-container {
      display: flex;
      flex-wrap: wrap;
      /* Added to handle smaller screens */
    }

    .reviews-left {
      width: 100%;
      padding: 10px;
    }

    .reviews-right {
      width: 100%;
      padding: 10px;
      border-top: 1px solid #ddd;
      /* Change border-left to border-top for small screens */
    }

    .review {
      border: 1px solid #ddd;
      padding: 10px;
      margin-bottom: 20px;
      box-shadow: 0px 0px 5px #ff7607;
    }

    .review h4 {
      margin: 0;
    }

    .review p {
      margin: 5px 0;
    }

    .review-form {
      background: #ff7607;
      padding: 10px;
      border: 1px solid #ddd;
      box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
    }

    .reply-button {
      cursor: pointer;
      color: #007BFF;
    }

    /* Media query for small screens */
    @media (max-width: 768px) {
      .reviews-container {
        flex-direction: column;
        /* Change to a single column layout for small screens */
      }

      .reviews-left,
      .reviews-right {
        width: 100%;
        /* Take up the full width on small screens */
      }

      .reviews-right {
        border-top: none;
        /* Remove top border for small screens */
      }

      .reply-form {
        margin-top: 10px;
        /* Add some spacing between reviews and the form */
      }
    }
  </style>
</head>

<body>
  <div class="site-preloader-wrap">
    <div class="spinner"></div>
  </div>

  <?php include 'header.php' ?>

  <section class="page-header padding">
    <div class="container">
      <div class="page-content text-center">
        <h2><?php echo $project['title']; ?></h2>
      </div>
    </div>
  </section>

  <section class="project-details-section padding">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="project-details-content">
            <h3>Project Description</h3>
            <?php if (isset($project)) : ?>
              <p><?php echo $project['description']; ?></p>
            <?php else : ?>
              <p>Project not found.</p>
            <?php endif; ?>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="project-details-images">
            <!-- Display project images using Bootstrap carousel with zoom functionality -->
            <?php if (isset($project)) : ?>
              <div id="project-carousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ul class="carousel-indicators">
                  <li data-target="#project-carousel" data-slide-to="0" class="active"></li>
                  <li data-target="#project-carousel" data-slide-to="1"></li>
                  <li data-target="#project-carousel" data-slide-to="2"></li>
                </ul>

                <!-- Slides -->
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <a href="img/projects/<?php echo $project['image1']; ?>" data-zoom-image="img/projects/<?php echo $project['image1']; ?>">
                      <img src="img/projects/<?php echo $project['image1']; ?>" alt="Project Image 1" class="img-fluid zoomify square-image">
                    </a>
                  </div>
                  <div class="carousel-item">
                    <a href="img/projects/<?php echo $project['image2']; ?>" data-zoom-image="img/projects/<?php echo $project['image2']; ?>">
                      <img src="img/projects/<?php echo $project['image2']; ?>" alt="Project Image 2" class="img-fluid zoomify square-image">
                    </a>
                  </div>
                  <div class="carousel-item">
                    <a href="img/projects/<?php echo $project['image3']; ?>" data-zoom-image="img/projects/<?php echo $project['image3']; ?>">
                      <img src="img/projects/<?php echo $project['image3']; ?>" alt="Project Image 3" class="img-fluid zoomify square-image">
                    </a>
                  </div>
                </div>

                <!-- Controls -->
                <a class="carousel-control-prev" href="#project-carousel" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#project-carousel" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
            <?php else : ?>
              <!-- Handle the case when the project is not found -->
              <p>Project not found.</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div class="container">
    <div class="reviews-container">
      <!-- Left side: Display reviews -->
      <div class="reviews-left">
        <?php foreach ($comments as $comment) : ?>
          <div class="review">
            <h4><?php echo htmlspecialchars($comment['client_name']); ?></h4>
            <p><?php echo htmlspecialchars($comment['comment']); ?></p>
            <p>Date and Time: <?php echo htmlspecialchars($comment['time']); ?></p>
            <button class="reply-button" onclick="toggleReplyForm(<?php echo $comment['id']; ?>)">Reply</button>
            <div class="reply-form" id="reply-form-<?php echo $comment['id']; ?>" style="display: none;">
              <h4>Reply to <?php echo htmlspecialchars($comment['client_name']); ?></h4>

              <form id="replyForm<?php echo $comment['id']; ?>" action="#" method="post">
                <input type="hidden" name="reply_id" value="<?php echo $comment['id']; ?>">
                <div class="form-group">
                  <label for="replyName<?php echo $comment['id']; ?>">Your Name</label>
                  <input type="text" class="form-control" id="replyName<?php echo $comment['id']; ?>" name="reply_name" placeholder="Your Name" required>
                </div>
                <div class="form-group">
                  <label for="replyText<?php echo $comment['id']; ?>">Reply</label>
                  <textarea class="form-control" id="replyText<?php echo $comment['id']; ?>" name="reply_text" rows="2" placeholder="Your Reply" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="reply_submit">Done</button>
                <button type="button" class="btn btn-secondary" onclick="cancelReply(<?php echo $comment['id']; ?>)">Cancel</button>
              </form>
            </div>
            <?php
            // Display replies to the comment
            foreach ($comment['replies'] as $reply) {
              echo '<div class="reply">';
              echo '<h5>' . htmlspecialchars($reply['client_name']) . '</h5>';
              echo '<p>' . htmlspecialchars($reply['reply']) . '</p>';
              echo '<p>Date and Time: ' . htmlspecialchars($reply['time']) . '</p>';
              echo '</div>';
            }
            ?>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Right side: Review form -->
      <div class="reviews-right">
        <div class="review-form">
          <h4>Leave a Review</h4>
          <form id="commentForm" action="#" method="post">
            <div class="form-group">
              <label for="commenterName">Your Name</label>
              <input type="text" class="form-control" id="commenterName" name="commenter_name" placeholder="Your Name" required>
            </div>
            <div class="form-group">
              <label for="commenterEmail">Your Email</label>
              <input type="email" class="form-control" id="commenterEmail" name="commenter_email" placeholder="Your Email" required>
            </div>
            <div class="form-group">
              <label for="commentText">Review</label>
              <textarea class="form-control" id="commentText" name="comment_text" rows="4" placeholder="Your Review" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="comment_submit">Submit Review</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php include 'footer.php' ?>

  <a data-scroll href="#header" id="scroll-to-top"><i class="arrow_carrot-up"></i></a>

  <!-- JavaScript Libraries -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    function toggleReplyForm(reviewId) {
      var replyForm = document.getElementById('reply-form-' + reviewId);
      replyForm.style.display = replyForm.style.display === 'block' ? 'none' : 'block';
    }

    function cancelReply(reviewId) {
      var replyForm = document.getElementById('reply-form-' + reviewId);
      replyForm.style.display = 'none';
    }
  </script>

  <!-- Included custom JavaScript file -->
  <script src="js/main.js"></script>
</body>

</html>