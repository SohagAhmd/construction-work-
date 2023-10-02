<?php
// Include your database connection configuration
include 'config.php';

// SQL query to retrieve project data, including the 'id' column
$query = "SELECT id, title, description, image1, image2, image3 FROM projects";
$result = mysqli_query($conn, $query);

$projects = array(); // Initialize an array to store project data

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $projects[] = $row;
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>denebConst</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/fibcon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <link rel="stylesheet" href="css/elegant-line-icons.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="css/main.css">
    <style>
        .card:hover {
            background-color: #ff7607;
            color: black;
            transition: background-color 0.3s ease;
        }

        /* Media query for tablets and smaller screens */
        @media (max-width: 768px) {
            .card {
                margin-bottom: 20px;
            }

            .carousel-inner {
                height: 200px;
                /* Adjust the carousel height for smaller screens */
            }
        }

        /* Media query for mobile phones */
        @media (max-width: 576px) {
            .card {
                margin-bottom: 20px;
            }

            .carousel-inner {
                height: 150px;
                /* Adjust the carousel height for even smaller screens */
            }
        }
    </style>
</head>

<body>
    <div class="site-preloader-wrap">
        <div class="spinner"></div>
    </div>

    <?php include 'header.php'; ?>

    <section class="page-header padding">
        <div class="container">
            <div class="page-content text-center">
                <h2>Specialized projects</h2>
            </div>
        </div>
    </section>

    <section class="projects-section padding">
        <div class="container">
            <div class="row">
                <?php foreach ($projects as $project) { ?>
                    <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                        <div class="card" style="border: 1px solid #ff7607;">
                            <div id="imageCarousel-<?php echo $project['id']; ?>" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="img/projects/<?php echo $project['image1']; ?>" class="d-block" style="width: 100%; height: 300px;" alt="Slide 1">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="img/projects/<?php echo $project['image2']; ?>" class="d-block" style="width: 100%; height: 300px;" alt="Slide 2">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="img/projects/<?php echo $project['image3']; ?>" class="d-block" style="width: 100%; height: 300px;" alt="Slide 3">
                                    </div>
                                </div>
                                <a class="carousel-control-prev" href="#imageCarousel-<?php echo $project['id']; ?>" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#imageCarousel-<?php echo $project['id']; ?>" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $project['title']; ?></h5>
                                <?php
                                $descriptionWords = explode(" ", $project['description']);
                                $shortDescription = implode(" ", array_slice($descriptionWords, 0, 20));
                                $remainingDescription = implode(" ", array_slice($descriptionWords, 20));
                                ?>
                                <p class="card-text">
                                    <?php echo $shortDescription; ?>
                                    <span style="display: none;"><?php echo $remainingDescription; ?></span>
                                    <a href="project_details.php?id=<?php echo $project['id']; ?>" style="color: gray;"><span style="color: gray">...</span>Read More</a>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
    <a data-scroll href="#header" id="scroll-to-top"><i class="arrow_carrot-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="js/main.js"></script>
</body>

</html>