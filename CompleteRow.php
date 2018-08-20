<?php
/*
 *  CompleteRow an extension to highlight rows that have been filled out.
 *  This extension makes it easier for participants and research assistents
 *  to see which rows require entries.
 */

namespace ABCD\CompleteRow;

use ExternalModules\AbstractExternalModule;
use REDCap;

class CompleteRow extends AbstractExternalModule {
        public function __construct() {
                parent::__construct();
        }

	public function redcap_survey_page_top($project_id, $record, $instrument, $event_id, $group_id, $survey_hash, $response_id, $repeat_instance) {
                if (isset($project_id) && intval($project_id)>0) {
		   $color = $this->getColor();
                        ?>
<script type='text/javascript'>

  // color all rows that have values assigned by the user
  function updateBackgrounds(color) {
     jQuery('tbody tr').each(function() {
       // for each row we check now if there is at least one entry in there that has been set
       existingEntries = false;
       // every field that requires values has an input (assumption)
       var inputs = jQuery(this).find('input');
       // for each of the inputs in this row see if at least one entry has a value (muliple-choice answers have multiple inputs)
       for (var i = 0; i < inputs.length; i++) {
         //console.log("the type of this is :" + inputs[i].type + " value: " + inputs[i].value);
	 if (jQuery(inputs[i]).attr('readonly') == "readonly") { // assume that this field is ok
	    existingEntries = true; // at least one input in this tr is not empty
	    break;	 
	 }	 
         if (inputs[i].type == "radio" && inputs[i].checked) {
            //console.log("Found set in " + jQuery(this).attr('id') + " as " + inputs[i].value + " input: " + inputs[i]);
	    existingEntries = true; // at least one input in this tr is not empty
	    break;	    
	 } else if ( inputs[i].type == "text" && inputs[i].value !== "") {
            //console.log("Found set in " + jQuery(this).attr('id') + " as " + inputs[i].value + " input: " + inputs[i]);
	    existingEntries = true; // at least one input in this tr is not empty	 
	    break;
         }
       }
       if (!existingEntries) {
          var inputs = jQuery(this).find('select');
          for (var i = 0; i < inputs.length; i++) {
            //console.log("the type of this is: " + inputs[i].type + " value: \"" + inputs[i].value +
	    //              "\" checked: " + inputs[i].checked + " this: \"" + jQuery(this).find('td').text() +
	    //              "\" full: " + JSON.stringify(inputs[i]));
            if ( inputs[i].type == "select-one" && inputs[i].value !== "") {
	       existingEntries = true; // at least one input in this tr is not empty
	       break;
	    }
          }
       }
       if (!existingEntries) {
          var inputs = jQuery(this).find('textarea');
          for (var i = 0; i < inputs.length; i++) {
             //console.log("the type of this is: " + inputs[i].type + " value: \"" + inputs[i].value +
	     //              "\" checked: " + inputs[i].checked + " this: \"" + jQuery(this).find('td').text() +
	     //              "\" full: " + JSON.stringify(inputs[i]));
             if ( inputs[i].type == "textarea" && inputs[i].value !== "") {
	        existingEntries = true; // at least one input in this tr is not empty
	        break;
 	     }
          }
       } 
       if (!existingEntries) {
         // we could be in a matrix row right now, in that case we should see a td.labelmatrix
         var inputs = jQuery(this).find('td.labelmatrix');
         for (var i = 0; i < inputs.length; i++) {
             var columns = jQuery(inputs[i]).find('td.choicematrix'); // get a list of the values in this row
	     for (var j = 0; j < columns.length; j++) {
	         if ( jQuery(columns[j]).find('input').last().val() !== "" ) {
	         	    existingEntries = true; // at least one input in this tr is not empty
	              break;
	         }
	     }
	     if (existingEntries)
	        break;
         }
       }
       if (!existingEntries) {
          // vertical checkboxes
          var inputs = jQuery(this).find('td.data');
          for (var i = 0; i < inputs.length; i++) {
             var checkboxes = jQuery(inputs[i]).find('div.choicevert'); // get a list of the values in this row
	     for (var j = 0; j < checkboxes.length; j++) {
	        // this would fit radio buttons as well - make it specific to checkbox only
	        if (jQuery(checkboxes[j]).find('input').last().val() !== "" && jQuery(checkboxes[j]).find('input').first().attr('type') == 'checkbox') {
	           existingEntries = true;
	  	   break;
	        }
             }
	     if (existingEntries)
	        break;
          }
       }
       if (existingEntries) {
          jQuery(this).find('td').css('background-color', color);
	  // matrix fields have another level of indirection
	  // jQuery(this).find('td').find('tr').find('td').css('background-color', color);
       } else if (inputs.length > 0) {
          jQuery(this).find('td').css('background-color', "white");
       }
     });
  }

     (function(window, document, $) {
        $(document).ready(function() {
	    color = "<?php echo($color); ?>";
 	    jQuery('tbody tr').click(function() {
   	       updateBackgrounds(color);
            });
            updateBackgrounds(color);
        });
     })(window, document, jQuery);
</script>
                        <?php
                }
        }
        
