<?php
require 'ORM/notesClass.php';
session_start();
$notes = new NotesClass();
$id = $_GET['id'];
$count_id = $_GET['count_id'];
if( isset($_SESSION["id"])&& isset($id) && isset($count_id) ){
    
  
    $old_data = $notes->getNote($id,  $count_id);
 
   $error_fields=[] ;
   if($_SERVER['REQUEST_METHOD'] === 'POST'){
       if (empty($_POST["title"])) {
           $error_fields[] = 'Title is required.';
       } else {
           $title = htmlspecialchars($_POST['title']);}
       if (empty($_POST["body"])) {
           $error_fields[] = 'Body is required.';
       }else{
           $body = htmlspecialchars($_POST["body"]);
       }
       if(!$error_fields){
           $data=[
               "title"=> $title,
               "body"=> $body,
           ];
           $notes->updateNote($data,$id,$count_id);
           header('location:notes.php');
           exit;
       }
   }


}else{
    header('location:notes.php');
    exit;
}

?>


<?php include('inc/headerNotes.php');?>
<div class ="container">
    <h1>Edit Note</h1>
    <form method="POST" >
    <div class = 'form-group'>
        <label >Title</label>
        <?php if (in_array('Title is required.',$error_fields)) : ?>
            <span class="error" style="color: red">Title is required.</span><?php endif; ?>
            <input type="text" name="title" class="form-control" value="<?php echo $old_data["title"];?>">



    </div>
    <div class = 'form-group'>
        <label >Body</label>
        <?php if (in_array('Body is required.',$error_fields)) : ?>
            <span class="error" style="color: red">Body is required.</span><?php endif; ?>
        <textarea name="body" class="form-control"><?php echo $old_data["body"];?></textarea>
       
    </div>
    <input type="submit" name="submit" value="Submit" class='btn btn-primary'>

</form>
</div>
<?php include('inc/footer.php');?>