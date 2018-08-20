<?php
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
       if (existingEntries) {
          //jQuery(this).find('td').css('background-color', '#dbf7df');
          jQuery(this).find('td').css('background-color', color);
       } else if (inputs.length > 0) {
          // console.log("Nothing set in " + jQuery(this).attr('id'));
          // jQuery(this).find('td').css('background-color', '#999');
       }
     });
  }

     (function(window, document, $) {
        $(document).ready(function() {
	    color = "<?php echo($color); ?>";
 	    jQuery('tbody tr').click(function() {
   	       updateBackgrounds(color);
            });
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
  function updateBackgrounds() {
     jQuery('tbody tr').each(function() {
       // for each row we check now if there is at least one entry in there that has been set
       existingEntries = false;
       // every field that requires values has an input (assumption)
       var inputs = jQuery(this).find('input');
       // for each of the inputs in this row see if at least one entry has a value (muliple-choice answers have multiple inputs)
       for (var i = 0; i < inputs.length; i++) {
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
       if (existingEntries) {
          jQuery(this).find('td').css('background-color', '#dbf7df');
       } else if (inputs.length > 0) {
          // console.log("Nothing set in " + jQuery(this).attr('id'));
          // jQuery(this).find('td').css('background-color', '#999');
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
     });
     })(window, document, jQuery);
</script>
                        <?php
                }
        }

	protected function getColor() {
           $color = $this->getProjectSetting('row-color');
	   return $color;
        }
}
