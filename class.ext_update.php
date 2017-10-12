<?php


use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Update class for the extension manager.
 *
 * @package    TYPO3
 * @subpackage metaseo
 */
class ext_update
{


    /**
     * @var \TYPO3\CMS\Core\Database\DatabaseConnection
     */
    protected $databaseConnection;

    // ########################################################################
    // Methods
    // ########################################################################

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->databaseConnection = $GLOBALS['TYPO3_DB'];
    }

    /**
     * Main update function called by the extension manager.
     *
     * @return string
     */
    public function main()
    {
        $this->processUpdates();

        $ret = $this->generateOutput();

        return $ret;
    }

    /**
     * Called by the extension manager to determine if the update menu entry
     * should be shown.
     *
     * @return bool
     */
    public function access()
    {
        return true;
    }


    /**
     * The actual update function. Add your update task in here.
     */
    protected function processUpdates()
    {
        $this->migrateDatabaseTableField(
            'tt_content',
            'ws_textmedia_bootstrap_image_size',
            'ws_textmedia_bootstrap_image_size_md'
        );
        $this->processClearCache();
    }

    /**
     * Clear cache
     */
    protected function processClearCache()
    {

        if ($this->clearCache) {

            // Init TCE
            $TCE        = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\DataHandling\\DataHandler');
            $TCE->admin = 1;
            $TCE->clear_cacheCmd('all');

            // Add msg
            $msgTitle  = 'Clearing TYPO3 cache';
            $msgStatus = FlashMessage::INFO;
            $msgText   = 'Cleared all caches due migration';

            $this->addMessage($msgStatus, $msgTitle, $msgText);
        }
    }

    /**
     * Add message
     *
     * @param integer $status  Status code
     * @param string  $title   Title
     * @param string  $message Message
     */
    protected function addMessage($status, $title, $message)
    {
        if (!empty($message) && is_array($message)) {
            $liStyle = 'style="margin-bottom: 0;"';

            $message = '<ul><li ' . $liStyle . '>' . implode('</li><li ' . $liStyle . '>', $message) . '</li></ul>';
        }

        $this->messageList[] = array($status, $title, $message);
    }

    /**
     * Generate message title from database row (using title and uid)
     *
     * @param   array $row Database row
     *
     * @return  string
     */
    protected function messageTitleFromRow(array $row)
    {
        $ret = array();

        if (!empty($row['title'])) {
            $ret[] = '"' . htmlspecialchars($row['title']) . '"';
        }

        if (!empty($row['uid'])) {
            $ret[] = '[UID #' . htmlspecialchars($row['uid']) . ']';
        }

        return implode(' ', $ret);
    }

    /**
     * Generates output by using flash messages
     *
     * @return string
     */
    protected function generateOutput()
    {
        $output = '';

        foreach ($this->messageList as $message) {
            $flashMessage = GeneralUtility::makeInstance(
                FlashMessage::class,
                $message[2],
                $message[1],
                $message[0]
            );
            $output .= $flashMessage->getMessage();
        }

        return $output;
    }


    /**
     * Renames a tabled field and does some plausibility checks.
     *
     * @param  string $table
     * @param  string $oldFieldName
     * @param  string $newFieldName
     * @return int
     */
    protected function migrateDatabaseTableField($table, $oldFieldName, $newFieldName)
    {
        $title = 'Renaming "' . $table . ':' . $oldFieldName . '" to "' . $table . ':' . $newFieldName . '": ';

        $currentTableFields = $this->databaseConnection->admin_get_fields($table);

        // if field exists then migrate old data
        if ($currentTableFields[$newFieldName]) {
            $sql = 'UPDATE ' . $table . ' SET ' . $newFieldName . ' = ' . $oldFieldName;
            if ($this->databaseConnection->admin_query($sql) === false) {
                $message = ' SQL ERROR: ' . $this->databaseConnection->sql_error();
                $status = FlashMessage::ERROR;
            } else {
                $message = 'Field ' . $table . ':' . $newFieldName . ' already existing and is updated';
                $status = FlashMessage::OK;
            }
        } else {
            $message = ' ERROR: Please run Database compare from install tool, then retry!';
            $status = FlashMessage::ERROR;
        }

        $this->addMessage($status, $title, $message);

        return $status;
    }
}
