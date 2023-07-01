<?php
header("Content-Type: text/plain");

require_once "config.php";

// Validate username

// Create OO connection
$db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Prepare a select statement
$sql = "SELECT * FROM users WHERE token=?";
$row = $db->execute_query($sql, [$_GET['token']])->fetch_assoc();

$script = "
	local Visit = game:service('Visit')
	local Players = game:service('Players')
	local NetworkClient = game:service('NetworkClient')
	local PlayerName = '" . $row['username'] . "'
	local PlayerID = " . $row['id'] . "

	local function onConnectionRejected()
		game:SetMessage('This game is not available. Please try another')
	end

	local function onConnectionFailed(_, id, reason)
		game:SetMessage('Failed to connect to the Game. (ID=' .. id .. ', ' .. reason .. ')')
	end

	local function onConnectionAccepted(peer, replicator)
		local worldReceiver = replicator:SendMarker()
		local received = false
		
		local function onWorldReceived()
			received = true
		end
		
		worldReceiver.Received:connect(onWorldReceived)
		game:SetMessageBrickCount()
		
		while not received do
			workspace:ZoomToExtents()
			wait(0.05)
		end
		
		local player = Players.LocalPlayer
		game:SetMessage('Requesting character')
		
		replicator:RequestCharacter()
		game:SetMessage('Waiting for character')
		
		while not player.Character do
			player.Changed:wait()
		end
		
		game:ClearMessage()
	end

	NetworkClient.ConnectionAccepted:connect(onConnectionAccepted)
	NetworkClient.ConnectionRejected:connect(onConnectionRejected)
	NetworkClient.ConnectionFailed:connect(onConnectionFailed)

	game:SetMessage('Connecting to Server')

	local success, errorMsg = pcall(function ()
		local player = Players.LocalPlayer
		
		if not player then
			player = Players:createLocalPlayer(0)
		end

		player.Name = PlayerName
		player.userId = PlayerID
		
		NetworkClient:connect('localhost', " . $_GET['port'] . ", 0)
	end)

	if not success then
		game:SetMessage(errorMsg)
	end
";

echo $script;

exit();