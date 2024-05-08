
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
	$query = "SELECT  id ,ssec,gov,sec, requestnumber, name ,phone ,addr FROM \"1_print_certificate_cover\" WHERE requestnumber LIKE '%". $userid ."%'"."OR requestnumber = '".$userid."'"."OR requestnumber = '%". $userid."'";
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
            
            <html>
         <head>
         <style>
        .container{
          margin-bottom:-52px;

        }
       
          .vv{
            margin-top:63px;
            padding-top:74px;
       
          }
          h1{
            font-size:83px;
            margin-top:-46px;
            
           text-align:center;
            font-weight:bold;
            
          }
          div {
            min-width: 1000px;
            max-width: 1000px;
        }
         body {
            font-family: Arial;
            width: 1870px !important;
            height: 560px;
            font-family: "PT Bold Heading";
        }

        #destinationAddress {
              font-size:60px;
              margin-left: -7px;
                width: 1600px !important;
                direction: rtl;
        }
      
            .hr{
                border-top: 2px solid rgb(0 0 0 / 54%);
                width:100%
            }
            .move{
              margin-right:230px
            }
            span{
              padding-top:50px;
            }
            .a{
              padding-top: 40px;
            }
         </style>
       </head>

       <body>

      
 <div id="destinationAddress">
       <div class="container">
         <div class="v">
        <img src="rsc.png" style="width:300px;position: relative; float: left;margin-top:-63px ">
          </div>
         <div class="vv">
           <h1> المركز التكنولوجي </h1>    
         <h1>   للتسجيل المساحي  العقاري </h1>
     </div>
 
</div>
<hr class="hr">
<br>
       <span class="replay" style="position: absolute;">رقم الطلب  :</span>
        <p class="move"> ${data.requestnumber} </p>
       
        <p class="a"> الإسم :<span>&nbsp;</span> ${data.name}</p>
    
        <p class="a"> رقم الهاتف:<span>&nbsp;</span> ${data.phone}</p>
      
        <p class="a">العنوان :<span>&nbsp;${data.addr} - ${data.sec} - ${data.gov}</span> </p>
  
        </div>
        
    <hr class="hr"/>
       
     
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