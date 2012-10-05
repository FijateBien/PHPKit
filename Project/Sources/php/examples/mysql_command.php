<?php
/**
 *  class mysql_command
 * 
 */
class mysql_command{
	/** Aggregations: */
            // Test change
    /** Compositions: */

     /*** Attributes: ***/
     // test
     /**
      * 
      * @access private
      * 
      */
      private $sql_string;
      
      /**
       * 
       * @access private
       */
       public $mysql_query_id = null;
       
       /**
        * 
        * @access private
        */
       private $mysql_connection_obj = null;
       /**
        * If the query is for fetching data, yo must pass 1 in the construct method
        * Else pass 0 
        * 
        * @access private
        */
        private $command_type; 
       
       /*** Operations ***/
       /**
        * 
        * @param string sql_string
        * 
        * @param mysql_connection connection
        * 
        * @param int cmd_type
        * 
        * @access public
        * @return mysql_command
        */ 
       public function __construct( $sql_string, $connection, $cmd_type ){
		   $this->mysql_connection_obj	= 		$connection;
		   $this->sql_string	 		= 		$sql_string;
		   $this->command_type			= 		$cmd_type;
	   }// End of member function __construct
	   /**
	    * 
	    * @access public
	    * @return bool
	    * 
	    */ 
	    public function exec( $sql_string = null ){
			if( !is_null( $sql_string ) )
				$this -> sql_string = $sql_string;
			try{
				$this->mysql_query_id = mysql_query(
												$this->sql_string,
												$this->mysql_connection_obj->mysql_connection_link
												);
				if( !$this->mysql_query_id )
					throw new Exception ( mysql_error( ), mysql_errno( ) );
			} catch ( Exception $e ) {
				$this->mysql_connection_obj->log( $e );
				return false;
			}
			return $this->mysql_query_id;
		}
		/**
		 * 
		 * @access public 
		 * @return array
		 */
		 public function fetch(){
			$items = array();
			$aux = $this->mysql_query_id;
			if ( mysql_num_rows ( $aux ) > 1 ):
				while ( $item = mysql_fetch_object ( $this->mysql_query_id ) ){
					array_push( $items, $item );
				}
			else:
				array_push( $items, $this->fetch_one() );
			endif;
			// return array with the items
			return $items;
		 }
		 
		 /**
		  * 
		  * @access public
		  * @return array
		  */
		  public function fetch_fields( ){
			  $num_fields = mysql_num_fields( $this->mysql_query_id );
			  $retArray = array( );
			  $i = 0;
			  while( $i < $num_fields ){
				  array_push( $retArray, mysql_fetch_field( $this->mysql_query_id, $i ) );
				  $i++;
			  }
			  return $retArray;
		  }
		 
		 /**
		  * 
		  * @access public
		  * @return array
		  */
		  
		  public function fetch_one(){
			  $item = mysql_fetch_object( $this->mysql_query_id );
			  return $item;
		  } 
		  /**
		   * 
		   * @access public
		   * @return void
		   */
		   public function generate_report( $fetch_data ){
			   //$list = $this->fetch( );
			   $table = "<table id='$id' class='mysql_report' cellspacing='2' cellpading='2'>";
			   $table.= "<tr>";
			    
			   foreach ( $fetch_data[0] As $key => $value){
				   $table.= "<th>$key</th>";
			   }
			   $table.= "</tr>";
			   foreach ( $fetch_data As $key => $value){
				   $table.= "<tr>";
				   foreach ( $value As $key => $valu){
					   $table.= "<td>". substr(strip_tags($valu), 0, 50) ."</td>";
				   }
				   $table.= "</tr>";
				}
			   $table.= "</table>";
			   echo( $table );
		   } 
     
}// end of class mysql_command
?> 
