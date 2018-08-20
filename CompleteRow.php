<?php
namespace ABCD\CompleteRow;

use ExternalModules\AbstractExternalModule;
use REDCap;

class CompleteRow extends AbstractExternalModule
{
        const DEFAULT_TEXT_SHOW = 'Expand';
        const DEFAULT_TEXT_SHOW_ALL = 'Expand all instruments';
        const DEFAULT_TEXT_HIDE = 'Collapse';
        const DEFAULT_TEXT_HIDE_ALL = 'Collapse all instruments';
        const DEFAULT_VISIBILITY = '1';
        
        public function __construct() {
                parent::__construct();
        }

	public function redcap_survey_page_top($project_id) {
                if (isset($project_id) && intval($project_id)>0) {
		   $color = $this->getColor();
                        ?>

<script type='text/javascript'>
    (function(window, document, $) {
        $(document).ready(function() {
	    console.log("HI in ready: use color" + <?php echo $color; ?>);
        });
     })(window, document, jQuery);
</script>
                        <?php
                }
        }
        
	public function redcap_data_entry_form_top($project_id) {
                if (isset($project_id) && intval($project_id)>0) {
		   $color = $this->getColor();
                        ?>

<script type='text/javascript'>
    (function(window, document, $) {
        $(document).ready(function() {
	    console.log("HI in ready: use color" + <?php echo $color; ?>);

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

        protected function getShowButtonText() {
                return $this->getButtonText('button-text-show', self::DEFAULT_TEXT_SHOW);
        }
        
        protected function getShowAllButtonText() {
                return $this->getButtonText('button-text-show-all', self::DEFAULT_TEXT_SHOW_ALL);
        }
        
        protected function getHideButtonText() {
                return $this->getButtonText('button-text-hide', self::DEFAULT_TEXT_HIDE);
        }
        
        protected function getHideAllButtonText() {
                return $this->getButtonText('button-text-hide-all', self::DEFAULT_TEXT_HIDE_ALL);
        }
        
        protected function getButtonText($setting, $default) {
                $btnText = $this->getProjectSetting($setting);

                if ($btnText=='') {
                        $this->setProjectSetting($setting, $default);
                        $btnText = $default;
                }
                return REDCap::escapeHtml($btnText);
        }

}
