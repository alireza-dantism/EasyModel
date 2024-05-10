                 

<label for="chain">Chain</label> <br/>
<select name="chain" id="chain" style="width: 100%;">
<?php
    $outputChain=null;
    $retvalChain=null;
    
    exec("grep -rnw tmp/".$_POST['jobname']."/Template.pdb -e 'TER'", $outputChain, $retvalChain);
    
    $chainString    =   "";
    
	$amino_3_letters = array("ALA", "ARG", "ASN", "ASP" , "CYS" , "GLU" , "GLN" , "GLY" , "HIS" , "ILE" , "LEU" , "LYS" , "MET" , "PHE" , "PRO" , "SER" , "THR" , "TRP", "TYR", "VAL", "SEC", "PYL", "HCY");
	
    foreach($outputChain as $chain) {     
        
        $ter_to_array   =   array_filter(explode(" ",$chain));
                
		if (in_array($ter_to_array[11], $amino_3_letters)) {
			$chainString    = $ter_to_array[12];        
		} else {
			$chainString    = $ter_to_array[11];        
		}
		

		if ($chainString == "") {
			$chainString = "A";
		}
        
        ?>
            <option value="<?php echo $chainString; ?>"><?php echo $chainString; ?></option>
        <?php
    }
	
	if (empty($chainString)) {
		?>
            <option value="A">A</option>
        <?php
	}
    
?>
</select>




<br/><br/>
 
<label for="numberOfModels">Model Numbers</label> <br/>
<select name="numberOfModels" id="numberOfModels" style="width: 100%;">
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
</select>

<br/><br/>                             

<div id="refreshPage" onclick="refreshPage()">Reset</div>
<div id="submitBasicForm" onclick="submitBasicForm()">Submit</div>
