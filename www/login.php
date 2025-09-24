<?php
session_start();
?>
<html>
    <header>
        <style>
@import url(https://fonts.googleapis.com/css?family=Roboto:300);

.login-page {
  padding: 8% 0 0;
  margin: auto;
}
.form {
  position: relative;
  z-index: 1;
  background: #FFFFFF;
  max-width: 360px;
  margin: 0 auto 100px;
  padding: 45px;
  text-align: center;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}
.form input {
  font-family: "Roboto", sans-serif;
  outline: 0;
  background: #f2f2f2;
  width: 100%;
  border: 0;
  margin: 0 0 15px;
  padding: 15px;
  box-sizing: border-box;
  font-size: 14px;
}
.form input[type=submit] {
  font-family: "Roboto", sans-serif;
  text-transform: uppercase;
  outline: 0;
  background: #4CAF50;
  width: 100%;
  border: 0;
  padding: 15px;
  color: #FFFFFF;
  font-size: 14px;
  -webkit-transition: all 0.3 ease;
  transition: all 0.3 ease;
  cursor: pointer;
}
.form input[type=submit]:hover,.form input[type=submit]:active,.form input[type=submit]:focus {
  background: #43A047;
}
.form .message {
  margin: 15px 0 0;
  color: #b3b3b3;
  font-size: 12px;
}
.form .message a {
  color: #4CAF50;
  text-decoration: none;
}
.form .register-form {
  display: none;
}
.container {
  position: relative;
  z-index: 1;
  max-width: 300px;
  margin: 0 auto;
}
.container:before, .container:after {
  content: "";
  display: block;
  clear: both;
}
.container .info {
  margin: 50px auto;
  text-align: center;
}
.container .info h1 {
  margin: 0 0 15px;
  padding: 0;
  font-size: 36px;
  font-weight: 300;
  color: #1a1a1a;
}
.container .info span {
  color: #4d4d4d;
  font-size: 12px;
}
.container .info span a {
  color: #000000;
  text-decoration: none;
}
.container .info span .fa {
  color: #EF3B3A;
}
body {
  background: #76b852; /* fallback for old browsers */
  background: -webkit-linear-gradient(right, #76b852, #8DC26F);
  background: -moz-linear-gradient(right, #76b852, #8DC26F);
  background: -o-linear-gradient(right, #76b852, #8DC26F);
  background: linear-gradient(to left, #76b852, #8DC26F);
  font-family: "Roboto", sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;      
}
        </style>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <title>Basic Login</title>
    </header>

    <body>
        <div style="position: static; font-size: 20px; padding: 5px;">
          <a href="/" style="color: #4CAF50">
            <i class="glyphicon glyphicon-home"></i>
          </a>
        </div>
        <div class="login-page">
                <?php
                    if (!$_SESSION["user"] && ($_POST["username"] || $_POST["password"])) {
                        include_once("sql.php");
                        $name = $_POST["username"];
                        $password = $_POST["password"];
                        $query = "SELECT * From basic_accounts where username='$name' and password='$password'";
                        $result = mysqli_multi_query($conn, $query);
                        if (!$result) {
                            echo '<div class="form" style="max-width: 900px">';
                            echo "<p><b>Error:</b> ".mysqli_error($conn)."</p>";
                            echo "<p><b>Query:</b> $query</p>";
                        } else {
                          echo '<div class="form">';
                          if ($result = mysqli_store_result($conn)) {
                            if ($row = mysqli_fetch_assoc($result)) {
                              $_SESSION["user"] = $row["username"];
                            } else {
                              echo '<h3>Invalid username or password.</h3>';
                            }
                            mysqli_free_result($result);
                          } else {
                            echo '<h3>Query executed, but no result returned.</h3>';
                          }

                          while (mysqli_more_results($conn) && mysqli_next_result($conn)) {
                            if ($result = mysqli_store_result($conn)) {
                              mysqli_free_result($result);
                            }
                          }
                        }
                    } else {
                      echo '<div class="form">';
                    }

                    if (isset($_POST["logout"])) {
                        unset($_SESSION["user"]);
                    }
                    
                    if ($_SESSION["user"]) {
                        echo "<h1>Welcome ".$_SESSION['user']."</h1>";
                        ?>
                        <form method="POST">
                        <input type="hidden" name="logout">
                        <input type="submit" value="Logout">
                        </form>
                        <?php
                    } else {
                        ?>
                        <form class="login-form" method="POST" id="login-form">
                            <input type="text" placeholder="username" name="username"/>
                            <input type="password" placeholder="password" name="password"/>
                            <input type="submit" value="Login">
                            <p class="message">Can you login without using the admin credentials?</p>
                        </form>
                        <?php
                    }
                ?>
            </div>
        </div>
    </body>
</html>