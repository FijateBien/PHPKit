<?php
/**
 * simple.php
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
