<?php

if (!function_exists('getallheaders')) {

	/**
	 * Get all HTTP header key/values as an associative array for the current request.
	 *
	 * @return string[string] The HTTP header key/value pairs.
	 */
	function getallheaders()
	{
		$headers = array();
		foreach ($_SERVER as $key => $value) {
			if (substr($key, 0, 5) == 'HTTP_') {
				$key = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($key, 5)))));
				$headers[$key] = $value;
			} elseif ($key == "CONTENT_TYPE") {
				$headers["Content-Type"] = $value;
			} elseif ($key == "CONTENT_LENGTH") {
				$headers["Content-Length"] = $value;
			}
		}
		return $headers;
	}

}
