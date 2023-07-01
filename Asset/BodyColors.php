<?php
header("Content-Type: text/plain");

require_once "../config.php";

// Create OO connection
$db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Prepare a select statement
$sql = "SELECT * FROM bodycolors WHERE userid=?";
$row = $db->execute_query($sql, [$_GET['userId']])->fetch_assoc();

$data = "
	<roblox xmlns:xmime=\"http://www.w3.org/2005/05/xmlmime\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"http://www.roblox.com/roblox.xsd\" version=\"4\">
		<External>null</External>
		<External>nil</External>
		<Item class=\"BodyColors\" referent=\"RBX0\">
			<Properties>
				<int name=\"HeadColor\">" . $row['headcolor'] . "</int>
				<int name=\"LeftArmColor\">" . $row['leftarmcolor']  . "</int>
				<int name=\"LeftLegColor\">" . $row['leftlegcolor'] . "</int>
				<string name=\"Name\">Body Colors</string>
				<int name=\"RightArmColor\">" . $row['rightarmcolor'] . "</int>
				<int name=\"RightLegColor\">" . $row['rightlegcolor'] . "</int>
				<int name=\"TorsoColor\">" . $row['torsocolor'] . "</int>
				<bool name=\"archivable\">true</bool>
			</Properties>
		</Item>
	</roblox>
";

echo $data;

exit();