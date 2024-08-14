<?PHP
 require 'ORM/notesClass.php';
 session_start();
 session_regenerate_id();
 $notes = new NotesClass();
 if(isset($_SESSION['id'])){
    $id = $_SESSION['id'];
    $count_user_notes = $notes->getRowcount($id);
   

    $error_fields=[] ;
    if(isset($_POST['submit'])){
       
        if (empty($_POST['title'])) {
            $error_fields[] = 'Title is required.';
        } else {
            $title = htmlspecialchars($_POST['title']);}
        if (empty($_POST['body'])) {
            $error_fields[] = 'Body is required.';
        }else{
            $body = htmlspecialchars($_POST['body']);
        }
        if(!$error_fields){
            $count_user_notes+=1;
            $data=[
                'title'=> $title,
                'body'=> $body,
                'count_id'=> $count_user_notes,
                'id'=> $id
            ];
            $notes->addNote($data);
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
    <h1>Add Note</h1>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <div class = 'form-group'>
        <label >Title</label>
        <?php if (in_array('Title is required.',$error_fields)) : ?>
            <span class="error" style="color: red">Title is required.</span><?php endif; ?>
        <input type="text" name="title" class="form-control">
    </div>
    <div class = 'form-group'>
        <label >Body</label>
        <?php if (in_array('Body is required.',$error_fields)) : ?>
            <span class="error" style="color: red">Body is required.</span><?php endif; ?>
        <textarea name="body" class="form-control"></textarea>
       
    </div>
    <input type="submit" name='submit' value="submit" class='btn btn-primary'>

</form>
</div>
<?php include('inc/footer.php');?>