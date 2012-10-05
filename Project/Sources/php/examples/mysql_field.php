<?php
/**
 * mysql_field.php
 * 
 * Copyright 2012 Alberto Miranda <alberto@alberto-Aspire-V3-571>
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 * 
 * @package phpkit
 * 
 */
/**
 *	This class is mysql field class for constructing phpkit::mysql_tables objects
 *
 * @package phpkit
 * @subpackage mysql
 * @since 0.0.1
 * @author Alberto Miranda Dencowski <alberto@fijatebien.net>
 * @licence GPLv2
 * 
 */
 
namespace phpkit;
 
class mysql_field {
    /** Aggregations: */
    /** Compositions: */
    /*     * * Attributes: ** */

    /**
     * The name of the field
     * @access private
     * @var String 
     * @default ""
     * @since 0.0.1
     *
     */
    public $name;

    /**
     * The name of the table for
     * @access private
     * @var String
     * @default ""
     * @since 0.0.1
     */
    public $table = "";

    /**
     * The max length of the field
     * @access private
     * @var int
     * @default 11
     * @since 0.0.1
     */
    public $max_length = 11;

    /**
     * Boolean attr defines if the field can be leaved null
     * @access private
     * @var bool
     * @default false
     * @since 0.0.1
     */
    public $not_null = false;

    /**
     * Boolean attr defines if the field is primary key in the table
     * @access private
     * @var bool
     * @default false
     * @since 0.0.1
     */
    public $primary_key = false;

    /**
     * Boolean attr defines if the field is unique key in the table
     * @access private
     * @var bool
     * @default false
     * @since 0.0.1
     */
    public $unique_key = false;

    /**
     * Boolean attr defines if the field is multiple key in the table
     * @access private
     * @var bool
     * @default false
     * @since 0.0.1
     */
    public $multiple_key = false;

    /**
     * Boolean attr defines if the field is numeric
     * @access private
     * @var bool
     * @default false
     * @since 0.0.1
     */
    public $numeric = false;

    /**
     * Boolean attr defines if the field is a blob
     * @access private
     * @var bool
     * @default false
     * @since 0.0.1
     */
    public $blob = false;

    /**
     * String determines the field type
     * @access private
     * @var string
     * @default "int"
     * @since 0.0.1
     */
    public $type = "int";

    /**
     * This attr defines if the integer field will have sing (for ex. -9) 
     * @access private
     * @var bool
     * @default false
     * @since 0.0.1
     */
    public $unsigned = false;

    /**
     * This attr defines if the integer field will be zerofilled (For ex. 123 to 0000000123) 
     * @access private
     * @var bool
     * @default false
     * @since 0.0.1
     */
    public $zerofill = false;

    /*     * * operations ** */

    /**
     * 		Construct Method for mysql_field class
     *
     * @param string name
     * 
     * @param string table
     * 
     * @param int max_length
     * 
     * @param bool not_null
     * 
     * @param bool primary_key
     * 
     * @param bool unique_key
     * 
     * @param bool multiple_key
     * 
     * @param bool numeric
     * 
     * @param bool blob
     * 
     * @param bool type
     * 
     * @param bool unsigned
     * 
     * @param bool zerofill
     * 
     * @access public
     * @return mysql_field
     */
    public function __construct(
    $name, $table, $max_length = 11, $not_null = false, $primary_key = false, $unique_key = false, $multiple_key = false, $numeric = false, $blob = false, $type = 'varchar', $unsigned = false, $zerofill = false
    ) {

        $this->name = $name;
        $this->table = $table;
        $this->max_length = $max_length;
        $this->not_null = $not_null;
        $this->primary_key = $primary_key;
        $this->unique_key = $unique_key;
        $this->multiple_key = $multiple_key;
        $this->numeric = $numeric;
        $this->blob = $blob;
        $this->type = $type;
        $this->unsigned = $unsigned;
        $this->zerofill = $zerofill;
        // Return this
        return $this;
    }

}

// end of mysql_field
?>
