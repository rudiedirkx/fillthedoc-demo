<?php

use GuzzleHttp\Client as Guzzle;
use rdx\invoicer\InvoiceLine;

function get_guzzle() {
	return new Guzzle([
		'headers' => [
			'Authorization' => 'Bearer ' . FTD_API_KEY,
			'User-agent' => 'FTD DEMO',
		],
		'http_errors' => false,
	]);
}

function get_url( $path, $query = array() ) {
	$query = $query ? '?' . http_build_query($query) : '';
	$path = $path ? $path . '.php' : basename($_SERVER['SCRIPT_NAME']);
	return $path . $query;
}

function do_redirect( $path, $query = array() ) {
	$url = get_url($path, $query);
	header('Location: ' . $url);
}

function html_asset( $src ) {
	$buster = '?_' . filemtime($src);
	return $src . $buster;
}

function html_options( $options, $selected = null, $empty = '' ) {
	$selected = (array) $selected;

	$html = '';
	$empty && $html .= '<option value="">' . $empty;
	foreach ( $options AS $value => $label ) {
		$isSelected = in_array($value, $selected) ? ' selected' : '';
		$html .= '<option value="' . html($value) . '"' . $isSelected . '>' . html($label) . '</option>';
	}
	return $html;
}

function html( $text ) {
	return htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8') ?: htmlspecialchars((string)$text, ENT_QUOTES, 'ISO-8859-1');
}
