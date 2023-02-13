<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "1234";

$sqlConnection = new mysqli($servername, $username, $password, 'user');


if ($sqlConnection->connect_error) {
  $sqlConnection->close();
  die("Connection failed: " . $sqlConnection->connect_error);
}

$createTableIfNotExists = "CREATE TABLE IF NOT EXISTS user.user (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,name TEXT,email VARCHAR(255) UNIQUE,password TEXT,age INT,dob TEXT,mobile INT)";
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
          echo jsonRespose("Success", 200);
        } else {
          echo jsonRespose("Password doesn't match", 400);
        }
      }
    } else {
      echo jsonRespose("Email isn't registred yet", 404);
      session_destroy();
    }
  } else {
    echo fieldAlert();
  }
}

// SignUp
if (isset($_POST['name']) && !isset($_POST['save'])) {
  if (!empty($_POST['mail']) && !empty($_POST['pass'])) {

    $name     = $_POST['name'];
    $email    = $_POST['mail'];
    $password = $_POST['pass'];

    $decodedMail = urldecode($email);


    try {
      $insertNewUser->bind_param("sss", $name, $decodedMail, $password);
      $insertNewUser->execute();

      saveToJson($name, $email, $dob, $mobile, $age);

      jsonRespose(array("name" => $name, "email" => $email), 200);

    } catch (mysqli_sql_exception $err) {
      if ($err->getCode() === 1062)
        jsonRespose(array("message" => "Email $email Already Exists"), 500);

    }
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
    echo jsonRespose('user updated', 200);
  } else {
    echo fieldAlert();
  }
}

// Delete Session
if (isset($_POST['delete'])) {
  session_destroy();
  echo jsonRespose('session deleted', 200);
}

// function to create json response
function jsonRespose($data, $statusCode)
{
  http_response_code($statusCode);
  return json_encode(array('message' => $data));
}

// error function
function fieldAlert()
{
  http_response_code(400);
  throw new Exception('All fields are required');
}

// function to convert data to json and save to file
function saveToJson($name, $email, $dob, $mobile, $age)
{
  $jsonArray = array('name' => $name, 'email' => $email, 'age' => $age, 'mobileNumber' => $mobile, 'dob' => $dob);
  $jsonFile = fopen("users.json", "w") or die("file not found!");
  fwrite($jsonFile, json_encode($jsonArray));
  fclose($jsonFile);
}