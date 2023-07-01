<?php session_start(); ?>

<!DOCTYPE html>
<html>
	<head>
		<title>
		</title>

		<link rel="stylesheet" href="CSS/AllCSS.ashx">

		<script type="text/javascript">
			function sleep(ms)
			{
			  return new Promise(resolve => setTimeout(resolve, ms));
			}

			async function tryJoinGame()
			{
				var modal = document.getElementById("JoiningModal");

			    modal.style.display = "block";

			    await sleep(3000);

			    window.location.replace('dyna3d://?port=53640&token=<?php echo($_SESSION['token']) ?>');

			    await sleep(1500);

			    modal.style.display = "none";
			}
		</script>

		<style>
			#JoiningModal
			{
				position: absolute;
				top: 50%;
				left: 50%;
				margin-top: -50px;
				margin-left: -150px;
				width: 270px;
				height: 75px;
			}
		</style>
	</head>
	<body>
		<div id="MasterContainer">
			<div id="Container">
				<div id="Body">
					<div id="ItemContainer">
						<div class="StandardBoxHeader" style="width: 709px;">
				            <span class="item-header">
				                <a id="FavoriteThisButton" disabled="disabled" class="favoriteStar_20h tooltip" title="Add This to Your Favorites" style="background-position: 0px 0px;"></a>
				                <h1>
				                    Plaec
				                </h1>
				            </span>
				        </div>
					</div>

					<div id="Item" class="StandardBox" style="width: 709px;">
						<div id="Details">
							<div id="placeContainer">
								<div id="Thumbnail_Place">
									
								</div>

								<div class="PlayGames">
									<div class="PlaceInfoIcons">
										<a class="CopyLockedIcon tooltip" title="Copylocked"></a>
										<span class="rbx2hide">Copy Protection: CopyLocked</span>
										<a class="GearIcon tooltip" title="All Gear Allowed"></a>
										<span class="rbx2hide">Gear Allowed</span>
									</div>

									<center>
										<div style="overflow: hidden; width: 400px;">
								            <div style="display: inline; width: 10px;">
								                <a class="ImageButton MultiplayerVisit" onclick="tryJoinGame()"></a>
								            </div>
								        </div>
									</center>

									<div style="clear:both; height:10px;"></div>
								</div>
							</div>

							<div class="clear"></div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="JoiningModal" style="display: none" id="PlaceLauncherStatusPanel">
			<div class="modalPopup blueAndWhite PlaceLauncherModal">
				<div id="Spinner" style="margin:0 1em 1em 0; padding-top:20px;">
	        		<img src="images/ProgressIndicator3.gif" alt="Progress">
	        	</div>

	        	<div id="Status" class="PlaceLauncherStatus" style="display:block">Requesting a server</div>

	        	<div style="text-align: center; margin-top: 1em;">
		            <input type="button" class="Button CancelPlaceLauncherButton" value="Cancel">
		        </div>
			</div>
		</div>

		<input type="image" class="ImageButton" src="images/Play.png" alt="Visit Online" onclick="tryJoinGame()" border="3">
	</body>
</html>