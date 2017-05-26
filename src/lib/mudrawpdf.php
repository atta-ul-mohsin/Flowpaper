<?php

namespace Flowpaper\Lib;
/**
 * █▒▓▒░ The FlowPaper custom
 * Author atta-ul-mohsin (attaulmohsin@gmail.com)
 */

class Mudrawpdf
{
    private $configManager = null;

    /**
     * function __construct
     *
     * @return
     */
    function __construct()
    {
        $this->configManager = new Config();
    }

    /**
     * function __destruct
     *
     * @return
     */
    function __destruct()
    {

    }

    /**
     * function draw
     *
     * @return
     */
    public function draw($pdfdoc, $swfdoc, $page, $subfolder)
    {
        $output = array();
        $command = $this->configManager->getConfig('cmd.conversion.mudraw');
        $command = str_replace("{path.pdf}", $this->configManager->getConfig('path.pdf') . $subfolder, $command);
        $command = str_replace("{path.swf}", $this->configManager->getConfig('path.swf') . $subfolder, $command);
        $command = str_replace("{pdffile}", $pdfdoc, $command);
        $command = str_replace("{page}", $page, $command);

        try {
            $return_var = 0;
            exec($command, $output, $return_var);
            if ($return_var == 1 || $return_var == 0 || (strstr(PHP_OS, "WIN") && $return_var == 1)) {
                return "[OK]";
            } else {
                return "[Error converting PDF using MuDraw, please check your configuration]";
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }
}
?>