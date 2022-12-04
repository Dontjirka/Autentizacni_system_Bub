<?php
ob_start();
session_start();
?>
<!DOCTYPE html>

<head>
    <title>User</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
</head>

<body>
<div class="container">
    <div class="title"><!--TITLE--></div>
        <form class="val" method="POST" action="login.php">
        <div class="user-details">
          <div class="input-box2">
          <div class="button2">
          <input type="submit" value="Logout" name="buttonLogout"/>
       </form>   
</div>  
</div>

<?php
    ########################################
    #Get email and connect to db
    require("index.php");
    $email = @$_SESSION["var"];
    ########################################
    if (!$_SESSION){
        header("Location: login.php");
        exit;
    }

    if ($_SESSION) {
        #Logout
        if (array_key_exists('buttonLogout',$_POST)) {
            header("Location: login.php");
            exit;
            session_destroy();
        }
    }

    if(isset($_POST['email'])){
        $email =$_POST['email'];    
    }

    $hello ="SELECT * FROM user WHERE email = '$email'";
    $userType = "SELECT typ FROM user WHERE email = '$email'";
    $userName = "SELECT jmeno FROM user WHERE email = '$email'";
    $resultName = mysqli_query($conn,$userName);
    $resultType = mysqli_query($conn,$userType);
    $result = mysqli_query($conn,$hello);
    $fetchType = mysqli_fetch_all($resultType);
    $fetchName = mysqli_fetch_all($resultName);
    $welcomeUser = implode($fetchName[0]);

    $pageTitle = "Hi, $welcomeUser";
    $pageContents = ob_get_contents ();
    ob_end_clean ();
    echo str_replace ('<!--TITLE-->', $pageTitle, $pageContents);

    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){ 
            echo "Email: " . $row["email"]."<br>";
            echo "Jmeno: " . $row["jmeno"]."<br>";
            echo "Prijmeni: " . $row["prijmeni"]."<br>";
            echo "Typ: " . $row["typ"]."<br>";
        }
    }

    if (implode($fetchType[0]) == "silver"){
        echo '<a href="https://www.youtube.com/watch?v=BMLElPpF8gQ" target="_blank">Very Funny</a>';
    }
    if (implode($fetchType[0]) == "gold"){
        echo '<a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" target="_blank">Secret DB</a>';
    }
    if (implode($fetchType[0]) == "platina"){
        echo '<a href="https://github.com/bubilem/tvorba-webovych-aplikaci/blob/master/dokumenty/Tvorba-webovych-aplikaci-A-prednaska.pdf" target="_blank">Something really important</a>';
    }


?>
   
</body>
</html>
