<?php
/**
 * mysql_connection.php
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
 *
 *	This class handles MySQL_Connect Function
 * 	Has an attribute Resource mysql_connection_link
 *	Contains the resource of the connection to mysql server
 *
 * @package phpkit
 * @subpackage mysql
 * @author Alberto Miranda Dencowski <alberto@fijatebien.net>
 * @since 0.0.1
 * @licence GPLv2
 * 
 */
class mysql_connection {
    /** Aggregations: */
    /** Compositions: */
    /*     * * Attributes: ** */

    /**
     * Mysql Server IP or Name
     * @access private
     * @var string
     * @default "localhost"
     * @since 0.0.1
     */
    private $mysql_server = "localhost";

    /**
     * Mysql user name
     * @access private
     * @var string
     * @default "root"
     * @since 0.0.1
     */
    private $mysql_user = "root";

    /**
     * Mysql user password
     * @access private
     * @var string
     * @default ""
     * @since 0.0.1
     */
    private $mysql_password = "";

    /**
     * Mysql database name
     * @access private
     * @var string
     * @default ""
     * @since 0.0.1
     */
    private $mysql_database = "";

    /**
     * Mysql connection link Resource
     * @access private
     * @var Resource
     * @default null
     * @since 0.0.1
     */
    public $mysql_connection_link = null;

    /**
     * Mysql loggin path ["CURRENT_DIRECTORY"] / error_log
     * @access private
     * @var String
     * @default "error_log"
     * @since 0.0.1
     */
    private $mysql_log_path = "error_log";

    /**
     * 		
     *		Constructor Method for the class. Mysql_Connection
     * 		Note: This function doesn't call to mysql_connect
     * 		After construct you need to call the method <connect()>
     * 
     *
     * @param string mysql_user_name Nombre de usuario para Mysql

     * @param string mysql_user_password Password para el usuario de mysql

     * @param string mysql_server_name Server name, or IP

     * @param string mysql_database_name Mysql database name

     * @return phpkit::mysql_connection
     * @access public
     */
    public function __construct($mysql_user_name = "root", $mysql_user_password = "", $mysql_server_name = "localhost", $mysql_database_name = "") {
        // Begin construct the class
        $this->mysql_user = $mysql_user_name;
        $this->mysql_password = $mysql_user_password;
        $this->mysql_server = $mysql_server_name;
        $this->mysql_database = $mysql_database_name;
        // Construct done
        /*
         * 	Return This
         */
        return $this;
    }

// end of member function __construct

    /**
     * 		Connect to mysql method
     *
     * @return bool
     * @access public
     * @since 0.0.1
     */
    public function connect() {
        // Connect to mysql
        try {
            $this->mysql_connection_link = mysql_connect
                    (// For a persistent Connection use "mysql_pconnect" function
                    $this->mysql_server, $this->mysql_user, $this->mysql_password
            );
            // debug Exceptions
            if (!$this->mysql_connection_link)
                throw new Exception(mysql_error(), mysql_errno());
            // select database to work
            if (!mysql_select_db(
                            $this->mysql_database, $this->mysql_connection_link
                    )
            )// debug Exceptions
                throw new Exception(mysql_error(), mysql_errno());
        } catch (Exception $e) {
            $this->log($e); // Temporal display of exceptions, this will be replaced with the mysql_log class
        }
    }

// end of member function connect
    /**
     * Return musql_stat function result   
     * @param auto_print bool
     *
     * @return string
     * @access public
     * @since 0.0.1
     */
    public function status($auto_print = false) {
        // Get mysql stat string
        $mysql_stat = mysql_stat($this->mysql_connection_link);
        if ($auto_print) {
            // show the result
            print($mysql_stat);
        }
        // finally return the string
        return $mysql_stat;
    }

// End of member function status
    /**
     * Error loggin method
     * @param Exception exception 
     *
     * @return void
     * @access public
     * @since 0.0.1
     */
    public function log($ec) {
        touch($this->mysql_log_path);
        // chmod( $this->mysql_log_path );
        if (file_exists($this->mysql_log_path)) {
            $fp = fopen($this->mysql_log_path, "a");
        } else {
            $fp = fopen("error_log.log", "a");
        }
        if (!$fp)
            echo("Error opening log file");
        $line = "";
        $fecha = date('l jS \of F Y h:i:s A');
        $line.= "[$fecha]\n";
        $line.= gzdeflate(print_r($ec, true));
        fwrite($fp, $line);
        fclose($fp);
    }

//end of function member log
    /**
     * Deletes the log file 
     * @access public
     * @return void
     * @since 0.0.1
     */
    public function delete_log_file() {
        if (file_exists($this->mysql_log_path))
            unlink($this->mysql_log_path);
    }

    /**
     * Read and uncompress the log file
     * @access public
     * @return void
     * @since 0.0.1
     */
    public function read_log() {
        $buffer = "";
        $fp = fopen($this->mysql_log_path, "r");
        while (!feof($fp)) {
            $buffer.= gzinflate(fgets($fp));
        }
        fclose($fp);
        return $buffer;
    }

    /**
     * Method to close the mysql_connection_link
     * @access public
     * @return void
     * @since 0.0.1
     */
    public function close() {
        // Close the connection to mysql
        mysql_close($this->mysql_connection_link);
    }

}

// end of mysql_connection
?>
