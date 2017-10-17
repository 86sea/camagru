<!DOCTYPE html>
<html>
		
	<head>

		<link rel="stylesheet" type="text/css" href="style.css">
		<title>SURFS-UP</title>
			<?php
			session_start();
			$servername="127.0.0.1";
			$username ="root";
			$password = "g5nrqbcm";
			$dbname = "cms_info_db";
			$login = $_SESSION['loggued_on_usr'];
			$conn = mysqli_connect($servername, $username, $password, $dbname);
			$sql = "SELECT * FROM cms_info_db.admins WHERE username = '$login'";
			$query = mysqli_query($conn, $sql);
			if (mysqli_num_rows($query) == 0)
			{
				header("Location: index.html");
			}
			if ($_POST['submit_rm_user'] == "rm_user")
			{
				$id = $_POST['id'];
				$sql = "DELETE FROM cms_info_db.users WHERE id = '$id'";
				$query = mysqli_query($conn, $sql);
			}
			if ($_POST['submit_add_prod'] == "add_prod")
			{
				$name = $_POST['name'];
				$img = $_POST['img'];
				$price = $_POST['price'];
				$sql = "INSERT INTO cms_info_db.products (name, img, price) VALUES('$name', '$img', $price)";
				$query = mysqli_query($conn, $sql);
			}
			if ($_POST['submit_rm_prod'] == "rm_prod")
			{
				$id = $_POST['id'];
				$sql = "DELETE FROM cms_info_db.products WHERE id = '$id'";
				$query = mysqli_query($conn, $sql);
			}
		?>

	</head>
	<body>
		<div class="dropdown">
			<a class="dropbtn" href="index.html">HOME</a>
		</div>
		<div class="dropdown">
			<button class="dropbtn">CATERGORY</button>
			<div class="dropdown-content">
				<a href="product.php?cat=1">BOARDS</a>
				<a href="product.php?cat=2">CLOTHES</a>
				<a href="product.php?cat=3">GLASSES</a>
				<a href="product.php?cat=4">SWIMWEAR</a>
				<a href="product.php?cat=5">GO-PRO</a>
			</div>
		</div>
		<div class="dropdown">
			<button class="dropbtn">ABOUT</button>
			<div class="dropdown-content">
				<a href="#">CONTACT</a>
				<a href="#">MOTTO</a>
				<a href="#">FAQ</a>
			</div>
		</div>
		<div class="dropdown">
			<button class="dropbtn">ACCOUNT</button>
			<div class="dropdown-content">
				<a href="login.html">SIGN-IN</a>
				<a href="logout.php">SIGN-OUT</a>
				<a href="create.html">CREATE AN ACCOUNT</a>
				<a href="admin.html">ADMIN</a>
			</div>


		</div>

		<a href="#" ><img src="https://www.materialui.co/materialIcons/action/shopping_cart_grey_192x192.png" style="float:right;float:top;margin-right:5%;height:40px;"</img></a>
	</div>
	<br>
		<?php 
			$sql = "SELECT * FROM cms_info_db.products";
			$query = mysqli_query($conn, $sql);
		?>
		<div class="query">
		<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>price</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($query))
		{
        echo "<tr>";
        echo "<td>".$row['id']."</td>";
        echo "<td>".$row['name']."</td>";
        echo "<td>".$row['price']."</td>";
        echo "</tr>";
    	}
        ?>
    </tbody>
</table>
</div>
	<br>
		<?php 
			$sql = "SELECT * FROM cms_info_db.users";
			$query = mysqli_query($conn, $sql);
		?>
		<div class="query">
		<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($query))
		{
        echo "<tr>";
        echo "<td>".$row['id']."</td>";
        echo "<td>".$row['username']."</td>";
        echo "</tr>";
    	}
        ?>
    </tbody>
</table>
</div>
	<br>
			<div>
			<form action="create.php" method="post">
				<h1>Add a user <br>Username:</h1>
				<input type="text" name="login" value="">
				<h1>Password:</h1>
				<input type="password" name="passwd" value="">
				<br><br>
				<input class="btn" type="submit" name='submit' value="OK">
			</form>
		</div>
			<br>
			<div>
			<form action="manage.php" method="post">
				<h1>Remove a user:<br>ID:</h1>
				<input type="text" name="id" value="">
				<input class="btn" type="submit" name='submit_rm_user' value="rm_user">
			</form>
		</div>
			<div>
			<form action="manage.php" method="post">
				<h1>Add Product<br>Name:</h1>
				<input type="text" name="name" value="">
				<h1>IMG:</h1>
				<input type="text" name="img" value="">
				<h1>Price:</h1>
				<input type="text" name="price" value="">
				<input class="btn" type="submit" name='submit_add_prod' value="add_prod">
			</form>
		</div>
		<div>
			<form action="manage.php" method="post">
				<h1>Remove Product<br>ID:</h1>
				<input type="text" name="id" value="">
				<input class="btn" type="submit" name='submit_rm_prod' value="rm_prod">
			</form>
		</div>
	<img src="http://s1.picswalls.com/wallpapers/2014/01/22/hq-black-wallpaper_052248_13.jpg" style="width:1904px;height:1000px;"</img>

</body>
</html>
