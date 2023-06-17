<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Web Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>

  <body>
    <h1>Web Shop</h1>
   
    <nav>
        <a href="dashboard.php"><button>Home</button></a>
        <a href="productsAdmin.php"><button>Browse products</button></a>
        <a href="add_product.php"><button>Add new product</button></a>
        <a href="ordersAdmin.php"><button>Orders</button></a>
        <a href="index.php"><button>Logout</button></a>
    </nav>

    <div class="info">
      <h3>
         Hello admin. You can change and update products, also you can add new ones or delete the existing ones.
      </h3>
      <h2>New Items</h2>
    </div>
    
    <div class="items-grid">
      
      <?php

        require "database.php";
        $conn = get_connection();
        
        $newItemsQuery = "SELECT * FROM products WHERE created_at >= DATE_SUB(NOW(), INTERVAL 3 day)";
        $newItemsResult = mysqli_query($conn, $newItemsQuery);
       
        while ($row = mysqli_fetch_array($newItemsResult, MYSQLI_ASSOC)) {
            
          echo "<div class=item>";
          echo "<img src=$row[image] alt='Missing'>";
          echo "<h2>$row[name]</h2>";
          echo "<h3>Price: $row[price]$</h3>";
          echo "<h2>In stock: $row[quantity]</h2>";
          echo "<a href='update_product.php?id=$row[id]'><button  class='update-btn'>Update</button></a>";
          echo "</div>";
        }

        mysqli_free_result($newItemsResult);
        mysqli_close($conn);
        session_write_close();
      ?>
    </div>
  </body>
</html>