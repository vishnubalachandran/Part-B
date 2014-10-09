<html>
<body >
<style>
		table, td, tr{
			border: 1px SOLID #848484;
		}

		tr {
			padding: 15px;
			background-color: #848484;
			color: white;
		}
		td {
			padding: 15px;
			 background-color: #848484;
		}

</style>
<BR/>
<BR/>
<?php

		//CONNECTION TO DATABASE
		
		$con=mysqli_connect("localhost","root","");
		$database="winestore";
		@mysqli_select_db($con,$database) 
		or die( "UNABLE TO SELECT DATABASE");

		$query="SELECT region_name 
				FROM   region";

		
		$result=mysqli_query($con,$query);
		
	    echo'<form name ="FORM1" action="Answer.php" method="get">';
	
	    echo '<center><table>';
	     //Question 1 
		echo '<tr>';
		
	    echo '<td>'; echo 'WINE NAME';  echo '</td>';
		echo '<td>';  echo '<INPUT TYPE = "TEXT" NAME ="WINENAME" width = "50px"/>';echo '</td>';
	    echo '</tr>';
	    //echo '<br/>';
	
     	//Question 2
	    echo '<tr>';
		echo '<td>'; echo 'REGION';	echo '</td>';
		echo '<td>'; echo'<select name="region">';

						while($row=mysqli_fetch_array($result))
						 { 
						 
						  $range=$row["region_name"];
						   
						   ?> <option value="<?php echo "$range" ?>">         <?php	echo $range  ?>         </option><?Php
						 
							
						}
					echo'</select>';
		echo '</td>';
        echo '</tr>';
        
		//Question 3
		
		echo '<tr>';
		echo '<td>';echo 'WINERY NAME'; echo '</td>';
		echo '<td>';echo  '<INPUT TYPE = "TEXT" NAME ="WINERY_NAME">';echo '</td>';
		 echo '</tr>';
		
		//Question 4
		
		echo '<tr>';
		echo '<td>';echo 'START YEAR  ';

		echo '<INPUT TYPE = "TEXT" NAME ="years1">'; echo '</td>';
		echo '<td>'; echo 'END YEAR  '; echo '<INPUT TYPE = "TEXT" NAME ="years2">';
		echo '</td>';
		 echo '</tr>';

		//Question 5 
			echo '<tr>';
		echo '<td>';echo 'MIN NUMBER OF WINES';echo '</td>';
		echo '<td>';echo '<INPUT TYPE = "TEXT" NAME ="min_wine">';echo '</td>';
		 echo '</tr>';
		
		//Question 6
		echo '<tr>';
		echo '<td>';echo 'MIN NUMBER OF CUSTOMERS :'; echo '</td>';
		echo '<td>';echo '<INPUT TYPE = "TEXT" NAME ="MIN_CUST">';	echo '</td>';	
		 echo '</tr>';
		
		
		//question 7
		echo '<tr>';
		echo '<td>';echo 'MIN COST : <INPUT TYPE = "TEXT" NAME ="min_cost">';echo '</td>';
		echo '<td>';echo 'MAX COST : <INPUT TYPE = "TEXT" NAME ="max_cost">';echo '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td COLSPAN="2">';
		echo '<CENTER>
		<input type="submit"  VALUE ="SEARCH" style="color:#842DCE;
											   font-family:Andalus;
											   font-size:20pt;  
											  border-color:#842DCE;	  
											  border-style:dashed; 
											  background-color:#000000;
											   border-width:1;
											   border-style:dashed;
       
												margin-top:7px;"/>
		</CENTER>';
		echo '</td>';	
		 echo '</tr>';
 echo '</table></center>';
 echo '</form>';
@mysqli_close();
?>
