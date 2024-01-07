<?php
include __DIR__ . '/php/connect.php';

// SQL query to fetch data
$sql = "SELECT * FROM cars"; // Fetching all records from the 'cars' table
$stmt = $con->prepare($sql);
$stmt->execute();

// Fetching data
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Splitting the 'Vehicle_extras' string by commas into an array
$vehicle_extras = $row['Vehicle_extras'];
$extras_array = explode(',', $vehicle_extras);
?>

<?php
session_start();

include __DIR__ . '/php/connect.php';


$con = new PDO($db_name, $user_name, $user_password);

$make = $model = $Colour = $Body_type = $Year = $price = $mileage = $Engine_size = $Fuel_type = $Transmission = $Number_of_doors = $Number_of_seats = "All";

$makeQuery = "SELECT DISTINCT make FROM cars ORDER BY make ASC";
$makeStmt = $con->prepare($makeQuery);
$makeStmt->execute();


$modelQuery = "SELECT DISTINCT model FROM cars ORDER BY model ASC";
$modelSTM = $con->prepare($modelQuery);
$modelSTM->execute();


$engineSizeQuery = "SELECT DISTINCT Engine_size FROM cars ORDER BY Engine_size ASC";
$Engine_SizeSTM = $con->prepare($engineSizeQuery);
$Engine_SizeSTM->execute();

$TransmissionQuery = "SELECT DISTINCT Transmission FROM cars ORDER BY Transmission ASC";
$TransmissionSTM = $con->prepare($TransmissionQuery);
$TransmissionSTM->execute();

$Number_of_doorsQuery = "SELECT DISTINCT Number_of_doors FROM cars ORDER BY Number_of_doors ASC";
$Number_of_doorsSTM = $con->prepare($Number_of_doorsQuery);
$Number_of_doorsSTM->execute();

$Number_of_seatsQuery = "SELECT DISTINCT Number_of_seats FROM cars ORDER BY Number_of_seats ASC";
$Number_of_seatsSTM = $con->prepare($Number_of_seatsQuery);
$Number_of_seatsSTM->execute();

$Fuel_typeQuery = "SELECT DISTINCT Fuel_type FROM cars ORDER BY Fuel_type ASC";
$Fuel_typeSTM = $con->prepare($Fuel_typeQuery);
$Fuel_typeSTM->execute();

$Body_typeQuery = "SELECT DISTINCT Body_type FROM cars ORDER BY Body_type ASC";
$Body_typeSTM = $con->prepare($Body_typeQuery);
$Body_typeSTM->execute();

$YearQuery = "SELECT DISTINCT Year FROM cars ORDER BY Year ASC";
$YearSTM = $con->prepare($YearQuery);
$YearSTM->execute();

$mileageQuery = "SELECT DISTINCT mileage FROM cars ORDER BY mileage ASC";
$mileageSTM = $con->prepare($mileageQuery);
$mileageSTM->execute();

$priceQuery = "SELECT DISTINCT price FROM cars ORDER BY price ASC";
$priceSTM = $con->prepare($priceQuery);
$priceSTM->execute();

$Number_of_seatsQuery = "SELECT DISTINCT Number_of_seats FROM cars ORDER BY Number_of_seats ASC";
$Number_of_seatsSTM = $con->prepare($Number_of_seatsQuery);
$Number_of_seatsSTM->execute();


$ColourQuery = "SELECT DISTINCT Colour FROM cars ORDER BY Colour ASC";
$ColourSTM = $con->prepare($ColourQuery);
$ColourSTM->execute();

// Fetch all unique engine sizes from the database into an associative array
$uniqueEngineSizes = [];
while ($row = $Engine_SizeSTM->fetch(PDO::FETCH_ASSOC)) {
    $uniqueEngineSizes[$row['Engine_size']] = true;
}
// Fetch all unique engine sizes from the database into an associative array
$uniqueTransmission = [];
while ($row = $TransmissionSTM->fetch(PDO::FETCH_ASSOC)) {
    $uniqueTransmission[$row['Transmission']] = true;
}
// Fetch all unique engine sizes from the database into an associative array
$uniqueNumber_of_doors = [];
while ($row = $Number_of_doorsSTM->fetch(PDO::FETCH_ASSOC)) {
    $uniqueNumber_of_doors[$row['Number_of_doors']] = true;
}

