<?php
error_reporting(E_ALL);
    
include 'connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:user_login.php');
};

if(isset($_POST['add_car'])){
    // Sanitize and store form data
    $make = filter_var($_POST['make'], FILTER_SANITIZE_STRING);
    $model = filter_var($_POST['model'], FILTER_SANITIZE_STRING);
    $colour = filter_var($_POST['colour'], FILTER_SANITIZE_STRING);
    $body_type = filter_var($_POST['body_type'], FILTER_SANITIZE_STRING);
    $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $mileage = filter_var($_POST['mileage'], FILTER_SANITIZE_NUMBER_INT);
    $engine_size = filter_var($_POST['engine_size'], FILTER_SANITIZE_STRING);
    $fuel_type = filter_var($_POST['fuel_type'], FILTER_SANITIZE_STRING);
    $transmission = filter_var($_POST['transmission'], FILTER_SANITIZE_STRING);
    $num_doors = filter_var($_POST['num_doors'], FILTER_SANITIZE_NUMBER_INT);
    $num_seats = filter_var($_POST['num_seats'], FILTER_SANITIZE_NUMBER_INT);
    $year = filter_var($_POST['year'], FILTER_SANITIZE_NUMBER_INT);
    $first_registered = filter_var($_POST['first_registered'], FILTER_SANITIZE_STRING);
    $vehicle_extras = filter_var($_POST['vehicle_extras'], FILTER_SANITIZE_STRING);
    $vehicle_description = filter_var($_POST['vehicle_description'], FILTER_SANITIZE_STRING);
    $Featured_Cars = filter_var($_POST['Featured_Cars'], FILTER_SANITIZE_STRING);

    // Handle primary image upload
    $primary_image = $_FILES['primary_image']['name'];
    $primary_image_tmp = $_FILES['primary_image']['tmp_name'];
    move_uploaded_file($primary_image_tmp, "../car_images/$primary_image");

    // Handle multiple secondary images
    $secondary_images = $_FILES['secondary_images']['name'];
    $secondary_images_tmp = $_FILES['secondary_images']['tmp_name'];
    $secondary_images_names = [];

for($i = 0; $i < count($secondary_images); $i++) {
    if (!move_uploaded_file($secondary_images_tmp[$i], "../car_images/".$secondary_images[$i])) {
        echo "Failed to upload image: " . $secondary_images[$i];
    } else {
        $secondary_images_names[] = $secondary_images[$i];
    }
}


    $secondary_images_str = implode(",", $secondary_images_names);

    // Insert into database
    $stmt = $con->prepare("INSERT INTO cars (Make, Model, Colour, Body_type, Price, Mileage, Engine_size, Fuel_type, Transmission, Number_of_doors, Number_of_seats, Year, First_Registered, Vehicle_extras, Vehicle_Description , Primary_Image, Secondary_Images, Featured_Cars) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$make, $model, $colour, $body_type, $price, $mileage, $engine_size, $fuel_type, $transmission, $num_doors, $num_seats, $year, $first_registered, $vehicle_extras, $vehicle_description, $primary_image, $secondary_images_str, $Featured_Cars]);

    if($stmt) {
        echo "New car added successfully!";
    } else {
        echo "Failed to add new car.";
    }
}


if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];

    // Fetch the car's images from the database
    $delete_car_images = $con->prepare("SELECT * FROM `cars` WHERE id = ?");
    $delete_car_images->execute([$delete_id]);
    $fetch_delete_images = $delete_car_images->fetch(PDO::FETCH_ASSOC);

    if ($fetch_delete_images) {
        // Delete the primary image
        $primary_image_path = '../car_images/'.trim($fetch_delete_images['Primary_Image']);
        if (file_exists($primary_image_path)) {
            unlink($primary_image_path);
        } else {
            echo "Primary image does not exist.<br>";
        }

        // Delete the secondary images
        $secondary_images = explode(",", $fetch_delete_images['Secondary_Images']);
        foreach($secondary_images as $image) {
            $image = trim($image);  // Remove any leading or trailing whitespace
            $image_path = '../car_images/'.$image;
            if(file_exists($image_path)) {  // Check if file exists
                unlink($image_path);
            } else {
                echo "Secondary image $image does not exist.<br>";
            }
        }

        // Delete the car entry from the database
        $delete_car = $con->prepare("DELETE FROM `cars` WHERE id = ?");
        $delete_car->execute([$delete_id]);
    } else {
        echo "No record found for ID: $delete_id.<br>";
    }
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>CarKingdom City</title>
    <!-- Bootstrap core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="../assets/css/fontawesome.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/owl.css">
    <!-- Site Icons -->
    <link rel="shortcut icon" href="../assets/images/logo.png" class="icon" type="image/x-icon">
    <link rel="apple-touch-icon" href="../assets/images/logo.png">
