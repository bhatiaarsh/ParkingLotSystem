<?php
 include "header.php"; 
 ?>
<!Doctype html>
<html>
<body>
<h1><em>Vehicle Parking Form </h1>

<form method="POST">
    <h3>1. Parking</h3>
    Vehicle Number: <input type="text" name="v_no" required><br><br>
    
    Vehicle Type: 
    <select name="type">
        <option value="Bike">Bike (10/hr)</option>
        <option value="Car">Car (20/hr)</option>
        <option value="SUV">SUV (30/hr)</option>
        <option value="Truck">Truck (50/hr)</option>
    </select><br><br>

    Entry Time: <input type="time" name="entry" required><br><br>
    Exit Time: <input type="time" name="exit" required><br><br>

    <h3>2. Extra Services</h3>
    <input type="checkbox" name="service[0]" value="100"> Car Wash (100) , Qty: <input type="number" name="qty[0]" value="0"><br>
    <input type="checkbox" name="service[1]" value="50"> Bike Wash (50) , Qty: <input type="number" name="qty[1]" value="0"><br>
    <input type="checkbox" name="service[2]" value="300"> Oil Change (300) , Qty: <input type="number" name="qty[2]" value="0"><br>
    <input type="checkbox" name="service[3]" value="50"> Tire Check (50) , Qty: <input type="number" name="qty[3]" value="0"><br><br>

    <input type="submit" name="calculate" value="Generate Bill">
</form>

<?php

if (isset($_POST['calculate'])) {
    
  
    $type = $_POST['type'];
    $entry = strtotime($_POST['entry']);
    $exit = strtotime($_POST['exit']);
    

    $diff = $exit - $entry;
    $hours = ceil($diff / 3600); // converts sec to hrs
    if ($hours < 0) $hours = 0;

    $rate = 0;
    if($type == "Bike")  $rate = 10;
    if($type == "Car")   $rate = 20;
    if($type == "SUV")   $rate = 30;
    if($type == "Truck") $rate = 50;

    $parkingTotal = $hours * $rate;

    if($hours > 5) {
        $parkingTotal = $parkingTotal * 0.90;
    }

    $servicesTotal = 0;
    $count = 0;

    if(isset($_POST['service'])){
        foreach($_POST['service'] as $key => $price){
            $q = $_POST['qty'][$key];
            if($q > 0){
                $servicesTotal += ($price * $q);
                $count++;
            }
        }
    }

    if($count > 2) {
        $servicesTotal = $servicesTotal * 0.95;
    }
    $fixedFee = 20;
    $subtotal = $parkingTotal + $servicesTotal;
    $tax = $subtotal * 0.08;      
    $grandTotal = $subtotal + $tax + $fixedFee;

   
    echo "<h3>3.Bill for: " . $_POST['v_no'] . "</h3>";
    echo "Parking Hours: " . $hours . "<br>";
    echo "Parking Total: " . $parkingTotal . "<br>";
    echo "Services Total: " . $servicesTotal . "<br>";
    echo "Tax (8%): " . $tax . "<br>";
    echo "Fixed Fee: " . $fixedFee . "<br>";
    echo "<b>Grand Total: " . $grandTotal . "</b>";
}
?>

</body>
</html>