<?php
session_start();

include __DIR__ . '/php/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['anonymous']) ? "Anonymous" : $_POST['name'];
    $review = $_POST['review'];
    $stars = $_POST['stars'];  // New line to get stars

    $stmt = $con->prepare("INSERT INTO customer_reviews (name, review, stars) VALUES (:name, :review, :stars)");
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':review', $review, PDO::PARAM_STR);
    $stmt->bindParam(':stars', $stars, PDO::PARAM_INT);  // New line to bind stars

    if ($stmt->execute()) {
        $_SESSION['review_added'] = true;
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $message = "Error: Could not add the review";
    }
}

if (isset($_SESSION['review_added'])) {
    $showModal = true;
    unset($_SESSION['review_added']);
} else {
    $showModal = false;
}

// Fetching data from the database
$stmt = $con->prepare("SELECT name, review, stars FROM customer_reviews");  // Modified line to fetch stars
$stmt->execute();
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
    


<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>CarKingdom City</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/owl.css">
      
          <!-- Site Icons -->
    <link rel="shortcut icon" href="assets/images/logo.png" class="icon" type="image/x-icon">
    <link rel="apple-touch-icon" href="assets/images/logo.png">
  </head>

  <body>

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>  
    <!-- ***** Preloader End ***** -->

    <!-- Header -->
    <div class="sub-header">
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-xs-12">
            <ul class="left-info">
            <a href="mailto:info@carkingdom-city.co.uk" onclick="if(!window.navigator.onLine){ alert('Please set up an email client to use this feature.'); return false; }" class= "envople">info@carkingdom-city.co.uk</a>
              <li><a href="tel:+447387327070"><i class="fa fa-phone"></i>+44-7387-327070 </a></li>
            </ul>
          </div>
          <div class="col-md-4">
            <ul class="right-icons">
              <li><a href="https://instagram.com/carkingdom_city?igshid=MzRlODBiNWFlZA=="><i class="fa fa-instagram"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <header class="">
      <nav class="navbar navbar-expand-lg">
        <div class="container">
          <a class="navbar-brand-logo" href="index.php"><img src="assets/images/logo.png" class="logo" alt=""></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link" href="index.php">Home
                  <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="cars.php">Cars</a>
              </li>
              <li class="nav-item dropdown">
                <a class="dropdown-toggle nav-link active" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">About</a>
              
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="about.html">About Us</a>
                    <a class="dropdown-item active" href="reviews.php">Reviews</a>
                    <a class="dropdown-item" href="faq.html">FAQ</a>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="contact.html">Contact Us</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>

    <!-- Page Content -->
    <div class="page-heading header-text">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1>Reviews</h1>    
            <span>Reviews from our greatest customers</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Custom Reviews Section -->
    <div class="custom-reviews">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2>Customer <em>Reviews</em></h2>
            </div>
          </div>
          <div class="col-md-12">
            <!-- Display message -->
            <?php if (isset($message)): ?>
              <p><?php echo $message; ?></p>
            <?php endif; ?>

    <!-- Display Reviews -->
    <div id="reviews-container">
      <!-- Reviews will be inserted here by JavaScript -->
    </div>
    <br>
    <br>
    <button id="view-more" onclick="loadMoreReviews()" class="filled-button">View More</button>
<br>
              <br>
              <br>
<br>
              <br>
              <br>
              
<!-- Add a Review -->
<h2>Add a Review</h2>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
  <label for="name">Name:</label>
  <input type="text" id="name" name="name" required>
  
  <div style="display: flex; align-items: center;">
    <label for="review" style="margin-right: 10px;">Review:</label>
    <div class="stars">
      <span class="star" data-value="1">☆</span>
      <span class="star" data-value="2">☆</span>
      <span class="star" data-value="3">☆</span>
      <span class="star" data-value="4">☆</span>
      <span class="star" data-value="5">☆</span>
      <input type="hidden" id="stars" name="stars" required>
    </div>
  </div>
  
  <textarea id="review" name="review" required></textarea>
  <div class="checkbox-container">
    <input type="checkbox" id="anonymous" name="anonymous" value="true">
    <label for="anonymous">Submit Anonymously</label>
  </div>
    <br>
    <br>
  <input type="submit" value="Submit" class="filled-button">
