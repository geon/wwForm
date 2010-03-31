<?php
	foreach(array(
		'TITLE' => '',
		'KEYWORDS' => 'wwForm, HTML, from, validation, rendering',
		'DESCRIPTION' => '',
	) as $Name => $Value)
		if(!defined($Name)) define($Name, $Value);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="sv">
	<head>
		<!--
         ___________                                             _
        |____   ____|                                           | |
             | |   ____    _____     _______     ____    _____  | |__
             | |  / __ \  |  __ \   / _   _ \   / __ \  /  ___| |  __|
             | | | /  \ | | |  \ | | | | | | | | /  \ | | |- .  | |   _
             | | | \__/ | | |__/ | | | | | | | | \__/ |  '- | | | \__/ |
             |_|  \____/  |  ___/  |_| |_| |_|  \____/  |____/   \____/
                          | |
                          |_|           Topmost 2010  *  www.topmost.se
		-->
		<title><?php print(htmlspecialchars(TITLE)); ?></title>
		<meta name="keywords" content="<?php print(htmlspecialchars(KEYWORDS)); ?>" />
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<meta name="description" content="<?php print(htmlspecialchars(DESCRIPTION)); ?>" />
		<link rel="stylesheet" type="text/css" media="screen" href="../wwForm.css" />
	</head>
	<body>
		<div id="<?php print(PAGE_ID); ?>">
