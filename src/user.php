<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome <?php echo $_SESSION['name'];  ?> </title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous" defer></script>
    <script src="scripts.js" defer></script>
</head>

<body>
    <div class="container">
        <div class="container-1 p-3">
            <h3>Welcome <?php echo $_SESSION['name'] ?></h3>
            <div class="my-3">
                <label>Name</label>
                <input type="text" class="form-control" id="user-name" placeholder='John' required disabled value="<?php echo $_SESSION['name'] ?>">
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" class="form-control" id="user-email" required disabled placeholder='example@mail.com' value=<?php echo $_SESSION['email'] ?>>
            </div>

            <div class="mb-3">
                <label>Age</label>
                <input type="number" class="form-control" id="user-age" required disabled placeholder=0 value=<?php echo $_SESSION['age'] ?>>
            </div>
            <div class="mb-3">
                <label>Date of birth</label>
                <input type="text" class="form-control" id="user-dob" required disabled placeholder='DD/MM/YYYY' value=<?php echo $_SESSION['dob'] ?>>
            </div>
            <div class="mb-3">
                <label>Mobile Number</label>
                <input type="text" class="form-control" id="user-mobile" required placeholder="0123456789" disabled value=<?php echo $_SESSION['mobile'] ?>>
            </div>
            <div class="mb-3">
                <button class="btn btn-primary" type="submit" id="edit-btn">Edit</button>
            </div>
            <div class="mb-3">
                <button class="btn btn-primary" type="submit" id="save-btn">Save</button>
                <button class="btn btn-primary" type="submit" id="signout-btn">Signout</button>
            </div>
        </div>
    </div>
</body>

</html>