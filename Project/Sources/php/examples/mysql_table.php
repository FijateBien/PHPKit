
<?php


/**
 * class mysql_table
 * 
 */
class mysql_table
{

    /** Aggregations: */

    /** Compositions: */

     /*** Attributes: ***/

    /**
     * 
     * @access private
     */
    private $name = "";

    /**
     * 
     * @access private
     */
    private $literal_name = "";

    /**
     * 
     * @access private
     */
    private $fields = array();
    /**
     * 
     * @access public
     */
     public $connection;

	
	public function __construct($name, $li_name="", $fields_arr=array()){
		$this->name = $name;
		$this->literal_name = $li_name;
		$this->fields = $fields_arr; 
	}
	/**
	 * 
	 * @access public 
	 * 
	 */
	public function generate_sql( ){
		$sql_string = "CREATE TABLE $this->name (";
		$fields_r = array();
		foreach ( $this->fields As $field){
			$current_field = $field->name . " ";
			$current_field .= "$field->type ($field->max_length)";
			if($field->not_null)
				$current_field.= " NOT NULL";
			if($field->primary_key)
				$current_field.= " PRIMARY KEY";
			array_push($fields_r, $current_field);
		}
		$sql_string .= implode(", ", $fields_r) . ");";
		
		echo($sql_string);
		
	}
	/**
	 * 
	 * @access public
	 */
	 public function get( ){
		 $sql_string = "SELECT * from $this->name;";
		 $rs = new mysql_command( $sql_string, $this->connection, 1 );
		 $rs->exec();
		 $i = 0;
		 while( $i < mysql_num_fields($rs->mysql_query_id) ){
			 $r=mysql_fetch_field( $rs->mysql_query_id, $i );
			 $this->fields[$r->name]= new mysql_field(	
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
	 }//end of member function get
	 public function get_form( $method, $id, $class ) {
		 $form_html = "<form method='$method' id='$id' class='$class'>";
		 foreach($this->fields As $key => $field){
			 $form_html.= "<br /><label for='$field->name'>$key</label><br />"; 
			 switch ( $field->type ){
				case "int":
					if( $field->max_length == 1 ):
						$form_html.="<input type='checkbox' value='1'name='$field->name' id='$field->name' data-valid='$field->type' />";
					else:
						$form_html.="<input type='text' name='$field->name' id='$field->name' data-valid='$field->type' maxlength='$field->max_length' size='$field->max_length' />";
					endif;
				break;
				default:
					 if($field->max_length < 41){
						 $form_html.="<input type='text' name='$field->name' id='$field->name' data-valid='$field->type' maxlength='$field->max_length' size='$field->max_length' />";
					 }else{
						 $rows = $field->max_length / 42;
						 $form_html.="<textarea name='$field->name' id='$field->name' data-valid='$field->type' rows='$rows' cols='42'></textarea>";
					 }
				break;
			}
		 } 
		 $form_html.="<button>Enviar</button>";
		 $form_html.= "</form><!-- Generated by PHP Kit -->";
		 echo($form_html);
	 }
	 
	 public function post( ){
		 print_r( $_POST );
		 foreach ( $_POST As $key => $value ){
			 /*/if( !array_key_exists( $key, $this->fields ) )
			echo("Error 1 $key");
			if( $this->validate_type ( $value, $this->fields[$key]->type ) )
				$_POST[$key]= $this->sanitize( $_POST[$key] );*/
			if( ( $this->fields[$key]->not_null == true ) && ( !$_POST[$key] ) )
				unset($_POST);
			echo "<br /> $key :".$_POST[$key];
		 }
	 }
	 public function validate_type ( $var, $type ){
			switch ( $type ) {
				case "int":
					if( !is_numeric( $var ) )
						return false;
					break;
				case "float":
					if( !is_float( $var ) )
						return false;
					break;
				default:
					return true;
				break;
			}
	
	}
	public function sanitize( $string ){
		$return = addslashes( strip_tags ( $string ) );
		return $return;
	}
	/**
	 * 
	 * @access public
	 * @return void
	 */


} // end of mysql_table
?>