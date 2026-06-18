<?php
session_start();

// كلمة المرور
$password = "admin123";

// تسجيل الخروج
if(isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

// تسجيل الدخول
if(isset($_POST['login'])) {
    if($_POST['password'] === $password) {
        $_SESSION['loggedin'] = true;
    } else {
        $error = "كلمة المرور غير صحيحة";
    }
}

// حفظ البيانات
if(isset($_POST['save']) && isset($_SESSION['loggedin'])) {

    $host = trim($_POST['host']);
    $port = (int)$_POST['port'];

    $config = [
        "host" => $host,
        "port" => $port
    ];

    file_put_contents(
        "server_config.json",
        json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
    );

    $success = "تم حفظ البيانات بنجاح";
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>SA-MP Control Panel</title>

<style>
body{
    font-family: Tahoma;
    background:#f5f5f5;
    padding:50px;
}
.container{
    max-width:500px;
    margin:auto;
    background:#fff;
    padding:20px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,.1);
}
input{
    width:100%;
    padding:10px;
    margin:10px 0;
    box-sizing:border-box;
}
button{
    width:100%;
    padding:12px;
    background:#28a745;
    color:#fff;
    border:none;
    cursor:pointer;
}
button:hover{
    background:#218838;
}
.msg{
    padding:10px;
    margin-bottom:10px;
}
.success{
    background:#d4edda;
    color:#155724;
}
.error{
    background:#f8d7da;
    color:#721c24;
}
.logout{
    display:inline-block;
    margin-top:10px;
    color:red;
    text-decoration:none;
}
</style>

</head>
<body>

<div class="container">

<?php if(!isset($_SESSION['loggedin'])): ?>

<h2>تسجيل الدخول</h2>

<?php if(isset($error)): ?>
<div class="msg error"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST">
    <input type="password" name="password" placeholder="كلمة المرور" required>
    <button type="submit" name="login">دخول</button>
</form>

<?php else: ?>

<h2>إعدادات خادم SA-MP</h2>

<?php if(isset($success)): ?>
<div class="msg success"><?php echo $success; ?></div>
<?php endif; ?>

<form method="POST">

    <label>Host (IP)</label>
    <input type="text" name="host" placeholder="127.0.0.1" required>

    <label>Port</label>
    <input type="number" name="port" placeholder="7777" required>

    <button type="submit" name="save">حفظ</button>

</form>

<a class="logout" href="?logout=1">تسجيل الخروج</a>

<?php endif; ?>

</div>

</body>
</html>