<?php
session_start();

	include("../conn/connection.php");
	include("functions.php");


	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$user_name = $_POST['username'];
		$password = $_POST['password'];

		if(!empty($user_name) && !empty($password) && !is_numeric($user_name))
		{

			$query = "select * from users where username = '$user_name' limit 1";
			$result = mysqli_query($conn, $query);

			if($result)
			{
				if($result && mysqli_num_rows($result) > 0)
				{

					$user_data = mysqli_fetch_assoc($result);
					
					if($user_data['password'] === $password)
					{

						$_SESSION['user_id'] = $user_data['user_id'];
						header("Location: ../index.php");
						die;
					}
				}
			}
			echo "wrong username or password!";
		}else
		{
			echo "wrong username or password!";
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0"/>

    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 110vh;
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
            box-shadow: rgba(50, 50, 93, 0.5) 0px 6px 12px -2px,
            rgba(0, 0, 0, 0.5) 0px 3px 7px -3px;
            min-height: 260px;
            min-width: 500px;
        }

        #basic-addon1, #basic-addon2 {
            background-color: rgb(245, 247, 248, 0.5);
            box-shadow: rgba(50, 50, 93, 0.5) 0px 6px 12px -2px,
            rgba(0, 0, 0, 0.5) 0px 3px 7px -3px;
        }

        #username, #password {
            background-color: rgb(245, 247, 248, 0.5);
            box-shadow: rgba(50, 50, 93, 0.5) 0px 6px 12px -2px,
            rgba(0, 0, 0, 0.5) 0px 3px 7px -3px;
        }

        ::placeholder {
            color: aqua;
        }

        a {
            text-decoration: none;
            color: rgb(0, 0, 0, 0.9);
            margin-left: 42vh;
        }

        h2 {
            margin-top: 10px;
            margin-bottom: 20px;
            border-width: 50%;
            font-size: 40px;
            color: rgb(0, 0, 0, 0.6);
        }

    </style>
</head>
<body>
<form method="post">
    <div class="container-sm">
        <h2>Login</h2>
        <div class="input-group mb-3 w-75">
            <span class="input-group-text" id="basic-addon1">
                <span class="material-symbols-outlined"> person </span>
            </span>
            <input
                type="text"
                class="form-control"
                placeholder="Username"
                aria-label="Username"
                aria-describedby="basic-addon1"
                id="username"
                name="username"
            />
        </div>
        <div class="input-group mb-3 w-75">
            <span class="input-group-text" id="basic-addon2">
                <span class="material-symbols-outlined"> lock </span>
            </span>
            <input
                type="password"
                class="form-control"
                placeholder="Password"
                aria-label="basic-addon2"
                aria-describedby="basic-addon2"
                id="password"
                name="password"
            />
        </div>
        <button
            type="submit"
            class="btn btn-outline-primary mb-3 left-2"
            id="basic-addon1"
        >
            Submit
        </button>
        <div class="input-group mb-3">
            <a href="signup.php">Don't Have a Account?</a>
        </div>
    </div>
</form>

</body>

</html>
