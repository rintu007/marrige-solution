<?php 

// Hero Slider
if(function_exists('vc_map')){
   vc_map( array(
   "name" => esc_html__("OT Hero Slider", 'lovus'),
   "base" => "heroslider",
   "class" => "",
   "category" => 'Lovus Element',
   "icon" => "icon-st",
   "params" => array(
      array(
         "type" => "attach_images",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__('Images Slider', 'lovus'),
         "param_name" => "slide",
         "value" => "",
      ),
      array(
         "type" => "textarea_html",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Content Slider", 'lovus'),
         "param_name" => "content",
         "value" => "",
      ),  
    )
    ));
}

// Service box
if(function_exists('vc_map')){
   vc_map( array(
   "name" => esc_html__("OT Service Box", 'lovus'),
   "base" => "servicesbox",
   "class" => "",
   "category" => 'Lovus Element',
   "icon" => "icon-st",
   "params" => array(
      array(
         "type" => "attach_image",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Icon Image", 'lovus'),
         "param_name" => "img",
         "value" => "",
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Title", 'lovus'),
         "param_name" => "title",
         "value" => "",
      ),
      array(
         "type" => "textarea_html",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Description", 'lovus'),
         "param_name" => "content",
         "value" => "",
      ),
    )
    ));
}

// Icon box
if(function_exists('vc_map')){
   vc_map( array(
   "name" => esc_html__("OT Icon Box", 'lovus'),
   "base" => "iconbox",
   "class" => "",
   "admin_enqueue_css" => get_template_directory_uri() . '/css/vc/icon-field.css',
   "category" => 'Lovus Element',
   "icon" => "icon-st",
   "params" => array(
      array(
         "type" => "dropdown",
         "heading" => esc_html__('Style Box', 'lovus'),
         "param_name" => "style",
         "value" => array(
            esc_html__('Align Left', 'lovus')   => 'left',
            esc_html__('Align Right', 'lovus')  => 'right',
            esc_html__('Align Center', 'lovus') => 'center',
         ), 
      ),  
      array(
         "type" => "icon",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Icon", 'lovus'),
         "param_name" => "icon",
         "value" => "",
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Title", 'lovus'),
         "param_name" => "title",
         "value" => "",
      ),
      array(
         "type" => "textarea_html",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Description", 'lovus'),
         "param_name" => "content",
         "value" => "",
      ),
      array(
         "type" => "checkbox",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Light Text", 'lovus'),
         "param_name" => "light",
         "value" => "",
      ),
    )
    ));
}


// Story Timeline
if(function_exists('vc_map')){
   vc_map( array(
   "name" => esc_html__("OT Story Timeline", 'lovus'),
   "base" => "story",
   "class" => "",
   "category" => 'Lovus Element',
   "icon" => "icon-st",
   "params" => array(
      array(
          'type' => 'param_group',
          'heading' => esc_html__("Stories", 'lovus'),
          'value' => '',
          'param_name' => 'story',
          // Note params is mapped inside param-group:
          'params' => array(
               array(
                  'type' => 'attach_image',
                  'value' => '',
                  'heading' => esc_html__('Photo', 'lovus'),
                  'param_name' => 'image',
               ),
               array(
                  'type' => 'textfield',
                  'value' => '',
                  'heading' => esc_html__('Date', 'lovus'),
                  'param_name' => 'date',
               ),
               array(
                  'type' => 'textfield',
                  'value' => '',
                  'heading' => esc_html__('Title', 'lovus'),
                  'param_name' => 'title',
               ),
               array(
                  'type' => 'textarea',
                  'value' => '',
                  'heading' => esc_html__('Description', 'lovus'),
                  'param_name' => 'desc',
               ),
          )
      ),
    )));
}

