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
 * Script that upgrades xPDO models from version 1.1+ to the 3.0 format.
 *
 * Can be run from CLI or web, accepting command-line arguments or $_REQUEST
 * variables to set the arguments.
 *
 * @package xpdo
 * @subpackage tools
 */
use xPDO\xPDO;

$scriptTitle = basename(__FILE__, '.php');
/**#@+
 * Arguments
 */
/**
 * @var string The xPDO root path, where the xpdo.class.php file is located.
 */
$xpdo_path= realpath(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR;
/**
 * @var string The name of the model package.
 */
$pkg= '';
/**
 * @var string The model root path.
 */
$pkg_path= realpath(dirname($xpdo_path) . DIRECTORY_SEPARATOR . 'model') . DIRECTORY_SEPARATOR;
/**
 * @var string The xPDO model schema filename.
 */
$schema_name= '';
/**
 * @var string The path to the model schema file.
 */
$schema_path= realpath(dirname($xpdo_path) . DIRECTORY_SEPARATOR . 'schema') . DIRECTORY_SEPARATOR;
/**
 * @var string The path to write the backup schema file.
 */
$backup_path= '';
/**
 * @var string A string to prepend to the backup file.
 */
$backup_prefix= '~';
/**
 * @var string A valid PDO DSN connection string.
 */
$dsn= 'mysql:host=localhost';
/**
 * @var string A valid database user name.
 */
$dbuser= 'root';
/**
 * @var string The password for the database user.
 */
$dbpass= '';
/**
 * @var boolean The debug setting for the script.
 */
$debug= false;
/**
 * @var integer The xPDO log level to use. Note 2 is LOG_LEVEL_WARN, 2 is LOG_LEVEL_INFO
 */
$log_level= 2;
/**
 * @var integer The PHP error_reporting level to use.
 */
$error_reporting= -1;
/**
 * @var boolean Indicates the PHP display_errors setting to use.
 */
$display_errors= true;
/**
 * @var boolean If true, will regenerate the model after the schema is updated.
 */
$regen= false;
/**
 * @var boolean If true, will write the updated schema changes to file, and backup the original.
 */
$write= false;
/**
 * @var boolean If true, will echo the updated schema.
 */
$echo= false;
/**
 * @var string An external file to include argument values from; will be overridden
 * by CLI or $_REQUEST arguments.
 */
$include= realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . "{$scriptTitle}.properties");

$defaultInclude= true;
$properties= array();
if (!empty($argv) && $argc > 1) {
    /* process CLI arguments */
    reset($argv);
    while ($argument = next($argv)) {
        if (strpos($argument, '=') > 0) {
            $arg = explode('=', $argument);
            $argKey = trim($arg[0], '-');
            $argValue = trim($arg[1], '"');
            if (strpos($argKey, '_path') > 0) {
                $argValue = realpath($argValue) . DIRECTORY_SEPARATOR;
            }
            if ($argKey == 'include') {
                $argValue = realpath($argValue);
                $defaultInclude= false;
            }
            $properties[$argKey] = $argValue;
        } else {
            $properties[trim($argument, '-')] = true;
        }
    }
} elseif (!empty($_REQUEST)) {
    /* process $_REQUEST arguments */
    while (list($argKey, $argValue)= each($_REQUEST)) {
        if (in_array(strtolower($argValue), array('true','false'))) {
            $argValue = $argValue === 'true' ? true : false;
        }
        if (strpos($argKey, '_path') > 0) {
            $argValue = realpath($argValue) . DIRECTORY_SEPARATOR;
        }
        if ($argKey == 'include') {
            $argValue = realpath($argValue);
            $defaultInclude= false;
        }
        $properties[$argKey] = $argValue;
    }
}
/* load external properties from default or specified file */
if (!empty($include) && file_exists($include)) {
    if (!include ($include)) {
        die("[{$scriptTitle}] FATAL: Error loading " . ($defaultInclude ? " default " : "") . "external properties file --include={$include}.\n");
    }
} elseif (!empty($include) && !$defaultInclude) {
    die("[{$scriptTitle}] FATAL: External properties file not found --include={$include}.\n");
}
extract($properties, EXTR_OVERWRITE);

if (empty($pkg)) {
    die("[{$scriptTitle}] FATAL: No valid pkg was specified.\n");
}
if (empty($pkg_path)) {
    die("[{$scriptTitle}] FATAL: No pkg_path was specified.\n");
}
if (empty($schema_name)) {
    die("[{$scriptTitle}] FATAL: No schema_name was specified.\n");
}
if (empty($schema_path)) {
    die("[{$scriptTitle}] FATAL: No schema_path was specified.\n");
}

if (empty($echo) && empty($write) && empty($regen) && $debug !== true) {
    die("[{$scriptTitle}] FATAL: At least one of the options --echo, --write, --regen, or --debug must be set.\n");
}
if ($debug === true && !empty($write)) {
    die("[{$scriptTitle}] FATAL: --write cannot be used when --debug is set.\n");
}

