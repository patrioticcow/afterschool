<?php

class Emojy
{
	public $request = NULL;
	public $get     = NULL;

	public function __construct($request = NULL, $get = NULL)
	{
		if ($request) $this->request = $request;
		if ($get) $this->get = $get;
	}

	public function getEmojy()
	{
		/**
		 * One way of getting the emojy based on the REQUEST_URI
		 * explode the URI to get the first part witch are the emoji icons,
		 * also reset the array and remove empty values
		 */
		//$uri = array_values(array_filter(explode('/', $this->request)));
		//if (!isset($uri[0])) return NULL;

		//$emojyIcons = $uri[0];

		/**
		 * another way of getting the emojy based on the .htaccess rule
		 */
		$emojyIcons = urlencode($this->get['emojy']);

		return str_replace('%', '', $emojyIcons);
	}

	public function getEmojyMessage($emojyString)
	{
		foreach ($this->parseEmojy() as $v) {
			if (strpos($emojyString, $v['utf8']) !== FALSE) $emojyString = str_replace($v['utf8'], '-' . $v['utf8'] . '-', $emojyString);
		}

		$emojyString = array_filter(explode('-', $emojyString));

		$arr = [];
		foreach ($emojyString as $val) $arr[] = $this->parseEmojy(NULL, $val);

		return $this->toArray($arr);
	}

	public function getUniqueEmojy($emojyString)
	{
		$arr = [];
		foreach ($this->parseEmojy() as $v) {
			if (strpos($emojyString, $v['utf8']) !== FALSE) $arr[] = $this->parseEmojy(NULL, $v['utf8']);
		}

		return $this->toArray($arr);
	}

	public function toArray($arr = NULL)
	{
		if (!$arr) return NULL;
		if (empty($arr)) return NULL;

		return $arr;
	}

	/**
	 * @param null $key
	 * @param null $utf8
	 * @param null $value
	 *
	 * http://apps.timwhitlock.info/unicode/inspect?s=%E2%9D%A4
	 *
	 * @return array|mixed
	 */
	public function parseEmojy($key = NULL, $utf8 = NULL, $value = NULL)
	{
		$emojis = $this->emojyData();

		if ($key) {
			foreach ($emojis as $k => $emoji) {
				if ($emoji['key'] == $key) return $emojis[$k];
			}
		}

		if ($utf8) {
			foreach ($emojis as $k => $emoji) {
				if (strtolower($emoji['utf8']) == strtolower($utf8)) return $emojis[$k];
			}
		}

		if ($value) {
			foreach ($emojis as $k => $emoji) {
				if (strtolower($emoji['value']) == strtolower($value)) return $emojis[$k];
			}
		}

		return $emojis;
	}

	public function emojyData()
	{
		return [
			['key' => 10, 'utf8' => 'E29DA4', 'value' => '&#x2764;'],
			['key' => 11, 'utf8' => 'F09F988D', 'value' => '&#x1F60D;'],
			['key' => 12, 'utf8' => 'F09F9988', 'value' => '&#x1F648;'],
			['key' => 13, 'utf8' => 'F09F9882', 'value' => '&#x1F602;'],
			['key' => 14, 'utf8' => 'F09F928B', 'value' => '&#x1F48B;'],
			['key' => 15, 'utf8' => 'F09F988E', 'value' => '&#x1F60E;'],
			['key' => 16, 'utf8' => 'F09F92AF', 'value' => '&#x1F4AF;'],
			['key' => 17, 'utf8' => 'F09F9889', 'value' => '&#x1F609;'],
			['key' => 18, 'utf8' => 'F09F9888', 'value' => '&#x1F608;'],
			['key' => 19, 'utf8' => 'F09F989C', 'value' => '&#x1F61C;'],
			['key' => 20, 'utf8' => 'F09F8E89', 'value' => '&#x1F389;'],
			['key' => 21, 'utf8' => 'F09F988B', 'value' => '&#x1F60B;'],
			['key' => 22, 'utf8' => 'F09F8E88', 'value' => '&#x1F388;'],
			['key' => 23, 'utf8' => 'F09F9883', 'value' => '&#x1F603;'],
			['key' => 24, 'utf8' => 'F09F988F', 'value' => '&#x1F60F;'],
			['key' => 25, 'utf8' => 'F09F9885', 'value' => '&#x1F605;'],
		];
	}
}

$emojyClass   = new Emojy($_SERVER['REQUEST_URI'], $_GET);
$emojyString  = $emojyClass->getEmojy();
$emojyMessage = $emojyClass->getEmojyMessage($emojyString);
$emojyIcons   = $emojyClass->getUniqueEmojy($emojyString);
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
			</div>
			<div class="jumbotron">
				<p>All Emoji Message</p>
				<?php if ($emojyMessage) { ?>
					<table class="table">
						<tr>
							<td>Key</td>
							<td>Value</td>
						</tr>
						<?php foreach ($emojyMessage as $emojy) { ?>
							<tr>
								<td><?php echo $emojy['key']; ?></td>
								<td><?php echo $emojy['value']; ?></td>
							</tr>
						<?php } ?>
					</table>
				<?php } else { ?>
					<p>No Results</p>
				<?php } ?>
			</div>

			<div class="jumbotron">
				<p>Unique Emoji</p>
				<?php if ($emojyIcons) { ?>
					<table class="table">
						<tr>
							<td>Key</td>
							<td>Value</td>
						</tr>
						<?php foreach ($emojyIcons as $emojy) { ?>
							<tr>
								<td><?php echo $emojy['key']; ?></td>
								<td><?php echo $emojy['value']; ?></td>
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

</body>
</html>