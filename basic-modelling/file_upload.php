<?php
if(!empty($_FILES)){     


    $fileName = $_FILES['file']['name'];
    $file_parts = pathinfo($fileName);
    
    mkdir("tmp/" . $_POST['jobnameBasic']);
    
    if ($file_parts['extension'] == "pdb") {
        

        $upload_dir = "tmp/" . $_POST['jobnameBasic'] . "/";
        $uploaded_file = $upload_dir."Template.pdb";    
        
    
        if(move_uploaded_file($_FILES['file']['tmp_name'],$uploaded_file)){
            
        }  
        
    } else {
        echo "No pdb file selected";
    }
    
 
}

?>