<?php
/**
 * MYSQL EXPORT TO GZIP 
 * exporting database to sql gzip compression data.
 * if directory writable will be make directory inside of directory if not exist, else wil be die
 *
 * @param string directory , as the directory to put file
 * @param $outname as file name just the name !, if file exist will be overide as numeric next ++ as name_1.sql.gz , name_2.sql.gz next ++
 *
 * @param string $dbhost database host
 * @param string $dbuser database user
 * @param string $dbpass database password
 * @param string $dbname database name
 *
 */
function backup_database($dbhost, $dbuser, $dbpass ,$dbname, $write = false){
  
  // check mysqli extension installed
  if( ! function_exists('mysqli_connect') ) {
    die(' This scripts need mysql extension to be running properly ! please resolve!!');
  }
 
	$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	
	if( $mysqli->connect_error ) {
		print_r( $mysqli->connect_error );
		return false;
	}
 
    if( ! $mysqli->error ) {
	 $mysqli->query("SET NAMES utf8");
      $sql = "SHOW TABLES";
      $show = $mysqli->query($sql);
      while ( $r = $show->fetch_array() ) {
        $tables[] = $r[0];
      }
 
      if( ! empty( $tables ) ) {
 
  //cycle through
  $return = '';
  foreach( $tables as $table )
  {
    $result     = $mysqli->query('SELECT * FROM '.$table);
    $num_fields = $result->field_count;
    $row2       = $mysqli->query('SHOW CREATE TABLE '.$table );
 
    $row2       = $row2->fetch_row();
    $return    .= 
"\n
-- ---------------------------------------------------------
--
-- Table structure for table : `{$table}`
--
-- ---------------------------------------------------------
 
".$row2[1].";\n";
 
    for ($i = 0; $i < $num_fields; $i++) 
    {
 
      $n = 1 ;
      while( $row = $result->fetch_row() )
      { 
        
 
        if( $n++ == 1 ) { # set the first statements
          $return .= 
"
--
-- Dumping data for table `{$table}`
--
 
";  
        /**
         * Get structural of fields each tables
         */
        $array_field = array(); #reset ! important to resetting when loop 
         while( $field = $result->fetch_field() ) # get field
        {
          $array_field[] = '`'.$field->name.'`';
          
        }
        $array_f[$table] = $array_field;
        // $array_f = $array_f;
        # endwhile
        $array_field = implode(', ', $array_f[$table]); #implode arrays
 
          $return .= "INSERT INTO `{$table}` ({$array_field}) VALUES\n(";
        } else {
          $return .= '(';
        }
        for($j=0; $j<$num_fields; $j++) 
        {
          
          $row[$j] = str_replace('\'','\'\'', preg_replace("/\n/","\\n", $row[$j] ) );
          if ( isset( $row[$j] ) ) { $return .= is_numeric( $row[$j] ) ? $row[$j] : '\''.$row[$j].'\'' ; } else { $return.= '\'\''; }
          if ($j<($num_fields-1)) { $return.= ', '; }
        }
          $return.= "),\n";
      }
      # check matching
      @preg_match("/\),\n/", $return, $match, false, -3); # check match
      if( isset( $match[0] ) )
      {
        $return = substr_replace( $return, ";\n", -2);
      }
 
    }
    
      $return .= "\n";
 
  }
 
$return = "
-- ---------------------------------------------------------
--
-- SIMPLE SQL Dump
--
-- Host Connection Info: ".$mysqli->host_info."
-- Generation Time: ".date('F d, Y \a\t H:i A ( e )')."
-- Server version: ".$mysqli->server_info."
-- PHP Version: ".PHP_VERSION." 
--
-- ---------------------------------------------------------\n\n
 
SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";
SET time_zone = \"+00:00\";
 
 
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
".$return."
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";
 
# end values result
 
 if($write) { # 9 as compression levels
    header('Content-Type: application/x-download');
    header("Content-Description: File Transfer");
    header('Content-Length: '.strlen($return)); #
    header('Content-Disposition: attachment; filename="backup.sql"');
    header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
    header('Connection: Keep-Alive');
    header('Expires: 0');
    header('Pragma: no-cache');
    echo $return;
  }
 
       } else {
 
         $return = '<p>Error when executing database query to export.</p>'.$mysqli->error;
       
       }
     }
 
 if( $mysqli && ! $mysqli->error ) {
      $mysqli->close();
 }
 
  return $return;
 
}
?>