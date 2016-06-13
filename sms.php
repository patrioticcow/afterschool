<?php

$emojyClass = new Emojy($_SERVER['REQUEST_URI'], $_GET);

$emojyIcons = $emojyClass->getEmojy();
$emojyIcons = $emojyClass->getEmojyArray($emojyIcons);

//var_dump($emojyIcons);


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

		//$emojyIcons = urldecode($uri[0]);

		/**
		 * another way of getting the emojy based on the .htaccess rule
		 */
		$emojyIcons = urldecode($this->get['emojy']);

		return $emojyIcons;
	}

	public function getEmojyArray($emojyIcons)
	{
		$emojy = $this->encodeEmoji($emojyIcons);
		$emojy = array_filter(explode(';', $emojy)); // I could have used preg_split

		foreach ($emojy as $val) {
			$val = $val . ';';
			//var_dump($val);
			//var_dump($this->emojyData(12));
			$this->emojyData(NULL, $val);
		}

		return $emojy;
	}

	public function emojyData($key = NULL, $value = NULL)
	{
		$emojis = [
			['key' => 10, 'value' => '&#x2764;'],
			['key' => 11, 'value' => '&#x1F60D;'],
			['key' => 12, 'value' => '&#x1F648;'],
			['key' => 13, 'value' => '&#x1F602;'],
			['key' => 14, 'value' => '&#x1F48B;'],
			['key' => 15, 'value' => '&#x1F60E;'],
			['key' => 16, 'value' => '&#x1F4AF;'],
			['key' => 17, 'value' => '&#x1F609;'],
			['key' => 18, 'value' => '&#x1F605;'],
			['key' => 19, 'value' => '&#x1F608;'],
			['key' => 20, 'value' => '&#x1F61C;'],
			['key' => 21, 'value' => '&#x1F389;'],
			['key' => 22, 'value' => '&#x1F60B;'],
			['key' => 23, 'value' => '&#x1F388;'],
			['key' => 24, 'value' => '&#x1F603;'],
			['key' => 25, 'value' => '&#x1F60F;'],
		];

		if ($key) {
			foreach ($emojis as $k => $emoji) {
				if ($emoji['key'] == $key) return $emojis[$k];
			}
		}

		if ($value) {
			foreach ($emojis as $k => $emoji) {
				var_dump($value);
				var_dump($emoji['value']);
				var_dump((string)$emoji['value'] == (string)$value);
				var_dump((string)$emoji['value'] === (string)$value);
				var_dump($emoji['value'] === '&#x1f605;');
				var_dump($value === '&#x1f605;');
				var_dump('-------------------');
				if ($emoji['value'] == $value) {
					return $emojis[$k];
				}
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