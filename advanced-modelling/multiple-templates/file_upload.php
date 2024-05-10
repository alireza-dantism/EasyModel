<?php 
include_once("../../config/config.php");
session_start();

if(!empty($_FILES)){     



    $fileName = $_FILES['file']['name']; $file_parts = pathinfo($fileName);
    
    if ($file_parts['extension'] == "pdb") {
        
        mkdir("jobs/" . $_POST['jobname']);

        $upload_dir = "jobs/" . $_POST['jobname'] . "/";
        $uploaded_file = $upload_dir.$fileName;    
        
    
        if(move_uploaded_file($_FILES['file']['tmp_name'],$uploaded_file)){
            
            
            $outputChain=null;
            $retvalChain=null;
            
            exec("grep -rnw ".$uploaded_file." -e 'TER'", $outputChain, $retvalChain);
            
            $chainString    =   "";
			
			$amino_3_letters = array("ALA", "ARG", "ASN", "ASP" , "CYS" , "GLU" , "GLN" , "GLY" , "HIS" , "ILE" , "LEU" , "LYS" , "MET" , "PHE" , "PRO" , "SER" , "THR" , "TRP", "TYR", "VAL", "SEC", "PYL", "HCY");
            
            foreach($outputChain as $chain) {
                $ter_to_array   =   array_filter(explode(" ",$chain));
                
				if (in_array($ter_to_array[11], $amino_3_letters)) {
					$chainString .= $ter_to_array[12];
				} else {
					$chainString .= $ter_to_array[11];
				}
                
                $chainString .=",";
            }
    
            $lastChain = substr_replace($chainString ,"", -1);
			
			if ($lastChain == "") {
                $lastChain = "A";
            }
    
            $mysql_insert = "INSERT INTO easypasy_advanced_multiple_templates (id, jobname , pdb_name , chain, date)VALUES(NULL , '".$_POST['jobname']."'  ,  '$fileName'  , '$lastChain' ,'".date("Y-m-d H:i:s")."')";
		    mysqli_query($conn, $mysql_insert) or die("database error:". mysqli_error($conn));
		
        }  


        
    } else {
        echo "No pdb file selected";
    }
    
 
}

