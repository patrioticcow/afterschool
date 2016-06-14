<?php

class Emojy
{
	public $request = NULL;
	public $get     = NULL;

	/**
	 * Emojy constructor.
	 *
	 * @param null $request
	 * @param null $get
	 *
	 * set some defaults
	 */
	public function __construct($request = NULL, $get = NULL)
	{
		if ($request) $this->request = $request;
		if ($get) $this->get = $get;
	}

	/**
	 * @return mixed
	 *
	 * get the icons from the url
	 */
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

	/**
	 * @param $emojyString
	 *
	 * @return null
	 *
	 *  maps the [EMOJIS] to unique INTEGER
	 */
	public function getEmojyMessage($emojyString)
	{
		foreach ($this->parseEmoji() as $v) {
			if (strpos($emojyString, $v['utf8']) !== FALSE) $emojyString = str_replace($v['utf8'], '-' . $v['utf8'] . '-', $emojyString);
		}

		$emojyString = array_filter(explode('-', $emojyString));

		$arr = [];
		foreach ($emojyString as $val) $arr[] = $this->parseEmoji(NULL, $val);

		return $this->toArray($arr);
	}

	/**
	 * @param $emojyString
	 *
	 * @return null
	 *
	 *  maps the [EMOJIS] to unique INTEGER
	 */
	public function getUniqueEmojy($emojyString)
	{
		$arr = [];
		foreach ($this->parseEmoji() as $v) {
			if (strpos($emojyString, $v['utf8']) !== FALSE) $arr[] = $this->parseEmoji(NULL, $v['utf8']);
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
	 * @param null $data
	 *
	 * @return array|null
	 */
	public function getEmojyById($data = NULL)
	{
		if (!$data) return NULL;

		$data   = isset($data[0]) ? $data : [$data];
		$emojis = $this->emojyData();
		$arr    = [];

		foreach ($data as $value) {
			foreach ($emojis as $k => $emoji) {
				if ($emoji['key'] == $value) $arr[] = $emoji;
			}
		}

		return $arr;
	}

	/**
	 * @param null $data
	 *
	 * @return array|null
	 */
	public function getEmojyByValue($data = NULL)
	{
		if (!$data) return NULL;

		$data = is_array($data) ? $data : [$data];
		$emojis = $this->emojyData();
		$arr  = [];

		foreach ($data as $value) {
			$value = str_replace('%', '', urlencode($value));
			foreach ($emojis as $k => $emoji) {
				if ($emoji['utf8'] == $value) $arr[] = $emoji;
			}
		}

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
	public function parseEmoji($key = NULL, $utf8 = NULL, $value = NULL)
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
