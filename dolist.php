<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Do list</title>
  </head>
  <body>

    <h2>Welcome your do list</h2>

<!-- form add -->
<form action="dolist.php" method="POST" id="form" name="form">

<input type="text" name="task" id="task" placeholder="Enter task ......." required="required">

<label for="end">End date:</label>

<input type="date" id="end" name="end" placeholder="2022-07-22"  min="2022-01-01" max="2022-12-31" required="required">

<input type="text" name="im" id="im" placeholder="Is imprtant ?" required="required">

<input type = "submit" name = "submit" value="Add">
<br><br><br>
</form>
<!-- form search -->
<form action="dolist.php" method="POST" id="for" name="for">
<input type="text" name="search" id="search" placeholder="Search about task"  required="required">
<input type = "submit" name = "sub" value="Search"  >
<br><br><br>
</form>
<!-- form view tasks -->
<form action="dolist.php" method="POST" id="for" name="for">
<input type = "submit" name = "v" value="view all tasks">
<br><br><br>
</form>

</body>
</html>

<?php
$db=mysqli_connect('localhost','root','','dolist');
//connection test
// $connection=mysqli_connect('localhost','root','','dolist');
// if(!$connection){
//   die("problem");
// }
// echo("work");



//add to database
  if (isset($_POST['submit'])) {
  $task=$_POST['task'];
  $end=$_POST['end'];
  $im=$_POST['im'];
  mysqli_query($db,"INSERT INTO tasks(task, important, dateend) VALUES ('$task','$im','$end')");
  header('location: dolist.php');}

//delet


if (isset($_GET['del'])){
$id=$_GET['del'];
mysqli_query($db,"DELETE FROM tasks WHERE id=$id");
header('location: dolist.php');

}
//update
// if(isset($_POST['up'])){
//   $id=$_GET['id'];
//   $tas1=$_POST['task'];
//   $end1=$_POST['end'];
//   $im1=$_POST['im'];
//   mysqli_query($db,"UPDATE tasks SET task ='$tas1',important='$im1',dateend='$end1' WHERE id=$id");
//   header('location: dolist.php');}




//view database
if(isset($_POST['v'])){
  ?>

  <html>
  <h1>Your All Tasks</h1>
  </html>
  <?php

echo"<table border=1>";
echo"<th>Number</th>";
echo"<th>Task</th>";
echo"<th>Is important</th>";
echo"<th>Dead line</th>";
$tasks=mysqli_query($db,"SELECT * FROM tasks");
$i=1;
while($row=mysqli_fetch_array($tasks)){
  echo("<tr>");
  echo("<td>".$i."</td>");
  echo("<td>".$row['task']."</td>");
  echo("<td>".$row['important']."</td>") ;
  echo("<td>".$row['dateend']."</td>") ;?>

  <html>
   <td><a href="dolist.php?del=<?php echo $row['id'];?>">X</a></td>
     <td><a href="edit.php?up=<?php echo $row['id'];?>">Edit</a></td>
  </html>
  <?php
  echo("</tr>");
  $i++;
}
 echo"</table>";}

// Pagination
$limit = 2;
$getQuery1= "select id from tasks";
$result1 = mysqli_query($db, $getQuery1);
$total_rows = mysqli_num_rows($result1);
$total_pages = ceil ($total_rows / $limit);

// update the active page number
isset ($_GET['page']) ?  $page_number = $_GET['page']:  $page_number = 0;
?>
<html><h1>Your Tasks</h1></html>
<?php
if($page_number>1){
  $start=($page_number*$limit)-$limit;
}else{
  $start=0;
}

$getQuery ="SELECT *FROM tasks LIMIT " . $start . ',' . $limit;
$result = mysqli_query($db, $getQuery);
//display the retrieved result on the webpage
echo"<table border=1>";
echo"<th>Number</th>";
echo"<th>Task</th>";
echo"<th>Is important</th>";
echo"<th>Dead line</th>";
$i=1;
while ($row = mysqli_fetch_array($result)){
 echo("<tr>");
  echo("<td>".$i."</td>");
  echo("<td>".$row['task']."</td>");
  echo("<td>".$row['important']."</td>") ;
  echo("<td>".$row['dateend']."</td>") ;
?>
<html>
 <td><a href="dolist.php?del=<?php echo $row['id'];?>">X</a></td>
   <td><a href="edit.php?up=<?php echo $row['id'];?>">Edit</a></td>
</html>
<?php
  echo("</tr>");
$i++;
}
 echo"</table>";


// show page number with link
for($page_number = 1; $page_number<= $total_pages; $page_number++) {
    echo "<a href = '?page= $page_number '>  $page_number  </a>";
}
//search
if(isset($_POST['sub'])){
  ?>
  <html>
  <h1>Your tasks Search</h1>
  </html>
  <?php
  $searchq=$_POST['search'];
  $query=mysqli_query($db,"SELECT * FROM tasks WHERE  task LIKE '%$searchq%' OR important LIKE '%$searchq%' OR dateend LIKE '%$searchq%' ") or die("could not search");
  $count=mysqli_num_rows($query);
 if($count==0){
   echo("No have any task with same information");
 }
else{
  $i=1;
  echo"<table border=1>";
  echo"<th>Number</th>";
  echo"<th>Task</th>";
  echo"<th>Is important</th>";
  echo"<th>Dead line</th>";
  while($ro=mysqli_fetch_array($query)){
  echo("<tr>");
   echo("<td>".$i."</td>");
   echo("<td>".$ro['task']."</td>");
   echo("<td>".$ro['important']."</td>") ;
   echo("<td>".$ro['dateend']."</td>") ;
  $i++;

  }

    echo"</table >";
}
}
?>
