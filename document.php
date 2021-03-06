<?php

use rdx\fillthedoc\Document;
use rdx\fillthedoc\DocumentType;

require 'inc.bootstrap.php';

$doc = Document::find($_GET['id'] ?? 0);
if (!$doc) exit("Missing document");

if (in_array($download = ($_GET['download'] ?? ''), ['pdf', 'html'], true)) {
	$rsp = get_guzzle()->get($doc->ftd_data['links'][$download]);
	if ($rsp->getStatusCode() != 200) {
		print_r($rsp);
		echo $rsp->getBody();
		exit;
	}

	$content = (string) $rsp->getBody();

	header('Content-type: ' . (['pdf' => 'application/pdf', 'html' => 'text/html'][$download]));
	echo $content;
	exit;
}

require 'tpl.header.php';

?>
<style>
iframe {
	box-sizing: border-box;
	border: solid 1px green;
	width: 100%;
	height: 400px;
}
</style>

<h1><?= html($doc->type->name) ?> - <?= date('Y-m-d H:i', $doc->created_on) ?></h1>

<p><a href="?id=<?= $doc->id ?>&download=pdf">Download PDF</a></p>
<p><a href="?id=<?= $doc->id ?>&download=html">Download HTML</a></p>

<hr />

<iframe src="<?= html($doc->ftd_data['links']['edit']) ?>" frameborder="0"></iframe>

<script>
window.addEventListener("message", function(e) {
    console.log(e, e.data);
}, false);
</script>

<hr />

<? dump($doc) ?>
<?php

require 'tpl.footer.php';
