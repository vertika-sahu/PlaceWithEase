<!doctype html>
<html lang="en">

  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- style.css  -->
    <link rel="stylesheet" href="assets/style.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
      integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- fontawesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"
      integrity="sha512-PgQMlq+nqFLV4ylk1gwUOgm6CtIIXkKwaIHp/PAIWHzig/lKZSEGKEysh0TCVbHJXCLN7WetD8TFecIky75ZfQ=="
      crossorigin="anonymous" />

    <title>PlaceWithEase</title>
  </head>

  <body>
    <!-- ==============header menu section starts here============== -->
    <section class="header_menu" id="header_menu">
      <div class="container-fluid px-0 shadow">
        <nav class="navbar navbar-expand-lg navbar-light bg-light py-3  ">
          <a class="navbar-brand pl-5 pl-small-0" href="home_j.php">
            <img src="assets/images/logo.png" class="img img-fluid" width="120px" alt="logo">
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto">
              <li class="nav-item">
                <a class="nav-link" href="home_j.php">Home</a>
              </li>
              <li>
                <a class="nav-link" href="aboutus_j.php">About Us</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="contactus_j.php">Contact Us</a>
              </li>
            </ul>
      
            <div class="dropdown mr-3">
                <div class="collapse navbar-collapse" id="navbar-list-4">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="https://s3.eu-central-1.amazonaws.com/bootstrapbaymisc/blog/24_days_bootstrap/fox.jpg" width="40" height="40" class="rounded-circle">
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">              
                                <a class="dropdown-item" href="myprofile_j.php">My Profile</a>
                                <a class="dropdown-item" href="logout.php">Log Out</a>
                            </div>
                        </li>   
                    </ul>
                </div>
            </div> 
          </div>
        </nav>
      </div>
    </section>
    <!-- ==============header menu section ends here============== -->

    <?php
      session_start();

      if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
        header("location: login_j.php");
        exit;
      }

      $servername = "localhost";
      $username = "root";
      $password = "";
      $database = "pwe";     
                    
      $conn=mysqli_connect($servername, $username, $password, $database);
    
      if(!$conn) {
        die(mysqli_connect_error());
      } 
      $email = $_SESSION['email']; 

      $id = $_GET['qid'];
      $sql = "SELECT * FROM qa WHERE q_id=$id"; 
      $result = mysqli_query($conn, $sql);
      $num = mysqli_num_rows($result);
      $link = "delete_j.php?qid=$id";

      if(! $result) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Warning!</strong> Failed due to Your details '. mysqli_connect_error() . '!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">??</span>
                </button>
              </div>';
      }
    
      $row=mysqli_fetch_assoc($result);

        $ques = $row['question'];
        //$qid = $row['q_id'];
        $date = $row['date']; 
        $ans = $row['answer']; 
        $a_email = $row['answerer']; 
          
        $sql = "SELECT * FROM `junior` WHERE email='$email'";
        $result2 = mysqli_query($conn, $sql);
        $num2 = mysqli_num_rows($result2);

        if(! $result2) {
          echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <strong>Warning!</strong> Failed due to Your details '. mysqli_connect_error() . '!
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">??</span>
                  </button>
                </div>';
        }

        if ($num2 == 1) {
            while($row=mysqli_fetch_assoc($result2))
            $j_name = $row['name'];
        }

        $sql = "SELECT * FROM `senior` WHERE email='$a_email'";
        $result2 = mysqli_query($conn, $sql);
        $num2 = mysqli_num_rows($result2);
        if ($num2 == 1) {
            while($row=mysqli_fetch_assoc($result2))
            $s_name = $row['name'];
        }

      function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }   
    ?>
  
      <!--============ Content container starts here ============-->

    <div class="container my-4">
        <div class="jumbotron">

            <div class='be-comment'>
                <div class='be-img-comment'>	
                  <a href='#'>
                    <img src='https://bootdey.com/img/Content/avatar/avatar1.png' alt='' class='be-ava-comment'>
                  </a>
                </div>
                <div class='be-comment-content'>
                  <span class='be-comment-name'>
                    <a href='#'><?php echo $j_name;?></a>
                  </span>
                  <span class='be-comment-time'>
                    <i class='fa fa-clock-o'></i><?php echo $date;?>
                  </span>
                  <h3><?php echo $ques;?></h3>
                </div>
            </div>
            <hr class="mt-4">      
        </div>
    </div>

     <!--============ Answer container starts here ============-->
     
     <?php
     if(!is_null($ans)) {
        echo "
     <div class='container be-comment-text'>
     <h3 style='font-size:13px; color:grey;' class='mb-3'><strong>Answered by $s_name</strong><br></h3>
        <p style='font-size:18px; color:black; line-height: 1.3;'> $ans</p>
        
    </div>
    ";
     }
    ?>
    <!--============ Answer container ends here ============-->

    
    <!-- ==============footer starts here============== -->
    <section class="footer_section pt-5 pb-2" id="footer_section">
    <footer>
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3 col-6 pl-5 pl-small-15">
            <div class="footer_title">
              <a href="home_j.php"><img src="assets/images/logo.png" width="150px" class="img img-fluid" alt="logo"></a>
            </div>
            <div>
              THINK BEYOND THE DEGREE!
            </div>
          </div>
          
          <div class="col-md-3 col-6">
            <div class="footer_title pt-3 mb-3">
              <h3>Features</h3>
            </div>
            <div class="footer_links">
              <ul>
                <li><a href="resource_j.php">Resources</a></li>
                <li><a href="interview_j.php">Experience</a></li>
                <li><a href="strategy_j.php">Preparation strategy</a></li>
                <li><a href="qa_j.php">Q/A </a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="footer_title pt-3 mb-3">
              <h3>Quick Links</h3>
            </div>
            <div class="footer_links">
              <ul>
                <li><a href="aboutus_j.php">About</a></li>
                
                <li><a href="contactus_j.php">Contact Us</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="footer_title pt-3 mb-3">
              <h3>Support</h3>
            </div>
            <div class="footer_links">
              <ul>
                <li><a href="javascript:;">Frequently Asked Questions</a></li>
                <li><a href="javascript:;">Terms & Conditions</a></li>
                <li><a href="javascript:;">Privacy Policy</a></li>
                <li><a href="javascript:;">Report Issue</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="border-top">
        <h6 class="text-center mt-3">Copyright ??2022 All rights reserved 
        </h6>
      </div>
    </footer>
  </section>
  <div class="backtop">
    <a id="button" href="#top" class="btn btn-lg btn-outline-danger" role="button">
      <i class="fas fa-chevron-up text-dark"></i>
    </a>
  </div>
  <!-- ==============footer ends here============== -->
 <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
    integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
    integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
    crossorigin="anonymous"></script>

</body>
  </html>