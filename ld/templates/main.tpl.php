<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="robots" content="noindex">
		<title>Laisvalaikio Informacinė Sistema</title>
		<link rel="stylesheet" type="text/css" href="scripts/datetimepicker/jquery.datetimepicker.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="style/main.css" media="screen" />
		<script type="text/javascript" src="scripts/jquery-1.12.0.min.js"></script>
		<script type="text/javascript" src="scripts/datetimepicker/jquery.datetimepicker.full.min.js"></script>
		<script type="text/javascript" src="scripts/main.js"></script>
	</head>
	<body>
		<div id="body">
			<div id="header">
				<h3 id="slogan"><a href="index.php">Laisvalaikio Informacinė Sistema</a></h3>
			</div>
			<div id="content">
				<div id="topMenu">
					<ul class="float-left">
						<li><a href="index.php?module=person&action=list" title="Asmenys"<?php if($module == 'person') { echo 'class="active"'; } ?>>Asmenys</a></li>
                        <li><a href="index.php?module=place&action=list" title="Vietos"<?php if($module == 'place') { echo 'class="active"'; } ?>>Vietos</a></li>
						<li><a href="index.php?module=host&action=list" title="Vedejai"<?php if($module == 'host') { echo 'class="active"'; } ?>>Vedejai</a></li>
						<li><a href="index.php?module=participant&action=list" title="Dalyviai"<?php if($module == 'participant') { echo 'class="active"'; } ?>>Dalyviai</a></li>
						<li><a href="index.php?module=dj&action=list" title="Didzejai"<?php if($module == 'dj') { echo 'class="active"'; } ?>>Didžėjai</a></li>
                        <li><a href="index.php?module=report&action=form" title="Report"<?php if($module=='report') {echo 'class="active"';} ?>>Ataskaita</a></li>
				</div>
				<div id="contentMain">
					<?php
						// įtraukiame veiksmų failą
						if(file_exists($actionFile)) {
							include $actionFile;
						}
					?>
					<div class="float-clear"></div>
				</div>
			</div>
			<div id="footer">

			</div>
		</div>
	</body>
</html>