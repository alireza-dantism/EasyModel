<?php

    mkdir("tmp/" . $_POST["jobname"]);

    file_put_contents("tmp/" . $_POST['jobname'] . "/Template.pdb", fopen("http://files.rcsb.org/download/" . $_POST['pdbID_val'] . ".pdb", 'r'));
    $filesize = filesize("tmp/" . $_POST['jobname'] . "/Template.pdb");

    if ($filesize > 0) {
        
        
        
    } else {
        
        
        echo "Error: There is no pdb file with this pdb ID";
    }

?>
