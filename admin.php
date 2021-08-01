<?php

use rdx\fillthedoc\DocumentType;

require 'inc.bootstrap.php';

if (isset($_POST['new_doc'])) {
	DocumentType::insert($_POST['new_doc']);

	return do_redirect('index');
}

$types = DocumentType::all('1 ORDER BY name');

require 'tpl.header.php';

?>
<h2>Document types</h2>

<table>
	<thead>
		<tr>
			<th>Name</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<? foreach ($types as $type): ?>
			<tr>
				<td><?= html($type->name) ?></td>
				<td>
					<a href="https://fillthedoc.com/admin/templates/<?= html($type->ftd_id) ?>">
						edit in FTD
					</a>
				</td>
			</tr>
		<? endforeach ?>
	</tbody>
</table>

<br>

<form method="post" action>
	<fieldset>
		<legend>Create document type</legend>
		<p>Name: <input required name="new_doc[name]" /></p>
		<p>FTD ID: <input required name="new_doc[ftd_id]" /></p>
		<p><button>Create</button></p>
	</fieldset>
</form>

<h2>Documents</h2>

<?php

require 'tpl.footer.php';
