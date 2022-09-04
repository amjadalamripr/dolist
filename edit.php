<?php
$db=mysqli_connect('localhost','root','','dolist');
$id=$_GET['up'];
$tasks=mysqli_query($db,"SELECT * FROM tasks where id=$id");
while($row=mysqli_fetch_array($tasks)){

 ?>

 <html>
 <form method="POST" action"">
<input type="text" name="task" id="task" placeholder="Enter task ......." value="<?php echo $row['task'] ?>" >

<label for="end">End date:</label>

<input type="date" id="end" name="end"   placeholder="2022-07-22"   min="2022-01-01" max="2022-12-31"  value="<?php echo $row['dateend'] ?>"  >

<input type="text" name="im" id="im" placeholder="Is imprtant ?"value="<?php echo $row['important'] ?>" >
<input type = "submit" name = "edit" value="edit">
<br><br><br>
</form>
</html>


<?php
}
if(isset($_POST['edit'])){
  $id=$_GET['up'];
  $tas1=$_POST['task'];
  $end1=$_POST['end'];
  $im1=$_POST['im'];
  mysqli_query($db,"UPDATE tasks SET task ='$tas1',important='$im1',dateend='$end1' WHERE id=$id");
  header('location: dolist.php');}
?>
