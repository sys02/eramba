<?

# WARNING! After you have uploaded the database, DELETE THIS FILE!
# WARNING! After you have uploaded the database, DELETE THIS FILE!
# WARNING! After you have uploaded the database, DELETE THIS FILE!
# WARNING! After you have uploaded the database, DELETE THIS FILE!
# WARNING! After you have uploaded the database, DELETE THIS FILE!
# WARNING! After you have uploaded the database, DELETE THIS FILE!

# you have to copmplete this three fields
$username="";
$password="";
$db_name="";

# you shouldnt touch this  ... 
$db = new PDO("mysql:host=localhost;dbname=$db_name", $username, $password);
$sql = file_get_contents('db-schema/base_schema.sql');
$qr = $db->exec($sql);


?>
