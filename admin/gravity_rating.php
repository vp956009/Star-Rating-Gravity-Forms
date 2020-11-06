<?php

class OC_RS_SRGF_Field_Rating extends GF_Field {

    public $type = 'ocRating';

    public function get_form_editor_field_title() { return esc_attr__( 'Rating', 'gravityforms' ); }

    public function get_form_editor_button() {
        return array(
            'group' => 'advanced_fields',
            'text'  => $this->get_form_editor_field_title(),
            'onclick'   => "StartAddField('".$this->type."');",
        );
    }
    function get_form_editor_field_settings() {
        return array(
        	'label_setting',
            'max_star',
            'step_star',
            'star_icon'
        );
    }
    function is_conditional_logic_supported() { return true; }

    function get_value_submission( $field_values, $get_from_post=true ) {
            if(!$get_from_post) {
                    return $field_values;
            }
      return $get_from_post;
    } 
     function get_field_input( $form, $value = '', $entry = null ) { 

        ob_start();

        $is_entry_detail = $this->is_entry_detail();
        $is_form_editor  = $this->is_form_editor();
        $form_id  = $form['id'];
        $id       = intval( $this->id );
        $field_id = $is_entry_detail || $is_form_editor || $form_id == 0 ? "input_$id" : 'input_' . $form_id . "_$id";
        $atts['type'] = 'hidden';


        $max_star = $this->max_star;
        $step_star = $this->step_star;
        $star_icon = $this->star_icon;
        $label = $this->label;
        $lables = '#'.$label.'';




        if ("icon_1" === $star_icon) {
            return "
            <div class='ginput_container'>
                <input type='hidden' value='0' name=".$label." id=".$label." step=".$step_star." >
                <div class='rateit' data-rateit-backingfld=".$lables." data-rateit-resetable='true' data-rateit-ispreset='true' data-rateit-min='0' data-rateit-max=".$max_star." data-rateit-mode='font' >
                    <input class='rating_val'  name='input_".$id."'  id=". $form_id." type=".$atts['type']."  />
                </div>
            </div>";
        }
        elseif ("icon_2" === $star_icon) {
            return "
            <div class='ginput_container'>
                <input type='hidden' value='0' name=".$label." id=".$label." step=".$step_star." >
                <div class='rateit' data-rateit-backingfld=".$lables." data-rateit-resetable='true' data-rateit-ispreset='true' data-rateit-min='0' data-rateit-max=".$max_star." data-rateit-icon='@' data-rateit-mode='font' >
                    <input class='rating_val'  name='input_".$id."'  id=". $form_id." type=".$atts['type']."  />
                </div>
            </div>";
        }
        elseif ("icon_3" === $star_icon){
            return"
            <div class='ginput_container'>
                <input type='hidden' min='0' name=".$label." value='' step=".$step_star." id=".$label.">
                <div class='rateit' data-rateit-backingfld=".$lables." data-rateit-max=".$max_star.">
                    <input class='rating_val'  name='input_".$id."'  id=". $form_id." type=".$atts['type']."  />
                </div>
            </div>
            ";
        }
        else{};
    }
}
GF_Fields::register(new OC_RS_SRGF_Field_Rating() );




add_action( 'gform_field_standard_settings', 'SRGV_rating_GF_add_custom_field' , 10,  2);
function SRGV_rating_GF_add_custom_field( $position, $form_id )
{
    if ($position == 50) {
    ?> 
    	<li class="max_star field_setting">
            <label for="max_star" class="section_label"><?php  echo esc_html( __( 'Max Star', 'gravityforms' ) );?></label>
            <input type="number" id="max_star"  name="Max star" min="1"  onchange="SetFieldProperty('max_star', this.value);"/>
        </li>

        <li class="step_star field_setting">
            <label for="step_star" class="section_label"><?php  echo esc_html( __( 'Step Star', 'gravityforms' ) );?></label>
            <input type="number" id="step_star"  name="Step star" min="1"  onchange="SetFieldProperty('step_star', this.value);"/>
        </li>
        <li class="star_icon field_setting">
            <label for="star_icon" class="section_label">
                <?php  echo esc_html( __( 'Star Icon', 'gravityforms' ) );?>
            </label>
            <input type="radio" name="icon" value="icon_3" onchange="SetFieldProperty('star_icon', this.value);">
            <img src="<?php  echo SRGF_rating_GF_PLUGIN_DIR."/js/star1.gif"; ?>">

        </li>

    <?php 
    }      
}

add_action('gform_editor_js', 'rating_GF_editor_script', 11, 2);
function rating_GF_editor_script() {
  	?>
    <script type='text/javascript'>
    jQuery(document).ready(function($) {
        jQuery(document).bind("gform_load_field_settings", function(event, field, form){
        	jQuery("#max_star").val(field["max_star"]);
        	jQuery("#step_star").val(field["step_star"]);
            jQuery("input[name=icon][value=" + field["star_icon"] + "]").prop('checked', true);
        });
    });
   	</script>
 	<?php
}

add_action( 'gform_editor_js_set_default_values', 'OC_SRGF_default_values' );
function OC_SRGF_default_values(){
    ?>
   
    case "ocRating" :
        field.label = "Star Ratings";
        field.max_star = 5;
        field.step_star = 1;
        field.star_icon = "icon_3";
    break;
    
    <?php
}

