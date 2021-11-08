<?php

namespace JPNS\Basic\http;

class HTTP {
	/**
	 * Send GET http-request
	 * @param string $url api request url
	 * @param string $content_type content type of request
	 */
	static public function get($url, $content_type='application/json') {
		$headers = array('Content-Type: ' . $content_type, 'Cache-Control: no-cache');
		$curl = curl_init($url);

		// Always send no-cache curl requests
		curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
		curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

		$response = curl_exec($curl);
		$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		if(curl_errno($curl)){
			echo 'Curl error: ' . curl_error($curl);
		}
		curl_close($curl);

		$result = ['response' => json_decode($response), 'code' => $httpCode];
		return json_encode($result);
	}

	/**
	 * Send POST http-request
	 * @param string  $url api request url
	 * @param array   $data array with request data
	 * @param string  $content_type content type of request
	 * @param boolean $code if true returns code of response, if false - returns body of response
	 */
	static public function post($url, $data, $content_type='application/json') {
		$headers = array('Content-Type: ' . $content_type, 'Cache-Control: no-cache');

		$curl = curl_init($url);

		// Always send no-cache curl requests
		curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
		curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 0);

		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

		$response = curl_exec($curl);
		$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		if(curl_errno($curl)){
			echo 'Curl error: ' . curl_error($curl);
		}
		curl_close($curl);

		$result = ['response' => json_decode($response), 'code' => $httpCode];
		return json_encode($result);
	}

	static public function delete($url) {
		$headers = array('Content-Type: application/json', 'Cache-Control: no-cache');
		$curl = curl_init($url);

		// Always send no-cache curl requests
		curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
		curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 0);

		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$response = curl_exec($curl);
		$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		curl_close($curl);

		$result = ['response' => json_decode($response), 'code' => $httpCode];
		return json_encode($result);
	}


	static public function patch($url, $data, $content_type='application/json') {
		$headers = array('Content-Type: ' . $content_type, 'Cache-Control: no-cache');
		$curl = curl_init();

		// Always send no-cache curl requests
		curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
		curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 0);

		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		$response = curl_exec($curl);
		curl_close($curl);

		return $response;
	}


	static public function file($url, $file, $mime, $file_name) {
		$headers = array('Content-Type: application/json', 'Cache-Control: no-cache');
		$curl = curl_init($url);

		// Always send no-cache curl requests
		curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
		curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 0);

		curl_setopt($curl, CURLOPT_POST, true);

		$fields = [
			'data' => new \CurlFile($file, $mime, $file_name)
		];
		curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));

		$response = curl_exec($curl);
		curl_close($curl);

		return $response;
	}
}