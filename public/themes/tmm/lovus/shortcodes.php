<?php 


// Hero Slider
add_shortcode('heroslider','heroslider_func');
function heroslider_func($atts, $content = null){
	extract(shortcode_atts(array(
		'slide'		=>	'',
	), $atts));

	ob_start(); 
?>
	
    <div class="owl-slider-nav">
        <div class="next"></div>
        <div class="prev"></div>
    </div>

    <div class="center-y fadeScroll relative" data-scroll-speed="4">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="row">
                        <div class="spacer-single"></div>
                        <div class="col-md-12 text-right text-center-sm relative">
                            <?php echo htmlspecialchars_decode($content); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="custom-owl-slider" class="owl-slide" data-scroll-speed="2">
    	<?php 
			$img_ids = explode(",",$slide);
			foreach( $img_ids AS $img_id ){
			$image_src = wp_get_attachment_image_src($img_id,''); 
		?>
        <div class="item">
            <img src="<?php echo esc_url($image_src[0]); ?>" alt="">
        </div>
        <?php } ?>
    </div>
  	
<?php
    return ob_get_clean();
}

// Icon box
add_shortcode('iconbox', 'iconbox_func');
function iconbox_func($atts, $content = null){
	extract(shortcode_atts(array(
		'icon'		=>	'',
		'title'		=>	'',
		'style'		=>	'',
		'light'		=>	'',
	), $atts));
	ob_start(); ?>

    <div class="icon-box <?php if($style == 'center') echo 'text-center';elseif($style == 'right') echo 'text-right'; ?> <?php if($light) echo 'text-light'; ?>">
		<i class="<?php echo esc_attr($icon); ?> id-color mb20 size40"></i>
        <h4><?php echo htmlspecialchars_decode($title); ?></h4>
        <?php echo htmlspecialchars_decode($content); ?>
	</div>

<?php
    return ob_get_clean();
}

// Service box
add_shortcode('servicesbox', 'servicesbox_func');
function servicesbox_func($atts, $content = null){
	extract(shortcode_atts(array(
		'img'		=>	'',
		'title'		=>	'',
	), $atts));
	$img 	 = wp_get_attachment_image_src($img,'full');
	$img 	 = $img[0];
	ob_start(); ?>

    <div class="service-box text-center">
		<img src="<?php echo esc_url($img); ?>" alt="" class="img-circle mb30"/>
        <h4><?php echo htmlspecialchars_decode($title); ?></h4>
        <?php echo htmlspecialchars_decode($content); ?>
	</div>

<?php
    return ob_get_clean();
}


// Story Timeline
add_shortcode('story','story_func');
function story_func($atts, $content = null){
    extract( shortcode_atts( array(
      'story'  => '',
   ), $atts ) );
	$stories = (array) vc_param_group_parse_atts( $story );
    ob_start(); ?>

    <ul class="timeline">
    	<?php $i=1; foreach ( $stories as $sto ) : if($sto) : ?>
    	<?php $img = wp_get_attachment_image_src($sto['image'],'full'); $img = $img[0]; ?>
        <li class="<?php if( $i%2 == 0 ) echo 'timeline-inverted'; ?> wow fadeInUp">
            <div class="timeline-badge"><i class="fa fa-heart"></i></div>
            <div class="timeline-panel">

                <div class="picframe img-rounded mb20">
                    <a class="image-popup" href="<?php echo esc_url($img); ?>">
							<span class="overlay-v">
								<i></i>
							</span>
						</a>
                    <img src="<?php echo esc_url($img); ?>" class="img-responsive img-rounded" alt="">
                </div>

                <div class="timeline-heading">
                    <h4><?php echo esc_html($sto['date']); ?></h4>
                    <h3 class="mt0"><?php echo esc_html($sto['title']); ?></h3>
                    <div class="tiny-border"></div>
                </div>
                <div class="timeline-body">
                    <p><?php echo esc_html($sto['desc']); ?></p>
                </div>
            </div>
        </li>
        <?php endif; $i++; endforeach; ?>
    </ul>

<?php
    return ob_get_clean();
}