// Event Countdown
if(function_exists('vc_map')){
   vc_map( array(
   "name" => esc_html__("OT Event Countdown", 'lovus'),
   "base" => "countdown",
   "class" => "",
   "category" => 'Lovus Element',
   "icon" => "icon-st",
   "params" => array(  
      array(
        'type' => 'textfield',
         "heading" => esc_html__("Year", 'lovus'),
         "param_name" => "year",         
      ),
      array(
        'type' => 'textfield',
         "heading" => esc_html__("Month", 'lovus'),
         "param_name" => "month",         
      ),
      array(
        'type' => 'textfield',
         "heading" => esc_html__("Day", 'lovus'),
         "param_name" => "day",         
      ),
      array(
        'type' => 'textfield',
         "heading" => esc_html__("Hour", 'lovus'),
         "param_name" => "hour",         
      ),
      array(
        'type' => 'textfield',
         "heading" => esc_html__("Minutes", 'lovus'),
         "param_name" => "mins",         
      ),
    )
   ));
}

// People
if(function_exists('vc_map')){
   vc_map( array(
   "name" => esc_html__("OT People", 'lovus'),
   "base" => "people",
   "class" => "",
   "category" => 'Lovus Element',
   "icon" => "icon-st",
   "params" => array(
      array(
         "type" => "attach_image",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Photo", 'lovus'),
         "param_name" => "photo",
         "value" => "",
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Name", 'lovus'),
         "param_name" => "name",
         "value" => "",
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Who?", 'lovus'),
         "param_name" => "who",
         "value" => "",
      ),
      array(
         "type" => "textarea_html",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Details", 'lovus'),
         "param_name" => "content",
         "value" => "",
      ),
    )
    ));
}


// Member Team
if(function_exists('vc_map')){
   vc_map( array(
   "name" => esc_html__("OT Member Team", 'lovus'),
   "base" => "member",
   "class" => "",
   "category" => 'Lovus Element',
   "icon" => "icon-st",
   "params" => array(
      array(
         "type" => "attach_image",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Photo", 'lovus'),
         "param_name" => "photo",
         "value" => "",
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Member Name", 'lovus'),
         "param_name" => "name",
         "value" => "",
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Member Job", 'lovus'),
         "param_name" => "job",
         "value" => "",
      ),
      array(
         "type" => "textarea_html",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Details", 'lovus'),
         "param_name" => "content",
         "value" => "",
      ),
      array(
          'type' => 'param_group',
          'heading' => esc_html__("Socials", 'lovus'),
          'value' => '',
          'param_name' => 'social',
          // Note params is mapped inside param-group:
          'params' => array(
               array(
                  'type' => 'iconpicker',
                  'value' => '',
                  'heading' => 'Social Icon',
                  'param_name' => 'icon',
               ),
               array(
                  'type' => 'textfield',
                  'value' => '',
                  'heading' => 'Social Link',
                  'param_name' => 'link',
               ),
          )
      ),
    )
    ));
}


// Testimonial Slider
if(function_exists('vc_map')){
   vc_map( array(
   "name" => esc_html__("OT Testimonials", 'lovus'),
   "base" => "testslide",
   "class" => "",
   "category" => 'Lovus Element',
   "icon" => "icon-st",
   "params" => array(
      array(
          'type' => 'param_group',
          'heading' => esc_html__("Testimonial", 'lovus'),
          'value' => '',
          'param_name' => 'testi',
          // Note params is mapped inside param-group:
          'params' => array(
               array(
                  'type' => 'textfield',
                  'value' => '',
                  'heading' => esc_html__('Name', 'lovus'),
                  'param_name' => 'name',
               ),
               array(
                  'type' => 'textarea',
                  'value' => '',
                  'heading' => esc_html__('Text', 'lovus'),
                  'param_name' => 'text',
               ),
          )
      ),
    )));
}


// Latest Wedding
if(function_exists('vc_map')){
   vc_map( array(
   "name" => esc_html__("OT Latest Wedding", 'lovus'),
   "base" => "listwedd",
   "class" => "",
   "category" => 'Lovus Element',
   "icon" => "icon-st",
   "params" => array(
      array(
          'type' => 'param_group',
          'heading' => esc_html__("Testimonial", 'lovus'),
          'value' => '',
          'param_name' => 'wedding',
          // Note params is mapped inside param-group:
          'params' => array(
               array(
                  "type" => "attach_image",
                  "holder" => "div",
                  "class" => "",
                  "heading" => esc_html__('Photo', 'lovus'),
                  "param_name" => "photo",
                  "value" => "",
               ), 
               array(
                  'type' => 'textfield',
                  'value' => '',
                  'heading' => esc_html__('Name', 'lovus'),
                  'param_name' => 'name',
               ),
               array(
                  'type' => 'textarea',
                  'value' => '',
                  'heading' => esc_html__('Testimonial', 'lovus'),
                  'param_name' => 'text',
               ),
          )
      ),
    )));
}