if (!file_exists("{$xpdo_path}xpdo.class.php")) {
    die("[{$scriptTitle}] FATAL: xPDO class not found; invalid xpdo_path: {$xpdo_path}.\n");
}
include_once ("{$xpdo_path}xpdo.class.php");

/* @var \xPDO\xPDO $xpdo */
$xpdo= new xPDO($dsn, $dbuser, $dbpass);
if (!is_object($xpdo)) {
    die("[{$scriptTitle}] FATAL: Error getting instance of xPDO object.");
}
$xpdo->setLogTarget(XPDO_CLI_MODE ? 'ECHO' : 'HTML');
$xpdo->setLogLevel($log_level);

if (!empty($debug)) {
    if ($debug === true && empty($echo)) {
        $echo = true;
    }
    $xpdo->setDebug($debug);
}

error_reporting($error_reporting);
ini_set('display_errors', (boolean) $display_errors);

$xpdo->setPackage($pkg, $pkg_path);

if (!file_exists("{$schema_path}{$schema_name}")) {
    $xpdo->log(xPDO::LOG_LEVEL_FATAL, "Could not find schema: {$schema_path}{$schema_file}");
}
/* load the schema file as a DOMDocument */
$schema = new DOMDocument();
$loaded = $schema->load("{$schema_path}{$schema_name}");
if ($loaded === false) {
    $xpdo->log(xPDO::LOG_LEVEL_FATAL, "Error loading schema file: {$schema_path}{$schema_file}");
}
$schema->formatOutput = true;

if (!empty($write)) {
    /* backup the existing schema if the --write argument is set */
    $backupSchemaName = $backup_prefix . $schema_name;
    if (empty($backup_path)) $backup_path = $schema_path;
    if ($backupSchemaName === $schema_name && $backup_path === $schema_path) {
        $xpdo->log(xPDO::LOG_LEVEL_FATAL, "backup_prefix is empty and no backup_path was specified.");
    }
    if (!$xpdo->getCacheManager()->writeFile("{$backup_path}{$backupSchemaName}", $schema->saveXML())) {
        $xpdo->log(xPDO::LOG_LEVEL_FATAL, "Error backing up schema to {$backup_path}{$backupSchemaName}.");
    }
}

