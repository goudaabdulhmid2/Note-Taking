<?php
require 'ORM/notesClass.php';
session_start();
session_regenerate_id();
$note = new NotesClass();
if(isset($_SESSION['id'])){
if(isset($_POST['delete'])){
    $note->deleteNote($_POST['delete_id']);
    header('location:notes.php');
    exit;

}
if(isset($_GET['id']) && isset($_GET['count_id'])){
 $row = $note->getNote($_GET['id'],$_GET['count_id']);
}
} else
{
  header('location:notes.php');
  exit;
}



?>




<?php include('inc/headerNotes.php');?>
   <div class="container">
    <br>
    <a href="<?php echo ROOT_URL.'notes.php';?>" class = "btn btn-light">Back</a>
   <h1><?php echo $row['title'];?></h1>
      <small class="text-info">Created on <?php echo $row['created_at'];?>
    </small>
      <p><?php echo $row['body']?></p>
      <hr>
      <form action="<?php echo $_SERVER['PHP_SELF'];?>"  style="float: right;" method="POST" >
      <input type="hidden" name= "delete_id" value ="<?php echo'id= '.$row['id'].' AND count_id= '.$row['count_id'];?>">
      <input type="submit" name="delete" value="Delete" class="btn btn-danger">
    
    </form>
      <a href="<?php echo ROOT_URL;?>editNote.php?id=<?php echo $row['id']; ?>&count_id=<?php echo $row['count_id']; ?>" class="btn btn-light">Edit</a>


     
    </div>

<?php include('inc/footer.php');?>