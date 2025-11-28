<?php
require_once __DIR__.'/../functions.php';
require_login();
$u=$_SESSION['username'];
?>
<!DOCTYPE html><html><body style="background:#000;color:#fff;font-family:Arial">
<h2>Welcome <?=$u?></h2>
<a href="/logout.php" style="color:yellow">Logout</a>
<p>Admin panel loaded. Insert your UI here.</p>
</body></html>