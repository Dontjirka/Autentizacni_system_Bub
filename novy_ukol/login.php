<?php
require_once('index.php');
session_start();
?>
<!DOCTYPE html>

<head>
    <title>Nevim</title>
    <meta charset='utf-8'>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>src = "https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"

    </script>
        
</head>

<body>
    <div class="container">  
    <div class ="title">Login</div>
        <form action="" method="POST">
        <div class="user-details">
          <div class="input-box">
            <span class="details">Email</span>
                <input type="email" id="email" name="email" placeholder="Type email" pattern="/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3,4,5})+$/." title="Must ..." required>
            </div>
            <div class="input-box">
            <span class="details">Heslo</span>
                <input type="password" id="psw" name="psw" placeholder="Type password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{7,}"
                    title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                    required>
                    <div class="button">
                <input type="submit" value="Login" name="button"/>
            </div>
        </form>
    </div>
<tr>

<?php
########################################
#Variables
$email = filter_input(INPUT_POST, "email");
$psw = hash("SHA256",filter_input(INPUT_POST, "psw") . "SALT");
$useremail = "SELECT email FROM user";
$userheslo = "SELECT heslo FROM user";
$resultUserEmail = mysqli_query($conn, $useremail);
$resultUserHeslo = mysqli_query($conn, $userheslo);
$fetchEmail = mysqli_fetch_all($resultUserEmail);
$fetchHeslo = mysqli_fetch_all($resultUserHeslo);
$numOfRows = mysqli_num_rows($resultUserEmail);
$HesloT = False;
$EmailT = False;
$HesloF = True;
$EmailF = True;
########################################

########################################
#for database

for ($i=0; $i < $numOfRows; $i++) { 
    $strHeslo = $fetchHeslo[$i];
    $strHeslo = implode($strHeslo);
    $strEmail = $fetchEmail[$i];
    $strEmail = implode($strEmail);
    for ($j=$i; $j <= $i; $j++){
        if (strlen($strHeslo) != 64) {
            $hashedHeslo = hash("SHA256", $strHeslo . "SALT");
            mysqli_query($conn, "UPDATE user SET heslo = '$hashedHeslo' WHERE email = '$strEmail'");
        }
    }
}
#########################################

#########################################
#if statement
if (array_key_exists('button',$_POST)){
    for ($i=0; $i < $numOfRows; $i++) { 
        if ($fetchEmail[$i] == [$email]) {
            $EmailT = True;
        }else{
            $EmailF = False;
        }
    }
}

if (array_key_exists('button',$_POST)){
    for ($i=0; $i < $numOfRows; $i++) { 
        if ($fetchHeslo[$i] == [$psw]) {
            $HesloT = True;
        }else{
            $HesloF = False;
        }
    }
}

if($HesloT == True && $EmailT == True) {
    $email=$email;
    $_SESSION["var"]=$email;
    header("Location: user.php");
    exit; 
}

if($HesloF == False || $EmailF == False){
    header("Location: hello.php");
    exit;
}
##########################################
?>
</tr>
</body>
</html>