// Fetch all unique engine sizes from the database into an associative array
$uniqueNumber_of_seats = [];
while ($row = $Number_of_seatsSTM->fetch(PDO::FETCH_ASSOC)) {
    $uniqueNumber_of_seats[$row['Number_of_seats']] = true;
}

// Fetch all unique engine sizes from the database into an associative array
$uniqueFuel_type = [];
while ($row = $Fuel_typeSTM->fetch(PDO::FETCH_ASSOC)) {
    $uniqueFuel_type[$row['Fuel_type']] = true;
}

// Fetch all unique engine sizes from the database into an associative array
$uniqueBody_type = [];
while ($row = $Body_typeSTM->fetch(PDO::FETCH_ASSOC)) {
    $uniqueBody_type[$row['Body_type']] = true;
}

// Fetch all unique engine sizes from the database into an associative array
$uniqueYear = [];
while ($row = $YearSTM->fetch(PDO::FETCH_ASSOC)) {
    $uniqueYear[$row['Year']] = true;
}
$uniqueModels = [];
while ($row = $modelSTM->fetch(PDO::FETCH_ASSOC)) {
    $uniqueModels[$row['model']] = true;
}

$uniqueColour = [];
while ($row = $ColourSTM->fetch(PDO::FETCH_ASSOC)) {
    $uniqueColour[$row['Colour']] = true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $make = isset($_POST['make']) ? $_POST['make'] : "All";
    $model = isset($_POST['model']) ? $_POST['model'] : "All";
    $price = isset($_POST['price']) ? $_POST['price'] : "All";
    $mileage = isset($_POST['mileage']) ? $_POST['mileage'] : "All";
    $Engine_size = isset($_POST['Engine_size']) ? $_POST['Engine_size'] : "All";
    $Fuel_type = isset($_POST['Fuel_type']) ? $_POST['Fuel_type'] : "All";
    $Transmission = isset($_POST['Transmission']) ? $_POST['Transmission'] : "All";
    $Number_of_doors = isset($_POST['Number_of_doors']) ? $_POST['Number_of_doors'] : "All";
    $Number_of_seats = isset($_POST['Number_of_seats']) ? $_POST['Number_of_seats'] : "All";
    $Body_type = isset($_POST['Body_type']) ? $_POST['Body_type'] : "All";
    $Year = isset($_POST['Year']) ? $_POST['Year'] : "All";
    $Colour = isset($_POST['Colour']) ? $_POST['Colour'] : "All";

    $sql = "SELECT * FROM cars WHERE 1=1";

    if ($make !== "All") {
        $sql .= " AND make = :make";
    }
    if ($model !== "All") {
        $sql .= " AND model = :model";
    }
    if ($price !== "All") {
        if ($price === 'Over 35000') {
            $sql .= " AND price > 35000";
        } else {
            $sql .= " AND price <= :price";
        }
    }
    if ($mileage !== "All") {
        if ($mileage === 'Over 80000') {
            $sql .= " AND mileage > 80000";
        } else {
            $sql .= " AND mileage <= :mileage";
        }
    }

    if ($Engine_size !== "All") {
        $sql .= " AND Engine_size = :Engine_size";
    }
    if ($Fuel_type !== "All") {
        $sql .= " AND Fuel_type = :Fuel_type";
    }
    if ($Transmission !== "All") {
        $sql .= " AND Transmission = :Transmission";
    }
    if ($Number_of_doors !== "All") {
        $sql .= " AND Number_of_doors = :Number_of_doors";
    }
    if ($Number_of_seats !== "All") {
        $sql .= " AND Number_of_seats = :Number_of_seats";
    }
    if ($Body_type !== "All") {
        $sql .= " AND Body_type = :Body_type";
    }
    if ($Year !== "All") {
        $sql .= " AND Year = :Year";
    }
    if ($Colour !== "All") {
        $sql .= " AND Colour = :Colour";
    }
    
    $stmt = $con->prepare($sql);

    if ($make !== "All") {
        $stmt->bindParam(':make', $make, PDO::PARAM_STR);
    }
    if ($model !== "All") {
        $stmt->bindParam(':model', $model, PDO::PARAM_STR);
    }
    if ($price !== "All" && $price !== 'Over 35000') {
        $stmt->bindParam(':price', $price, PDO::PARAM_INT);
    }
    if ($mileage !== "All" && $mileage !== 'Over 80000') {
        $stmt->bindParam(':mileage', $mileage, PDO::PARAM_INT);
    }
    if ($Engine_size !== "All") {
        $stmt->bindParam(':Engine_size', $Engine_size, PDO::PARAM_STR);
    }
    if ($Fuel_type !== "All") {
        $stmt->bindParam(':Fuel_type', $Fuel_type, PDO::PARAM_STR);
    }
    if ($Transmission !== "All") {
        $stmt->bindParam(':Transmission', $Transmission, PDO::PARAM_STR);
    }
    if ($Number_of_doors !== "All") {
        $stmt->bindParam(':Number_of_doors', $Number_of_doors, PDO::PARAM_STR);
    }
    if ($Number_of_seats !== "All") {
        $stmt->bindParam(':Number_of_seats', $Number_of_seats, PDO::PARAM_STR);
    }
    if ($Body_type !== "All") {
        $stmt->bindParam(':Body_type', $Body_type, PDO::PARAM_STR);
    }
    if ($Year !== "All") {
        $stmt->bindParam(':Year', $Year, PDO::PARAM_STR);
    }

    if ($Colour !== "All") {
        $stmt->bindParam(':Colour', $Year, PDO::PARAM_STR);
    }
    
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $stmt = $con->prepare("SELECT * FROM cars");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Define the number of results per page
$limit = 15;

// Find out the number of total cars
$stmt = $con->prepare("SELECT COUNT(*) FROM cars");
$stmt->execute();
$total_results = $stmt->fetchColumn();

// Calculate the number of total pages
$total_pages = ceil($total_results / $limit);

// Get the current page or set a default
$current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset for the query
$offset = ($current_page - 1) * $limit;

// Fetch the records for the current page
$stmt = $con->prepare("SELECT * FROM cars LIMIT :limit OFFSET :offset");
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
              <li class="nav-item active">
                <a class="nav-link" href="cars.php">Cars</a>
              </li>
              <li class="nav-item dropdown">
                <a class="dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">About</a>
              
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="about.html">About Us</a>
                    <a class="dropdown-item" href="reviews.php">Reviews</a>
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
            <h1>Cars</h1>
            <span>Lorem ipsum dolor sit amet.</span>
          </div>
        </div>
      </div>
    </div>
          <!-- Filters Button -->
    <div class="main-button text-center">
    <button id="filters-button" class="cars-button xox"> Filters</button>
    </div>
    <div class="services">
      <div class="container">
          <!-- Filters Container -->
    <div id="filters-container">
        <form action="" method="post" id="contact">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="make">Make:</label>
                        <select class="form-control" required name="make" id="make">
                            <option value="All" <?php if ($make === "All") echo 'selected'; ?>>All</option>
                            <?php
                            while ($row = $makeStmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='" . $row['make'] . "'";
                                if ($make === $row['make']) {
                                    echo " selected";
                                }
                                echo ">" . $row['make'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="model">Model:</label>
                        <select class="form-control" required name="model" id="model">
                            <option value="All" <?php if ($model === "All") echo 'selected'; ?>>All</option>
                            <?php
                            // Loop through unique models to create options
                            foreach (array_keys($uniqueModels) as $mod) {
                                echo "<option value='$mod'";
                                if ($model === $mod) {
                                    echo " selected";
                                }
                                echo ">$mod</option>";
                            }
                            ?>
                        </select>

                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="Body_type">Body type:</label>
                        <select class="form-control" required name="Body_type" id="Body_type">
                            <option value="All" <?php if ($Body_type === "All") echo 'selected'; ?>>All</option>
                            <?php
                            // Loop through unique engine sizes to create options
                            foreach (array_keys($uniqueBody_type) as $Body) {
                                echo "<option value='$Body'";
                                if ($Body_type === $Body) {
                                    echo " selected";
                                }
                                echo ">$Body</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="Year">Year:</label>
                        <select class="form-control" required name="Year" id="Year">
                            <option value="All" <?php if ($Year === "All") echo 'selected'; ?>>All</option>
                            <?php
                            // Loop through unique engine sizes to create options
                            foreach (array_keys($uniqueYear) as $age) {
                                echo "<option value='$age'";
                                if ($Year == $age) {
                                    echo " selected";
                                }
                                echo ">$age</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <select class="form-control" required name="price" id="price">
                            <option value="All" <?php if ($price === "All") echo 'selected'; ?>>All</option>
                                <?php
                                $priceRanges = [2000, 4000, 6000, 8000, 10000, 12000, 14000, 16000, 18000, 20000, 22000, 24000, 26000, 28000, 30000, 32000, 34000, 35000, 'Over 35000'];
                                foreach ($priceRanges as $range) {
                                    echo "<option value='$range'";
                                    if ($price == $range) {
                                        echo " selected";
                                    }
                                    if ($range == 'Over 35000') {
                                        echo ">Over £35,000</option>";
                                    } else {
                                        echo ">Up to £" . $range . "</option>";
                                    }
                                }
                                ?>                    
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="Body_type">Colour:</label>
                        <select class="form-control" required name="Body_type" id="Body_type">
                            <option value="All" <?php if ($Colour === "All") echo 'selected'; ?>>All</option>
                            <?php
                            // Loop through unique engine sizes to create options
                            foreach (array_keys($uniqueColour) as $Color) {
                                echo "<option value='$Color'";
                                if ($Colour === $Color) {
                                    echo " selected";
                                }
                                echo ">$Color</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="mileage">Mileage:</label>
                        <select class="form-control" required name="mileage" id="mileage">
                            <option value="All" <?php if ($mileage === "All") echo 'selected'; ?>>All</option>
                                <?php
                                $mileageRanges = [10000, 20000, 30000, 40000, 50000, 60000, 70000, 80000, 'Over 80000'];
                                foreach ($mileageRanges as $range) {
                                    echo "<option value='$range'";
                                    if ($mileage == $range) {
                                        echo " selected";
                                    }
                                    if ($range == 'Over 80000') {
                                        echo ">Over 80k miles</option>";
                                    } else {
                                        echo ">Up to " . $range . " miles</option>";
                                    }
                                }
                                ?>                     
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="Engine_size">Engine Size:</label>
                        <select class="form-control" required name="Engine_size" id="Engine_size">
                            <option value="All" <?php if ($Engine_size === "All") echo 'selected'; ?>>All</option>
                            <?php
                            // Loop through unique engine sizes to create options
                            foreach (array_keys($uniqueEngineSizes) as $size) {
                                echo "<option value='$size'";
                                if ($Engine_size === $size) {
                                    echo " selected";
                                }
                                echo ">$size</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="Fuel_type">Fuel Type:</label>
                        <select class="form-control" required name="Fuel_type" id="Fuel_type">
                            <option value="All" <?php if ($Fuel_type === "All") echo 'selected'; ?>>All</option>
                            <?php
                            // Loop through unique number of doors to create options
                            foreach (array_keys($uniqueFuel_type) as $Fuel) {
                                echo "<option value='$Fuel'";
                                if ($Fuel_type == $Fuel) {
                                    echo " selected";
                                }
                                echo ">$Fuel</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="Transmission">Transmission:</label>
                        <select class="form-control" required name="Transmission" id="Transmission">
                        <option value="All" <?php if ($Transmission === "All") echo 'selected'; ?>>All</option>
                            <?php
                            // Loop through unique engine sizes to create options
                            foreach (array_keys($uniqueTransmission) as $TransmissionType) {
                                echo "<option value='$TransmissionType'";
                                if ($Transmission === $TransmissionType) {
                                    echo " selected";
                                }
                                echo ">$TransmissionType</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="Number_of_doors">Number of Doors:</label>
                        <select class="form-control" required name="Number_of_doors" id="Number_of_doors">
                            <option value="All" <?php if ($Number_of_doors === "All") echo 'selected'; ?>>All</option>
                            <?php
                            // Loop through unique number of doors to create options
                            foreach (array_keys($uniqueNumber_of_doors) as $Numdoor) {
                                echo "<option value='$Numdoor'";
                                if ($Number_of_doors == $Numdoor) {
                                    echo " selected";
                                }
                                echo ">$Numdoor</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="Number_of_seats">Number of Seats:</label>
                        <select class="form-control" required name="Number_of_seats" id="Number_of_seats">
                            <option value="All" <?php if ($Number_of_seats === "All") echo 'selected'; ?>>All</option>
                            <?php
                            // Loop through unique number of doors to create options
                            foreach (array_keys($uniqueNumber_of_seats) as $Numseat) {
                                echo "<option value='$Numseat'";
                                if ($Number_of_seats == $Numseat) {
                                    echo " selected";
                                }
                                echo ">$Numseat</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 offset-sm-4">
                <div class="main-button text-center">
                    <button type="submit" id="form-submit" class="cars-button search-button">Search</button>
                </div>
            </div>
            <br>
            <br>
        </form>
    </div>

        <div class="row">
            <?php foreach($products as $product): ?>
            <div class="col-md-4">
                <div class="service-item">
                    <img src="car_images/<?= $product['Primary_Image']; ?>" alt="">
                    <div class="down-content">
                        <h4><?= $product['Make']; ?> - <?= $product['Model']; ?></h4>
                        <div style="margin-bottom:10px;">
                            <span>
                                <sup>£</sup><?= $product['Price']; ?>
                            </span>
                        </div>
                        <p>
                            <i class="fa fa-dashboard"></i> <?= $product['Mileage']; ?>km &nbsp;&nbsp;&nbsp;
                            <i class="fa fa-cube"></i> <?= $product['Engine_size']; ?> cc &nbsp;&nbsp;&nbsp;
                            <i class="fa fa-cog"></i> <?= $product['Transmission']; ?> &nbsp;&nbsp;&nbsp;
                        </p>
                        <a href="car-details.php?id=<?= $product['id']; ?>" class="filled-button">View More</a>

                    </div>
                </div>
                <br>
            </div>
            <?php endforeach; ?>
        </div>

        <br>
        <br>

        <nav>
          <ul class="pagination pagination-lg justify-content-center">
            <!-- Previous Button -->
            <li class="page-item <?php if($current_page <= 1){ echo 'disabled'; } ?>">
              <a class="page-link" href="<?php if($current_page <= 1){ echo '#'; } else { echo "?page=".($current_page - 1); } ?>" aria-label="Previous">
                <span aria-hidden="true">«</span>
              </a>
            </li>
            <!-- Page Numbers -->
            <?php for($i = 1; $i <= $total_pages; $i++): ?>
              <li class="page-item <?php if($current_page == $i) { echo 'active'; } ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
              </li>
            <?php endfor; ?>
            <!-- Next Button -->
            <li class="page-item <?php if($current_page >= $total_pages){ echo 'disabled'; } ?>">
              <a class="page-link" href="<?php if($current_page >= $total_pages){ echo '#'; } else { echo "?page=".($current_page + 1); } ?>" aria-label="Next">
                <span aria-hidden="true">»</span>
              </a>
            </li>
          </ul>
        </nav>




        <br>
        <br>
        <br>
        <br>
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
    document.addEventListener("DOMContentLoaded", function() {
        const makeSelect = document.getElementById('make');
        const modelSelect = document.getElementById('model');
        const selectedModelFromPHP = "<?php echo $model; ?>";

        function populateModels(make) {
            console.log("Fetching models for make:", make);  // Debug line
            fetch(`get_models.php?make=${make}`)
            .then(response => response.json())
            .then(models => {
                console.log("Received models:", models);  // Debug line
                modelSelect.innerHTML = '';

                const allOption = new Option("All", "All");
                modelSelect.appendChild(allOption);

                models.forEach(function(model) {
                    const option = new Option(model, model);
                    modelSelect.appendChild(option);
                });

                if (selectedModelFromPHP && (models.includes(selectedModelFromPHP) || selectedModelFromPHP === "All")) {
                    modelSelect.value = selectedModelFromPHP;
                }
            });
        }

        // Initialize the model dropdown to be empty or just "All"
        populateModels("All");

        makeSelect.addEventListener('change', function() {
            console.log("Make changed:", makeSelect.value);  // Debug line
            populateModels(makeSelect.value);
        });
    });


</script>








</body>
</html>

