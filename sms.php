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

	public function getEmojyArray($emojyIcons)
	{
		$emojy = $this->encodeEmoji($emojyIcons);
		var_dump($emojyIcons);
		var_dump($emojy);
		$emojy = array_filter(explode(';', $emojy)); // I could have used preg_split

		$arr = [];
		foreach ($emojy as $val) {
			$val   = $val . ';';
			$arr[] = $this->emojyData(NULL, $val);
		}

		return empty($arr) ? NULL : $arr;
	}

	/**
	 * @param null $key
	 * @param null $value
	 *
	 * http://apps.timwhitlock.info/unicode/inspect?s=%E2%9D%A4
	 *
	 * @return array|mixed
	 */
	public function emojyData($key = NULL, $value = NULL)
	{
		$emojis = [
			['key' => 10, 'value' => '&#x2764;' , 'utf8' => 'E29DA4'],
			['key' => 11, 'value' => '&#x1F60D;', 'utf8' => 'F09F988D'],
			['key' => 12, 'value' => '&#x1F648;', 'utf8' => '%E2%9D%A4'],
			['key' => 13, 'value' => '&#x1F602;', 'utf8' => '%E2%9D%A4'],
			['key' => 14, 'value' => '&#x1F48B;', 'utf8' => '%E2%9D%A4'],
			['key' => 15, 'value' => '&#x1F60E;', 'utf8' => '%E2%9D%A4'],
			['key' => 16, 'value' => '&#x1F4AF;', 'utf8' => '%E2%9D%A4'],
			['key' => 17, 'value' => '&#x1F609;', 'utf8' => '%E2%9D%A4'],
			['key' => 18, 'value' => '&#x1F605;', 'utf8' => '%E2%9D%A4'],
			['key' => 19, 'value' => '&#x1F608;', 'utf8' => '%E2%9D%A4'],
			['key' => 20, 'value' => '&#x1F61C;', 'utf8' => '%E2%9D%A4'],
			['key' => 21, 'value' => '&#x1F389;', 'utf8' => '%E2%9D%A4'],
			['key' => 22, 'value' => '&#x1F60B;', 'utf8' => '%E2%9D%A4'],
			['key' => 23, 'value' => '&#x1F388;', 'utf8' => '%E2%9D%A4'],
			['key' => 24, 'value' => '&#x1F603;', 'utf8' => '%E2%9D%A4'],
			['key' => 25, 'value' => '&#x1F60F;', 'utf8' => '%E2%9D%A4'],
		];

		if ($key) {
			foreach ($emojis as $k => $emoji) {
				if ($emoji['key'] == $key) return $emojis[$k];
			}
		}

		if ($value) {
			foreach ($emojis as $k => $emoji) {
				if (strtolower($emoji['value']) == strtolower($value)) return $emojis[$k];
			}
		}

		return $emojis;
	}

	public function encodeEmoji($content)
	{
		if (function_exists('mb_convert_encoding')) {
			$regex = '/(
		     \x23\xE2\x83\xA3               # Digits
		     [\x30-\x39]\xE2\x83\xA3
		   | \xF0\x9F[\x85-\x88][\xA6-\xBF] # Enclosed characters
		   | \xF0\x9F[\x8C-\x97][\x80-\xBF] # Misc
		   | \xF0\x9F\x98[\x80-\xBF]        # Smilies
		   | \xF0\x9F\x99[\x80-\x8F]
		   | \xF0\x9F\x9A[\x80-\xBF]        # Transport and map symbols
		)/x';

			$matches = array();
			if (preg_match_all($regex, $content, $matches)) {
				if (!empty($matches[1])) {
					foreach ($matches[1] as $emoji) {
						$unpacked = unpack('H*', mb_convert_encoding($emoji, 'UTF-32', 'UTF-8'));
						if (isset($unpacked[1])) {
							$entity  = '&#x' . ltrim($unpacked[1], '0') . ';';
							$content = str_replace($emoji, $entity, $content);
						}
					}
				}
			}
		}

		return $content;
	}
}

$emojyClass = new Emojy($_SERVER['REQUEST_URI'], $_GET);

$emojyIcons = $emojyClass->getEmojy();
$emojyIcons = $emojyClass->getEmojyArray($emojyIcons);
$emojyIcons = $emojyIcons ? (isset($emojyIcons[0]) ? $emojyIcons : [$emojyIcons]) : NULL;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>After School Test</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" crossorigin="anonymous">
</head>
<body>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="jumbotron">
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
					<p>No results</p>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

</body>
</html>

