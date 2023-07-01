<?php
	session_start();

	require_once "../config.php";

	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['headColor'])
											  && isset($_POST['torsoColor'])
											  && isset($_POST['leftArmColor'])
											  && isset($_POST['rightArmColor'])
											  && isset($_POST['leftLegColor'])
											  && isset($_POST['rightLegColor']))
	{
		$newHeadColor = $_POST['headColor'];
		$newTorsoColor = $_POST['torsoColor'];
		$newLeftArmColor = $_POST['leftArmColor'];
		$newRightArmColor = $_POST['rightArmColor'];
		$newLeftLegColor = $_POST['leftLegColor'];
		$newRightLegColor = $_POST['rightLegColor'];

		$sql = "UPDATE bodycolors SET headcolor=" . $newHeadColor . ", torsocolor=" . $newTorsoColor . ", leftarmcolor=" . $newLeftArmColor . ", rightarmcolor=" . $newRightArmColor . ", leftlegcolor=" . $newLeftLegColor . ", rightlegcolor=" . $newRightLegColor . " WHERE userid=" . $_SESSION["id"];

		if (mysqli_query($link, $sql))
		{
			// echo "Character updated successfully";
		} else {
			echo "Error updating bodycolors: " . mysqli_error($link);
		}
	}

	
	$characterInfoSql = "SELECT * FROM bodycolors WHERE userid=" . $_SESSION["id"];

	if ($result = mysqli_query($link, $characterInfoSql))
	{
		while ($rows = mysqli_fetch_assoc($result))
		{
			$headColor = $rows["headcolor"];
			$leftArmColor = $rows["leftarmcolor"];
			$leftLegColor = $rows["leftlegcolor"];
			$rightArmColor = $rows["rightarmcolor"];
			$rightLegColor = $rows["rightlegcolor"];
			$torsoColor = $rows["torsocolor"];
		}
	} else {
		echo "Error loading info: " . mysqli_error($link);
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>

		<script src="https://cdn.jsdelivr.net/npm/jquery@3.7/dist/jquery.min.js"></script>

		<style type="text/css">
			#popUpDiv{
			   z-index: 100;
			   position: absolute;
			   background-color: rgba(123, 123, 123, 0.8);
			   display: none;
			   top: 50;
			   left: 50;
			}

			#popupSelect{
			   z-index: 1000;
			   position: absolute;
			   top: 130px;
			   left: 50px;
			}
		</style>
	</head>
	<body>
		<div id="baseDiv"></div>

		<table id="parts" width="200" cellspacing="7">
			<tbody>
				<tr height="60">
					<td colspan="4" style="text-align:center;">
						<img src="../images/face.png" height="55" width="50" id="head"></td>
					</td>
				</tr>
				<tr height="85">
					<td width="auto" bgcolor="black" id="leftArm"></td>
					<td width="90" colspan="2" bgcolor="black" id="torso"></td>
					<td width="auto" bgcolor="black" id="rightArm"></td>
				</tr>
				<tr height="85">
					<td width="auto"></td>
					<td width="30" bgcolor="black" id="leftLeg"></td>
					<td width="30" bgcolor="black" id="rightLeg"></td>
					<td width="auto"></td>
				</tr>
			</tbody>
		</table>

		<div id="popUpDiv">
		  <select id="popupSelect">
		  </select>
		</div>

		<form action="Character.php" method="post" id="characterForm">
			<input type="hidden" name="headColor" id="headColor" value="<?= $headColor; ?>">
			<input type="hidden" name="torsoColor" id="torsoColor" value="<?= $torsoColor; ?>">
			<input type="hidden" name="leftArmColor" id="leftArmColor" value="<?= $leftArmColor; ?>">
			<input type="hidden" name="rightArmColor" id="rightArmColor" value="<?= $headColor; ?>">
			<input type="hidden" name="leftLegColor" id="leftLegColor" value="<?= $leftLegColor; ?>">
			<input type="hidden" name="rightLegColor" id="rightLegColor" value="<?= $rightLegColor; ?>">
		</form>

		<script type="text/javascript">
			var headColor = <?= $headColor; ?>;
			var torsoColor = <?= $torsoColor; ?>;
			var leftArmColor = <?= $leftArmColor; ?>;
			var rightArmColor = <?= $rightArmColor; ?>;
			var leftLegColor = <?= $leftLegColor; ?>;
			var rightLegColor = <?= $rightLegColor; ?>;

			var selectedLimb = "Torso";

			function loadXMLDoc() {
			  var xmlhttp = new XMLHttpRequest();
			  xmlhttp.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			      fillColourSpots(this);
			    }
			  };
			  xmlhttp.open("GET", "http://localhost/bodycolorlist.xml", true);
			  xmlhttp.send();
			}

			function fillColourSpots(xml)
			{
				var x, i, xmlDoc, txt;

				xmlDoc = xml.responseXML;

				x = xmlDoc.getElementsByTagName("color");

				for (i = 0; i< x.length; i++) {
					// create a new div element
					const option = document.createElement("option");

					option.setAttribute("colorId", x[i].getElementsByTagName("brickColor")[0].childNodes[0].nodeValue)
					option.innerText = x[i].getElementsByTagName("colorName")[0].childNodes[0].nodeValue;
					option.id = x[i].getElementsByTagName("colorName")[0].childNodes[0].nodeValue;

					document.getElementById("popupSelect").appendChild(option);
				}
			}

			// TODO: why does this suck so much
			$("#torso").click(function(e) {
				selectedLimb = "Torso";
			    $("#popUpDiv").show();
			});
			$("#leftArm").click(function(e) {
				selectedLimb = "Left Arm";
			    $("#popUpDiv").show();
			});
			$("#rightArm").click(function(e) {
				selectedLimb = "Right Arm";
			    $("#popUpDiv").show();
			});
			$("#head").click(function(e) {
				selectedLimb = "Head";
			    $("#popUpDiv").show();
			});
			$("#leftLeg").click(function(e) {
				selectedLimb = "Left Leg";
			    $("#popUpDiv").show();
			});
			$("#rightLeg").click(function(e) {
				selectedLimb = "Right Leg";
			    $("#popUpDiv").show();
			});

		    $("#popupSelect").change(function(e) {
			    $("#baseDiv").html($("#popupSelect").val() + ' clicked. Click again to change. ' + selectedLimb);

			    if (selectedLimb == "Torso")
			    {
			    	torsoColor = document.getElementById($("#popupSelect").val()).getAttribute("colorId");
			    	console.log(torsoColor);
			    	document.getElementById("torsoColor").setAttribute("value", torsoColor);
			    }
			    if (selectedLimb == "Left Arm")
			    {
			    	leftArmColor = document.getElementById($("#popupSelect").val()).getAttribute("colorId");
			    	console.log(leftArmColor);
			    	document.getElementById("leftArmColor").setAttribute("value", leftArmColor);
			    }
			    if (selectedLimb == "Right Arm")
			    {
			    	rightArmColor = document.getElementById($("#popupSelect").val()).getAttribute("colorId");
			    	console.log(rightArmColor);
			    	document.getElementById("rightArmColor").setAttribute("value", rightArmColor);
			    }
			    if (selectedLimb == "Left Leg")
			    {
			    	leftLegColor = document.getElementById($("#popupSelect").val()).getAttribute("colorId");
			    	console.log(leftLegColor);
			    	document.getElementById("leftLegColor").setAttribute("value", leftLegColor);
			    }
			    if (selectedLimb == "Right Leg")
			    {
			    	rightLegColor = document.getElementById($("#popupSelect").val()).getAttribute("colorId");
			    	console.log(rightLegColor);
			    	document.getElementById("rightLegColor").setAttribute("value", rightLegColor);
			    }
			    if (selectedLimb == "Head")
			    {
			    	headColor = document.getElementById($("#popupSelect").val()).getAttribute("colorId");
			    	console.log(headColor);
			    	document.getElementById("headColor").setAttribute("value", headColor);
			    }

			    $("#popUpDiv").hide();

			    document.getElementById("characterForm").submit();
			});

			loadXMLDoc();
		</script>
	</body>
</html>