</head>



    <!-- Header -->
    <div class="sub-header">
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-xs-12">
            <ul class="left-info">
              <li><a href="#"><i class="fa fa-envelope"></i>info@carkingdom-city.co.uk</a></li>
              <li><a href="tel:+447387327070"><i class="fa fa-phone"></i>+44-7387-327070 </a></li>
            </ul>
          </div>
          <div class="col-md-4">
            <ul class="right-icons">
              <li><a href="#"><i class="fa fa-instagram"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <header class="">
      <nav class="navbar navbar-expand-lg">
        <div class="container">
          <a class="navbar-brand-logo" href="index.html"><img src="../assets/images/logo.png" class="logo" alt=""></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item active">
                <a class="nav-link" href="index.html">Home
                  <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../cars.html">Cars</a>
              </li>
              <li class="nav-item dropdown">
                <a class="dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">About</a>
              
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="about.html">About Us</a>
                    <a class="dropdown-item" href="team.html">Team</a>
                    <a class="dropdown-item" href="testimonials.html">Reviews</a>
                    <a class="dropdown-item" href="faq.html">FAQ</a>
                    <a class="dropdown-item" href="terms.html">Terms</a>
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
          </div>
        </div>
      </div>
    </div>
<body>

<section class="add-products py-5">
    <div class="container">
        <h1 class="heading text-center mb-5" style="font-weight: bold; font-size: 2.5rem;">Add Cars</h1>

