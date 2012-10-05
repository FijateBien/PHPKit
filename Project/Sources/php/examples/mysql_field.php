<?php

/**
 * class mysql_field
 * 
 */
class mysql_field {
    /** Aggregations: */
    /** Compositions: */
    /*     * * Attributes: ** */

    /**
     * 
     * @access private
     */
    public $name;

    /**
     * 
     * @access private
     */
    public $table = "";

    /**
     * 
     * @access private
     */
    public $max_length = false;

    /**
     * 
     * @access private
     */
    public $not_null = false;

    /**
     * 
     * @access private
     */
    public $primary_key = false;

    /**
     * 
     * @access private
     */
    public $unique_key = false;

    /**
     * 
     * @access private
     */
    public $multiple_key = false;

    /**
     * 
     * @access private
     */
    public $numeric = false;

    /**
     * 
     * @access private
     */
    public $blob = false;

    /**
     * 
     * @access private
     */
    public $type = "int";

    /**
     * 
     * @access private
     */
    public $unsigned = false;

    /**
     * 
     * @access private
     */
    public $zerofill = false;

    /*     * * operations ** */

    /**
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
