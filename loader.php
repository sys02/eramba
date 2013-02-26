<?

# WARNING! After you have uploaded the database, DELETE THIS FILE!
# WARNING! After you have uploaded the database, DELETE THIS FILE!
# WARNING! After you have uploaded the database, DELETE THIS FILE!
# WARNING! After you have uploaded the database, DELETE THIS FILE!
# WARNING! After you have uploaded the database, DELETE THIS FILE!
# WARNING! After you have uploaded the database, DELETE THIS FILE!

# you have to copmplete this three fields
$host="";
$username="";
$password="";
# you must create this database first! (create database blah)
$db_name="";

if (!$host || !$username || !$db_name) {
	echo "you need to configure the loader.php script first<br>";
	exit;
} else {
	echo "You will push eramba db scema in the database: \"$db_name\", hosted at: \"$host\", with username: \"$username\" and some password<br><br>";
}


# you shouldnt touch this  ... 
echo "1- I'll now try to connect ... any error means you have set the configuration parameters right<br>";
$db = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);

echo "2- I'll now try to upload the schema .. if you havent got problems yet, this should work<br>";
$sql = file_get_contents('db-schema/base_schema.sql');
$qr = $db->exec($sql);

echo "3- Make sure lib/configuration.inc has the database parameters you used here .. otherwise eramba wont work<br>";

?>
