
<?php





include "config.php";

$request = "";
if(isset($_GET['request'])){
	$request = $_GET['request'];
}


	$userid ='##' ;

// Fetch record by id
if($request =='search'){
	if(isset($_GET['userid']) ){ 
	    $userid = $_GET['userid']; 
	    
	}
}
	// $query = 'SELECT * FROM print_sh ';
	$query = "SELECT  id ,ssec,gov,sec, requestnumber, name ,phone ,addr FROM print_sh WHERE requestnumber LIKE '%". $userid ."%'"."OR requestnumber = '".$userid."'"."OR requestnumber = '%". $userid."'";
	$result = pg_query($con, $query);

	$response = array();
	if (pg_numrows($result) > 0) {

		// $row = pg_fetch_assoc($result);
		while ($row = pg_fetch_assoc($result) ) {
			
		

		$id = $row['id'];
		$requestnumber = $row['requestnumber'];
		$name=$row['name'];
		$phone = $row['phone'];
		$addr = $row['addr'];
      $ssec = $row['ssec'];
      $sec = $row['sec'];
      $gov = $row['gov'];
	    $response[] = array(
					"id" => $id,
					"requestnumber" => $requestnumber,
					"name" =>$name,
					"phone" => $phone,
					"addr" => $addr,
               "ssec" => $ssec,
               "sec" => $sec,
               "gov" => $gov,
				);
	} 
	}






?>

<!DOCTYPE html>

<html>
<head>
   
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
  <meta charset="UTF-8">
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
   <meta charset="utf-8">
   
</head>
<body>
<div class="container">
<img src="logo.png" style="float: left; width: 7%;height: 7%;">
 
                <form action="index.php" method="get">
                <input type="text" id="search" name='userid' class="form-control rounded" placeholder="بحــــــث ......" aria-label="Search"
                aria-describedby="search-addon" style="height: 40px;" />
   <input type="submit"  value="search" id='but_search' name="request" class="btn btn-outline-primary mt-3" style="float: left;margin: 10px 0 0 20px; " />
   </form>
   <a  class="btn btn-danger mt-3" href="./?" style="float: left; margin: 10px 0 0 20px; ">close</a>
   <br/>
  
   <div class="container mt-3" style="margin-top: 80px;">
   <!-- Table -->
   <table border='1' id='userTable' class="table " style='direction:rtl;'>
     <thead>
       <tr>
       <th > #</th>
       <th >رقم الطلب</th>
     <th >أسم مقدم الطلب</th>
     <th >رقم التليفون</th>
     <th >العنوان</th>
     <th  >--</th>
    
       </tr>
      <!-- <button> print</button>-->
      <?php
        foreach($response as $k=>$v) {

    echo '<tr> ';
    echo " <th > " . $v['id'] . " </th>";
    echo " <th >" . $v['requestnumber'] . " </th>";
    echo " <th >" . $v['name'] . " </th>";
    echo " <th >" . $v['phone'] . " </th>";

    echo " <th >" .$v['addr'] . "</th>";
    $data=json_encode($v);
    echo " <th  ><a href='#'class='btn btn-info'  onclick='print( $data)'>طباعة </a></th>";
    echo "</tr>";
        }
?>
     </thead>
     <tbody>

     </tbody>
   </table>
</div>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
<script type="text/javascript">
    function print (data){
       
           
            var w = window.open();
          
            var constant=`
            
            <html dir=rtl>
         <head>
         <style>
         div {
          min-width: 350px;
            max-width: 350px;
           
        }
         body {
            font-family: Arial;
            width: 1870px !important;
            height: 560px;
            font-family: "PT Bold Heading";
        }

        #destinationAddress {
              font-size:120px;
              font-weight:bold;
                margin:20% 10%;
                width: 1600px !important;
                direction: rtl;
        }
        #destinationAddress p {
            width: 500%;
        }
        #labelHeader+hr {
                width: 1850px;
                border: 3px !important;
                border-top: 2px solid #000000 !important;
            }
            .none{
                direction: ltr;
            }
          
            .hr{
                border-top: 2px solid rgb(0 0 0 / 54%);
            }
            .move{
              margin-right:470px
            }
         </style>
       </head>

       <body>
      
       <div id="destinationAddress">
       <span class="replay" style="position: absolute;">رقم الطلب  :</span>
        <p class="move"> ${data.requestnumber} </p>
       
        <p> الإسم :<span>&nbsp;</span> ${data.name}</p>
    
        <p> رقم الهاتف:<span>&nbsp;</span> ${data.phone}</p>
      
        <p>العنوان :<span>&nbsp;${data.addr} - ${data.sec} - ${data.gov}</span> </p>
  
        </div>
        
        <hr class="hr"/>
       
           <img src="rsc.png" style=" position: absolute;padding-inline:60%;  width: 700px; margin-top:600px ;">
     
        </body></html>
            `


            w.document.write(constant) ;
            
           
            setTimeout(function() {
               w.window.print();
               w.window.close();
}, 250);
        
    }
</script>
</body>
</html>