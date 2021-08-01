<?php

return [
	'version' => 2,
	'tables' => [
		'document_types' => [
			'id' => ['pk' => true],
			'name',
			'ftd_id',
		],
		'documents' => [
			'id' => ['pk' => true],
			'created_on',
			'document_type_id' => ['references' => ['document_types', 'id']],
			'ftd_id',
			'ftd_data',
		],
	],
];
