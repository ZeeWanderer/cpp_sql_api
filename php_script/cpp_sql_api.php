<?php
include("../inc.php");
include('header.php');

function print_j($message)
{
    print json_encode($message);
}

if(!empty($_GET))
{
    $query_ =  $_GET['query'];
    $query_ = urldecode($query_);
    
    //$cmd_pre_ =  $_GET['cmd_pre'];
    //$cmd_pre_ = urldecode($cmd_pre_);
    
    $db_ =  $_GET['db'];
    $db_ = urldecode($db_);
    
    $fetch_cmd_ =  $_GET['fetch_cmd'];
    $fetch_cmd_ = urldecode($fetch_cmd_);
    
    //$cmd_post_ =  $_GET['cmd_post'];
    //$cmd_post_ = urldecode($cmd_post_);
}
else
{
    print("No arguments specified");
    exit();
}

$conn = new mysqli($server, $user, $pwd);

if ($conn->connect_errno)
{
    print_j("error: {$conn->connect_error}");
    $conn->close();
    exit();
}

if($db_ != "")
{
	$conn->select_db($db_);
}
else
{
	$conn->select_db($dbase);
}

if($conn->error)
{
    print_j("error: {$conn->error}");
    $conn->close();
    exit();
}

if($query_ != "")
{
	
	$result = $conn->query($query_);
	
	if($conn->error)
	{
	    print_j("error: {$conn->error}");
	    $conn->close();
	    exit();
	}


	if($result->num_rows == 0)
	{
	    print("Success");
	}
	else {
		if($fetch_cmd_ != "")
		{
			switch($fetch_cmd_)
			{
				case "assoc":
					{
					    $rows = array();
					    while ($r = $result->fetch_assoc()) 
					    {
					        $rows[] = $r;
					    }
					    print_j($rows);
					    break;
					}
			    case "all":
			    		print_j($result->fetch_all());
			    		break;
			    case "array":
			    	{
			    		$rows = array();
					    while ($r = $result->fetch_array()) 
					    {
					        $rows[] = $r;
					    }
					    print_j($rows);
			    		break;
			    	}
			    case "rows":
					{
					    $rows = array();
					    while ($r = $result->fetch_row()) 
					    {
					        $rows[] = $r;
					    }
					    print_j($rows);
					    break;
					}
			    case "fields":
			    		print_j($result->fetch_fields());
			    		break;
			    default: // All
			    		print_j($result->fetch_all());
			    		break;
			}
		}
		else
		{
			print_j($result->fetch_all());
		}
	}
}
else
{
	print("Query is empty");
}
$conn->close();
?>