</form>




          </div>
        </div>
      </div>
    </div>
    <!-- End of Custom Reviews Section -->
<!-- Modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="successModalLabel">Success</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Review has been added successfully.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


    <!-- Footer Starts Here -->
    <footer>
      <div class="container">
        <div class="row">
            <div class="col-md-4 footer-item">
              <h4>Opening hours</h4>
              <p>Monday to Friday: 10am to 6pm<br>
                 Saturday and Sunday: 11am to 4pm</p>
            </div>
          <div class="col-md-4 footer-item">
            <h4>Additional Pages</h4>
            <ul class="menu-list">
              <li><a href="cars.php">Cars</a></li>
              <li><a href="reviews.php">Reviews</a></li>
              <li><a href="contact.html">Contact Us</a></li>
              <li><a href="faq.html">FAQ</a></li>
            </ul>
          </div>
          <div class="col-md-4 footer-item last-item">
            <h4>Contact Us</h4>
            <p><a href="tel:+447387327070">+44-7387-327070</a></p>
            <a href="mailto:info@carkingdom-city.co.uk" onclick="if(!window.navigator.onLine){ alert('Please set up an email client to use this feature.'); return false; }">info@carkingdom-city.co.uk</a>
            <br>
            <br>
            <br>
            <ul class="social-icons">
              <li><a href="https://instagram.com/carkingdom_city?igshid=MzRlODBiNWFlZA=="><i class="fa fa-instagram"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </footer>
    
    <div class="sub-footer">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <p>
                Copyright © 2023 Car Kingdom City
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Additional Scripts -->
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/owl.js"></script>
    <script src="assets/js/slick.js"></script>
    <script src="assets/js/accordions.js"></script>

    <script language = "text/Javascript"> 
      cleared[0] = cleared[1] = cleared[2] = 0; //set a cleared flag for each field
      function clearField(t){                   //declaring the array outside of the
      if(! cleared[t.id]){                      // function makes it static and global
          cleared[t.id] = 1;  // you could use true and false, but that's more typing
          t.value='';         // with more chance of typos
          t.style.color='#fff';
          }
      }
    </script>
    <script>
    // Declare these variables outside of DOMContentLoaded to make them globally accessible
    let allReviews = [];
    let currentReviewIndex = 0;

    // Function to load more reviews
    function loadMoreReviews() {
      const container = document.getElementById('reviews-container');
      for (let i = 0; i < 5; i++) {
        if (currentReviewIndex >= allReviews.length) {
          document.getElementById('view-more').style.display = 'none';
          break;
        }
        const review = allReviews[currentReviewIndex];
        const reviewBox = document.createElement('div');
        reviewBox.className = 'review-box';
        reviewBox.innerHTML = `
          <h4>${review.name}</h4>
          <p>${review.review}</p>
          <div class="stars">${'★'.repeat(review.stars)}</div>
        `;
        container.appendChild(reviewBox);
        currentReviewIndex++;
      }
    }
    document.addEventListener('DOMContentLoaded', function() {
      // Initialize allReviews and currentReviewIndex here
      allReviews = <?php echo json_encode($reviews); ?>;
      currentReviewIndex = 0;

      // Load the first 5 reviews initially
      loadMoreReviews();

      // Attach the function to the button
      document.getElementById('view-more').addEventListener('click', loadMoreReviews);

      // Handle star ratings
      const stars = document.querySelectorAll('.star');
      const ratingInput = document.getElementById('stars');

      stars.forEach(function(star) {
        star.addEventListener('click', function() {
          let rating = this.getAttribute('data-value');
          ratingInput.value = rating;
          stars.forEach(function(innerStar) {
            innerStar.textContent = parseInt(innerStar.getAttribute('data-value')) <= rating ? '★' : '☆';
          });
        });
      });
      // Handle form submission
      const form = document.querySelector('form');
      form.addEventListener('submit', function(event) {
        const name = document.getElementById('name').value;
        const review = document.getElementById('review').value;
        const stars = document.getElementById('stars').value;

        if (!name || !review || !stars) {
          alert('Please fill in all fields and select a star rating before submitting.');
          event.preventDefault();
        }
      });
    });

    </script>
<?php
if ($showModal) {
    echo '<script type="text/javascript">
            $(document).ready(function() {
                $("#successModal").modal("show");
            });
          </script>';
}
?>

  </body>
</html>