// Pricing Table
if(function_exists('vc_map')){
   vc_map( array(
   "name" => esc_html__("OT Pricing Table", 'lovus'),
   "base" => "table",
   "class" => "",
   "category" => 'Lovus Element',
   "icon" => "icon-st",
   "params" => array(
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Title", 'lovus'),
         "param_name" => "title",
         "value" => "",
         "description" => esc_html__("Title of table", 'lovus')
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Price", 'lovus'),
         "param_name" => "price",
         "value" => "",
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Currency", 'lovus'),
         "param_name" => "cur",
         "value" => "",
      ),
      array(
         "type" => "textarea_html",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Description", 'lovus'),
         "param_name" => "content",
         "value" => "",
      ),
      array(
        'type' => 'vc_link',
         "heading" => esc_html__("Button", 'lovus'),
         "param_name" => "btn",         
         "description" => esc_html__("Add link and label to Button.", 'lovus'),
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Recommend Text", 'lovus'),
         "param_name" => "feat",
         "value" => "",
         "description" => esc_html__("Enter text if recommend this package.", 'lovus')
      )
    )));
}


// Socials
if(function_exists('vc_map')){
   vc_map( array(
   "name" => esc_html__("OT Socials", 'lovus'),
   "base" => "socials",
   "class" => "",
   "category" => 'Lovus Element',
   "icon" => "icon-st",
   "params" => array(
      array(
          'type' => 'param_group',
          'heading' => esc_html__("Socials", 'lovus'),
          'value' => '',
          'param_name' => 'social',
          // Note params is mapped inside param-group:
          'params' => array(
               array(
                  'type' => 'iconpicker',
                  'value' => '',
                  'heading' => 'Social Icon',
                  'param_name' => 'icon',
               ),
               array(
                  'type' => 'textfield',
                  'value' => '',
                  'heading' => 'Social Link',
                  'param_name' => 'link',
               ),
          )
      ),
    )
    ));
}

// Gallery 
if(function_exists('vc_map')){
   vc_map( array(
   "name" => esc_html__("OT Gallery", 'lovus'),
   "base" => "listimage",
   "class" => "",
   "category" => 'Lovus Element',
   "icon" => "icon-st",
   "params" => array(
      array(
         "type" => "attach_images",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__('Images', 'lovus'),
         "param_name" => "gallery",
         "value" => "",
      ), 
      array(
         "type" => "dropdown",
         "heading" => esc_html__('Style', 'lovus'),
         "param_name" => "style",
         "value" => array(                     
            esc_html__('Grid', 'lovus')   => 'grid',
            esc_html__('Slider', 'lovus') => 'slider',
         ),
      ),
      array(
         "type" => "dropdown",
         "heading" => esc_html__('Columns', 'lovus'),
         "param_name" => "col",
         "value" => array(                     
            esc_html__('3 Columns', 'lovus')   => '4',
            esc_html__('2 Columns', 'lovus')   => '6',
            esc_html__('4 Columns', 'lovus')   => '3',
         ),
      ),     
    )
    ));
}


//Google Map

if(function_exists('vc_map')){
   vc_map( array(
   "name"      => __("OT Google Maps", 'lovus'),
   "base"      => "maps",
   "class"     => "",
   "icon" => "icon-st",
   "category"  => 'Content',
   "params"    => array(
      
      array(
         "type"      => "textfield",
         "holder"    => "div",
         "class"     => "",
         "heading"   => __("Latitude", 'lovus'),
         "param_name"=> "latitude",
         "value"     => 40.706187,
         "description" => __("", 'lovus')
      ),
     array(
         "type"      => "textfield",
         "holder"    => "div",
         "class"     => "",
         "heading"   => __("Longitude", 'lovus'),
         "param_name"=> "longitude",
         "value"     => -74.008833,
         "description" => __("", 'lovus')
      ),     
     array(
         "type"      => "attach_image",
         "holder"    => "div",
         "class"     => "",
         "heading"   => __("Location Image", 'lovus'),
         "param_name"=> "imgmap",
         "value"     => "",
         "description" => __("Upload Location Image.", 'lovus')
      ),
     array(
         "type"      => "textfield",
         "holder"    => "div",
         "class"     => "",
         "heading"   => __("Zoom map number", 'lovus'),
         "param_name"=> "zoom",
         "value"     => '',
         "description" => __("", 'lovus')
      ),
     array(
         "type"      => "textfield",
         "holder"    => "div",
         "class"     => "",
         "heading"   => __("Height (px)", 'lovus'),
         "param_name"=> "height",
         "value"     => '',
         "description" => __("Ex: 400px.", 'lovus')
      ),
    )));
}



