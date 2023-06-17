<!--  <!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="index.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>

        <input type="submit" name="submit" value="Login">
    </form>
</body>
</html> -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Admin Login</title>
</head>
<body>
    <h1>Web Shop</h1>
    <?php
      session_start();
      if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        echo "<script language='javascript'>";
        echo "alert('$message')";
        echo "</script>";
        unset($_SESSION['message']);
      }
      if(!empty($_SESSION["shopping_cart"])) {
        $cart_count = count(array_keys($_SESSION["shopping_cart"]));
      }
      else{
        $cart_count = 0;
      }
    ?>
    <nav>
        <a href="index.php"><button>Home</button></a>
      <a href="products.php"><button>Browse shop</button></a>
      <a href="cart.php"><button>Cart<span class="cart-badge"><?php echo $cart_count; ?></span></button></a>
      <a href="order.php"><button>Order information</button></a>
      <a href="admin.php"><button>Admin Login</button></a>
    </nav>
 <!--    <h2>Admin Login</h2>
    <form action="admin.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>

        <input type="submit" name="submit" value="Login">
    </form>
 -->
    <div class="admin-login-container">
        <div class="admin-login-form">
        <h2>Admin Login</h2>
        <form action="admin.php" method="POST">
            <label for="email">Email:   </label>
            <input type="email" name="email" id="email" required><br>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br>

            <input type="submit" name="submit" value="Login">
        </form>
        </div>
    </div>
    <?php
    //session_start();
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'webshoplv44';

    $connection = mysqli_connect($host, $username, $password, $database);

    // Function to authenticate user credentials
    function authenticateUser($connection, $email, $password) {
        // Query to retrieve user record based on email
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);

            // Verify password
            //if (password_verify($password, $user['password'])) {
            if($password == $user['password']){
                // Password matches, user is authenticated
                return true;
            }
        }

        // Invalid email or password
        return false;
    }

    // Check if the login form is submitted
    if (isset($_POST['submit'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Authenticate user
        if (authenticateUser($connection, $email, $password)) {
            // Successful login
            header("Location: dashboard.php");
            exit();
        } else {
            // Invalid credentials
            echo "Invalid email or password.";
        }
    }

    // Close database connection
    mysqli_close($connection);
    //session_write_close();
    ?>
</body>
</html>
