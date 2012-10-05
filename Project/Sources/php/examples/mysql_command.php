<?php

/**
 *	This class handles the mysql_query function  
 * 	
 * @package phpkit
 * @subpackage mysql
 * @author Alberto Miranda Dencowski <alberto@fijatebien.net>
 * @since 0.0.1
 * @licence GPLv2
 */
class mysql_command {

    /** Aggregations: */
    
    /** Compositions: */
    /*     * * Attributes: ** */
    /**
     * SQL String to execute
     * @access private
     * @var String
     * @since 0.0.1
     * 
     */
    private $sql_string;

    /**
     * Mysql Query Resource
     * @access private
     * @var Resource
     * @since 0.0.1
     */
    public $mysql_query_id = null;

    /**
     * Mysql_Connection Object
     * @access private
     * @var phpkit::mysql_connection
     * @since 0.0.1
     */
    private $mysql_connection_obj = null;

    /**
     * If the query is for data fetching, yo must pass 1 in the construct method
     * Else pass 0 
     * 
     * @access private
     * @var int
     * @since 0.0.1
     */
    private $command_type;

    /*     * * Operations ** */

    /**
     * Mysql_Command Contructor Method
     *
     * @param string sql_string
     * 
     * @param mysql_connection connection
     * 
     * @param int cmd_type
     * 
     * @access public
     * @return phpkit::mysql_command
     *
     * @since 0.0.1
     *
     */
    public function __construct($sql_string, $connection, $cmd_type) {
	// Begin construct
        $this->mysql_connection_obj = $connection;
        $this->sql_string = $sql_string;
        $this->command_type = $cmd_type;
        // Return this
        return $this;
    }

// End of member function __construct
    /**
     *		This method run the mysql_query 
     *
     * @param sql_string String
     *
     * @access public
     *
     * @return bool
     *
     * @since 0.0.1
     * 
     */
    public function exec($sql_string = null) {
        if (!is_null($sql_string))
            $this->sql_string = $sql_string;
        try {
            $this->mysql_query_id = mysql_query(
                    $this->sql_string, $this->mysql_connection_obj->mysql_connection_link
            );
            if (!$this->mysql_query_id)
                throw new Exception(mysql_error(), mysql_errno());
        } catch (Exception $e) {
            $this->mysql_connection_obj->log($e);
            return false;
        }
        return $this->mysql_query_id;
    }

    /**
     *	This method run mysql_fetch_object and return an array with the rows
     *
     * @access public 
     *
     * @return array
     *
     * @since 0.0.1
     *
     */
    public function fetch() {
        $items = array();
        $aux = $this->mysql_query_id;
        if (mysql_num_rows($aux) > 1):
            while ($item = mysql_fetch_object($this->mysql_query_id)) {
                array_push($items, $item);
            }
        else:
            array_push($items, $this->fetch_one());
        endif;
        // return array with the items
        return $items;
    }

    /**
     * 	This function run mysql_fetch_field recursively and return an array
     *	with the fields in objects
     *
     * @access public
     * @return array
     * @since 0.0.1
     */
    public function fetch_fields() {
        $num_fields = mysql_num_fields($this->mysql_query_id);
        $retArray = array();
        $i = 0;
        while ($i < $num_fields) {
            array_push($retArray, mysql_fetch_field($this->mysql_query_id, $i));
            $i++;
        }
        return $retArray;
    }

    /**
     * This function fetch only one row of the query
     *
     * @access public
     * @return array
     * @since 0.0.1
     */
    public function fetch_one() {
        $item = mysql_fetch_object($this->mysql_query_id);
        return $item;
    }

    /**
     * This function creates a html table based on a fetched array
     *
     * @param $fetch_data array
     *
     * @access public
     *
     * @return void
     */
    public function generate_report($fetch_data) {
        //$list = $this->fetch( );
        $table = "<table id='$id' class='mysql_report' cellspacing='2' cellpading='2'>";
        $table.= "<tr>";

        foreach ($fetch_data[0] As $key => $value) {
            $table.= "<th>$key</th>";
        }
        $table.= "</tr>";
        foreach ($fetch_data As $key => $value) {
            $table.= "<tr>";
            foreach ($value As $key => $valu) {
                $table.= "<td>" . substr(strip_tags($valu), 0, 50) . "</td>";
            }
            $table.= "</tr>";
        }
        $table.= "</table>";
        echo( $table );
    }

}

// end of class mysql_command
?> 
