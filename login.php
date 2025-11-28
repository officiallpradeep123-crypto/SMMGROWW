<?php
require_once __DIR__.'/functions.php';
$err=null;$ok=flash_get('success');
if($_SERVER['REQUEST_METHOD']==='POST'){
 if(!csrf_verify($_POST['csrf']??''))$err="Invalid request";
 else{
  $u=trim($_POST['username']??'');$p=$_POST['password']??'';
  $st=$pdo->prepare("SELECT * FROM users WHERE username=? LIMIT 1");
  $st->execute([$u]);$user=$st->fetch();
  if($user && password_verify($p,$user['password'])){login_user($user);header("Location:/admin/index.php");exit;}
  else $err="Invalid username/password";
 }}
$token=csrf_token();
?>
<!DOCTYPE html><html><body>
<h2>Login</h2>
<?php if($ok)echo "<p style='color:green'>$ok</p>";?>
<?php if($err)echo "<p style='color:red'>$err</p>";?>
<form method="post">
<input type="hidden" name="csrf" value="<?=$token?>">
<input name="username" placeholder="Username"><br>
<input type="password" name="password" placeholder="Password"><br>
<button>Login</button>
</form>
</body></html>