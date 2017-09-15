<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="index.css"/>
<title>Untitled Document</title>
</head>

<body>

<?php
	
	$servername = 'localhost';
	$username = 'root';
	$password = '';
	$dbname = "family_account";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

//Welcome sentence
    echo "Hello Family! You have accessed to your Accounting Database successfully.";

?>

<h3 id="header">How much do We have:<span id="onhand">
	
<?php


//llamando el listado de Income en la bd
$sql = "SELECT SUM(Entry) AS totalIncome FROM activity WHERE category = 'Income'";
$sumaIncome = $conn->query($sql);
$Income = $sumaIncome->fetch_assoc();
$x = $Income['totalIncome'];


//llamando el listado de Expenses en la bd
$sql = "SELECT SUM(Entry) As totalExpenses FROM activity WHERE category = 'Expenses'";
$sumaExpenses = $conn->query($sql);
$Expenses = $sumaExpenses->fetch_assoc();
$y = $Expenses['totalExpenses'];

echo $x - $y;


?>


</span>!</h3>

<div id="left-section">
<div id="income">

<h3>Income</h3>
<form action="income_post.php" method="post">
<input class="form_elements" type="number" step="0.01" name="post_entry"><br>
<input class="form_elements" type="date" name="post_date"><br>
<input class="form_elements" type="text" name="post_description"><br>
<input class="form_elements" type="text" name="post_who"><br>
<input id="add1" type="submit">
</form>
</div>
<div id="reports">
<h3>See the Reports on:</h3>
<a href="index.php">Inicio</a>
</div>
</div>

<div id="right-section">
<div id="other">
<h3>Other Expenses</h3>
<form action="expense_post.php" method="post">
<input class="form_elements" type="number" step="0.01" name="post_entry"><br>
<input class="form_elements" type="date" name="post_date"><br>
<input class="form_elements" type="text" name="post_description"><br>
<input class="form_elements" type="text" name="post_who"><br>
<input id="add2" type="submit">
</form>
</div>
<div class="items">
<div id="modify">
<h3>Modify existing Items</h3>
</div>
<div id="add">
<h3>Add new Items</h3>
<form action="addnew_post.php" method="post">
<input class="form_elements" type="number" step="0.01" name="post_entry"><br>
<input class="form_elements" type="date" name="post_date"><br>
<input class="form_elements" type="text" name="post_description"><br>
<input class="form_elements" type="text" name="post_category"><br>
<input id="add3" type="submit">
</form>
</div>
</div>
</div>

<h4 id="requiered">Our next Two Months Requiered Expenses<br>
<?php


//llamando el listado de Income en la bd
$sql = "SELECT SUM(Entry) AS totalIncome FROM activity WHERE category = 'Income'";
$sumaIncome = $conn->query($sql);
$Income = $sumaIncome->fetch_assoc();
$x = $Income['totalIncome'];


//llamando el listado de Expenses en la bd
$sql = "SELECT SUM(Entry) As totalExpenses FROM activity WHERE category = 'Expenses'";
$sumaExpenses = $conn->query($sql);
$Expenses = $sumaExpenses->fetch_assoc();
$y = $Expenses['totalExpenses'];
 $z = $x - $y;


//llamando el listado de la bd
$sql = "SELECT id, Entry, date, description, category FROM activity WHERE category = 'Required' ORDER BY date ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>
<tr>
<th>Date</th>
<th>Description</th>
<th>Ammount</th>
<th>Left / Needed</th>
<th>Status</th>
</tr>";

    // output data of each row
    while($row = $result->fetch_assoc()) {
$m = $row["Entry"];
$z = $z - $m;
$c = 'Covered';
$nc = 'Not Covered';
if($z>0){
        echo "<tr>
<td>".$row["date"]."</td>
<td>".$row["description"]."</td>
<td>".$row["Entry"]."</td>
<td>$z</td>
<td>$c</td>
	</tr>";
} else {
        echo "<tr>
<td>".$row["date"]."</td>
<td>".$row["description"]."</td>
<td>".$row["Entry"]."</td>
<td>$z</td>
<td>$nc</td>
	</tr>";
}
    }
    echo "</table>";
} else {
    echo "0 results";
}

?>
</h4>

<h4 id="goals">Our next Plans/Goals<br>

<?php


//llamando el listado de la bd
$sql = "SELECT id, Entry, date, description, category FROM activity WHERE category = 'Plans' ORDER BY date ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
       echo "<table>
<tr>
<th>Date</th>
<th>Ammount</th>
<th>Description</th>
<th>Left / Needed</th>
<th>Status</th>
</tr>";

    // output data of each row
 while($row = $result->fetch_assoc()) {
$m = $row["Entry"];
$z = $z - $m;
$p = 'Possible';
$np = 'Not Possible';
if($z>0){
        echo "<tr>
<td>".$row["date"]."</td>
<td>".$row["description"]."</td>
<td>".$row["Entry"]."</td>
<td>$z</td>
<td>$p</td>
	</tr>";
} else {
        echo "<tr>
<td>".$row["date"]."</td>
<td>".$row["description"]."</td>
<td>".$row["Entry"]."</td>
<td>$z</td>
<td>$np</td>
	</tr>";
}
    }
    echo "</table>";
} else {
    echo "0 results";
}

$conn->close();
?>

</h4>
 
</body>
</html>