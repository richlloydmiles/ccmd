<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * CategorySettings Base Class
 *
 * All functionality pertaining to core functionality of the Category Settings plugin.
 *
 * @package WordPress
 * @subpackage ccmd
 * @author RichMiles
 * @since 1.0.0
 *
 * TABLE OF CONTENTS
 *
 * public $sections
 * private $settings
 *  __construct()
 * display_sections()
 * add_setting()
 * add_section()
 * render_input()
 * save_settings()
 */

class ccmd {
	public $sections = array();
	public $settings = array();
	function __construct($cat_type) {
		add_action( $cat_type . '_edit_form_fields', array(&$this , 'display_sections'));  
		add_action( 'edited_' . $cat_type , array(&$this , 'save_settings') );  
	}

	/**
	 * function that generates the markup for the plugin
	 * @param array $tag atttibutes of the term being edited 
	 * @return void
	 */
	public function display_sections($tag) {
		$t_id = $tag->term_id;
		$term_meta = get_option( "cat_settings_$t_id" );
		if ($this->sections) {
			?>
			<div class="nav-tab-wrapper">
				<a id="general-tab" class="nav-tab nav-tab-active">General</a>
				<?php
				foreach ($this->sections as $section) {
					?>
					<a id="<?php echo $section; ?>-tab" class="nav-tab"><?php echo ucfirst($section); ?></a>
					<?php
				}
				?>
			</div>
			<?php
		}
		if ($this->settings) {
			foreach ($this->settings as $setting) {

				if (!isset($setting['id'])) {
					$setting['id'] = 'id';
				}
				if (!isset($setting['name'])) {
					$setting['name'] = 'name';
				}

				if (!isset($setting['type'])) {
					$setting['type'] = 'text';
				}	

				if (!isset($setting['placeholder'])) {
					$setting['placeholder'] = '';
				}	

				if (!isset($setting['description'])) {
					$setting['description'] = '';
				}
				if (!isset($setting['section'])) {
					$setting['section'] = 'general';
				}			
				?>
				<table class="<?php echo $setting['section']; ?>-tab form-table cat-section">
					<tr class="form-field">  
						<th scope="row" valign="top">  
							<label for="<?php echo $setting['id']; ?>"><?php echo $setting['name']; ?></label>  
						</th>  
						<td> 
							<?php $this->render_input($setting , $term_meta); ?>
							<p class="description">
								<?php echo $setting['description']; ?>
							</p>
						</td>  
					</tr>
				</table>
				<script>
					jQuery(document).ready(function($) {
						jQuery(document).on("click", "#<?php echo $setting['section']; ?>-tab", function(event) {
							event.preventDefault();
							jQuery('.nav-tab').removeClass('nav-tab-active');
							jQuery(this).addClass('nav-tab-active');
							jQuery('.form-table').hide();
							jQuery('.' + this.id).show();
						});
					});
				</script>
				<?php
			}
			?>
			<script>
				jQuery(document).ready(function($) {
					jQuery('.nav-tab').css('cursor' , 'pointer');
					jQuery('.form-table').hide();
					jQuery('.form-table').first().addClass('general-tab');
					jQuery('.general-tab').show();
					jQuery(document).on("click", "#general-tab", function(event) {
						event.preventDefault();
						jQuery('.nav-tab').removeClass('nav-tab-active');
						jQuery(this).addClass('nav-tab-active');
						jQuery('.form-table').hide();
						jQuery('.' + this.id).show();
					});
				});
			</script>
			<?php
		}
	}

	/**
	 * function that pushes section to $this-section and replaces url unfriendly chars
	 * @param id
	 * @return void
	 */
	public function add_section($section_id) {
		$invalid_characters = array("$", "%", "#", "<", ">", "|" , "-" , " ");
		$section_id =  strtolower(str_replace($invalid_characters, "", $section_id));
		array_push($this->sections , $section_id ); 
	}
	/**
	 * function that pushes setting to $this-setting
	 * @param array $setting arguments of the setting
	 * @return void
	 */
	public function add_setting($setting_args) {
		array_push($this->settings , $setting_args ); 
	}

