<?php

namespace rdx\fillthedoc;

class DocumentType extends Model {

	static $_table = 'document_types';

	public function createFtdDocument() : array {
		$guzzle = new Guzzle([
			'headers' => [
				'Authorization' => 'Bearer ' . FTD_API_KEY,
				'User-agent' => 'FTD DEMO',
			],
			'http_errors' => false,
		]);
		$rsp = $guzzle->post('https://fillthedoc.com/api/documents', [
			'form_params' => [
				'template' => $this->ftd_id,
				'callback' => 'https://webblocks.nl/_http_server.php',
			],
		]);
		if ($rsp->getStatusCode() != 200) {
			print_r($rsp);
			echo $rsp->getBody();
			exit;
		}

		$json = (string) $rsp->getBody();
		return json_decode($json, true);
	}

	public function createLocalDocument(array $meta) : Document {
		$id = Document::insert([
			'created_on' => time(),
			'document_type_id' => $this->id,
			'ftd_id' => $meta['id'],
			'ftd_data' => json_encode($meta),
		]);
		return Document::find($id);
	}

}
