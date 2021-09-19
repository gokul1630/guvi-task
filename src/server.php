<?php
session_start();
$servername = "localhost";
$username = "gokul";
$password = "1234";

$sqlConnection = new mysqli($servername, $username, $password, 'user');


if ($sqlConnection->connect_error) {
  die("Connection failed: " . $sqlConnection->connect_error);
  $sqlConnection->close();
}

$createTableIfNotExists = "CREATE TABLE IF NOT EXISTS user.user (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,name TEXT,email TEXT,password TEXT,age INT,dob TEXT,mobile INT)";
$sqlConnection->query($createTableIfNotExists);

$selectEmailFromTable = $sqlConnection->prepare("SELECT * FROM user.user WHERE email=? LIMIT 1");

$insertNewUser = $sqlConnection->prepare("INSERT INTO user.user (name,email,password) VALUES (?,?,?)");

$updateUser = $sqlConnection->prepare("UPDATE user.user SET name=?,age=?,dob=?,mobile=? WHERE email=?");


// Login
if (isset($_GET['mail']) && !isset($_POST['save'])) {
  if (!empty($_GET['mail']) && !empty($_GET['pass'])) {

    $selectEmailFromTable->bind_param("s", urldecode($_GET["mail"]));
    $selectEmailFromTable->execute();
    $result = $selectEmailFromTable->get_result();

    if ($result->num_rows > 0) {
      while ($data = $result->fetch_assoc()) {
        if ($data['password'] == $_GET['pass']) {
          $_SESSION['name'] = $data['name'];
          $_SESSION['email'] = $data['email'];
          $_SESSION['age'] = $data['age'];
          $_SESSION['dob'] = $data['dob'];
          $_SESSION['mobile'] = $data['mobile'];
          $_SESSION['session'] = $_POST['name'];
          saveToJson($data['name'], $data['email'], $data['dob'], $data['mobile'], $data['age']);
          echo $data['email'];
        } else {
          echo "Password doesn't match";
        }
      }
    } else {
      echo "Email isn't registred yet";
      session_destroy();
    }
  } else {
    echo fieldAlert();
  }
}

// SignUp
if (isset($_POST['name']) && !isset($_POST['save'])) {
  if (!empty($_POST['mail']) && !empty($_POST['pass'])) {

    $insertNewUser->bind_param("sss", $_POST["name"], urldecode($_POST["mail"]), $_POST["pass"]);
    $insertNewUser->execute();

    $_SESSION['name'] = $_POST['name'];
    $_SESSION['email'] = $_POST['mail'];

    saveToJson($_POST['name'], $_POST['mail'], $_POST['dob'], $_POST['mobile'], $_POST['age']);

    echo "user added";
  } else {
    echo fieldAlert();
  }
}


// Update details
if (isset($_POST['save'])) {
  if (!empty($_POST['mail']) && !empty($_POST['name']) && !empty($_POST['age']) && !empty($_POST['dob']) && !empty($_POST['mobile'])) {
    $updateUser->bind_param("sisis", $_POST['name'], $_POST['age'], $_POST['dob'], $_POST['mobile'], urldecode($_POST['mail']));
    $updateUser->execute();

    $_SESSION['name'] = $_POST['name'];
    $_SESSION['email'] = $_POST['mail'];
    $_SESSION['age'] = $_POST['age'];
    $_SESSION['dob'] = $_POST['dob'];
    $_SESSION['mobile'] = $_POST['mobile'];
    saveToJson($_POST['name'], $_POST['mail'], $_POST['dob'], $_POST['mobile'], $_POST['age']);

    echo 'user updated';
  } else {
    echo fieldAlert();
  }
}

// Delete Session
if (isset($_POST['delete'])) {
  session_destroy();
  echo "deleted\n";
}

function fieldAlert(): string
{
  return "All fields are required";
}

// function to convert data to json and save to file
function saveToJson($name, $email, $dob, $mobile, $age)
{
  $jsonArray = array('name' => $name, 'email' => $email, 'age' => $age, 'mobileNumber' => $mobile, 'dob' => $dob);
  $jsonFile = fopen("users.json", "w") or die("file not found!");
  fwrite($jsonFile, json_encode($jsonArray));
  fclose($jsonFile);
}
