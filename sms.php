<?php
require_once 'emoji.php';

// instantiate the class
$emojyClass = new Emojy($_SERVER['REQUEST_URI'], $_GET);

// get the icons from the url
$messageString = $emojyClass->getEmojy();

$emojyMessage = $emojyClass->getEmojyMessage($messageString);
$emojyIcons   = $emojyClass->getUniqueEmojy($messageString);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>AS Test</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" crossorigin="anonymous">
</head>
<body>
<br>
<br>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="jumbotron">
				<p><strong>Test Url</strong> <a href="/❤😍🙈😂💋😎💯😉😈😜🎉😋🎈😃😏😅/LowellHighSchool"><?php echo $_SERVER['HTTP_HOST']; ?>/❤😍🙈😂💋😎💯😉😈😜🎉😋🎈😃😏😅/LowellHighSchool</a></p>
				<p><strong>Query:</strong> <?php echo $_GET['query']; ?></p>
				<br>
				<p>
					<small>Some methods that can be used</small>
				</p>
				<table class="table">
					<tr>
						<td>Get data by id</td>
						<td><code>$emojyClass->getEmojyById(10);</code></td>
					</tr>
					<tr>
						<td>Get data by id</td>
						<td><code>$emojyClass->getEmojyById(10);</code></td>
					</tr>
					<tr>
						<td>Get data by emoji</td>
						<td><code>$emojyClass->getEmojyById([10, 11, 12]);</code></td>
					</tr>
					<tr>
						<td>Get data by emoji</td>
						<td><code>$emojyClass->getEmojyByValue('❤');</code></td>
					</tr>
					<tr>
						<td>Get data by emoji</td>
						<td><code>$emojyClass->getEmojyByValue(['❤', '😍', '🙈']);</code></td>
					</tr>
					<tr>
						<td>Get data by emoji message</td>
						<td><code>$emojyClass->getEmojyMessage($messageString);</code></td>
					</tr>
					<tr>
						<td>Get data by unique emoji message</td>
						<td><code>$emojyClass->getUniqueEmojy($messageString);</code></td>
					</tr>
				</table>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="jumbotron">
						<p>All Emoji Message</p>
						<?php if ($emojyMessage) { ?>
							<table class="table">
								<tr>
									<td>Key</td>
									<td>Value</td>
									<td>UTF8</td>
									<td>Value</td>
								</tr>
								<?php foreach ($emojyMessage as $emojy) { ?>
									<tr>
										<td><?php echo $emojy['key']; ?></td>
										<td><?php echo $emojy['value']; ?></td>
										<td><code><?php echo $emojy['utf8']; ?></code></td>
										<td><code><?php echo str_replace(['&#x', ';'], '', $emojy['value']); ?></code></td>
									</tr>
								<?php } ?>
							</table>
						<?php } else { ?>
							<p>No Results</p>
						<?php } ?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="jumbotron">
						<p>Unique Emoji</p>
						<?php if ($emojyIcons) { ?>
							<table class="table">
								<tr>
									<td>Key</td>
									<td>Value</td>
									<td>UTF8</td>
									<td>Value</td>
								</tr>
								<?php foreach ($emojyIcons as $emojy) { ?>
									<tr>
										<td><?php echo $emojy['key']; ?></td>
										<td><?php echo $emojy['value']; ?></td>
										<td><code><?php echo $emojy['utf8']; ?></code></td>
										<td><code><?php echo str_replace(['&#x', ';'], '', $emojy['value']); ?></code></td>
									</tr>
								<?php } ?>
							</table>
						<?php } else { ?>
							<p>No Results</p>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

</body>
</html>