	/**
	 * function that generates various types of inputs
	 * @param array $setting id of the term being edited
	 * @return void
	 */
	protected function render_input($setting , $term_meta) {
		switch ($setting['type']) {
			case 'text':
			?>
			<input placeholder="<?php echo $setting['placeholder']; ?>" 
			type="text"
			name="cat_settings[<?php echo $setting['id']; ?>]"
			id="cat_settings[<?php echo $setting['id']; ?>]"
			value="<?php if(isset($term_meta[$setting['id']])) {echo $term_meta[$setting['id']];}?>">
			<?php
			break;
			case 'number':
			?>
			<input placeholder="<?php echo $setting['placeholder']; ?>" 
			type="number"
			name="cat_settings[<?php echo $setting['id']; ?>]"
			id="cat_settings[<?php echo $setting['id']; ?>]"
			value="<?php if(isset($term_meta[$setting['id']])) {echo $term_meta[$setting['id']];}?>">
			<?php
			break;
			case 'email':
			?>
			<input placeholder="<?php echo $setting['placeholder']; ?>" 
			type="email"
			name="cat_settings[<?php echo $setting['id']; ?>]"
			id="cat_settings[<?php echo $setting['id']; ?>]"
			value="<?php if(isset($term_meta[$setting['id']])) {echo $term_meta[$setting['id']];}?>">
			<?php
			break;	
			case 'textarea':
			?>
			<textarea rows="8" name="cat_settings[<?php echo $setting['id']; ?>]"
				id="cat_settings[<?php echo $setting['id']; ?>]"
				placeholder="<?php echo $setting['placeholder']; ?>" ><?php if(isset($term_meta[$setting['id']])) {echo $term_meta[$setting['id']];}?></textarea>
				<?php
				break;
				case 'select':
				?>
				<select
				id="select_<?php echo $setting['id']; ?>">
				<?php

				foreach ($setting['options'] as $option) {
					?>
					<option value="<?php echo $option;?>" <?php selected( $option, $term_meta[$setting['id']] ); ?>
						><?php echo $option;?></option>
						<?php
					}
					?>
				</select>
				<input 
				type="hidden"
				name="cat_settings[<?php echo $setting['id']; ?>]"
				id="cat_settings[<?php echo $setting['id']; ?>]"
				value="<?php if(isset($term_meta[$setting['id']])) {echo $term_meta[$setting['id']];}?>">

				<script>
					jQuery(document).ready(function($) {
						jQuery("#select_<?php echo $setting['id']; ?>").change(function() {
							jQuery("#cat_settings\\[<?php echo $setting['id']; ?>\\]").val(jQuery("#select_<?php echo $setting['id']; ?> option:selected").val());
						});
					});
				</script>
				<?php
				break;
				default:
				#default reverts to text input
				?>
				<input placeholder="<?php echo $setting['placeholder']; ?>" 
				type="text"
				name="cat_settings[<?php echo $setting['id']; ?>]"
				id="cat_settings[<?php echo $setting['id']; ?>]"
				value="<?php if(isset($term_meta[$setting['id']])) {echo $term_meta[$setting['id']];}?>">
				<?php
				break;
			}
		}

	/**
	 * function that saves the term options to the options table in the db
	 * @param array $setting_id arguments of the setting
	 * @return void
	 */
	public function save_settings($term_id) {
		if ( isset( $_POST['cat_settings'] ) ) {  
			$t_id = $term_id;  
			$term_meta = get_option( "cat_settings_$t_id" );  
			$cat_keys = array_keys( $_POST['cat_settings'] );  
			foreach ( $cat_keys as $key ){  
				if ( isset( $_POST['cat_settings'][$key] ) ){  
					$term_meta[$key] = $_POST['cat_settings'][$key];  
				}  
			}  
		//save the option array  
			update_option( "cat_settings_$t_id", $term_meta );  
		}  
	}
}//end of class