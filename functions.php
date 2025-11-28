<?php
require_once __DIR__.'/config.php';
function csrf_token(){if(empty($_SESSION['csrf']))$_SESSION['csrf']=bin2hex(random_bytes(32));return $_SESSION['csrf'];}
function csrf_verify($t){return isset($_SESSION['csrf'])&&hash_equals($_SESSION['csrf'],$t);}
function flash_set($k,$v){$_SESSION['flash'][$k]=$v;}
function flash_get($k){if(!isset($_SESSION['flash'][$k]))return null;$v=$_SESSION['flash'][$k];unset($_SESSION['flash'][$k]);return $v;}
function login_user($u){session_regenerate_id(true);$_SESSION['user_id']=$u['id'];$_SESSION['username']=$u['username'];$_SESSION['role']=$u['role'];$_SESSION['last_activity']=time();}
function is_logged_in(){if(empty($_SESSION['user_id']))return false;if($_SESSION['fingerprint']!==hash('sha256',$_SERVER['HTTP_USER_AGENT'].session_id()))return false;if(time()-($_SESSION['last_activity']??0)>1800)return false;$_SESSION['last_activity']=time();return true;}
function require_login(){if(!is_logged_in()){flash_set('error','Login required');header("Location:/login.php");exit;}}
?>