<?php

namespace Flowpaper\Services;
/**
 * █▒▓▒░ The FlowPaper custom
 * Author atta-ul-mohsin (attaulmohsin@gmail.com)
 *
 * SWF text extraction for PHP. Executes the specified text extraction
 * executable and returns the output
*/
use Swfextract;
$doc=$_GET["doc"] . ".pdf";
$page=$_GET["page"];
$searchterm=$_GET["searchterm"];
$swfextract=new swfextract();
echo $swfextract->findText($doc,$page,$searchterm);	
?>