//Add More Icons

$GLOBALS['icons'] = get_icons();

if ( function_exists( 'vc_add_shortcode_param' ) ) {
   vc_add_shortcode_param( 'icon', 'icon_param', get_template_directory_uri() . '/js/vc/icon-field.js' );
} elseif ( function_exists( 'add_shortcode_param' ) ) {
   add_shortcode_param( 'icon', 'icon_param', get_template_directory_uri() . '/js/vc/icon-field.js' );
}

function icon_param( $settings, $value ) {
  // Generate dependencies if there are any
   $icons = array();
  foreach( $GLOBALS['icons'] as $icon ) {
    $icons[] = sprintf(
      '<i data-icon="%1$s" class="%1$s %2$s"></i>',
      $icon,
      $icon == $value ? 'selected' : ''
    );
  }

  return sprintf(
    '<div class="icon_block">
      <span class="icon-preview"><i class="%s"></i></span>
      <input type="text" class="icons-search" placeholder="%s">
      <input type="hidden" name="%s" value="%s" class="wpb_vc_param_value wpb-textinput %s %s_field">
      <div class="icon-selector">%s</div>
    </div>',
    esc_attr( $value ),
    esc_attr__( 'Quick Search', 'lovus' ),
    esc_attr( $settings['param_name'] ),
    esc_attr( $value ),
    esc_attr( $settings['param_name'] ),
    esc_attr( $settings['type'] ),
    implode( '', $icons )
  );
}