// Event Countdown
add_shortcode('countdown','countdown_func');
function countdown_func($atts, $content = null){
    extract( shortcode_atts( array(
      'year'  => '',       
      'month' => '',       
      'day'   => '',       
      'hour'  => '',       
      'mins'  => '',       
   ), $atts ) );
    ob_start(); ?>

    <div id="defaultCountdown" class="wow fadeIn" data-y="<?php echo esc_attr($year); ?>" data-m="<?php echo esc_attr($month); ?>" data-d="<?php echo esc_attr($day); ?>" data-h="<?php echo esc_attr($hour); ?>" data-mi="<?php echo esc_attr($mins); ?>"></div>

<?php
    return ob_get_clean();
}

// People
add_shortcode('people','peopel_func');
function peopel_func($atts, $content = null){
	extract(shortcode_atts(array(
		'photo'		=>	'',
		'name'		=>	'',
		'who'		=>	'',
	), $atts));
		$img 	 = wp_get_attachment_image_src($photo,'full');
		$img 	 = $img[0];
	ob_start(); 
?>
	
	<div class="text-center">
        <figure class="picframe img-rounded mb20">
            <img src="<?php echo esc_url($img); ?>" class="img-responsive img-rounded" alt="">
        </figure>
        <h3><?php echo htmlspecialchars_decode($name); ?></h3>
        <small><?php echo htmlspecialchars_decode($who); ?></small>
        <div class="spacer-half"></div>
        <p><?php echo htmlspecialchars_decode($content); ?></p>
    </div>

<?php
    return ob_get_clean();
}

// Member Team
add_shortcode('member','member_func');
function member_func($atts, $content = null){
	extract(shortcode_atts(array(
		'photo'		=>	'',
		'name'		=>	'',
		'job'		=>	'',
		'social'	=>	'',
	), $atts));
		$img 	 = wp_get_attachment_image_src($photo,'full');
		$img 	 = $img[0];
		$socials = (array) vc_param_group_parse_atts( $social );
	ob_start(); 
?>

	<div class="profile_pic">
        <figure class="pic-hover hover-scale mb30">
            <img src="<?php echo esc_url($img); ?>" class="img-responsive" alt="">
        </figure>

        <h3><?php echo htmlspecialchars_decode($name); ?></h3>
        <span class="subtitle"><?php echo htmlspecialchars_decode($job); ?></span>
        <span class="tiny-border"></span>
        <?php echo htmlspecialchars_decode($content); ?>
        <?php if($socials) { ?>
		<div class="team-social">
			<ul class="none-style">
				<?php foreach ( $socials as $soc ) : if($soc) : ?>
					<li>
						<a class="id-color" href="<?php echo esc_url($soc['link']); ?>"><i class="<?php echo esc_attr($soc['icon']); ?>"></i></a>
					</li>
				<?php endif; endforeach; ?>
			</ul>
		</div>
		<?php } ?>
    </div>

<?php
    return ob_get_clean();
}


// Testimonial Silder
add_shortcode('testslide','testslide_func');
function testslide_func($atts, $content = null){
	extract(shortcode_atts(array(
		'testi'		=>	'',
	), $atts));
	$test = (array) vc_param_group_parse_atts( $testi );
	ob_start(); 
?>
	
	<div id="testimonial-carousel" class="de_carousel row" data-wow-delay=".3s">
		<?php foreach ( $test as $tes ) { ?>
		<div class="col-md-6 item">
            <div class="de_testi opt-2">
                <blockquote>
                    <p><?php echo htmlspecialchars_decode($tes['text']); ?></p>
                    <div class="de_testi_by"><?php echo esc_html($tes['name']); ?></div>
                </blockquote>

            </div>
        </div>
        <?php } ?>
    </div>

<?php
    return ob_get_clean();
}


