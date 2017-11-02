<?php include "config/database.php" ?>
<ul class ="nav">
    <li><a id="home" href="index.php">HOME</a></li>
        <form action="accounts.php" method="post">
            <li> <button type="submit" name="submit" value="login">Login</button></li>
            <li><button type="submit" name="submit" value="create">Create An Account</button></li>
            <li><button type="submit" name="submit" value="admin">Admin</button></li>
        </form>
        <form action="logout.php" method="post">
            <li id="logout"><button type="submit" name="submit" value="logout">Logout</button></li>
        </form>
</ul>


