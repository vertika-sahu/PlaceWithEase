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
              <a class="nav-link" href="home_j.php">Home </a>
            </li>
           <li>
              <a class="nav-link" href="about_j.php">About Us</a>
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
          <a class="dropdown-item" href="history_j.php">History</a>
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

    $type = "interview";
    $email = $_SESSION['email'];

    if(isset($_POST['report'])) {
      $cid=$_POST['hidden'];
      //echo "done";

      // check if user has alredy marked spam
      $ssql = "SELECT * FROM spam WHERE cid = '$cid' AND u_email='$email'";
      $sresult = mysqli_query($conn, $ssql);
      $snum = mysqli_num_rows($sresult);
      if($snum != 1) {

        // insert report info in spam table
        $sql="INSERT INTO `spam` (`cid`, `u_email`) VALUES ('$cid', '$email') ";
        $result = mysqli_query($conn, $sql); 
        if(! $result) {
          echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <strong>Warning!</strong> Failed! '. mysqli_connect_error() . '!
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">??</span>
                  </button>
                </div>';
        }
        //unset($_POST['report']);

        // increase spam value for than content in com=ntent table
        $sql="UPDATE `content` SET `spam` = spam+1 WHERE `c_id` = '$cid' ";
        $result = mysqli_query($conn, $sql); 
        if(! $result) {
          echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <strong>Warning!</strong> Failed! '. mysqli_connect_error() . '!
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">??</span>
                  </button>
                </div>';
        }
      }
    }

    if(isset($_POST['remove'])) {
      $cid=$_POST['hidden'];
      //echo "done";

      // check if user has already removed spam (num == 0), if yes then do nothing else delete 
      // that entry from spam table and decrease spam count
      $ssql = "SELECT * FROM spam WHERE cid = '$cid' AND u_email='$email'";
      $sresult = mysqli_query($conn, $ssql);
      $snum = mysqli_num_rows($sresult);
      if($snum == 1) {

        // delete report info from spam table 
        $sql="DELETE FROM `spam` WHERE `cid` = $cid AND `u_email`='$email' ";
       // $sql="DELETE FROM 'spam' WHERE cid = $cid AND u_email='$email' ";
        $result = mysqli_query($conn, $sql); 
        if(! $result) {
          echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <strong>Warning!</strong> Failed! '. mysqli_connect_error() . '!
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">??</span>
                  </button>
                </div>';
        }
        //unset($_POST['report']);

        // decrease spam value for than content in com=ntent table
        $sql="UPDATE `content` SET `spam` = spam-1 WHERE `c_id` = '$cid' ";
        $result = mysqli_query($conn, $sql); 
        if(! $result) {
          echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <strong>Warning!</strong> Failed! '. mysqli_connect_error() . '!
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">??</span>
                  </button>
                </div>';
        }
      }
    }

  ?>
       
    <!-- ==============feed starts here============== -->
  <div class="container bootstrap snippets bootdey">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <h4>
                      <b>Hope you get your desired results!!!</b>
                    </h4>
                </div>
            </div>
        </div>
    </div>
  </div>
    
  <section class="search-sec">
    <div class="container">
      <form action="search.php" method="GET" novalidate="novalidate">
        <div class="row">
          <div class="col-lg-12">
            <div class="row">

              <div class="col-lg-3 col-md-3 col-sm-12 p-1">
                  <input type="text" required='' class="form-control search-slt" name="company" placeholder="Enter company name.">
              </div>
              <input type="hidden" name="type" id="type" value="interview" />
              <div class="col-lg-3 col-md-3 col-sm-12 p-1">
                  <button type="submit" class="btn btn-danger wrn-btn">Search</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </section>
    
    <!-- Content -->
    <!--===================================================-->
    <div class="container bootdey">
    <div class="col-md-12 bootstrap snippets">
      <div class="panel">
        <div class="panel-body">
          <!--================= Content ========================-->
            <div class="media-block">
    
              <?php 
             
                $s_name = $data = $s_email = "";

                $sql = "SELECT * FROM content WHERE ctype='$type' ORDER BY c_id DESC;";
                $result = mysqli_query($conn, $sql);
                $num = mysqli_num_rows($result);
                //echo "$num";
                  
                while($row=mysqli_fetch_assoc($result)) {
                    $s_email = $row['posted_by']; 
                    $data = $row['data'];  
                    $id = $row['c_id'];   
                    $com = $row['company'];           

                    $sql2 = "SELECT * FROM `senior` WHERE email='$s_email'";
                    $result2 = mysqli_query($conn, $sql2);
                    $num2 = mysqli_num_rows($result2);

                    if ($num2 == 1) {
                      $row2=mysqli_fetch_assoc($result2);
                      $s_name = $row2['name'];
                    
                    }
                  
                  echo " 
                    <div class='media-body'>
                      <div class='mar-btm'>
                        <img src='https://bootdey.com/img/Content/avatar/avatar3.png' alt='' class='be-ava-comment'>
                        <a href='#' class='btn-link text-semibold media-heading box-inline'>$s_name</a>        
                      </div>

                      <div class='mt-2'>
                        <p>$data</p>
                      </div>";

                    $csql = "SELECT * FROM course_tag WHERE c_id = '$id' ";
                    $cresult = mysqli_query($conn, $csql);
                    $cnum = mysqli_num_rows($cresult);

                    while($crow=mysqli_fetch_assoc($cresult)) { 
                      $tag = $crow['tag']; 
                      echo "<span class='badge badge-pill badge-info mb-3 mr-2'>$tag</span>";
                    }

                    echo "
                        <span class='badge badge-pill badge-danger'>$com</span>
                       
                        </div>";

                    $spam_count = $row['spam'];
                    $ssql = "SELECT * FROM spam WHERE cid = '$id' AND u_email='$email'";
                    $sresult = mysqli_query($conn, $ssql);
                    $snum = mysqli_num_rows($sresult);
                    
                    if($snum == 1) {
                      echo "
                          <form action='interview_j.php' method='POST' novalidate='novalidate'>
                            <input type='hidden' name='hidden' value=$id>
                            <div align='right'>
                              <button type='submit' name='remove' class='btn btn-danger'>Remove spam</button>
                            </div>
                          </form>
                      
                        </div> <hr>";
                    }
                    else {
                      echo "
                          <form action='interview_j.php' method='POST' novalidate='novalidate'>
                            <input type='hidden' name='hidden' value=$id>
                            <div align='right'>
                              <button type='submit' name='report' class='btn btn-outline-danger'>Report spam</button>
                            </div>
                          </form>

                        </div> <hr>";
                    }            
                }
              ?>                  
            </div>
          </div>
        </div>
      </div>
    </div>
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

  <script>

    //Form validation with Jquery and JavaScript
    $(document).ready(function () {

        $('#form').submit(function (e) {

            //Get Value
            var name = $('#name').val().trim();
            var email = $('#email').val().trim();
            var msg = $('#msg').val().trim();

            //reset the errors
            $(".error").remove();

            var isValidForm = true; 

            //Validation Conditions here
            if (name.length < 1) {
                $('#name').after('<span class="error"><i>This field is required</i></span>');
                var isValidForm = false;
            }
            
            if (email.length < 1) {
                $('#email').after('<span class="error"><i>This field is required</i></span>');
                var isValidForm = false;
            } 

            if (msg.length < 1) {
                $('#msg').after('<span class="error"><i>This field is required</i></span>');
                var isValidForm = false;
            }

            return isValidForm;  //if isValidForm is true then form submits else submission is stopped
                     
        });

    });

</script>
</body>
  </html>