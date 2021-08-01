<?php

namespace rdx\fillthedoc;

class Document extends Model {

	static $_table = 'documents';



	protected function relate_type() {
		return $this->to_one(DocumentType::class, 'document_type_id');
	}



	static public function presave(array &$data) {
		if (isset($data['ftd_data']) && !is_string($data['ftd_data'])) {
			$data['ftd_data'] = json_encode($data['ftd_data'], JSON_UNESCAPED_SLASHES);
		}
	}

	public function init() {
		if (isset($this->ftd_data) && is_string($this->ftd_data)) {
			$this->ftd_data = json_decode($this->ftd_data, true);
		}
	}

}
