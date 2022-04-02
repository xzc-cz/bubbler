<!DOCTYPE html>
<html lang="en">
<head>
<title>COMP284Assignment1</title>
<link rel = "" href = "" type = "" >
<meta charset ="utf-8">
</head>
<body>
<article>
<header>
<h1>GYM-BOOKING system Chenxi Jia</h1>
</header>

<!---与服务器连接--->
<?php
$db_hostname = "studdb.csc.liv.ac.uk";
$db_database = "sgcjia4";
$db_username = "sgcjia4";
$db_password = "Jcx147258";
$db_charset = "utf8mb4";
$dsn = "mysql:host=$db_hostname;dbname=$db_database;charset=$db_charset";
$opt = array(
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
PDO::ATTR_EMULATE_PREPARES => false
);
?>

<!---把学校老师给的内容都先在前面提一提 requirement of the assignment--->
<div class = gym>
	<section id = "">
		<b>COMP284 assignment1 gym-booking system</b>
		<p>
			You can use this system to see how a gym booking system can be simulated.<br>
      You will need to select the course you wish to take and the time of the course, enter your name and mobile phone number.<br>
      <br>
      Please note that your name consists of only letters, hyphens, apostrophes and spaces; <br>
      it does not contain a sequence of two or more hyphens and apostrophes; begins with a letter or apostrophe; <br>
      and does not end with a hyphen. If these are not met, your name is not valid and the booking will fail.<br>
      <br>
      Your mobile number should consist of only digits and spaces; contain nine or ten digits; and start with the number 0.<br>
      If these are not met, your phone number is not valid and the booking will fail.<br>
		</p>
	</section>
</div>
<div class = "">
	<section id = "">
		<b> There are 4 sessions that can attend:<br> </b>
		<b>Zumba, Yoga, Pilates and Boxercise</b>
	</section>
</div>

<!-- Classes Table just a table shows the stuff clearly-->
		<div class = "">
			<section id = "">
				<h3> Session Timetable </h3>
				<table>
					<tr>
						<th class = "corner"></th>
						<th>11:00</th>
						<th>13:00</th>
						<th>14:00</th>
					</tr>
					<tr>
						<td class="Day">Monday</td>
						<td>Boxercise,Pilates</td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td class="Day">Tuesday</td>
						<td></td>
						<td>Yoga,Pilates</td>
						<td></td>
					</tr>
					<tr>
						<td class="Day"> Wednesday</td>
						<td></td>
						<td>Yoga,Boxercise</td>
						<td></td>
					</tr>
					<tr>
						<td class="Day">Thursday</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<!--  -->
					<tr>
						<td class="Day">Friday</td>
						<td></td>
						<td></td>
						<td>Pilates,Zumba</td>
					</tr>
				</table>
			</section>
		</div>

<!-- you should input your information here -->
		<div class="">
			<section id = "">
				<h3> BOOK HERE </h3>
				<p> Please enter your details into the form below. </p>
				<!-- 在这里展示预定信息 -->
        <form name='form1' method='post'>
        
        <!-- select class name with inserted value -->
        <label for ="Class">
        <select  name="Class"  onchange ="document.form1.submit()" > <!-- required 可能导致后面菜单选不上-->
					<option value="" disabled selected>Choose what you wanna study</option>
					<?php
          $pdo = new PDO($dsn,$db_username,$db_password,$opt);
          $Sql1 = "SELECT DISTINCT Class FROM gymBook WHERE capacity >0";
          $classSelect = $pdo -> prepare($Sql1);
          $classSelect -> execute();
          foreach ($classSelect as $row)
						echo "<option value = $row[Class]>".$row['Class']."</option>";
          ?>;  
            
        </select><br>
        <?php
       session_start();
       foreach ($_REQUEST as $key => $value){
       if ($key == 'Class'){
        if (!empty($key)){
          $_SESSION["Class"] = $value;
          echo "You have selected: ", $_SESSION["Class"];
        }
        }
        }
       ?><br> 
        
        <!-- select time with previous information collected -->
        <label for ="Time">
        <select  name="Time" required ="document.form1.submit()" >
					<option value="" disabled selected >Choose a time</option>
           <?php
           $pdo = new PDO($dsn,$db_username,$db_password,$opt);
          foreach ($_REQUEST as $key => $value){
          if ($key == 'Class'){
          $Sql2 = "SELECT Time FROM gymBook WHERE Capacity >0  AND Class= '$value' ";
          $timeSelect = $pdo -> prepare($Sql2);
          $timeSelect -> execute();
          foreach ($timeSelect as $row){
           echo "<option value = $row[Time] >".$row['Time']."</option>";
          }}}
           ?>;  

				</select><br>
         <?php
       foreach ($_REQUEST as $key => $value){
       if ($key == 'Time'){
        if (!empty($key)){
          $_SESSION["Time"] = $value;
          echo "You have selected: ", $_SESSION["Time"];
          }
          }
          }
       ?><br> 
    
    
    	
		 <p>Please input your name here:</p>
        <!-- name -->
        <label for ="Name">
				<input type="text" name="Name" value="" pattern = "[a-zA-Z'][a-zA-Z' -+]{0,}"
				 title = "Please enter a valid name" required ></label><br>
    	  <!-- 只由字母（a-z和-Z）、连字符、撇号和空格组成；不包含两个或两个以上连字符和撇号的序列；以字母或撇号开始 -->

         <!-- phone -->
      <p>Please input your phone number here:</p>
        <label for="Phone">
				<input type="text" name="Phone" value="" pattern = "[0][0-9 ]{9,10}"	
				 title = "Please enter a valid number"  required></label><br>
    	   <!-- 9或10位，以0开头，仅包含数字 -->
           
         <!-- submit button -->
				<input type="submit" name = "insert">
			</form>
		</section>
	</div>
<?php
    if (isset($_POST['insert'])){//connect to the submit button
      $success = true;
      if ($success){
        echo "Input values are shown below:<br>";
        echo $_SESSION["Class"], "<br>";
        echo $_SESSION["Time"], "<br>";
        echo $_REQUEST["Name"], "<br>";
        echo $_REQUEST["Phone"], "<br>";

       $pdo = new PDO($dsn,$db_username,$db_password,$opt);
       $stmt = "INSERT INTO bookForm(Class,Time,Name,Phone) VALUES (?,?,?,?) ;";
       $insert= $pdo->prepare($stmt);
       $insertsuccess= $insert->execute(array($_SESSION['Class'],$_SESSION["Time"],$_REQUEST["Name"],$_REQUEST["Phone"]));
       echo 'Information has been inserted!'; //to test fail or not
       
       $updatesql = "UPDATE gymBook SET Capacity =(Capacity-1) WHERE Time =? and Class=? and Capacity>0";
       $update = $pdo -> prepare($updatesql);
       $updatesuccess = $update -> execute(array($_SESSION["Time"],$_SESSION["Class"]));
       echo 'Cpacity has been updated!!';//to test fail or not
        
      }else{
      echo"Your booking has failed, please try again.";
      } 
    }
?>
<footer>
		<div class = gym>
   	<section id = "">
     <p>" this is the end of comp284 assignment 1, cheers"<p/>
		</section>
	</div>
</footer>
		</article>
	</body>
</html>