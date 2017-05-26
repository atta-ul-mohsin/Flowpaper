<?php

namespace Flowpaper\Services;
/**
 * █▒▓▒░ The FlowPaper custom
 * Author atta-ul-mohsin (attaulmohsin@gmail.com)
 *
 * Document page counter file for PHP. Accepts parameters 'doc'
 * Executes specified conversion command if the document has not yet been
 * converted and returns the number of pages in the converted document
*/
use Flowpaper\Lib\Config;
use Flowpaper\Lib\Common;
use Flowpaper\Lib\Pdf2swf;

$configManager = new Config();
$doc=$_GET["doc"];
$page = "1";
$swfFilePath = $configManager->getConfig('path.swf') . $doc  . $page. ".swf";
$pdfFilePath = $configManager->getConfig('path.pdf') . $doc;
$output = "";

if(glob($configManager->getConfig('path.swf') . $doc . "*")!=false)
	$pagecount = count(glob($configManager->getConfig('path.swf') . $doc . "*" . ".swf"));
else
	$pagecount = 0;

if($pagecount == 0 && validPdfParams($pdfFilePath,$doc,$page)){
	$pdfconv=new pdf2swf();
	$output=$pdfconv->convert($doc,$page);
	
	if(rtrim($output) === "[Converted]")
		$pagecount = count(glob($configManager->getConfig('path.swf') . $doc . "*"));
}else{
	$output = "Incorrect document file specified, file may not exist or insufficient permissions to read file" . $configManager->getDocUrl();
}

if($pagecount!=0)
	echo $pagecount;
else
	echo $output;
?>