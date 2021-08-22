<?php
$file = (isset($_GET['f'])) ? $_GET['f'] : '';
$ids = explode("_", $file);

$objeto = $ids[0];
$url = (isset($ids[1])) ? $ids[1] : "";
$archivo = URL_PRIVATE . "{$objeto}/{$url}";

if(file_exists($archivo)) {
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$mime = finfo_file($finfo, $archivo);
	finfo_close($finfo);
	header("Content-Type: {$mime}");
	ob_end_clean();
	$imagen = readfile($archivo);
} elseif ($objeto == 0) {
	$archivo = URL_PRIVATE . "common/imagenes/image_pdf.png";
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$mime = finfo_file($finfo, $archivo);
	finfo_close($finfo);
	header("Content-Type: $mime");
	$imagen = readfile($archivo);
} else {
	$archivo = URL_PRIVATE . "common/imagenes/no_image.png";
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$mime = finfo_file($finfo, $archivo);
	finfo_close($finfo);
	header("Content-Type: $mime");
	$imagen = readfile($archivo);
}
?>