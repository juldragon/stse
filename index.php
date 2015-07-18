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
		<meta name="description" content= "Jämför trafikskolor och körlektioner online. Studera inför trafikprovet med vårt teoriprov baserat på riktiga frågor">
		<meta name="keywords" content="körkort, trafikskola, trafikskolor, teoriprov, körkortsprov, jämförelse, moped, bil, motorcykel, MC"> 
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
				<il><a href="index.php">Bil</a></il>
				<il><a href="Korkortsblanketter.php">Körkortsblanketter</a></il>

<il><a href="syntest.php">Syntest</a></il>

<il><a href="handledarutbildning.php">Handledarutbildning</a></il>




				<!--il><a href="index.php">Moppe</a></il -->
				<!--il><a href="index.php">MC</a></il -->
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
			<?php if(isset($_GET['loc']) && isset($_GET['ort']) && !isset($_GET['name'])): ?>
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
			<?php if(isset($_GET['name'])): ?>
					<?php $Skola = $dao->getSkola($_GET['name']); ?>
						<div id="content">
							<div id="contentContainer">
								<div class="Detailstable" style="width:740px;">
									<table>
										<tr> 
											<td>Namn</td>
											<td><?=$Skola->name; ?></td>
										</tr>
										<tr> 
											<td>Adress</td>
											<td><?=$Skola->address; ?></td>
										</tr>
										<tr> 
											<td>Hemsida</td>
											<td><a class="tableDetails" href="<?=$Skola->homepage; ?>"><?=$Skola->homepage; ?></a></td>
										</tr>
										<tr> 
											<td>Telefonnummer</td>
											<td><?=$Skola->tel; ?></td>
										</tr>
										<tr> 
											<td>Pris för körlektion per timme</td>
											<td><?=$Skola->priceLesson;?> KR</td>
										</tr>
										<tr> 
											<td>Pris för riskettan</td>
											<td><?=$Skola->priceRisketta;?> KR</td>
									</tr>
									<tr> 
											<td>Pris för risktvåan (halkbana)</td>
											<td><?=$Skola->priceGuide;?></td>
										</tr>
									</table>
								</div>
								<br /><br />
							</div>
						</div>
					</div>
				</div>
			<?php endif ?>
			
			</div></div></div></div></div></div></div></div></div></div></div></div></div></div></div>
			<!-- Dynamic content - End -->
			<div id="footer">Partner <a class="table3" href="http://makeup.ph">http://makeup.ph</a></div>
		
	</body>
</html>