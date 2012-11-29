<?php
/*
 * Copyright 2010-2012 by MODX, LLC.
 *
 * This file is part of xPDO.
 *
 * xPDO is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * xPDO is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * xPDO; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 */

/**
 * Contains a trait for the xPDOObject class for SQLite.
 *
 * This file contains a trait defining overrides to the xPDOObject class for SQLite,
 * which your user-defined classes will use when implementing an xPDO object model
 * targeted at the SQLite platform.
 *
 * @package xpdo
 * @subpackage om.sqlite
 */
namespace xPDO\om\sqlite;

use xPDO\xPDO;

/**
 * Implements overrides to the base xPDOObject class for SQLite.
 *
 * @package xpdo
 * @subpackage om.sqlite
 */
trait xPDOObject {
    /**
     * Register the map for this class in an xPDO instance.
     *
     * @param \xPDO\xPDO $xpdo
     */
    public static function map(xPDO &$xpdo) {
        $xpdo->map['xPDO\\om\\xPDOObject'] = $xpdo->map[__CLASS__] = array(
            'table' => null,
            'fields' => array(),
            'fieldMeta' => array(),
            'indexes' => array()
        );
    }
}