// Latest Wedding
add_shortcode('listwedd','listwedd_func');
function listwedd_func($atts, $content = null){
	extract(shortcode_atts(array(
		'wedding'	=>	'',
	), $atts));
	$wedd = (array) vc_param_group_parse_atts( $wedding );
	ob_start(); 
?>
	
	<div id="testimonial-carousel-3" class="de_carousel">
		<?php foreach ( $wedd as $wed ) { ?>
		<?php $img = wp_get_attachment_image_src($wed['photo'],'full'); $img = $img[0]; ?>
		<div class="col-md-6 item">
            <div class="de_testi opt-3">
				<figure class="pic-hover img-rounded hover-scale mb30">
					<img src="<?php echo esc_url($img); ?>" class="img-responsive" alt="">
				</figure>
                <blockquote>
                    <p><?php echo htmlspecialchars_decode($wed['text']); ?></p>
                    <div class="de_testi_by"><?php echo htmlspecialchars_decode($wed['name']); ?></div>
                </blockquote>
            </div>
        </div>
        <?php } ?>
    </div>

<?php
    return ob_get_clean();
}

// Pricing Table
add_shortcode('table', 'table_func');
function table_func($atts, $content = null){
	extract(shortcode_atts(array(
		'cur'		=>	'',
		'title'		=>	'',
		'feat'		=>	'',
		'btn'		=>	'',
		'price'		=>	'',
	), $atts)); 
		$url 	= vc_build_link( $btn );
	ob_start(); ?>

	<div class="pricing-s1 mb30">
		<?php if($feat) { ?><div class="ribbon"><?php echo htmlspecialchars_decode($feat); ?></div><?php } ?>
		<div class="top">
			<h2 class="s1"><?php echo esc_html($title); ?></h2>
			<p class="price"><span class="currency"><?php echo esc_html($cur); ?></span> <b><?php echo esc_html($price); ?></b>
		</div>
		<div class="bottom">
			<?php echo htmlspecialchars_decode($content); ?>
		</div>
		<div class="bottom">
		<?php if ( strlen( $btn ) > 0 && strlen( $url['url'] ) > 0 ) {
			echo '<a class="btn btn-custom" href="' . esc_attr( $url['url'] ) . '" target="' . ( strlen( $url['target'] ) > 0 ? esc_attr( $url['target'] ) : '_self' ) . '">' . htmlspecialchars_decode( $url['title'] ) .'</a>';
		} ?>
		</div>
	</div>

<?php
    return ob_get_clean();
}


// Socials
add_shortcode('socials','socials_func');
function socials_func($atts, $content = null){
	extract(shortcode_atts(array(
		'social'	=>	'',
	), $atts));
		$socials = (array) vc_param_group_parse_atts( $social );
	ob_start(); 
?>

	<div class="social-icons-sm text-center">
		<?php foreach ( $socials as $soc ) : if($soc) : ?>		
			<a href="<?php echo esc_url($soc['link']); ?>"><i class="<?php echo esc_attr($soc['icon']); ?>"></i></a>	
		<?php endif; endforeach; ?>
	</div>

<?php
    return ob_get_clean();
}


// Gallery
add_shortcode('listimage','listimage_func');
function listimage_func($atts, $content = null){
	extract(shortcode_atts(array(
		'gallery'		=> 	'',
		'style'			=> 	'grid',
		'col'		  	=>	'4',	
	), $atts));
		$img = wp_get_attachment_image_src($gallery,'full');
		$img = $img[0];
		if($col == 4){
			$cols = 3;
		}elseif($col == 6){
			$cols = 2;
		}else{
			$cols = 4;
		}
	ob_start(); ?>
    
    <?php if($style == 'grid') { ?>    	
		<div class="row">
			<?php 
				$img_ids = explode(",",$gallery);
				foreach( $img_ids AS $img_id ){
				$image_src = wp_get_attachment_image_src($img_id,''); 
			?>
			<div class="col-md-<?php echo esc_attr($col); ?> text-center mb10">
                <figure class="picframe img-rounded mb20">
                    <a class="image-popup" href="<?php echo esc_url( $image_src[0] ); ?>">
						<span class="overlay-v">
							<i></i>
						</span>
					</a>
                    <img src="<?php echo esc_url( $image_src[0] ); ?>" class="img-responsive img-rounded" alt="">
                </figure>
            </div>
            <?php } ?>
        </div>
    <?php }else{ ?>
    	<div id="gallery-carousel-<?php echo esc_attr($cols); ?>" class="owl-slide">
    		<?php 
				$img_ids = explode(",",$gallery);
				foreach( $img_ids AS $img_id ){
				$image_src = wp_get_attachment_image_src($img_id,''); 
			?>
            <div class="carousel-item">
                <figure class="picframe">
                    <a class="image-popup" href="<?php echo esc_url( $image_src[0] ); ?>">
					<span class="overlay-v">
					<i></i>
					</span>
				</a>
                    <img src="<?php echo esc_url( $image_src[0] ); ?>" class="img-responsive" alt="">
                </figure>
            </div>
            <?php } ?>
        </div>
    <?php } ?>

<?php
    return ob_get_clean();	
}