<form action="" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-6 mb-4">
            <label for="make">Make (required)</label>
            <select class="form-control" required name="make" id="make">
              <option value="Abarth">All</option>
              <option value="Abarth">Abarth</option>
              <option value="Alfa Romeo">Alfa Romeo</option>
              <option value="Audi">Audi</option>
              <option value="BMW">BMW</option>
              <option value="Citroen">Citroen</option>
              <option value="Dacia">Dacia</option>
              <option value="Fiat">Fiat</option>
              <option value="Ford">Ford</option>
              <option value="Honda">Honda</option>
              <option value="Hyundai">Hyundai</option>
              <option value="Jaguar">Jaguar</option>
              <option value="Jeep">Jeep</option>
              <option value="KIA">KIA</option>
              <option value="Land Rover">Land Rover</option>
              <option value="Lexus">Lexus</option>
              <option value="Mazda">Mazda</option>
              <option value="Mercedes">Mercedes</option>
              <option value="Mini">Mini</option>
              <option value="Mitsubishi">Mitsubishi</option>
              <option value="Nissan">Nissan</option>
              <option value="Peugeot">Peugeot</option>
              <option value="Renault">Renault</option>
              <option value="Seat">Seat</option>
              <option value="Skoda">Skoda</option>
              <option value="Smart">Smart</option>
              <option value="Suzuki">Suzuki</option>
              <option value="Tesla">Tesla</option>
              <option value="Toyota">Toyota</option>
              <option value="Vauxhall">Vauxhall</option>
              <option value="Volkswagen">Volkswagen</option>
              <option value="Volvo">Volvo</option>
            </select>

        </div>
        <div class="col-md-6 mb-4">
            <label for="model">Model (required)</label>
            <select class="form-control" required name="model" id="model">
            </select>
        </div>
        <div class="col-md-6 mb-4">
            <label for="colour">Colour (required)</label>
            <select class="form-control" required name="colour" id="colour">
                <option value="Black">Black</option>
                <option value="White">White</option>
                <option value="Red">Red</option>
                <option value="Blue">Blue</option>
                <option value="Green">Green</option>
                <option value="Yellow">Yellow</option>
                <option value="Silver">Silver</option>
                <option value="Grey">Grey</option>
                <option value="Brown">Brown</option>
                <option value="Orange">Orange</option>
                <option value="Purple">Purple</option>
                <option value="Pink">Pink</option>
                <option value="Gold">Gold</option>
            </select>
            </div>
        <div class="col-md-6 mb-4">
            <label for="body_type">Body Type (required)</label>
            <select class="form-control" required name="body_type" id="body_type">
                <option value="Sedan">Sedan</option>
                <option value="SUV">SUV</option>
                <option value="Coupe">Coupe</option>
                <option value="Convertible">Convertible</option>
                <option value="Hatchback">Hatchback</option>
                <option value="Wagon">Wagon</option>
                <option value="Van">Van</option>
                <option value="Truck">Truck</option>
                <option value="Electric">Electric</option>
                <option value="Hybrid">Hybrid</option>
                <option value="Diesel">Diesel</option>
            </select>
        </div>
        <div class="col-md-6 mb-4">
            <label for="price">Price (required)</label>
            <input type="number" class="form-control" required name="price" id="price">
        </div>
        <div class="col-md-6 mb-4">
            <label for="mileage">Mileage (required)</label>
            <input type="number" class="form-control" required name="mileage" id="mileage">
        </div>
        <!-- Engine Size -->
        <div class="col-md-6 mb-4">
            <label for="engine_size">Engine Size (required)</label>
            <select class="form-control" required name="engine_size" id="engine_size">
                <option value="1.0L">1.0L</option>
                <option value="1.1L">1.1L</option>
                <option value="1.2L">1.2L</option>
                <option value="1.3L">1.3L</option>
                <option value="1.4L">1.4L</option>
                <option value="1.5L">1.5L</option>
                <option value="1.6L">1.6L</option>
                <option value="1.7L">1.7L</option>
                <option value="1.8L">1.8L</option>
                <option value="1.9L">1.9L</option>
                <option value="2.0L">2.0L</option>
                <option value="2.1L">2.1L</option>
                <option value="2.2L">2.2L</option>
                <option value="2.3L">2.3L</option>
                <option value="2.4L">2.4L</option>
                <option value="2.5L">2.5L</option>
                <option value="2.6L">2.6L</option>
                <option value="2.7L">2.7L</option>
                <option value="2.8L">2.8L</option>
                <option value="2.9L">2.9L</option>
                <option value="3.0L">3.0L</option>
                <option value="3.1L">3.1L</option>
                <option value="3.2L">3.2L</option>
                <option value="3.3L">3.3L</option>
                <option value="3.4L">3.4L</option>
                <option value="3.5L">3.5L</option>
                <option value="3.6L">3.6L</option>
                <option value="3.7L">3.7L</option>
                <option value="3.8L">3.8L</option>
                <option value="3.9L">3.9L</option>
                <option value="4.0L">4.0L</option>
            </select>
        </div>

        <div class="col-md-6 mb-4">
            <label for="fuel_type">Fuel Type (required)</label>
            <select class="form-control" required name="fuel_type" id="fuel_type">
              <option value="Petrol">Petrol</option>
              <option value="Diseal">Diseal</option>
              <option value="Electric">Electric</option>
              <option value="Electric">Petrol Hybrid</option>
              <option value="Electric">Petrol Plug-in Hybrid</option>
            </select>
        </div>
        <!-- Transmission -->
        <div class="col-md-6 mb-4">
            <label for="transmission">Transmission (required)</label>
            <select class="form-control" required name="transmission" id="transmission">
                <option value="Automatic">Automatic</option>
                <option value="Manual">Manual</option>
            </select>
        </div>
        <!-- Number of Doors -->
        <div class="col-md-6 mb-4">
            <label for="num_doors">Number of Doors (required)</label>
            <select class="form-control" required name="num_doors" id="num_doors">
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>

        <!-- Number of Seats -->
        <div class="col-md-6 mb-4">
            <label for="num_seats">Number of Seats (required)</label>
            <select class="form-control" required name="num_seats" id="num_seats">
                <option value="2">2</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="7">7</option>
                <option value="8">8</option>
            </select>
        </div>
        <!-- Year -->
        <div class="col-md-6 mb-4">
            <label for="year">Year (required)</label>
            <select class="form-control" required name="year" id="year">
                <?php for($i = 2000; $i <= date("Y"); $i++): ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="col-md-6 mb-4">
            <label for="first_registered">First Registered (required)</label>
            <input type="date" class="form-control" required name="first_registered" id="first_registered">
        </div>
        <div class="col-md-6 mb-4">
            <label for="vehicle_extras">Vehicle Extras</label>
            <input type="text" class="form-control" name="vehicle_extras" id="vehicle_extras">
        </div>
        <div class="col-md-6 mb-4">
            <label for="vehicle_description">Vehicle Description</label>
            <textarea class="form-control" name="vehicle_description" id="vehicle_description"></textarea>
        </div>
        <div class="col-md-6 mb-4">
            <label for="primary_image">Primary Image (required)</label>
            <input type="file" class="form-control" required name="primary_image" id="primary_image">
        </div>
        <div class="col-md-6 mb-4">
            <label for="secondary_images">Secondary Images</label>
            <input type="file" class="form-control" multiple name="secondary_images[]" id="secondary_images">
        </div>
        <div class="col-md-6 mb-4">
            <label for="Featured_Cars">Featured_Cars</label>
            <select class="form-control" name="Featured_Cars" id="Featured_Cars">
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>
        <div class="col-12 text-center">
            <input type="submit" value="Add Car" class="btn btn-primary" name="add_car">
        </div>
    </div>
