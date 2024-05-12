<?php
session_start();
include("../conn/connection.php");
include("functions.php");

$message = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password) && !is_numeric($username)) {
        $user_id = random_num(20);
        $query = "INSERT INTO users (user_id,name,username,password) VALUES ('$user_id','$name','$username','$password')";
        
        if(mysqli_query($conn, $query)){
            $message = "Successfully registered!";
            header("location: login.php");
            die;
        }else{
            $message = "Error: " . mysqli_error($conn);
        }

    } else {
        $message = "Please enter some valid information!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            border: solid 1px;
            background-image: url("Backgroundlog.jpg");
            background-repeat: no-repeat;
            background-position: center;
            background-size: 100%;
        }

        .container-sm {
            width: 500px;
            display: grid;
            place-items: center;
            backdrop-filter: blur(10px);
            box-shadow: rgba(50, 50, 93, 0.5) 0px 6px 12px -2px, rgba(0, 0, 0, 0.5) 0px 3px 7px -3px;
            min-height: 260px;
            min-width: 500px;
        }

        #basic-addon1,
        #basic-addon2 {
            background-color: rgb(245, 247, 248, 0.5);
            box-shadow: rgba(50, 50, 93, 0.5) 0px 6px 12px -2px, rgba(0, 0, 0, 0.5) 0px 3px 7px -3px;
        }

        #name,
        #username,
        #password,
        #cellnumber {
            background-color: rgb(245, 247, 248, 0.5);
            box-shadow: rgba(50, 50, 93, 0.5) 0px 6px 12px -2px, rgba(0, 0, 0, 0.5) 0px 3px 7px -3px;
        }

        a {
            text-decoration: none;
            color: rgb(0, 0, 0, 0.9);
            margin-left: 42vh;
        }

        h2 {
            margin-top: 5px;
            margin-bottom: 20px;
            border-width: 50%;
            font-size: 40px;
            color: rgb(0, 0, 0, 0.6);
        }
    </style>
</head>
<body>
    <form action="" method="post">
        <div class="container-sm">
            <a class="btn btn-outline-danger" href="login.php" role="button" id="basic-addon2">Back</a>
            <h2>Register</h2>

            <div class="input-group mb-3 w-75">
                <span class="input-group-text" id="basic-addon1">
                    <span class="material-symbols-outlined"> person</span>
                </span>
                <input type="text" class="form-control" placeholder="Name" aria-label="basic-addon1" aria-describedby="basic-addon1" id="name" name="name" />
            </div>

            <div class="input-group mb-3 w-75">
                <span class="input-group-text" id="basic-addon1">
                    <span class="material-symbols-outlined"> mail</span>
                </span>
                <input type="text" class="form-control" placeholder="Email" aria-label="basic-addon1" aria-describedby="basic-addon1" id="username" name="username" />
            </div>

            <div class="input-group mb-3 w-75">
                <span class="input-group-text" id="basic-addon1">
                    <span class="material-symbols-outlined"> lock </span>
                </span>
                <input type="password" class="form-control" placeholder="Password" aria-label="basic-addon2" aria-describedby="basic-addon2" id="password" name="password" />
            </div>

            <input type="submit" class="btn btn-outline-primary mb-3 left-2" value="Submit" name="submit">
        </div>
    </form>

    <!-- Success Modal -->
    <?php if ($message): ?>
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="successModalLabel">Success!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php echo $message; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <script>
        <?php if ($message): ?>
            var successModal = new bootstrap.Modal(document.getElementById('successModal'), {});
            successModal.show();
        <?php endif; ?>
    </script>
</body>

</html>
