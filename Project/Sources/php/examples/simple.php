<?php
/**
 * Created by alberto
 * @example
 */
require_once ( "mysql_connection.php" );
require_once ( "mysql_command.php" );
require_once ( "mysql_field.php" );
require_once ( "mysql_table.php" );

$myConnection = new mysql_connection("root", "471291471291", "localhost", "fumitodo");

$myConnection->connect();

$myTable = new mysql_table("paginas");

// This is an modification

if (!isset($_GET['p']))
    $_GET['p'] = 'contacto';

$ID = $myTable->sanitize($_GET['p']);

$myResource = new mysql_command("SELECT * from paginas WHERE ID = '$ID';", $myConnection, 1);

  $myResource -> exec ( );

  $myList = $myResource -> fetch_one( );

  foreach( $myList As $myItem )
  echo( $myItem );

  $myResource -> exec( "SELECT * from paginas" );

  $myList = $myResource -> fetch( );

  echo( "<ul>" );
  foreach( $myList As $menuItem )
  printf( "<li><a href='?p=%s'>%s</a></li>", $menuItem->ID, $menuItem->Titulo_menu);
  echo( "</ul>" );

  $myResource -> generate_report( $myList );

?> 
