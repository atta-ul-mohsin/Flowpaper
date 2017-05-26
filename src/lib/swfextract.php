<?php

namespace Flowpaper\Lib;
/**
 * █▒▓▒░ The FlowPaper custom
 * Author atta-ul-mohsin (attaulmohsin@gmail.com)
 */

class Swfextract
{
    private $configManager = null;
    private $pdftoolsPath;

    /**
     * function __construct
     *
     * @return
     */
    public function __construct()
    {
        $this->configManager = new Config();
    }

    /**
     * function __destruct
     *
     * @return
     */
    public function __destruct()
    {
    }

    /**
     * function findText
     *
     * @return
     */
    public function findText($doc, $page, $searchterm, $numPages = -1)
    {
        $output = array();
        if (strlen($searchterm) == 0) {
            return "[{\"page\":-1, \"position\":-1}]";
        }

        try {
            $swf_file = $this->configManager->getConfig('path.swf') . $doc . "_" . $page . ".swf";
            if (!file_exists($swf_file)) {
                return "[{\"page\":-1, \"position\":-1}]";
            }

            // check for directory traversal & access to non pdf files and absurdely long params
            $pdfFilePath = $this->configManager->getConfig('path.pdf') . $doc;
            if ($numPages == -1) {
                $pagecount = count(glob($this->configManager->getConfig('path.swf') . $doc . "*"));
            } else {
                $pagecount = $numPages;
            }

            if (!validPdfParams($pdfFilePath, $doc, $page))
                return;

            $command = $this->configManager->getConfig('cmd.searching.extracttext');
            $command = str_replace("{swffile}", $this->configManager->getConfig('path.swf') . $doc . "_" . $page . ".swf", $command);
            $return_var = 0;

            exec($command, $output, $return_var);

            $pos = strpos(strtolower(arrayToString($output)), strtolower($searchterm));
            if ($return_var == 0 && $pos > 0) {
                return "[{\"page\":" . $page . ", \"position\":" . $pos . "}]";
            } else {
                if ($page < $pagecount) {
                    $page++;
                    return $this->findText($doc, $page, $searchterm, $pagecount);
                } else {
                    return "[{\"page\":-1, \"position\":-1}]";
                }
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }
}