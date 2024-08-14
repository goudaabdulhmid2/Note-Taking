<?php 
require 'ORM/userClass.php';
$error_fields= array();
$add = new User();

// Validation
if(isset($_POST['submit'])):
 if(!(isset($_POST['name']) && !empty((trim($_POST['name']))))):  
    $error_fields[] = 'name';
 endif;
 if(!(isset($_POST['email']) && filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL) && !$add->searchEmail(trim($_POST['email'])))):
  $error_fields[] = 'email';
 endif;
 if(!(isset($_POST['password']) && strlen($_POST['password'] )>8 )):
  $error_fields[] = 'password';
 endif;
 if(!(isset($_POST['repeat_pass']) && $_POST['password']===$_POST['repeat_pass'])):
  $error_fields[] = 'repeat_pass';
 endif;

 if(!$error_fields):
  $name = filter_var($_POST['name'],FILTER_SANITIZE_SPECIAL_CHARS);
  $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);



  
  $data = [
    'name'=> $name,
    'email'=> $email,
    'password'=> $password
  ];

  if($id = $add->addUser($data)){
    session_start();
    $_SESSION['id'] = $id;
    header('location:notes.php');
    exit;
  }

endif;



  


endif;



?>


<?php include('inc/header.php');?>

<div class='container'>
<section class="vh-100" style="background-color: #eee;">
  <div class="container h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-lg-12 col-xl-11">
        <div class="card text-black" style="border-radius: 25px;">
          <div class="card-body p-md-5">
            <div class="row justify-content-center">
              <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>

                <form class="mx-1 mx-md-4" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
               <!-- Name -->
                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <input type="text" id="form3Example1c" class="form-control" name="name" />
                      <label class="form-label" for="form3Example1c">Your Name</label>
                      <?php if(in_array('name', $error_fields)): echo ' <span class="error" style="color: red">Please enter a valid name </span>';endif; ?>
                    </div>
                  </div>
                <!-- email -->
                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <input type="email" id="form3Example3c" class="form-control" name="email" />
                      <label class="form-label" for="form3Example3c">Your Email</label>
                      <?php if(in_array('email', $error_fields)): echo ' <span class="error" style="color: red">Please enter a valid email </span>'; endif;?>
                    </div>
                  </div>
                  <!-- password -->
                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <input type="password" id="form3Example4c" class="form-control" name='password' />
                      <label class="form-label" for="form3Example4c">Password</label>
                      <?php if(in_array('password', $error_fields)): echo ' <span class="error" style="color: red">Please enter a valid password </span>';endif; ?>
                    </div>
                  </div>
                <!-- repeat email  -->
                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <input type="password" id="form3Example4cd" class="form-control" name="repeat_pass" />
                      <label class="form-label" for="form3Example4cd">Repeat your password</label>
                      <?php if(in_array('repeat_pass', $error_fields)): echo ' <span class="error" style="color: red"> password not match </span>';endif; ?>
                    </div>
                  </div>

                  <div class="form-check d-flex justify-content-center mb-5">
                    <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3c" />
                    <label class="form-check-label" for="form2Example3">
                      I agree all statements in <a href="#!">Terms of service</a>
                    </label>
                  </div>
                   <!-- submit  -->
                  <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    <input type="SUBMIT" class="btn btn-primary btn-lg" name='submit' value='Register'>
                  </div>

                </form>

              </div>
              <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                <img src="img\note-taking.png"
                  class="img-fluid" alt="Sample image">

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
<?php include('inc/footer.php');