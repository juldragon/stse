<?php
	session_start();
	include('inc/db.inc');
	header('Content-Type: text/html; charset=utf-8');
	$dao = new DAO();
	if(!isset($_SESSION["Locations"]))
	{
		$_SESSION["Locations"] = $dao->getLocations(); 
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
		<link rel="stylesheet" href="css/main.css">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Sveriges Trafikskolor</title>
	</head>
	<body>
		<div id="container">
			<div id="head">
				<img src="img/logo.jpg" class="logo" alt="Logo" />
				<h1 style="float: left;">Sveriges Trafikskolor</h1>
			</div>
			<div id="links">
			<ul id="linkList">
				<il><a href="index.php">Trafikskolor</a></il>
				<il><a href="#">Teorifrågor</a></il>
				<il><a href="#">Kontakta oss</a></il>
				<il><a href="#">Logga in</a></il>
			</ul>
			</div>
			<div id="sortAndFilters">
				<!-- Dynamic content - Start -->
				<?php if(!isset($_GET['loc'])): ?>
					<h2>Välj län</h3>
					<?php 
						$Locations = $_SESSION["Locations"];
						$arrLengh = count($Locations);
					?>
					
					<table id="LanTable">
						<?php for($i=0; $i<$arrLengh; $i++): ?>
							<?php if($i%4 == 0): ?>
								<?php if($i != 0): ?>
									</tr>
								<?php endif; ?>
								<tr>
							<?php endif; ?>
							<td>
								<a class="table" href="index.php?loc=<?=urlencode($Locations[$i]);?>"><?=$Locations[$i];?></a>
							</td>
						<?php endfor; ?>
						</tr>
					</table>
				<?php endif; ?>	
				
				<?php if(isset($_GET['loc'])): ?>
					<h2>Välj postort i <?=$_GET['loc']?></h3>
					<?php
						$orter = $dao->getPostort($_GET['loc']);
						$arrLengh = count($orter);
					?>
					<table id="LanTable">
						<?php for($i=0; $i<$arrLengh; $i++): ?>
							<?php if($i%4 == 0): ?>
								<?php if($i != 0): ?>
									</tr>
								<?php endif; ?>
								<tr>
							<?php endif; ?>
							<td>
								<a class="table" href="index.php?loc=<?=$_GET['loc'];?>&ort=<?=$orter[$i];?>"><?=$orter[$i];?></a>
							</td>
						<?php endfor; ?>
						</tr>
					</table>
				<?php endif; ?>	
				<!-- Dynamic content - End -->
			</div>
			<!-- Dynamic content - Start -->
			<?php if(isset($_GET['loc']) && isset($_GET['ort'])): ?>
				<?php 

				?>
				<div id="content">
					<div id="contentContainer">
					<div class="SchoolsTable" style="width:740px;">
					<table>
						<tr> 
							<td>
								Trafikskola (Mer info)
							</td>
							<td >
								Pris för Lektion per timme
							</td>
							<td>
								Pris för Risketta
							</td>
							<td>
								Pris för Risktvåa
							</td>
						</tr>
						<?php $Skolor = $dao->getSkolor();  ?>
						<?php foreach($Skolor as $skola): ?>
							<?php if(strtolower($skola->location) == strtolower($_GET['loc'])
								&& strtolower($skola->postort) == strtolower($_GET['ort'])): ?>
							<tr>
							<td>
								<a class="table" href="index.php?name=<?=$skola->name;?>&loc=<?=$_GET['loc'];?>&ort=<?=$_GET['ort'];?>"><?=$skola->name;?></a>
							</td>
							<td>
								<?=$skola->priceLesson . " SEK"; ?>
							</td>
							<td>
								<?=$skola->priceRisketta . " SEK"; ?>
							</td>
							<td>
								<?php
								if($skola->priceGuide == "0")
								{
									echo "Uppgift saknas";
								}
								else
								{
									echo $skola->priceGuide . " SEK";
								}
								?>
							</td>
							</tr>
							<?php endif; ?>
						<?php endforeach; ?>

					</table>
					<div/>
					</div>
				</div>
			<?php endif; ?>
			<!-- Dynamic content - End -->
			<div id="footer"></div>
		</div>
	</body>
</html>