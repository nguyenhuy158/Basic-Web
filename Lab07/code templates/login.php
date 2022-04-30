<?php
// Start the session
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <?php
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $user = $pass = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user = test_input($_POST["user"]);
        $pass = test_input($_POST["pass"]);
    }

    ?>

    <?php
    // go back to home
    if (isset($_SESSION['user']) && isset($_SESSION['pass'])) {
        $domain = dirname($_SERVER['REQUEST_URI']);
        header("Location: {$domain}/home.php");
    }
    ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <h3 class="text-center text-secondary mt-5 mb-3">User Login</h3>

                <form class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                    <div class=" form-group">
                        <label for="username">Username</label>
                        <!-- <input name="user" id="username" type="text" class="form-control" placeholder="Username"> -->
                        <?php
                        if (isset($_COOKIE['user'])) {
                            echo '<input name="user" id="username" type="text" class="form-control" placeholder="Username" value="' . $_COOKIE['user'] . '">';
                        } else {
                            echo '<input name="user" id="username" type="text" class="form-control" placeholder="Username"';
                        }
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <!-- <input name="pass" id="password" type="password" class="form-control" placeholder="Password"> -->
                        <?php
                        if (isset($_COOKIE['pass'])) {
                            echo '<input name="pass" id="password" type="password" class="form-control" placeholder="Password" value="' . $_COOKIE['pass'] . '">';
                        } else {
                            echo '<input name="pass" id="password" type="password" class="form-control" placeholder="Password">';
                        }
                        ?>
                    </div>

                    <div class="form-group custom-control custom-checkbox">
                        <!-- <input name="remember" type="checkbox" class="custom-control-input" id="remember"> -->
                        <?php
                        if (isset($_COOKIE['remember'])) {
                            echo '<input name="remember" type="checkbox" class="custom-control-input" id="remember" checked>';
                        } else {
                            echo '<input name="remember" type="checkbox" class="custom-control-input" id="remember">';
                        }
                        ?>
                        <label class="custom-control-label" for="remember">Remember login</label>

                        <?php
                        // echo "<br>";
                        // echo $_POST['remember'];
                        // echo "<br>";

                        if (isset($_POST['remember'])) {
                            setcookie(
                                'user',
                                $user,
                                time() + (86400 * 30),
                                "/"
                            );
                            setcookie(
                                'pass',
                                $pass,
                                time() + (86400 * 30),
                                "/"
                            );
                            setcookie(
                                'remember',
                                $_POST['remember'],
                                time() + (86400 * 30),
                                "/"
                            );
                        } else {
                            setcookie(
                                'user',
                                '',
                                time() - 3600,
                                "/"
                            );
                            setcookie(
                                'pass',
                                '',
                                time() - 3600,
                                "/"
                            );
                            setcookie(
                                'remember',
                                '',
                                time() - 3600,
                                "/"
                            );
                        }
                        ?>
                    </div>

                    <div class="form-group">
                        <?php
                        $domain = dirname($_SERVER['REQUEST_URI']);

                        if ($user == 'admin' && $pass == '123') {
                            // Set session variables
                            $_SESSION["user"] = $user;
                            $_SESSION["pass"] = $pass;
                            // echo "Session variables are set.";

                            header("Location: {$domain}/home.php");
                        } else if ($user != '' && $pass != '') {
                            echo '<div class="messages alert alert-danger">
                            Invalid username or password
                            </div>';
                        }
                        ?>

                        <button class="btn btn-success px-5">
                            Login
                        </button>
                    </div>

                    <div class="form-group">
                        <p>Forgot password? <a href="#">Click here</a></p>
                    </div>

                </form>

            </div>
        </div>
    </div>



    <script>
        $(document).ready((event) => {
            // function login() {
            //     console.log('hihi');
            // }

            // $('.messages').hide();
        })
    </script>
</body>

</html>