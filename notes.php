<?PHP
 require 'ORM/notesClass.php';
 session_start();
 session_regenerate_id();
 //echo $_SESSION['id'];
 $notes = new NotesClass();
 if(isset($_SESSION['id'])){
    $row = $notes->getNotes($_SESSION['id']);
    
 }
 else
  {
    header('location:log.php');
    exit;
  }

?>
<?php include('inc/headerNotes.php');?>
     
     <div class="container">
     <h1>Notes</h1><small> <a href="addNote.php" class="btn btn-light">Add Note</a></small>
     <hr>
     <?php foreach($row as $note) : ?>
      <div class="blockquote">
        <h3><?php echo  $note['title'];?></h3>
        <small class="text-info">Update at <?php echo $note['update_at'];?>
        <p><?php echo $note['body']?></p>
        <a class="btn btn-light" href="<?php echo ROOT_URL; ?>note.php?id=<?php echo $note['id']; ?>&count_id=<?php echo $note['count_id']; ?>">Read More</a>
        <hr>
      </div>
      <?php endforeach ;?></div>
  
      <?php include('inc/footer.php');?>