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
 * Contains a trait for the xPDOSimpleObject class for MySQL.
 *
 * This file contains a trait providing method and property overrides to the
 * xPDOSimpleObject class for MySQL, defining a database-managed integer primary
 * key field named id.
 *
 * @package xpdo
 * @subpackage om.mysql
 */
namespace xPDO\om\mysql;

use xPDO\xPDO;

/**
* Use this trait to define a class having an integer primary key.
*
* @package xpdo
* @subpackage om.mysql
*/
trait xPDOSimpleObject {
    /**
     * Register the map for this class in an xPDO instance.
     *
     * @param \xPDO\xPDO $xpdo
     */
    public static function map(xPDO &$xpdo) {
        $xpdo->map['xPDO\\om\\xPDOSimpleObject'] = $xpdo->map[__CLASS__] = array(
            'table' => null,
            'fields' => array(
                'id' => null,
            ),
            'fieldMeta' => array(
                'id' => array(
                    'dbtype' => 'INTEGER',
                    'phptype' => 'integer',
                    'null' => false,
                    'index' => 'pk',
                    'generated' => 'native',
                    'attributes' => 'unsigned',
                )
            ),
            'indexes' => array(
                'PRIMARY' =>
                array(
                    'alias' => 'PRIMARY',
                    'primary' => true,
                    'unique' => true,
                    'type' => 'BTREE',
                    'columns' =>
                    array(
                        'id' =>
                        array(
                            'length' => '',
                            'collation' => 'A',
                            'null' => false,
                        ),
                    ),
                )
            )
        );
    }
}