</form>
    </div>
</section>

<section class="show-products py-5">
    <div class="container">
        <h1 class="heading text-center mb-5" style="font-weight: bold; font-size: 2.5rem;">Products Added</h1>
        <div class="row">

            <?php
            $select_products = $con->prepare("SELECT * FROM `cars`");
            $select_products->execute();
            if ($select_products->rowCount() > 0) {
                while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
            ?>

            <div class="col-md-4 mb-4">
                <div class="box p-4 shadow rounded">
                    <img src="../car_images/<?= $fetch_products['Primary_Image']; ?>" alt="" class="img-fluid mb-3">
                    <h4 class="name text-center"><?= $fetch_products['Make'] . ' - ' . $fetch_products['Model']; ?></h4>
                    <p class="price text-center">$<span><?= $fetch_products['Price']; ?></span>/-</p>
                    <div class="d-flex justify-content-between mt-3">
                        <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="btn btn-danger" onclick="return confirm('Delete this product?');">Delete</a>
                    </div>
                </div>
            </div>

            <?php
                }
            } else {
                echo '<p class="empty text-center col-12" style="font-size: 1.3rem;">No products added yet!</p>';
            }
            ?>

        </div>
    </div>
</section>


  <!-- Footer Starts Here -->
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-md-3 footer-item">
            <h4>Opening hours</h4>
            <p>Vivamus tellus mi. Nulla ne cursus elit,vulputate. Sed ne cursus augue hasellus lacinia sapien vitae.</p>
            <ul class="social-icons">
              <li><a href="#"><i class="fa fa-instagram"></i></a></li>
            </ul>
          </div>
          <div class="col-md-3 footer-item">
            <h4>Useful Links</h4>
            <ul class="menu-list">
              <li><a href="#">Vivamus ut tellus mi</a></li>
              <li><a href="#">Nulla nec cursus elit</a></li>
              <li><a href="#">Vulputate sed nec</a></li>
              <li><a href="#">Cursus augue hasellus</a></li>
              <li><a href="#">Lacinia ac sapien</a></li>
            </ul>
          </div>
          <div class="col-md-3 footer-item">
            <h4>Additional Pages</h4>
            <ul class="menu-list">
              <li><a href="#">About Us</a></li>
              <li><a href="#">FAQ</a></li>
              <li><a href="#">Contact Us</a></li>
              <li><a href="#">Terms</a></li>
            </ul>
          </div>
          <div class="col-md-3 footer-item last-item">
            <h4>Contact Us</h4>
            <p><a href="tel:+447387327070">+44-7387-327070</a></p>
            <a href="mailto:info@carkingdom-city.co.uk">info@carkingdom-city.co.uk</a>
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
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Additional Scripts -->
    <script src="../assets/js/custom.js"></script>
    <script src="../assets/js/owl.js"></script>
    <script src="../assets/js/slick.js"></script>
    <script src="../assets/js/accordions.js"></script>

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

        // Set a default "All" option for the model dropdown
        const defaultOption = new Option("All", "All");
        modelSelect.appendChild(defaultOption);
        const carModels = {
          'Audi': ["A1", "A3", "A4", "A5", "A6", "A7", "A8", "Q2", "Q3", "Q5", "Q7", "Q8"],
          'BMW': ["1 Series", "2 Series", "3 Series", "4 Series", "5 Series", "6 Series", "7 Series", "8 Series", "X1", "X2", "X3", "X4", "X5", "X6", "X7"],
          'Ford': ["Fiesta", "Focus", "Mustang", "Explorer", "F-150"],
          'Mercedes-Benz': ["A-Class", "B-Class", "C-Class", "E-Class", "S-Class", "GLA", "GLC", "GLE", "GLS"],
          'Volkswagen': ["Golf", "Passat", "Polo", "Tiguan", "Arteon", "Touareg"],
          'Nissan': ["Micra", "Leaf", "Qashqai", "X-Trail", "Navara"],
          'Toyota': ["Yaris", "Corolla", "Camry", "Prius", "RAV4", "Hilux"],
          'Honda': ["Civic", "Accord", "CR-V", "HR-V", "Jazz"],
          'Hyundai': ["i10", "i20", "i30", "Tucson", "Santa Fe"],
          'Kia': ["Rio", "Ceed", "Sportage", "Sorento", "Niro"],
          'Land Rover': ["Discovery", "Defender", "Range Rover", "Range Rover Sport", "Range Rover Evoque"],
          'Mazda': ["2", "3", "6", "CX-3", "CX-30", "CX-5"],
          'Peugeot': ["208", "308", "508", "2008", "3008", "5008"],
          'Renault': ["Clio", "Megane", "Captur", "Kadjar", "Koleos"],
          'Skoda': ["Fabia", "Octavia", "Superb", "Karoq", "Kodiaq"],
          'Suzuki': ["Swift", "Vitara", "S-Cross", "Ignis", "Jimny"],
          'Vauxhall': ["Corsa", "Astra", "Insignia", "Crossland", "Grandland"],
          'Alfa Romeo': ["Giulia", "Stelvio", "Giulietta"],
          'Citroen': ["C1", "C3", "C4", "C5", "Berlingo", "Picasso"],
          'Dacia': ["Duster", "Logan", "Sandero"],
          'Fiat': ["500", "Panda", "Punto", "Tipo"],
          'Jaguar': ["XE", "XF", "XJ", "F-Pace", "E-Pace"],
          'Jeep': ["Cherokee", "Grand Cherokee", "Wrangler", "Renegade"],
          'Lexus': ["IS", "ES", "GS", "LS", "NX", "RX"],
          'Mitsubishi': ["Outlander", "ASX", "Eclipse Cross", "L200"],
          'Porsche': ["911", "Cayenne", "Macan", "Panamera"],
          'Seat': ["Ibiza", "Leon", "Ateca", "Tarraco"],
          'Subaru': ["Impreza", "Forester", "Outback"],
          'Volvo': ["S60", "S90", "V60", "V90", "XC40", "XC60", "XC90"],
          'Mini': ["Cooper", "Clubman", "Countryman", "Paceman", "Roadster"],
          'Abarth': ["500", "595", "695", "124 Spider"],
          'Smart': ["ForTwo", "ForFour", "EQ ForTwo", "EQ ForFour"],
          'Tesla': ["Model S", "Model 3", "Model X", "Model Y", "Cybertruck", "Roadster"]



        
        };

    makeSelect.addEventListener('change', function() {
        const selectedMake = this.value;
        const models = carModels[selectedMake];

        modelSelect.innerHTML = '';

        // Add "All" option again after clearing
        const allOption = new Option("All", "All");
        modelSelect.appendChild(allOption);

        models.forEach(function(model) {
            const option = new Option(model, model);
            modelSelect.appendChild(option);
        });
    });
});
 </script>

  </body>
</html>