    <?php include "config.php" ?>
<div class="dropdown">
			<a class="dropbtn" href="index.php">HOME</a>
		</div>
		<div class="dropdown">
			<form action="accounts.php" method="post">
				<div class="dropdown-content">
                    <button type="submit" name="submit" value="login">Login</button>
                    <button type="submit" name="submit" value="create">Create An Account</button>
                    <button type="submit" name="submit" value="admin">Admin</button>
				</div>
			</form>
		</div>
        <div class="logout">
            <form action="logout.php" method="post">
                <button type="submit" name="submit" value="logout">Logout</button>
            </form>
        </div>

