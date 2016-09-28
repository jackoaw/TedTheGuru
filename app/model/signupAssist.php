<html>
<body>

<br>
<!-- Your email address is: --> <?php 
include_once '../global.php';
//connection to the database
$db = db::instance();
"<br>";


//Initialization
$username = $_POST["username-signup"];
$passwd = $_POST["password1"];
$day = $_POST["birthDay"];
$month = $_POST["birthMonth"];
$year = $_POST["birthYear"];
$date = date("Y-m-d", mktime(0,0,0,$month, $day, $year));




$sql="SELECT * FROM users WHERE Username='$username'";
$result=$db->lookup($sql);

// If result matched $username
if($result->num_rows==1){
	echo "Error: Username has already been used.";
}
else {

	//Create new user
	$user = new AppUser();
	$user->set('Username', $username);
	$user->set('Password', $passwd);
	$user->set('Birthday', $date);
	$user->save();

}

header('Location: '.BASE_URL);
?>
</body>
</html>
