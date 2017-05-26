<?php

namespace Flowpaper\Lib;
/**
 * █▒▓▒░ The FlowPaper custom
 * Author atta-ul-mohsin (attaulmohsin@gmail.com)
 */

class Splitpdf
{
    private $configManager = null;

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
     * function splitPDF
     *
     * @return
     */
    public function splitPDF($pdfdoc, $subfolder)
    {
        $output = array();
        $command = $this->configManager->getConfig('cmd.conversion.splitpdffile');
        $command = str_replace("{path.pdf}", $this->configManager->getConfig('path.pdf') . $subfolder, $command);
        $command = str_replace("{path.swf}", $this->configManager->getConfig('path.swf') . $subfolder, $command);
        $command = str_replace("{pdffile}", $pdfdoc, $command);

        try {
            $return_var = 0;
            exec($command, $output, $return_var);
            if ($return_var == 1 || $return_var == 0 || (strstr(PHP_OS, "WIN") && $return_var == 1)) {
                return "[OK]";
            } else {
                return "[Error converting splitting PDF, please check your configuration]";
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }
}