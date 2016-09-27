<?php 
class MySQLHandler { 

  // Change these variables to your own database settings 
  var $DATABASE = 'dbweb'; 
  var $USERNAME = 'root'; 
  var $PASSWORD = ''; 
  var $SERVER = 'localhost'; 

  //var $LOGFILE = "c:/mysqli.log"; 	// full path to debug LOGFILE. Use only in debug mode! 
  var $LOGFILE = "mysqli.log"; 		// full path to debug LOGFILE. Use only in debug mode! 
  var $LOGGING = false;			 	// debug on or off 
  var $SHOW_ERRORS = true; 			// output errors. true/false 
  var $USE_PERMANENT_CONNECTION = false; 

  // Do not change the variables below 
  var $CONNECTION; 
    var $FILE_HANDLER; 
    var $ERROR_MSG = ''; 

########################################### 
# Function:    init 
# Parameters:  N/A 
# Return Type: boolean 
# Description: initiates the MySQL Handler 
########################################### 
  function init(){ 
    $this->logfile_init(); 
    if ($this->OpenConnection()) { 
      return true; 
    } else { 
      return false;
        } 
    } 

########################################### 
# Function:    OpenConnection 
# Parameters:  N/A 
# Return Type: boolean 
# Description: connects to the database 
########################################### 
    function OpenConnection()    { 
    if ($this->USE_PERMANENT_CONNECTION) { 
      $conn = mysqli_pconnect($this->SERVER,$this->USERNAME,$this->PASSWORD, $this->DATABASE); 
    } else { 
      $conn = mysqli_connect($this->SERVER,$this->USERNAME,$this->PASSWORD); 
    } 
      if (!$conn || (!mysqli_select_db($conn, $this->DATABASE))) { 
      //$this->ERROR_MSG = "\r\n" . "Unable to connect to database - " . date('H:i:s'); 
	  $this->ERROR_MSG = "\r\n" . " Unable to connect to database - MySQLHandler.OpenConnection() " . $this->get_current_datestamp(); 
      $this->debug(); 
      return false; 
    } else { 
          $this->CONNECTION = $conn; 
          return true; 
    } 
    } 

########################################### 
# Function:    CloseConnection 
# Parameters:  N/A 
# Return Type: boolean 
# Description: closes connection to the database 
########################################### 
    function CloseConnection() { 
      if (mysqli_close($this->CONNECTION)) { 
      return true; 
    } else { 
      //$this->ERROR_MSG = "\r\n" . "Unable to close database connection - " . date('H:i:s'); 
	  $this->ERROR_MSG = "\r\n" . "Unable to close database connection - " . $this->get_current_datestamp(); 
      $this->debug(); 
      return false; 
    } 
    } 

########################################### 
# Function:    logfile_init 
# Parameters:  N/A 
# Return Type: N/A 
# Description: initiates the logfile 
########################################### 
    function logfile_init() { 
    if ($this->LOGGING) { 
      $this->FILE_HANDLER = fopen($this->LOGFILE,'a') ; 
        $this->debug(); 
    } 
    } 
    
########################################### 
# Function:    logfile_close 
# Parameters:  N/A 
# Return Type: N/A 
# Description: closes the logfile 
########################################### 
    function logfile_close() { 
    if ($this->LOGGING) { 
          if ($this->FILE_HANDLER) { 
            fclose($this->FILE_HANDLER) ; 
        } 
    } 
    } 

########################################### 
# Function:    debug 
# Parameters:  N/A 
# Return Type: N/A 
# Description: logs and displays errors 
########################################### 
  function debug() { 
    if ($this->SHOW_ERRORS) { 
      echo $this->ERROR_MSG; 
    } 
    if ($this->LOGGING) { 
          if ($this->FILE_HANDLER) { 
              fwrite($this->FILE_HANDLER,$this->ERROR_MSG); 
          } else { 
              return false; 
          } 
    } 
    } 

########################################### 
# Function:    Insert 
# Parameters:  sql : string 
# Return Type: integer 
# Description: executes a INSERT statement and returns the INSERT ID 
########################################### 
function Insert($sql) { 
  if((empty($sql)) || (!eregi("^insert",$sql)) || (empty($this->CONNECTION))) { 
    //$this->ERROR_MSG = "\r\n" . "SQL Statement is <code>null</code> or not an INSERT - " . date('H:i:s'); 
    $this->ERROR_MSG = "\r\n" . "SQL Statement is <code>null</code> or not an INSERT - " . $this->get_current_datestamp(); 
    $this->debug(); 
    return false; 
  }else { 
    $conn = $this->CONNECTION; 
    $results = mysqli_query($conn,$sql); 
    if (!$results) { 
      //$this->ERROR_MSG = "\r\n" . mysqli_error()." - " . date('H:i:s'); 
	  $this->ERROR_MSG = "\r\n" . mysqli_error()." - " . $this->get_current_datestamp(); 
      $this->debug(); 
      return false; 
    }else{ 
      $result = mysqli_insert_id($conn);
      return $result; 
	  //return true; 
    }
  } 
}

########################################### 
# Function:    Select 
# Parameters:  sql : string 
# Return Type: array 
# Description: executes a SELECT statement and returns a 
#              multidimensional array containing the results 
#              array[row][fieldname/fieldindex] 
########################################### 
    function Select($sql)    { 
      if ((empty($sql)) || (!eregi("^select",$sql)) || (empty($this->CONNECTION))) { 
        //$this->ERROR_MSG = "\r\n" . "SQL Statement is <code>null</code> or not a SELECT - " . date('H:i:s'); 
	    $this->ERROR_MSG = "\r\n" . " SQL Statement is <code>null</code> or not a SELECT - MySQLHandler().Select " . $this->get_current_datestamp(); 
        $this->debug(); 
        return false; 
      } else {
        $conn = $this->CONNECTION; 
        $results = mysqli_query($conn,$sql); 
        if ((!$results) || (empty($results))) {
          //$this->ERROR_MSG = "\r\n" . mysqli_error()." - " . date('H:i:s'); 
		  $this->ERROR_MSG = "\r\n" . mysqli_error()." - " . $this->get_current_datestamp(); 
          $this->debug(); 
          return false; 
        } else { 
          $i = 0; 
          $data = array(); 
          while ($row = mysqli_fetch_array($results)) { 
            $data[$i] = $row; 
            $i++; 
          } 
          mysqli_free_result($results); 
          return $data; 
        } 
      } 
    } 
	
