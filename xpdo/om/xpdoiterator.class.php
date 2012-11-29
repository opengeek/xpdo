<?php
namespace xPDO\om;

use PDO;
use PDOStatement;
use Iterator;
use xPDO\xPDO;

/**
 * An iteratable representation of an xPDOObject result set.
 *
 * Use an xPDOIterator to loop over large result sets and work with one instance
 * at a time. This greatly reduces memory usage over loading the entire collection
 * of objects into memory at one time. It is also slightly faster.
 *
 * @package xpdo
 */
class xPDOIterator implements Iterator {
    /** @var null|\xPDO\xPDO */
    private $xpdo = null;
    private $index = 0;
    private $current = null;
    /** @var \PDOStatement */
    private $stmt;
    private $class = null;
    private $alias = null;
    /** @var \xPDO\om\xPDOCriteria|\xPDO\om\xPDOQuery */
    private $criteria = null;
    private $criteriaType = 'xPDOQuery';
    private $cacheFlag = false;

    /**
     * Construct a new xPDOIterator instance (do not call directly).
     *
     * @see xPDO::getIterator()
     * @param xPDO &$xpdo A reference to a valid xPDO instance.
     * @param array $options An array of options for the iterator.
     * @return xPDOIterator An xPDOIterator instance.
     */
    function __construct(& $xpdo, array $options= array()) {
        $this->xpdo =& $xpdo;
        if (isset($options['class'])) {
            $this->class = $this->xpdo->loadClass($options['class']);
        }
        if (isset($options['alias'])) {
            $this->alias = $options['alias'];
        } else {
            $this->alias = $this->class;
        }
        if (isset($options['cacheFlag'])) {
            $this->cacheFlag = $options['cacheFlag'];
        }
        if (array_key_exists('criteria', $options) && is_object($options['criteria'])) {
            $this->criteria = $options['criteria'];
        } elseif (!empty($this->class)) {
            $criteria = array_key_exists('criteria', $options) ? $options['criteria'] : null;
            $this->criteria = $this->xpdo->getCriteria($this->class, $criteria, $this->cacheFlag);
        }
        if (!empty($this->criteria)) {
            $this->criteriaType = $this->xpdo->getCriteriaType($this->criteria);
            if ($this->criteriaType === 'xPDOQuery') {
                $this->class = $this->criteria->getClass();
                $this->alias = $this->criteria->getAlias();
            }
        }
    }

    public function rewind() {
        $this->index = 0;
        if (!empty($this->stmt)) {
            $this->stmt->closeCursor();
        }
        $this->stmt = $this->criteria->prepare();
        if ($this->stmt && $this->stmt->execute()) {
            $this->fetch();
        }
    }

    public function current() {
        return $this->current;
    }

    public function key() {
        return $this->index;
    }

    public function next() {
        if ($this->fetch()) {
            $this->index++;
        } else {
            $this->index = null;
        }
        return $this->current();
    }

    public function valid() {
        return ($this->current !== null);
    }

    /**
     * Fetch the next row from the result set and set it as current.
     *
     * Calls the _loadInstance() method for the specified class, so it properly
     * inherits behavior from xPDOObject derivatives.
     *
     * @return bool
     */
    protected function fetch() {
        $row = $this->stmt->fetch(PDO::FETCH_ASSOC);
        if (is_array($row) && !empty($row)) {
            $this->current = $this->xpdo->call($this->class, '_loadInstance', array(& $this->xpdo, $this->class, $this->alias, $row));
        } else {
            $this->current = null;
        }
        return $this->valid();
    }
}
