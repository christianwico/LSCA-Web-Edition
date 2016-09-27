<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php
// define variables and set to empty values
$usernameErr = $passwordErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty($_POST["username"])) {
    $nameErr = "Userame is required";

  } elseif (empty($_POST["password"])) {

    $passwordErr = "Password is required";

  } else {
   header("Location: http://localhost/xampp/web/index.php"); /* Redirect browser */
   exit();
  }
    
  
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<


<form method="post" action="#" class="student">
                  
                    <h1><font size="5">Student Information</font></h1>
                    <br> <br>

                    

                    <fieldset>    
                      <span class="error">* <?php echo $usernameErr;?></span>      
                      <label for="mail">User ID :</label>
                      <input type="text" id="username" name="username">
                      
                      
                       <span class="error">* <?php echo $passwordErr;?></span>
                      <label for="password">Password:</label>
                      <input type="password" id="password" name="password">


                      <center><font size="1"><b>PLEASE CONTACT OUR I.T. DEPARTMENT FOR YOUR PASSWORD</b></font></center>
                    </fieldset>
                    <br>  
                    
                   <button type="submit" name="submit" value="Log-in"><font color="white">Log-in</font></button>

</form>



</body>
</html>