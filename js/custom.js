jQuery('#pdbAccess').on('change', function() {

    jQuery("#getMsg").html("");

    if (this.value == "Upload .pdf file") {
        jQuery('form.basicModelFormUi').attr('action', 'file_upload.php');
        jQuery(".dz-default.dz-message").removeClass("displayNone");
        jQuery("#checkPdbFileExist").addClass("displayNone");
        jQuery("#pdbIdFromRCSB").addClass("displayNone");
    } 
    
    if (this.value == "With pdb id") {
        jQuery('form.basicModelFormUi').attr('action', '');
        
        jQuery(".dz-default.dz-message").addClass("displayNone");
        jQuery("#checkPdbFileExist").removeClass("displayNone");
        jQuery("#pdbIdFromRCSB").removeClass("displayNone");
    }
  
});


jQuery( document ).ready(function() {

});


function submitBasicForm() {
    
    
    
    jQuery("#getMsg").html("");
    
    jQuery('#fastaseq').removeAttr("style");
	jQuery('#modellerlicensekey').removeAttr("style");
    
    let EnglishLetter = /^[a-zA-Z\r\n]+$/;
    
    var ModelSequence  =  document.getElementById('fastaseq').value.trim(); 
	var ModelerLicense =  document.getElementById('modellerlicensekey').value.trim(); 
    
    var FlagMessage = "";
    var Flag = 1;
    
    if (ModelSequence == "") {
       Flag = 0;
       FlagMessage = "Error: Model sequence is empty."
       
       jQuery('#fastaseq').css('border-color', "#F00");
    } else if (ModelSequence.indexOf(' ') >= 0) {
        Flag = 0;
        FlagMessage = "Error: Model sequence has white space."
        
        jQuery('#fastaseq').css('border-color', "#F00");
    } else if (!EnglishLetter.test(ModelSequence)) {
        Flag = 0;
        FlagMessage = "Error: Only sequences are acceptable in model sequence field."
        
        jQuery('#fastaseq').css('border-color', "#F00");
    } else if (ModelerLicense == "") {
       Flag = 0;
       FlagMessage = "Error: Modeller license key is empty."
       
       jQuery('#modellerlicensekey').css('border-color', "#F00");		
	} 	
	
	
	
	
    
    if (Flag) {
        jQuery('form.basicModelFormUi').submit();
    } else {
        jQuery("#getMsg").html(FlagMessage);
    }
    
}


function refreshPage() {
    location.reload();    
}


jQuery("#checkPdbFileExist").click(function(){
    
    jQuery("#pdbIdFromRCSB").prop('disabled', true);

    jQuery("#getMsg").html("");
    
    jQuery("#loading_progress").removeClass("displayNone");

    var pdbID                 =  document.getElementById('pdbIdFromRCSB').value;
    var hiddenJobNameBasic    =  document.getElementById('jobnameBasic').value;

    jQuery.ajax({
        type: 'POST',
        cache: false,
        data: ({pdbID_val: pdbID, jobname: hiddenJobNameBasic}),
        url: '../basic-modelling/getpdb.php',
        dataType: 'html',
        success: function(response){ 
            
            jQuery("#loading_progress").addClass("displayNone");
        
            if (response == "") {
                
                jQuery("#pdbAccess").addClass("displayNone");
                jQuery("#checkPdbFileExist").addClass("displayNone");
                jQuery("#pdbIdFromRCSB").prop('disabled', true);

                
                jQuery.ajax({
                        type: 'POST',
                        cache: false,
                        data: ({jobname: hiddenJobNameBasic}),
                        url: '../basic-modelling/make-tmp.php',
                        dataType: 'html',
                        success: function(response){ // <--- (data) is in json format
                        
                            jQuery("#checkCHains").html(response);
                            jQuery("form").attr("action", "");
                            
                        //parse the json data
                      }
                    });    
                
            } else {
                jQuery("#pdbIdFromRCSB").prop('disabled', false);
                jQuery("#getMsg").html(response);
            }
        
            
      }
    }); 
    
});
  
