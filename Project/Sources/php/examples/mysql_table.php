<?php
/**
 * mysql_table.php
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
 * Mysql_Table Class
 * @package phpkit
 * @subpackage mysql
 * @author Alberto Miranda Dencowski <alberto@fijatebien.net>
 * @since 0.0.1
 * @licence GPLv2
 * 
 */
 
namespace phpkit;
 
class mysql_table {
    /** Aggregations: */
    /** Compositions: */
    /*     * * Attributes: ** */

    /**
     * The name of the table
     * @access private
     * @var String
     * @default ""
     * @since 0.0.1
     */
    private $name = "";

    /**
     * The literal name of the table
     * @access private
     * @var String
     * @default ""
     * @since 0.0.1
     */
    private $literal_name = "";

    /**
     * An Array of phpkit::mysql_field objects
     * @access private
     * @var Array
     * @default array()
     * @since 0.0.1
     */
    private $fields = array();

    /**
     * Mysql_Command to execute the queries
     * @var mysql_command
     * @access public
     */
    public $connection;
    /**
     * Contructor method for mysql_table
     * @param String name 
     * @param String li_name
     * @param Array fields_arr
     * @access public
     * @since 0.0.1
     */
    public function __construct($name, $li_name = "", $fields_arr = array()) {
        $this->name = $name;
        $this->literal_name = $li_name;
        $this->fields = $fields_arr;
    }// End of member function

    /**
     * Generate the SQL String for create the mysql table
     * @access public
     * @return void
     * @since 0.0.1
     * 
     */
    public function generate_sql() {
        $sql_string = "CREATE TABLE $this->name (";
        $fields_r = array();
        foreach ($this->fields As $field) {
            $current_field = $field->name . " ";
            $current_field .= "$field->type ($field->max_length)";
            if ($field->not_null)
                $current_field.= " NOT NULL";
            if ($field->primary_key)
                $current_field.= " PRIMARY KEY";
            array_push($fields_r, $current_field);
        }
        $sql_string .= implode(", ", $fields_r) . ");";

        echo($sql_string);
    }// end of member function generate_sql

    /**
     * Load the mysql_table from de database
     * @access public
     * @return void
     * @since 0.0.1
     */
    public function get() {
        $sql_string = "SELECT * from $this->name;";
        $rs = new mysql_command($sql_string, $this->connection, 1);
        $rs->exec();
        $i = 0;
        while ($i < mysql_num_fields($rs->mysql_query_id)) {
            $r = mysql_fetch_field($rs->mysql_query_id, $i);
            $this->fields[$r->name] = new mysql_field(
                            $r->name,
                            $this->name,
                            $r->max_length,
                            $r->not_null,
                            $r->primary_key,
                            $r->unique_key,
                            $r->multiple_key,
                            $r->numeric,
                            $r->blob,
                            $r->type,
                            $r->unsigned,
                            $r->zerofill
            );
            $i++;
        }
    }// end of member function get

    /**
     * Generate HTML Form for the mysql_table
     * @param String method
     * @param String id
     * @param string class
     * @access public
     * @return void
     * @since 0.0.1
     */
    public function get_form($method, $id, $class) {
        $form_html = "<form method='$method' id='$id' class='$class'>";
        foreach ($this->fields As $key => $field) {
            $form_html.= "<br /><label for='$field->name'>$key</label><br />";
            switch ($field->type) {
                case "int":
                    if ($field->max_length == 1):
                        $form_html.="<input type='checkbox' value='1'name='$field->name' id='$field->name' data-valid='$field->type' />";
                    else:
                        $form_html.="<input type='text' name='$field->name' id='$field->name' data-valid='$field->type' maxlength='$field->max_length' size='$field->max_length' />";
                    endif;
                    break;
                default:
                    if ($field->max_length < 41) {
                        $form_html.="<input type='text' name='$field->name' id='$field->name' data-valid='$field->type' maxlength='$field->max_length' size='$field->max_length' />";
                    } else {
                        $rows = $field->max_length / 42;
                        $form_html.="<textarea name='$field->name' id='$field->name' data-valid='$field->type' rows='$rows' cols='42'></textarea>";
                    }
                    break;
            }
        }
        $form_html.="<button>Enviar</button>";
        $form_html.= "</form><!-- Generated by PHP Kit -->";
        echo($form_html);
    }// end of member function get_form
    /**
     * Receive and process forms POST
     * @access public
     * @return void
     * @since 0.0.1
     */
    public function post() {
        print_r($_POST);
        foreach ($_POST As $key => $value) {
            /* /if( !array_key_exists( $key, $this->fields ) )
              echo("Error 1 $key");
              if( $this->validate_type ( $value, $this->fields[$key]->type ) )
              $_POST[$key]= $this->sanitize( $_POST[$key] ); */
            if (( $this->fields[$key]->not_null == true ) && (!$_POST[$key] ))
                unset($_POST);
            echo "<br /> $key :" . $_POST[$key];
        }
    }// end of member function post
    /**
     * Validate the field type
     * @param String var
     * @param String type
     * @access public
     * @return bool
     * @since 0.0.1
     */
    public function validate_type($var, $type) {
        switch ($type) {
            case "int":
                if (!is_numeric($var))
                    return false;
                break;
            case "float":
                if (!is_float($var))
                    return false;
                break;
            default:
                return true;
                break;
        }
    }// end of member function validate_type
    /**
     * Strip and Add slashes to string to make it safer
     * @param String string
     * @access public
     * @return string
     * @since 0.0.1
     */
    public function sanitize($string) {
        $return = addslashes(strip_tags($string));
        return $return;
    }// end of member function sanitize

}

// end of mysql_table
?>
