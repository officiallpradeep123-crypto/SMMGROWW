<?php
require_once __DIR__.'/functions.php';
$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
 if(!csrf_verify($_POST['csrf']??''))$errors[]="Bad request";
 $u=trim($_POST['username']);$e=trim($_POST['email']);$p=$_POST['password'];$p2=$_POST['password2'];
 if($p!==$p2)$errors[]="Passwords mismatch";
 if(!$errors){
  $s=$pdo->prepare("SELECT id FROM users WHERE username=?");$s->execute([$u]);
  if($s->fetch())$errors[]="User exists";
  else{
    $hash=password_hash($p,PASSWORD_DEFAULT);
    $s=$pdo->prepare("INSERT INTO users(username,email,password,role)VALUES(?,?,?, 'admin')");
    $s->execute([$u,$e,$hash]);
    flash_set('success','Admin created');header("Location:/login.php");exit;
  }
 }
}
$t=csrf_token();?>
<!DOCTYPE html><html><body>
<h2>Create Admin</h2>
<?php foreach($errors as $e)echo "<p style='color:red'>$e</p>";?>
<form method="post">
<input type="hidden" name="csrf" value="<?=$t?>">
<input name="username" placeholder="Username"><br>
<input name="email" placeholder="Email"><br>
<input type="password" name="password" placeholder="Password"><br>
<input type="password" name="password2" placeholder="Confirm"><br>
<button>Create</button>
</form>
</body></html>