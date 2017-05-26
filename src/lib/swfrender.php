<?php

namespace Flowpaper\Lib;
/**
 * █▒▓▒░ The FlowPaper custom
 * Author atta-ul-mohsin (attaulmohsin@gmail.com)
 */
class Swfrender
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
     * function renderPage
     *
     * @return
     */
    public function renderPage($pdfdoc, $swfdoc, $page, $subfolder)
    {
        $output = array();

        try {
            if ($this->configManager->getConfig('splitmode') == 'true') {
                $command = $this->configManager->getConfig('cmd.conversion.rendersplitpage');
            } else {
                $command = $this->configManager->getConfig('cmd.conversion.renderpage');
            }
            $command = str_replace("{path.swf}", $this->configManager->getConfig('path.swf') . $subfolder, $command);
            $command = str_replace("{swffile}", $swfdoc, $command);
            $command = str_replace("{pdffile}", $pdfdoc, $command);
            $command = str_replace("{page}", $page, $command);

            $return_var = 0;
            exec($command, $output, $return_var);
            if ($return_var == 0) {
                return "[OK]";
            } else {
                return "[Error converting PDF to PNG, please check your configuration]";
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }
}