	public function redcap_data_entry_form_top($project_id, $record, $instrument, $event_id, $group_id, $repeat_instance) {
                if (isset($project_id) && intval($project_id)>0) {
		   $color = $this->getColor();
                        ?>
<script type='text/javascript'>
  // color all rows that have values assigned by the user
  function updateBackgrounds(color) {
     jQuery('tbody tr').each(function() {
       // for each row we check now if there is at least one entry in there that has been set
       existingEntries = false;
       // every field that requires values has an input (assumption)
       var inputs = jQuery(this).find('input');
       // for each of the inputs in this row see if at least one entry has a value (muliple-choice answers have multiple inputs)
       for (var i = 0; i < inputs.length; i++) {
         // console.log("the type of this is: " + inputs[i].type + " value: \"" + inputs[i].value + "\" checked: " +
	 //             inputs[i].checked + " this: \"" + jQuery(this).find('td').text() + "\" full: " +
	 //             JSON.stringify(inputs[i]));
	 if (jQuery(inputs[i]).attr('readonly') == "readonly") { // assume that this field is ok
	    existingEntries = true; // at least one input in this tr is not empty
	    break;	 
	 }	 
         if (inputs[i].type == "radio" && inputs[i].checked) {
            //console.log("Found set in " + jQuery(this).attr('id') + " as " + inputs[i].value + " input: " + inputs[i]);
	    existingEntries = true; // at least one input in this tr is not empty
	    break;
	 } else if ( inputs[i].type == "text" && inputs[i].value !== "") {
             //console.log("Found set in " + jQuery(this).attr('id') + " as " + inputs[i].value + " input: " + inputs[i]);
	     // we could have a calculated field, in that case we don't want to mark it
	     if (jQuery(inputs[i]).attr('readonly') == "readonly") {
		 break;
	     }
	     existingEntries = true; // at least one input in this tr is not empty	 
	     break;
         }
       }
       if (!existingEntries) {
         var inputs = jQuery(this).find('select');
         for (var i = 0; i < inputs.length; i++) {
            // console.log("the type of this is: " + inputs[i].type + " value: \"" + inputs[i].value + "\" checked: " +  
  	    //             inputs[i].checked + " this: \"" + jQuery(this).find('td').text() + "\" full: " +
	    //             JSON.stringify(inputs[i]));
            if ( inputs[i].type == "select-one" && inputs[i].value !== "") {
	       existingEntries = true; // at least one input in this tr is not empty
	       break;
	    }
         }
       }
       if (!existingEntries) {
         var inputs = jQuery(this).find('textarea');
         for (var i = 0; i < inputs.length; i++) {
           //console.log("the type of this is: " + inputs[i].type + " value: \"" + inputs[i].value +
	   //              "\" checked: " + inputs[i].checked + " this: \"" + jQuery(this).find('td').text() +
	   //              "\" full: " + JSON.stringify(inputs[i]));
           if ( inputs[i].type == "textarea" && inputs[i].value !== "") {
	      existingEntries = true; // at least one input in this tr is not empty
	      break;
	   }
         }
       }
       if (!existingEntries) {
         // we could be in a matrix row right now, in that case we should see a td.labelmatrix
         var inputs = jQuery(this).find('td.labelmatrix');
         for (var i = 0; i < inputs.length; i++) {
             var columns = jQuery(inputs[i]).find('td.choicematrix'); // get a list of the values in this row
	     for (var j = 0; j < columns.length; j++) {
	         if ( jQuery(columns[j]).find('input').last().val() !== "" ) {
	         	    existingEntries = true; // at least one input in this tr is not empty
	              break;
	         }
	     }
	     if (existingEntries)
	        break;
         }
       }
       if (!existingEntries) {
          // vertical checkboxes
          var inputs = jQuery(this).find('td.data');
          for (var i = 0; i < inputs.length; i++) {
             var checkboxes = jQuery(inputs[i]).find('div.choicevert'); // get a list of the values in this row
	     for (var j = 0; j < checkboxes.length; j++) {
	        // this would fit radio buttons as well - make it specific to checkbox only
	        if (jQuery(checkboxes[j]).find('input').last().val() !== "" && jQuery(checkboxes[j]).find('input').first().attr('type') == 'checkbox') {
	           existingEntries = true;
	  	   break;
	        }
             }
	     if (existingEntries)
	        break;
          }
       }
       if (existingEntries) {
          jQuery(this).find('td').css('background-color', color);
	  // matrix fields have another level of indirection and color seems to not be able to be changed here
	  //jQuery(this).find('td').find('tr').find('td.choicematrix').css('background-color', color);
       } else if (inputs.length > 0) {
          jQuery(this).find('td').css('background-color', "white");
       }
     });
  }

    (function(window, document, $) {
        $(document).ready(function() {
	    color = "<?php echo($color); ?>";
     	    jQuery('tbody tr').click(function() {
               //console.log("Someone clicked on something (in redcap_data_entry_form)");
	       updateBackgrounds(color);
            });
            updateBackgrounds(color);
     });
     })(window, document, jQuery);
</script>
                        <?php
                }
        }

	protected function getColor() {
           $color  = $this->getProjectSetting('row-color');
           $colorM = $this->getProjectSetting('row-color-manual');
	   $colorM = trim($colorM); // ignore leading and trailing spaces
	   if (strlen($colorM) > 0) {
	      $color = $colorM;
	   }
	   return $color;
        }
}
