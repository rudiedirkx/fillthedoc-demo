<?php

use rdx\fillthedoc\Document;
use rdx\fillthedoc\DocumentType;

require 'inc.bootstrap.php';

if (isset($_POST['document_type_id'])) {
	$type = DocumentType::find($_POST['document_type_id']);
	$meta = $type->createFtdDocument();
	// print_r($meta);
	$doc = $type->createLocalDocument($meta);
	// print_r($doc);
	return do_redirect('document', ['id' => $doc->id]);
}

require 'tpl.header.php';

$types = DocumentType::all('1 ORDER BY name');
$documents = Document::all('1 ORDER BY created_on DESC');

?>
<h1>Koop een document</h1>

<table>
	<thead>
		<tr>
			<th>Type</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<? foreach ($types as $type): ?>
			<tr>
				<td><?= html($type->name) ?></td>
				<td>
					<form method="post" action>
						<input type="hidden" name="document_type_id" value="<?= html($type->id) ?>" />
						<button>koop</button>
					</form>
				</td>
			</tr>
		<? endforeach ?>
	</tbody>
</table>

<h2>Bestaande documenten</h2>

<table>
	<thead>
		<tr>
			<th>Type</th>
			<th>Time</th>
		</tr>
	</thead>
	<tbody>
		<? foreach ($documents as $doc): ?>
			<tr>
				<td><?= html($doc->type->name) ?></td>
				<td>
					<a href="document.php?id=<?= $doc->id ?>">
						<?= date('Y-m-d H:i', $doc->created_on) ?>
					</a>
				</td>
			</tr>
		<? endforeach ?>
	</tbody>
</table>

<?php

require 'tpl.footer.php';