function get_icons() {
   $icons_etline = array('icon-mobile', 'icon-laptop', 'icon-desktop', 'icon-tablet', 'icon-phone', 'icon-document', 'icon-documents', 'icon-search', 'icon-clipboard', 'icon-newspaper', 'icon-notebook', 'icon-book-open', 'icon-browser', 'icon-calendar', 'icon-presentation', 'icon-picture', 'icon-pictures', 'icon-video', 'icon-camera', 'icon-printer', 'icon-toolbox', 'icon-briefcase', 'icon-wallet', 'icon-gift', 'icon-bargraph', 'icon-grid', 'icon-expand', 'icon-focus', 'icon-edit', 'icon-adjustments', 'icon-ribbon', 'icon-hourglass', 'icon-lock', 'icon-megaphone', 'icon-shield', 'icon-trophy', 'icon-flag', 'icon-map', 'icon-puzzle', 'icon-basket', 'icon-envelope', 'icon-streetsign', 'icon-telescope', 'icon-gears', 'icon-key', 'icon-paperclip', 'icon-attachment', 'icon-pricetags', 'icon-lightbulb', 'icon-layers', 'icon-pencil', 'icon-tools', 'icon-tools-2', 'icon-scissors', 'icon-paintbrush', 'icon-magnifying-glass', 'icon-circle-compass', 'icon-linegraph', 'icon-mic', 'icon-strategy', 'icon-beaker', 'icon-caution', 'icon-recycle', 'icon-anchor', 'icon-profile-male', 'icon-profile-female', 'icon-bike', 'icon-wine', 'icon-hotairballoon', 'icon-globe', 'icon-genius', 'icon-map-pin', 'icon-dial', 'icon-chat', 'icon-heart', 'icon-cloud', 'icon-upload', 'icon-download', 'icon-target', 'icon-hazardous', 'icon-piechart', 'icon-speedometer', 'icon-global', 'icon-compass', 'icon-lifesaver', 'icon-clock', 'icon-aperture', 'icon-quote', 'icon-scope', 'icon-alarmclock', 'icon-refresh', 'icon-happy', 'icon-sad', 'icon-facebook', 'icon-twitter', 'icon-googleplus', 'icon-rss', 'icon-tumblr', 'icon-linkedin', 'icon-dribbble');
   $icons_awesome = array('fa fa-adjust', 'fa fa-adn', 'fa fa-align-center', 'fa fa-align-justify', 'fa fa-align-left', 'fa fa-align-right', 'fa fa-ambulance', 'fa fa-anchor', 'fa fa-android', 'fa fa-angellist', 'fa fa-angle-double-down', 'fa fa-angle-double-left', 'fa fa-angle-double-right', 'fa fa-angle-double-up', 'fa fa-angle-down', 'fa fa-angle-left', 'fa fa-angle-right', 'fa fa-angle-up', 'fa fa-apple', 'fa fa-archive', 'fa fa-area-chart', 'fa fa-arrow-circle-down', 'fa fa-arrow-circle-left', 'fa fa-arrow-circle-o-down', 'fa fa-arrow-circle-o-left', 'fa fa-arrow-circle-o-right', 'fa fa-arrow-circle-o-up', 'fa fa-arrow-circle-right', 'fa fa-arrow-circle-up', 'fa fa-arrow-down', 'fa fa-arrow-left', 'fa fa-arrow-right', 'fa fa-arrow-up', 'fa fa-arrows', 'fa fa-arrows-alt', 'fa fa-arrows-h', 'fa fa-arrows-v', 'fa fa-asterisk', 'fa fa-at', 'fa fa-automobile', 'fa fa-backward', 'fa fa-ban', 'fa fa-bank', 'fa fa-bar-chart', 'fa fa-bar-chart-o', 'fa fa-barcode', 'fa fa-bars', 'fa fa-beer', 'fa fa-behance', 'fa fa-behance-square', 'fa fa-bell', 'fa fa-bell-o', 'fa fa-bell-slash', 'fa fa-bell-slash-o', 'fa fa-bicycle', 'fa fa-binoculars', 'fa fa-birthday-cake', 'fa fa-bitbucket', 'fa fa-bitbucket-square', 'fa fa-bitcoin', 'fa fa-bold', 'fa fa-bolt', 'fa fa-bomb', 'fa fa-book', 'fa fa-bookmark', 'fa fa-bookmark-o', 'fa fa-briefcase', 'fa fa-btc', 'fa fa-bug', 'fa fa-building', 'fa fa-building-o', 'fa fa-bullhorn', 'fa fa-bullseye', 'fa fa-bus', 'fa fa-cab', 'fa fa-calculator', 'fa fa-calendar', 'fa fa-calendar-o', 'fa fa-camera', 'fa fa-camera-retro', 'fa fa-car', 'fa fa-caret-down', 'fa fa-caret-left', 'fa fa-caret-right', 'fa fa-caret-square-o-down', 'fa fa-caret-square-o-left', 'fa fa-caret-square-o-right', 'fa fa-caret-square-o-up', 'fa fa-caret-up', 'fa fa-cc', 'fa fa-cc-amex', 'fa fa-cc-discover', 'fa fa-cc-mastercard', 'fa fa-cc-paypal', 'fa fa-cc-stripe', 'fa fa-cc-visa', 'fa fa-certificate', 'fa fa-chain', 'fa fa-chain-broken', 'fa fa-check', 'fa fa-check-circle', 'fa fa-check-circle-o', 'fa fa-check-square', 'fa fa-check-square-o', 'fa fa-chevron-circle-down', 'fa fa-chevron-circle-left', 'fa fa-chevron-circle-right', 'fa fa-chevron-circle-up', 'fa fa-chevron-down', 'fa fa-chevron-left', 'fa fa-chevron-right', 'fa fa-chevron-up', 'fa fa-child', 'fa fa-circle', 'fa fa-circle-o', 'fa fa-circle-o-notch', 'fa fa-circle-thin', 'fa fa-clipboard', 'fa fa-clock-o', 'fa fa-close', 'fa fa-cloud', 'fa fa-cloud-download', 'fa fa-cloud-upload', 'fa fa-cny', 'fa fa-code', 'fa fa-code-fork', 'fa fa-codepen', 'fa fa-coffee', 'fa fa-cog', 'fa fa-cogs', 'fa fa-columns', 'fa fa-comment', 'fa fa-comment-o', 'fa fa-comments', 'fa fa-comments-o', 'fa fa-compass', 'fa fa-compress', 'fa fa-copy', 'fa fa-copyright', 'fa fa-credit-card', 'fa fa-crop', 'fa fa-crosshairs', 'fa fa-css3', 'fa fa-cube', 'fa fa-cubes', 'fa fa-cut', 'fa fa-cutlery', 'fa fa-dashboard', 'fa fa-database', 'fa fa-dedent', 'fa fa-delicious', 'fa fa-desktop', 'fa fa-deviantart', 'fa fa-digg', 'fa fa-dollar', 'fa fa-dot-circle-o', 'fa fa-download', 'fa fa-dribbble', 'fa fa-dropbox', 'fa fa-drupal', 'fa fa-edit', 'fa fa-eject', 'fa fa-ellipsis-h', 'fa fa-ellipsis-v', 'fa fa-empire', 'fa fa-envelope', 'fa fa-envelope-o', 'fa fa-envelope-square', 'fa fa-eraser', 'fa fa-eur', 'fa fa-euro', 'fa fa-exchange', 'fa fa-exclamation', 'fa fa-exclamation-circle', 'fa fa-exclamation-triangle', 'fa fa-expand', 'fa fa-external-link', 'fa fa-external-link-square', 'fa fa-eye', 'fa fa-eye-slash', 'fa fa-eyedropper', 'fa fa-facebook', 'fa fa-facebook-square', 'fa fa-fast-backward', 'fa fa-fast-forward', 'fa fa-fax', 'fa fa-female', 'fa fa-fighter-jet', 'fa fa-file', 'fa fa-file-archive-o', 'fa fa-file-audio-o', 'fa fa-file-code-o', 'fa fa-file-excel-o', 'fa fa-file-image-o', 'fa fa-file-movie-o', 'fa fa-file-o', 'fa fa-file-pdf-o', 'fa fa-file-photo-o', 'fa fa-file-picture-o', 'fa fa-file-powerpoint-o', 'fa fa-file-sound-o', 'fa fa-file-text', 'fa fa-file-text-o', 'fa fa-file-video-o', 'fa fa-file-word-o', 'fa fa-file-zip-o', 'fa fa-files-o', 'fa fa-film', 'fa fa-filter', 'fa fa-fire', 'fa fa-fire-extinguisher', 'fa fa-flag', 'fa fa-flag-checkered', 'fa fa-flag-o', 'fa fa-flash', 'fa fa-flask', 'fa fa-flickr', 'fa fa-floppy-o', 'fa fa-folder', 'fa fa-folder-o', 'fa fa-folder-open', 'fa fa-folder-open-o', 'fa fa-font', 'fa fa-forward', 'fa fa-foursquare', 'fa fa-frown-o', 'fa fa-futbol-o', 'fa fa-gamepad', 'fa fa-gavel', 'fa fa-gbp', 'fa fa-ge', 'fa fa-gear', 'fa fa-gears', 'fa fa-gift', 'fa fa-git', 'fa fa-git-square', 'fa fa-github', 'fa fa-github-alt', 'fa fa-github-square', 'fa fa-gittip', 'fa fa-glass', 'fa fa-globe', 'fa fa-google', 'fa fa-google-plus', 'fa fa-google-plus-square', 'fa fa-google-wallet', 'fa fa-graduation-cap', 'fa fa-group', 'fa fa-h-square', 'fa fa-hacker-news', 'fa fa-hand-o-down', 'fa fa-hand-o-left', 'fa fa-hand-o-right', 'fa fa-hand-o-up', 'fa fa-hdd-o', 'fa fa-header', 'fa fa-headphones', 'fa fa-heart', 'fa fa-heart-o', 'fa fa-history', 'fa fa-home', 'fa fa-hospital-o', 'fa fa-html5', 'fa fa-ils', 'fa fa-image', 'fa fa-inbox', 'fa fa-indent', 'fa fa-info', 'fa fa-info-circle', 'fa fa-inr', 'fa fa-instagram', 'fa fa-institution', 'fa fa-ioxhost', 'fa fa-italic', 'fa fa-joomla', 'fa fa-jpy', 'fa fa-jsfiddle', 'fa fa-key', 'fa fa-keyboard-o', 'fa fa-krw', 'fa fa-language', 'fa fa-laptop', 'fa fa-lastfm', 'fa fa-lastfm-square', 'fa fa-leaf', 'fa fa-legal', 'fa fa-lemon-o', 'fa fa-level-down', 'fa fa-level-up', 'fa fa-life-bouy', 'fa fa-life-buoy', 'fa fa-life-ring', 'fa fa-life-saver', 'fa fa-lightbulb-o', 'fa fa-line-chart', 'fa fa-link', 'fa fa-linkedin', 'fa fa-linkedin-square', 'fa fa-linux', 'fa fa-list', 'fa fa-list-alt', 'fa fa-list-ol', 'fa fa-list-ul', 'fa fa-location-arrow', 'fa fa-lock', 'fa fa-long-arrow-down', 'fa fa-long-arrow-left', 'fa fa-long-arrow-right', 'fa fa-long-arrow-up', 'fa fa-magic', 'fa fa-magnet', 'fa fa-mail-forward', 'fa fa-mail-reply', 'fa fa-mail-reply-all', 'fa fa-male', 'fa fa-map-marker', 'fa fa-maxcdn', 'fa fa-meanpath', 'fa fa-medkit', 'fa fa-meh-o', 'fa fa-microphone', 'fa fa-microphone-slash', 'fa fa-minus', 'fa fa-minus-circle', 'fa fa-minus-square', 'fa fa-minus-square-o', 'fa fa-mobile', 'fa fa-mobile-phone', 'fa fa-money', 'fa fa-moon-o', 'fa fa-mortar-board', 'fa fa-music', 'fa fa-navicon', 'fa fa-newspaper-o', 'fa fa-openid', 'fa fa-outdent', 'fa fa-pagelines', 'fa fa-paint-brush', 'fa fa-paper-plane', 'fa fa-paper-plane-o', 'fa fa-paperclip', 'fa fa-paragraph', 'fa fa-paste', 'fa fa-pause', 'fa fa-paw', 'fa fa-paypal', 'fa fa-pencil', 'fa fa-pencil-square', 'fa fa-pencil-square-o', 'fa fa-phone', 'fa fa-phone-square', 'fa fa-photo', 'fa fa-picture-o', 'fa fa-pie-chart', 'fa fa-pied-piper', 'fa fa-pied-piper-alt', 'fa fa-pinterest', 'fa fa-pinterest-square', 'fa fa-plane', 'fa fa-play', 'fa fa-play-circle', 'fa fa-play-circle-o', 'fa fa-plug', 'fa fa-plus', 'fa fa-plus-circle', 'fa fa-plus-square', 'fa fa-plus-square-o', 'fa fa-power-off', 'fa fa-print', 'fa fa-puzzle-piece', 'fa fa-qq', 'fa fa-qrcode', 'fa fa-question', 'fa fa-question-circle', 'fa fa-quote-left', 'fa fa-quote-right', 'fa fa-ra', 'fa fa-random', 'fa fa-rebel', 'fa fa-recycle', 'fa fa-reddit', 'fa fa-reddit-square', 'fa fa-refresh', 'fa fa-remove', 'fa fa-renren', 'fa fa-reorder', 'fa fa-repeat', 'fa fa-reply', 'fa fa-reply-all', 'fa fa-retweet', 'fa fa-rmb', 'fa fa-road', 'fa fa-rocket', 'fa fa-rotate-left', 'fa fa-rotate-right', 'fa fa-rouble', 'fa fa-rss', 'fa fa-rss-square', 'fa fa-rub', 'fa fa-ruble', 'fa fa-rupee', 'fa fa-save', 'fa fa-scissors', 'fa fa-search', 'fa fa-search-minus', 'fa fa-search-plus', 'fa fa-send', 'fa fa-send-o', 'fa fa-share', 'fa fa-share-alt', 'fa fa-share-alt-square', 'fa fa-share-square', 'fa fa-share-square-o', 'fa fa-shekel', 'fa fa-sheqel', 'fa fa-shield', 'fa fa-shopping-cart', 'fa fa-sign-in', 'fa fa-sign-out', 'fa fa-signal', 'fa fa-sitemap', 'fa fa-skype', 'fa fa-slack', 'fa fa-sliders', 'fa fa-slideshare', 'fa fa-smile-o', 'fa fa-soccer-ball-o', 'fa fa-sort', 'fa fa-sort-alpha-asc', 'fa fa-sort-alpha-desc', 'fa fa-sort-amount-asc', 'fa fa-sort-amount-desc', 'fa fa-sort-asc', 'fa fa-sort-desc', 'fa fa-sort-down', 'fa fa-sort-numeric-asc', 'fa fa-sort-numeric-desc', 'fa fa-sort-up', 'fa fa-soundcloud', 'fa fa-space-shuttle', 'fa fa-spinner', 'fa fa-spoon', 'fa fa-spotify', 'fa fa-square', 'fa fa-square-o', 'fa fa-stack-exchange', 'fa fa-stack-overflow', 'fa fa-star', 'fa fa-star-half', 'fa fa-star-half-empty', 'fa fa-star-half-full', 'fa fa-star-half-o', 'fa fa-star-o', 'fa fa-steam', 'fa fa-steam-square', 'fa fa-step-backward', 'fa fa-step-forward', 'fa fa-stethoscope', 'fa fa-stop', 'fa fa-strikethrough', 'fa fa-stumbleupon', 'fa fa-stumbleupon-circle', 'fa fa-subscript', 'fa fa-suitcase', 'fa fa-sun-o', 'fa fa-superscript', 'fa fa-support', 'fa fa-table', 'fa fa-tablet', 'fa fa-tachometer', 'fa fa-tag', 'fa fa-tags', 'fa fa-tasks', 'fa fa-taxi', 'fa fa-tencent-weibo', 'fa fa-terminal', 'fa fa-text-height', 'fa fa-text-width', 'fa fa-th', 'fa fa-th-large', 'fa fa-th-list', 'fa fa-thumb-tack', 'fa fa-thumbs-down', 'fa fa-thumbs-o-down', 'fa fa-thumbs-o-up', 'fa fa-thumbs-up', 'fa fa-ticket', 'fa fa-times', 'fa fa-times-circle', 'fa fa-times-circle-o', 'fa fa-tint', 'fa fa-toggle-down', 'fa fa-toggle-left', 'fa fa-toggle-off', 'fa fa-toggle-on', 'fa fa-toggle-right', 'fa fa-toggle-up', 'fa fa-trash', 'fa fa-trash-o', 'fa fa-tree', 'fa fa-trello', 'fa fa-trophy', 'fa fa-truck', 'fa fa-try', 'fa fa-tty', 'fa fa-tumblr', 'fa fa-tumblr-square', 'fa fa-turkish-lira', 'fa fa-twitch', 'fa fa-twitter', 'fa fa-twitter-square', 'fa fa-umbrella', 'fa fa-underline', 'fa fa-undo', 'fa fa-university', 'fa fa-unlink', 'fa fa-unlock', 'fa fa-unlock-alt', 'fa fa-unsorted', 'fa fa-upload', 'fa fa-usd', 'fa fa-user', 'fa fa-user-md', 'fa fa-users', 'fa fa-video-camera', 'fa fa-vimeo-square', 'fa fa-vine', 'fa fa-vk', 'fa fa-volume-down', 'fa fa-volume-off', 'fa fa-volume-up', 'fa fa-warning', 'fa fa-wechat', 'fa fa-weibo', 'fa fa-weixin', 'fa fa-wheelchair', 'fa fa-wifi', 'fa fa-windows', 'fa fa-won', 'fa fa-wordpress', 'fa fa-wrench', 'fa fa-xing', 'fa fa-xing-square', 'fa fa-yahoo', 'fa fa-yelp', 'fa fa-yen', 'fa fa-youtube', 'fa fa-youtube-play', 'fa fa-youtube-square', );
   $icons = array_merge( $icons_awesome, $icons_etline );
   return apply_filters( 'lovus_theme_icons', $icons );
}