/* parse the schema's DOM */
$rootIdx = 0;
$root = $schema->documentElement;
$xpdo->log(xPDO::LOG_LEVEL_INFO, "parsing root element: {$root->nodeName}");
if (strtolower($root->nodeName) !== 'model') {
    $xpdo->log(xPDO::LOG_LEVEL_FATAL, "root element is not a valid model schema element: {$root->nodeName}");
}
$platform = $root->attributes->getNamedItem('platform');
$written = false;
if ($root->hasAttribute('version')) {
    $version = $root->attributes->getNamedItem('version');
    if ($written = version_compare($version->nodeValue, '3.0', '>=')) {
        if (!empty($write) || empty($regen)) {
            $xpdo->log(xPDO::LOG_LEVEL_FATAL, "this model is already at version 3.0; this migration is intended for older models");
        }
    } elseif (version_compare($version->nodeValue, '1.1', '<')) {
        $xpdo->log(xPDO::LOG_LEVEL_FATAL, "this model is older than version 1.1; this migration is intended for models at version 1.1 or higher");
    }
} else {
    $xpdo->log(xPDO::LOG_LEVEL_FATAL, "this model is older than version 1.1; this migration is intended for models at version 1.1 or higher");
}
if (!empty($regen) && empty($write) && empty($written)) {
    die("[{$scriptTitle}] FATAL: --regen can only be used when --write is set or the schema is already at version 3.0.\n");
}
if (empty($written)) {
    $root->setAttribute('version', '3.0');

    $attrIdx = 0;
    $package = $pkg;
    while ($attr = $root->attributes->item($attrIdx++)) {
        switch ($attr->nodeName) {
            case 'package':
                $package = $attr->nodeValue = str_replace('.', '\\', $attr->nodeValue);
                break;
            case 'baseClass':
                if (in_array($attr->nodeValue, array('xPDOObject', 'xPDOSimpleObject'))) {
                    $attr->nodeValue = "\\xPDO\\om\\{$attr->nodeValue}";
                } else {
                    $attr->nodeValue = '\\' . $package . '\\' . str_replace('.', '\\', $attr->nodeValue);
                }
                break;
            default:
                break;
        }
    }
    $xpdo->log(xPDO::LOG_LEVEL_INFO, "model element ({$rootIdx}): " . print_r($root->attributes, true));

    $objectIdx = 0;
    while ($object = $root->childNodes->item($objectIdx++)) {
        $xpdo->log(xPDO::LOG_LEVEL_DEBUG, "parsing model child element: {$object->nodeName}");
        if (strtolower($object->nodeName !== 'object')) continue;

        $attrIdx = 0;
        while ($attr = $object->attributes->item($attrIdx++)) {
            switch (strtolower($attr->nodeName)) {
                case 'class':
                    $attr->nodeValue = str_replace('.', '\\', $attr->nodeValue);
                    break;
                case 'extends':
                    if (in_array($attr->nodeValue, array('xPDOObject', 'xPDOSimpleObject'))) {
                        $attr->nodeValue = "\\xPDO\\om\\{$attr->nodeValue}";
                    } else {
                        $attr->nodeValue = '\\' . $package . '\\' . str_replace('.', '\\', $attr->nodeValue);
                    }
                    break;
                default:
                    break;
            }
        }

        $idx = 0;
        while ($node = $object->childNodes->item($idx++)) {
            $xpdo->log(xPDO::LOG_LEVEL_DEBUG, "parsing object child element: {$node->nodeName}");

            switch (strtolower($node->nodeName)) {
                case 'field':
                    $attrIdx = 0;
                    $isClassKey = false;
                    while ($attr = $node->attributes->item($attrIdx++)) {
                        if (strtolower($attr->nodeName) === 'key' && $attr->nodeValue === 'class_key') {
                            $isClassKey = true;
                        } elseif (strtolower($attr->nodeName) === 'default' && $isClassKey) {
                            $attr->nodeValue = $package . '\\' . str_replace('.', '\\', $attr->nodeValue);
                        }
                    }
                    break;
                case 'aggregate':
                case 'composite':
                    $attrIdx = 0;
                    while ($attr = $node->attributes->item($attrIdx++)) {
                        if (strtolower($attr->nodeName) === 'class') {
                            $attr->nodeValue = $package . '\\' . str_replace('.', '\\', $attr->nodeValue);
                        }
                    }
                    break;
                case 'validation':
                    $attrIdx = 0;
                    while ($attr = $node->attributes->item($attrIdx++)) {
                        if (strtolower($attr->nodeName) === 'class' && strtolower($attr->nodeValue) === 'validation.xpdovalidator') {
                            $attr->nodeValue = '\\xPDO\\' . str_replace('.', '\\', $attr->nodeValue);
                        }
                    }
                    $childIdx = 0;
                    while ($child = $node->childNodes->item($childIdx++)) {
                        if (strtolower($child->nodeName) === 'rule') {
                            $rAttrIdx = 0;
                            while ($rAttr = $child->attributes->item($rAttrIdx++)) {
                                if (strtolower($rAttr->nodeName) === 'rule') {
                                    if (substr($rAttr->nodeValue, 0, 4) === 'xPDO') {
                                        $rAttr->nodeValue = '\\xPDO\\validation\\' . str_replace('.', '\\', $rAttr->nodeValue);
                                    }
                                }
                            }
                        }
                    }
                    break;
                default:
                    break;
            }
        }
    }
}
$xml = $schema->saveXML();
if (!empty($echo)) {
    echo (XPDO_CLI_MODE ? "{$schema_name}:\n{$xml}\n" : "<h1>{$schema_name}</h1>\n<pre>{$xml}</pre>\n<br />");
}
if (!empty($write) && empty($written)) {
    $xpdo->log(xPDO::LOG_LEVEL_INFO, "Updating schema file at {$schema_path}{$schema_name}...");
    if (!$xpdo->getCacheManager()->writeFile("{$schema_path}{$schema_name}", $xml)) {
        $xpdo->log(xPDO::LOG_LEVEL_FATAL, "Migration failed! Error writing content to file at {$schema_path}{$schema_name}");
    }
    $xpdo->log(xPDO::LOG_LEVEL_INFO, "Migration of schema file {$schema_name} for pkg {$pkg} completed successfully.");
}
if ((!empty($write) || !empty($written)) && !empty($regen)) {
    $xpdo->log(xPDO::LOG_LEVEL_INFO, "Attempting to regenerate model maps for pkg {$pkg} from migrated schema at {$pkg_path}...");
    if (!$xpdo->getManager() || !$xpdo->manager->getGenerator()) {
        $xpdo->log(xPDO::LOG_LEVEL_FATAL, "Model regeneration failed: could not get instance of the xPDOManager or xPDOGenerator.");
    }
    if (!$xpdo->manager->generator->parseSchema("{$schema_path}{$schema_name}", $pkg_path)) {
        $xpdo->log(xPDO::LOG_LEVEL_FATAL, "Model regeneration failed! Error parsing schema {$schema_name} for pkg {$pkg} at {$pkg_path}.");
    }
    $xpdo->log(xPDO::LOG_LEVEL_INFO, "Regeneration of model files for pkg {$pkg} at {$pkg_path} completed successfully.");
}
exit();