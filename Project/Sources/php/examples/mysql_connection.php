<?php
/**
 * class mysql_connection
 * 
 */
class mysql_connection
{

    /** Aggregations: */

    /** Compositions: */

     /*** Attributes: ***/

    /**
     * 
     * @access private
     */
    private $mysql_server = "localhost";

    /**
     * 
     * @access private
     */
    private $mysql_user = "root";

    /**
     * 
     * @access private
     */
    private $mysql_password = "";

    /**
     * 
     * @access private
     */
    private $mysql_database = "";

    /**
     * 
     * @access private
     */
    public $mysql_connection_link = null;

    /**
     * 
     * @access private
     */
    private $mysql_log_path = "error_log";



    /**
     * Constructor Method for the class. Mysql_Connection
     * 
     *
     * @param string mysql_user_name Nombre de usuario para Mysql

     * @param string mysql_user_password Password para el usuario de mysql

     * @param string mysql_server_name Server name, or IP

     * @param string mysql_database_name Mysql database name

     * @return phpkit::mysql_connection
     * @access public
     */
    public function __construct( $mysql_user_name = "root",  $mysql_user_password = "",  $mysql_server_name = "localhost",  $mysql_database_name = "" ) {
	// Begin construct the class
	$this->mysql_user	=	$mysql_user_name;
	$this->mysql_password	=	$mysql_user_password;
	$this->mysql_server	=	$mysql_server_name;
	$this->mysql_database	=	$mysql_database_name;
	// Construct done
	/*
	 *	Return THis
	 */
	 return $this;
    } // end of member function __construct

    /**
     * 
     *
     * @return bool
     * @access public
     */
    public function connect( ) {
	  // Connect to mysql
	  try{
		$this->mysql_connection_link	=	mysql_connect
							      (// For a persistent Connection use "mysql_pconnect" function
							      $this->mysql_server,
							      $this->mysql_user,
							      $this->mysql_password
							      );
		// debug Exceptions
		if( !$this->mysql_connection_link )
			throw new Exception ( mysql_error(), mysql_errno() );
		// select database to work
		if( !mysql_select_db 	(
					      $this->mysql_database,
					      $this->mysql_connection_link
				)
			)// debug Exceptions
			throw new Exception ( mysql_error(), mysql_errno() );
		
	  } catch ( Exception $e ) {
		$this->log($e); // Temporal display of exceptions, this will be replaced with the mysql_log class
	  }
    } // end of member function connect
    /**
     *
     *
     * @return string
     * @access public
     */
     
     public function status( $auto_print = false ) {
	    // Get mysql stat string
	    $mysql_stat = mysql_stat($this->mysql_connection_link);
	    if( $auto_print ){
		  // show the result
		  print($mysql_stat);
	    }
	    // finally return the string
	    return $mysql_stat;
     }// End of member function status
     /**
      *
      * @param Exception exception 
      *
      * @return void
      * @access public
      */
     public function log ( $ec ) {
	    touch( $this->mysql_log_path );
	    // chmod( $this->mysql_log_path );
	    if( file_exists( $this->mysql_log_path ) ) {
		  $fp = fopen( $this->mysql_log_path, "a" );
	    } else {
		  $fp = fopen( "error_log.log", "a" );
	    }
	    if( !$fp )
		  echo("Error opening log file");
	    $line = "";
	    $fecha = date('l jS \of F Y h:i:s A');
	    $line.= "[$fecha]\n";
	    $line.= gzdeflate ( print_r( $ec, true ) );
	    fwrite( $fp, $line );
	    fclose( $fp );
     }//end of function member log
     /**
      * 
      * @access public
      * @return void
      */
      
      public function delete_log_file(){
		  if( file_exists ( $this->mysql_log_path ) )
				unlink ( $this->mysql_log_path );
	  }
	  
	  /**
	   * 
	   * @access public
	   * @return void
	   */ 
	   public function read_log(){
			$buffer = "";
			$fp = fopen( $this->mysql_log_path, "r" );
			while( !feof( $fp ) ){
				$buffer.= gzinflate( fgets( $fp ) );
			}
			fclose($fp);
			return $buffer;
	   } 
		/**
		 * 
		 * @access public
		 * @return void
		 */ 
		 
		public function close( ){
			// Close the connection to mysql
			mysql_close( $this->mysql_connection_link );
		}


} // end of mysql_connection
?>
