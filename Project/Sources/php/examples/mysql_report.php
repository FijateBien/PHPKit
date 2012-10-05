<?php
/*
 * mysql_report.php
 * 
 * class mysql_report
 */
 
 class mysql_report{
	 /**
	  *  @access public
	  */ 
	  
	  public $mysql_command;
	  
	  /**
	   * 
	   * @access public
	   */ 
	   public function __construct( $command, $table ){
		   switch( $_GET[ 'order' ] ){
			   case 'DESC':
					$order = 'DESC';
				break;
				case 'ASC':
					$order = 'ASC';
				break;
				default:
					$order = 'ASC';
				break;
		   }
		   $command -> exec ( "SELECT * from $table" );
		   $item = $command->fetch_one( );
		   if( property_exists( $item, $_GET['orderby'] ) ):
				$command-> exec( "SELECT * FROM $table ORDER BY $_GET[orderby] $order" );
			endif;
		   // Get the data
		   $list = $command->fetch( );
		   // Get the fields
		   $fields = $command->fetch_fields( );
		   // Form actions
		   
		   $table_html.="<form>";
				$table_html.="<label for='orderby'>Orderby</label>";
				$table_html.="<select name='orderby'>";
					foreach( $fields As $field )
						$table_html.= "<option value='$field->name'>$field->name</option>'";
				$table_html.="</select>";
				$table_html.="<label for='order'>Order</label>";
				$table_html.="<select name='order' id='order'>";
					$table_html.="<option>ASC</option>";
					$table_html.="<option>DESC</option>";
				$table_html.="</select>";
				$table_html.="<label for='search'>Search</label>";
				$table_html.="<input type='text' name='search' id='search' placeholder='search'/>";
				$table_html.="<label for='searchby'>Search by</label>";
				$table_html.="<select name='searchby'>";
					foreach( $fields As $field )
						$table_html.= "<option value='$field->name'>$field->name</option>'";
					$table_html.= "<option value='ALL'>ALL</option>'";
				$table_html.="</select>";
				$table_html.="<button>Filter</button>";
		   $table_html.="</form>";
		   
		   // Begin html table
		   $table_html .= "<table id='$table' class='mysql_report'>";
		   // Begin the headers
		   $table_html.="<tr>";
		   $table_html.="<th>*</th>";
		   foreach( $fields As $th ):
				if( ( isset( $_GET['order'] ) ) && ($_GET['orderby']==$th->name) ):
					if( $_GET['order'] =='ASC' ):
						$order = 'DESC';
					else:
						$order = 'ASC';
					endif;
				else:
					$order = 'ASC';
				endif;
				
				$table_html.="<th><a href='?orderby=$th->name&order=$order'>$th->name</a></th>";
			endforeach;
		   $table_html.="</tr>";
		   foreach( $list As $tr ):
				$table_html.= "\n<tr>";
				$table_html.= "\n\t<td><input type='checkbox' name='row[]' value='0'/></td>";
				
				foreach( $tr As $col )
					$table_html.= "\n\t<td>" . substr( strip_tags ( $col ), 0, 48 ) . "</td>";
				$table_html.="\n</tr>";
			endforeach;
		   // End html table
		   $table_html.="\n</table>";
		   echo( $table_html );
	   }
 }

?>