//Google Map

add_shortcode('maps','maps_func');
function maps_func($atts, $content = null){
	extract(shortcode_atts(array(
		'height'	 	 => '450px',
		'imgmap'	 	 => '',
		'tooltip'	 	 => '',
		'latitude'		 => '',
		'longitude'	 	 => '',
		'zoom'		 	 => '',
	), $atts));
	$id = 'map-canvas-'.(rand(10,10000));
	ob_start(); ?>
	<?php 
		$img = wp_get_attachment_image_src($imgmap,'full');
		$img = $img[0];
		if(!$zoom){
			$zoom = 13;
		}
	 ?>

	<div id="<?php echo esc_attr($id); ?>" class="map-warp" style="<?php if($height) echo 'height: '.esc_attr($height).';';?>"></div>

	<script>
	(function($) { "use strict";
		var mapOptions = {
        zoom: <?php echo esc_js($zoom); ?>,
        scrollwheel: false,
        center: new google.maps.LatLng(<?php echo esc_js($latitude); ?>, <?php echo esc_js($longitude); ?>, 20.75),
        styles: [
        {
            "featureType": "landscape",
            "stylers": [
                {
                    "hue": "#FFA800"
                },
                {
                    "saturation": 0
                },
                {
                    "lightness": 0
                },
                {
                    "gamma": 1
                }
            ]
        },
        {
            "featureType": "road.highway",
            "stylers": [
                {
                    "hue": "#53FF00"
                },
                {
                    "saturation": -73
                },
                {
                    "lightness": 40
                },
                {
                    "gamma": 1
                }
            ]
        },
        {
            "featureType": "road.arterial",
            "stylers": [
                {
                    "hue": "#FBFF00"
                },
                {
                    "saturation": 0
                },
                {
                    "lightness": 0
                },
                {
                    "gamma": 1
                }
            ]
        },
        {
            "featureType": "road.local",
            "stylers": [
                {
                    "hue": "#00FFFD"
                },
                {
                    "saturation": 0
                },
                {
                    "lightness": 30
                },
                {
                    "gamma": 1
                }
            ]
        },
        {
            "featureType": "water",
            "stylers": [
                {
                    "hue": "#00BFFF"
                },
                {
                    "saturation": 6
                },
                {
                    "lightness": 8
                },
                {
                    "gamma": 1
                }
            ]
        },
        {
            "featureType": "poi",
            "stylers": [
                {
                    "hue": "#679714"
                },
                {
                    "saturation": 33.4
                },
                {
                    "lightness": -25.4
                },
                {
                    "gamma": 1
                }
            ]
        }
    ]
    };
	
    var mapElement = document.getElementById('<?php echo esc_attr($id); ?>'),
		map = new google.maps.Map(mapElement, mapOptions),
		marker = new google.maps.Marker({
			position: new google.maps.LatLng(<?php echo esc_js($latitude); ?>, <?php echo esc_js($longitude); ?>, 20.75),
			map: map,
			title: '',
			icon: '<?php echo esc_url($img); ?>'
		});
	})(jQuery); 

	</script>

	<?php

    return ob_get_clean();

}
