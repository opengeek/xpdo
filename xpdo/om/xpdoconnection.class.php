<?php
namespace xPDO\om;

use PDO;
use PDOStatement;
use Exception;
use xPDO\xPDO;

/**
 * Represents a unique PDO connection managed by xPDO.
 *
 * @package xpdo
 */
class xPDOConnection {
    /**
     * @var xPDO A reference to a valid xPDO instance.
     */
    public $xpdo;
    /**
     * @var array An array of configuration options for this connection.
     */
    public $config = array();

    /**
     * @var \PDO The PDO object represented by the xPDOConnection instance.
     */
    public $pdo = null;
    /**
     * @var boolean Indicates if this connection can be written to.
     */
    private $_mutable = true;

    /**
     * Construct a new xPDOConnection instance.
     *
     * @param xPDO $xpdo A reference to a valid xPDO instance to attach to.
     * @param string $dsn A string representing the DSN connection string.
     * @param string $username The database username credentials.
     * @param string $password The database password credentials.
     * @param array $options An array of xPDO options for the connection.
     * @param array $driverOptions An array of PDO driver options for the connection.
     */
    public function __construct(xPDO &$xpdo, $dsn, $username= '', $password= '', $options= array(), $driverOptions= array()) {
        $this->xpdo =& $xpdo;
        if (is_array($this->xpdo->config)) $options= array_merge($this->xpdo->config, $options);
        if (!isset($options[xPDO::OPT_TABLE_PREFIX])) $options[xPDO::OPT_TABLE_PREFIX]= '';
        $this->config= array_merge($options, xPDO::parseDSN($dsn));
        $this->config['dsn']= $dsn;
        $this->config['username']= $username;
        $this->config['password']= $password;
        $driverOptions = is_array($driverOptions) ? $driverOptions : array();
        if (array_key_exists('driverOptions', $this->config) && is_array($this->config['driverOptions'])) {
            $driverOptions = array_merge($this->config['driverOptions'], $driverOptions);
        }
        $this->config['driverOptions']= $driverOptions;
        if (array_key_exists(xPDO::OPT_CONN_MUTABLE, $this->config)) {
            $this->_mutable= (boolean) $this->config[xPDO::OPT_CONN_MUTABLE];
        }
    }

    /**
     * Indicates if the connection can be written to, e.g. INSERT/UPDATE/DELETE.
     *
     * @return bool True if the connection can be written to.
     */
    public function isMutable() {
        return $this->_mutable;
    }

    /**
     * Actually make a connection for this instance via PDO.
     *
     * @param array $driverOptions An array of PDO driver options for the connection.
     * @return bool True if a successful connection is made.
     */
    public function connect($driverOptions = array()) {
        if ($this->pdo === null) {
            if (is_array($driverOptions) && !empty($driverOptions)) {
                $this->config['driverOptions']= array_merge($this->config['driverOptions'], $driverOptions);
            }
            try {
                $this->pdo= new \PDO($this->config['dsn'], $this->config['username'], $this->config['password'], $this->config['driverOptions']);
            } catch (\PDOException $xe) {
                $this->xpdo->log(xPDO::LOG_LEVEL_ERROR, $xe->getMessage(), '', __METHOD__, __FILE__, __LINE__);
                return false;
            } catch (\Exception $e) {
                $this->xpdo->log(xPDO::LOG_LEVEL_ERROR, $e->getMessage(), '', __METHOD__, __FILE__, __LINE__);
                return false;
            }

            $connected= (is_object($this->pdo));
            if ($connected) {
                $connectFile = XPDO_CORE_PATH . 'om/' . $this->config['dbtype'] . '/connect.inc.php';
                if (!empty($this->config['connect_file']) && file_exists($this->config['connect_file'])) {
                    $connectFile = $this->config['connect_file'];
                }
                if (file_exists($connectFile)) include ($connectFile);
            }
            if (!$connected) {
                $this->pdo= null;
            }
        }
        $connected= is_object($this->pdo);
        return $connected;
    }

    public function getOption($key, $options = null, $default = null) {
        return $this->xpdo->getOption($key, array_merge($this->config, $options), $default);
    }
}
