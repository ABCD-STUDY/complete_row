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
    (function(window, document, $) {
        $(document).ready(function() {
	    console.log("HI in ready: use color" + <?php echo($color); ?>);
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
    (function(window, document, $) {
        $(document).ready(function() {
	    console.log("HI in ready: use color" + <?php echo($color); ?>);

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
