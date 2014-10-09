<?PHP
echo "</br>";
echo "</br>";
echo "</br>";

?>
<html>
<body background="black-floor.jpg">
<a href="index.php"> Go back </a>
<br>
<style>
		table, td, th {
			border: 1px  #848484;
		}

		th {
			padding: 15px;
			background-color: #848484;
			color: white;
		}
		td {
			padding: 15px;
			 background-color: #848484;
		}
</style>
<?php
		
     	$wine_name_search=$_GET["WINENAME"];
		$region_search=$_GET["region"];
		$winery_search=$_GET["WINERY_NAME"];
		$year1=$_GET["years1"];
		$year2=$_GET["years2"];
		$min_wine_search=$_GET["min_wine"];
		$min_cust=$_GET["MIN_CUST"];
		$min_cost=$_GET["min_cost"];
		$max_cost=$_GET["max_cost"];
		
		
		if ($year1 == NULL)
			$year1 = "1970";
		
		if ($year2 == NULL)
			$year2 = "1999";
		if($region_search == "All")
			$region_search = "";	
			
		if ($min_wine_search== NULL)
			$min_wine_search = "0";
			
		if ($min_cost == NULL)
			$min_cost = "5";
		
		if ($max_cost == NULL)
			$max_cost = "30";
			
		if (($max_cost != NULL) && ($min_cost != NULL) && ($max_cost<$min_cost))
		{
		    echo '<font color = "white">';
		    ECHO "Maximum cost should be greater than Minimum cost";
			echo '</font>';
		}
		if ($min_cust == NULL)
		   $min_cust = "0";
		
		
		
		//CONNECTION TO DATABASE
		$con=mysqli_connect("localhost","root","");
		$database="winestore";
		@mysqli_select_db($con,$database) 
		or die( "UNABLE TO SELECT DATABASE");

		$query="SELECT 	wine_name,
					   (SELECT variety FROM grape_variety where grape_variety.variety_id = wine_variety.variety_id) AS variety,
						winery_name,
						year,
						region_name,
                       (SELECT MIN(cost) FROM inventory WHERE inventory.wine_id = wine.wine_id) AS cost,
					   (SELECT COUNT(orders.cust_id) FROM orders WHERE orders.order_id = items.order_id and items.wine_id = wine.wine_id) AS num_customers,
					   inventory.on_hand as stock
						
					   
						
				FROM   wine 
				INNER JOIN winery ON wine.winery_id = winery.winery_id
				INNER JOIN region on winery.region_id = region.region_id
                INNER JOIN wine_variety on wine.wine_id = wine_variety.wine_id
				LEFT OUTER JOIN items on wine.wine_id = items.wine_id
				INNER JOIN inventory ON wine.wine_id = inventory.wine_id
				
								
				WHERE (wine.wine_name LIKE '%$wine_name_search%')
						AND (region.region_name LIKE '%$region_search%')
						AND (winery.winery_name LIKE '%$winery_search%')
						AND(year BETWEEN $year1 AND $year2)
						AND ( inventory.on_hand >= $min_wine_search )
						AND (inventory.cost>$min_cost and inventory.cost<$max_cost)";
					//AND ( (SELECT COUNT(orders.cust_id) FROM orders WHERE orders.order_id = items.order_id) >0";
					//AND ((SELECT COUNT(orders.cust_id) FROM orders WHERE orders.order_id = items.order_id)>$min_cust)";

		//(SELECT stock FROM inventory WHERE cost =( Select min(inventory.cost) from inventory where inventory.wine_id = wine.wine_id)) as num
		//AND ((SELECT COUNT(cust_id) FROM orders WHERE orders.order_id = items.order_id)>$min_cust)";
		
		$result=mysqli_query($con,$query);
		
	
	
	if(mysqli_num_rows($result) >0)  //This will shows if the query results any rows
	{
        echo '<center><table border = 2>';
			echo '<tr>  
				 <th>WINE NAME </th>
				 <th>REGION</th>
				 <th>WINERY</th>  
				 <th>YEAR</th>
				 <th> WINE VARIETIES </th>
				 <th>MINIMUM COST</th>
				 <th>TOTAL NUM OF BOTTLES (STOCK)</th>
				 <th>NUM OF CUSTOMERS</th>
				 </tr>';
		
			while($row=mysqli_fetch_array($result))
			{ 
				echo '<tr>';
				echo '<td>'; echo $row["wine_name"]; echo '</td>';
				echo '<td>'; echo $row["region_name"]; echo '</td>';
				echo '<td>'; echo $row["winery_name"]; echo '</td>';
				echo '<td>'; echo $row["year"]; echo '</td>';
				echo '<td>'; echo $row["variety"]; echo '</td>';
				echo '<td>'; echo $row["cost"]; echo '</td>';
				echo '<td>'; echo $row["stock"]; echo '</td>';
				//echo '<td>'; echo $row["num"]; echo '</td>';
				echo '<td>'; echo $row["num_customers"]; echo '</td>';
				echo "</tr>";
			}
        echo '</table></center>';
		
	}
	else
	{
	    echo '<br/>';
		echo '<font color="white">';
		echo "No records match your search criteria";
		echo '</font>';
	}

@mysqli_close();


?>

</body>
</html>
