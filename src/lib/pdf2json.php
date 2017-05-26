<?php

namespace Flowpaper\Lib;
/**
 * █▒▓▒░ The FlowPaper custom
 * Author atta-ul-mohsin (attaulmohsin@gmail.com)
 */

class Pdf2Json
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
        //echo "swfextract destructed\n";
    }

    /**
     * function convert
     *
     * Description: render page as image
     * @return
     */
    public function convert($pdfdoc, $jsondoc, $page, $subfolder)
    {
        $output = array();

        try {
            if ($this->configManager->getConfig('splitmode') == 'true') {
                $command = $this->configManager->getConfig('cmd.conversion.splitjsonfile');
            } else {
                $command = $this->configManager->getConfig('cmd.conversion.jsonfile');
            }

            $command = str_replace("{path.pdf}", $this->configManager->getConfig('path.pdf') . $subfolder, $command);
            $command = str_replace("{path.swf}", $this->configManager->getConfig('path.swf') . $subfolder, $command);
            $command = str_replace("{pdffile}", $pdfdoc, $command);
            $command = str_replace("{jsonfile}", $jsondoc, $command);

            $return_var = 0;

            exec($command, $output, $return_var);

            if ($return_var == 0) {
                return "[OK]";
            } else {
                return "[Error converting PDF to JSON, please check your directory permissions and configuration]";
            }
        } catch (Exception $ex) {
            return "[" . $ex . "]";
        }
    }
}