	function get_current_datestamp(){ 
      //get the current timestamp 
      $currdate = gmdate("Ymd"); 
      $currday = substr($currdate,6,2); 
      $currmonth = substr($currdate,4,2); 
      $curryear = substr($currdate,0,4); 
      $currdate_stamp = ($curryear . "-" . $currmonth . "-" . $currday); 
      return $currdate_stamp; 
    }

########################################### 
# Function:    Update 
# Parameters:  sql : string 
# Return Type: integer 
# Description: executes a UPDATE statement 
#              and returns number of affected rows 
########################################### 
    function Update($sql)    { 
        if ((empty($sql)) || (!eregi("^update",$sql)) || (empty($this->CONNECTION))) {
      //$this->ERROR_MSG = "\r\n" . "SQL Statement is <code>null</code> or not an UPDATE - " . date('H:i:s'); 
	  $this->ERROR_MSG = "\r\n" . "SQL Statement is <code>null</code> or not an UPDATE - " . $this->get_current_datestamp(); 
      $this->debug(); 
      return false; 
	  }
	  else { 
          $conn = $this->CONNECTION; 
          $results = mysqli_query($conn,$sql); 
          if (!$results) { 
			//$this->ERROR_MSG = "\r\n" . mysqli_error()." - " . date('H:i:s'); 
			$this->ERROR_MSG = "\r\n" . mysqli_error()." - " . $this->get_current_datestamp(); 
			$this->debug(); 
			return false; 
		  }
		  else {
            //return mysqli_affected_rows(); 
			return true;
		  } 
	 } 
    } 
  
########################################### 
# Function:    Replace 
# Parameters:  sql : string 
# Return Type: boolean 
# Description: executes a REPLACE statement 
########################################### 
    function Replace($sql) { 
        if ((empty($sql)) || (!eregi("^replace",$sql)) || (empty($this->CONNECTION))) { 
      //$this->ERROR_MSG = "\r\n" . "SQL Statement is <code>null</code> or not a REPLACE - " . date('H:i:s'); 
	  $this->ERROR_MSG = "\r\n" . "SQL Statement is <code>null</code> or not a REPLACE - " . $this->get_current_datestamp(); 
      $this->debug(); 
      return false; 
    } else { 
          $conn = $this->CONNECTION; 
          $results = mysqli_query($conn,$sql); 
          if (!$results) { 
        //$this->ERROR_MSG = "\r\n" . "Error in SQL Statement : ($sql) - " . date('H:i:s'); 
		$this->ERROR_MSG = "\r\n" . "Error in SQL Statement : ($sql) - " . $this->get_current_datestamp(); 
        $this->debug(); 
        return false; 
      } else { 
            return true; 
      } 
    } 
    }  

########################################### 
# Function:    Delete 
# Parameters:  sql : string 
# Return Type: boolean 
# Description: executes a DELETE statement 
########################################### 
    function Delete($sql)    { 
        if ((empty($sql)) || (!eregi("^delete",$sql)) || (empty($this->CONNECTION))) { 
      //$this->ERROR_MSG = "\r\n" . "SQL Statement is <code>null</code> or not a DELETE - " . date('H:i:s'); 
	  $this->ERROR_MSG = "\r\n" . "SQL Statement is <code>null</code> or not a DELETE - " . $this->get_current_datestamp(); 
      $this->debug(); 
      return false; 
    } else { 
          $conn = $this->CONNECTION; 
          $results = mysqli_query($conn,$sql); 
          if (!$results) { 
        //$this->ERROR_MSG = "\r\n" . mysqli_error()." - " . date('H:i:s'); 
		$this->ERROR_MSG = "\r\n" . mysqli_error()." - " . $this->get_current_datestamp(); 
        $this->debug(); 
        return false; 
      } else { 
            return true; 
      } 
    } 
    } 
  
########################################### 
# Function:    Query 
# Parameters:  sql : string 
# Return Type: boolean 
# Description: executes any SQL Query statement 
########################################### 
    function Query($sql)    { 
        if ((empty($sql)) || (empty($this->CONNECTION))) { 
      //$this->ERROR_MSG = "\r\n" . "SQL Statement is <code>null</code> - " . date('H:i:s'); 
	  $this->ERROR_MSG = "\r\n" . "SQL Statement is <code>null</code> - " . $this->get_current_datestamp(); 
      $this->debug(); 
      return false; 
    } else { 
          $conn = $this->CONNECTION; 
          $results = mysqli_query($conn,$sql); 
          if (!$results) { 
        //$this->ERROR_MSG = "\r\n" . mysqli_error()." - " . date('H:i:s'); 
		$this->ERROR_MSG = "\r\n" . mysqli_error()." - " . $this->get_current_datestamp(); 
        $this->debug(); 
        return false; 
      } else { 
            return true; 
      } 
    } 
    } 

################################################################## 
# Function:    Pagination 
# Parameters:  aCondition : string : SQL Condition 
#              aRecordCount : int : Total No of Records 
#              aLimit : int : No of Records per page 
#              aLimitPage : int : No of Pages in pagination
#              aPage : int : Page to be shown
#              aFileName : string : Page to redirect   
# Return Type: string 
# Description: Constructs a Pagination
#################################################################
	function Pagination($aCondition,$aRecordCount,$aLimit,$aLimitPages,$aPage,$aFileName){
	  $s_pagination = '';
	  $conditions = urlencode($aCondition);
      $numPages = intval($aRecordCount / $aLimit);
	  $modPages = $aRecordCount % $aLimit;
      if($modPages>0){
		$numPages = $numPages +1;
	  }
	  $startPage = intval(($aPage-1)/ $aLimitPages) * $aLimitPages + 1;
	  $endPage = $startPage + $aLimitPages - 1;
	  if($endPage>$numPages){
		$endPage = $numPages;
	  }
	  if($startPage>$aLimitPages){
		$prev = $startPage - 1;
		//echo('<a href="'.$aFileName.'?page='.$prev.'&conditions='.$conditions.'"><< prev</a>'.' ');
		$s_pagination = '<a href="'.$aFileName.'?page='.$prev.'&conditions='.$conditions.'"><< prev</a>'.' ';
	  }
	  for($i=$startPage;$i<=$endPage;$i++){
        if($i==$aPage){
		  //echo('<b>['.$i.']</b></a>'.' ');
		  $s_pagination = $s_pagination.'<b>['.$i.']</b></a>'.' ';
		}else{
		  //echo('<a href="'.$aFileName.'?page='.$i.'&conditions='.$conditions.'">'.$i.'</a>'.' ');
		  $s_pagination = $s_pagination.'<a href="'.$aFileName.'?page='.$i.'&conditions='.$conditions.'">'.$i.'</a>'.' ';
		}
	  }
	  if($endPage<$numPages){
		$next = $endPage + 1;
		//echo('<a href="'.$aFileName.'?page='.$next.'&conditions='.$conditions.'">next >></a>');
		$s_pagination = $s_pagination.'<a href="'.$aFileName.'?page='.$next.'&conditions='.$conditions.'">next >></a>';
	  }
	  return $s_pagination;
	}
}
?>