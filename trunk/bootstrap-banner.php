<?php
/*
Plugin Name: Bootstrap Banner
Plugin URI: http://www.github.com/ewels/bootstrap-banner/
Description: A Wordpress Customiser Widget to add a global website banner, styled using a Bootstrap Alert.
Version: 1.0dev
Author: Phil Ewels
Author URI: http://phil.ewels.co.uk
Text Domain: bootstrap-banner
License: GPLv2
*/

//
// Theme customiser
//
function bootstrap_banner_theme_customizer( $wp_customize ) {

    // Regeneration button custom control
    class WP_Bootstrap_Banner_Dismiss_ID_Control extends WP_Customize_Control {
        public $type = 'button';
        public function render_content() {
            ?>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
            <button type="button" class="button-primary" onclick="bootstrap_banner_regen_cookie_id();"><?php _e('Refresh Dismissal ID'); ?></button>
            <code id="_customize-bootstrap-banner-regen-preview"><?php echo esc_attr($this->value()); ?></code>
            <input type="hidden" name="_customize-input-<?php echo esc_attr($this->id); ?>" id="_customize-bootstrap-banner-regen-input" <?php $this->link(); ?>>
            <script type="text/javascript">
            function bootstrap_banner_regen_cookie_id(){
                var new_id = '';
                var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                for (var i = 0; i < 12; i++){
                    new_id += characters.charAt(Math.floor(Math.random() * characters.length));
                }
                jQuery('#_customize-input-bootstrap_banner[alert_before]').val(new_id);
                jQuery('#_customize-bootstrap-banner-regen-input').trigger('change');
            }
            </script>
            <?php
        }
    }

    // Customiser section
    $wp_customize->add_section('bootstrap_banner', array(
        'title' => __('Banner Message'),
        'description' => __('Show an alert box at the top of every page.'),
        'priority' => 32
    ) );

    // Enable / disable alert
    $wp_customize->add_setting('bootstrap_banner[enabled]', array(
        'type' => 'option',
        'default' => true
    ));
    $wp_customize->add_control('bootstrap_banner[enabled]', array(
        'type' => 'checkbox',
        'label' => __('Enable banner message'),
        'section' => 'bootstrap_banner'
    ) );

    // Alert class
    $wp_customize->add_setting('bootstrap_banner[colour]', array(
        'type' => 'option',
        'default' => 'alert-primary'
    ));
    $wp_customize->add_control('bootstrap_banner[colour]', array(
        'type' => 'select',
        'label' => 'Alert Colour',
        'choices' => array(
            'alert-primary' => 'Primary (blue)',
            'alert-danger' => 'Danger (red)',
            'alert-warning' => 'Warning (yellow)',
            'alert-success' => 'Success (green)',
            'alert-info' => 'Info (turquoise)',
            'alert-secondary' => 'Secondary (grey)',
        ),
        'section' => 'bootstrap_banner'
    ) );

    // Header text
    $wp_customize->add_setting('bootstrap_banner[header_text]', array('type' => 'option'));
    $wp_customize->add_control('bootstrap_banner[header_text]', array(
        'type' => 'text',
        'label' => __('Header text'),
        'description' => __('Header for the alert (optional).'),
        'section' => 'bootstrap_banner',
    ) );

    // Body text
    $wp_customize->add_setting('bootstrap_banner[body_text]', array('type' => 'option'));
    $wp_customize->add_control('bootstrap_banner[body_text]', array(
        'type' => 'textarea',
        'label' => __('Main Text'),
        'description' => __('Main body text for the alert. You can use HTML.'),
        'section' => 'bootstrap_banner'
    ) );

    // Link text
    $wp_customize->add_setting('bootstrap_banner[link_text]', array('type' => 'option'));
    $wp_customize->add_control('bootstrap_banner[link_text]', array(
        'type' => 'text',
        'label' => __('Button Text'),
        'description' => __('Text for a button at the bottom of the alert (optional)'),
        'section' => 'bootstrap_banner'
    ) );

    // Link URL
    $wp_customize->add_setting('bootstrap_banner[link_url]', array('type' => 'option'));
    $wp_customize->add_control('bootstrap_banner[link_url]', array(
        'type' => 'text',
        'label' => __('Button URL'),
        'description' => __('URL for a button at the bottom of the alert (optional)'),
        'input_attrs' => array( 'placeholder' => get_site_url() ),
        'section' => 'bootstrap_banner'
    ) );

    // Link open-in-new-window
    $wp_customize->add_setting('bootstrap_banner[link_new_window]', array('type' => 'option'));
    $wp_customize->add_control('bootstrap_banner[link_new_window]', array(
        'type' => 'checkbox',
        'label' => __('Open link in new window'),
        'description' => __('Select to make the button open the link in a new window'),
        'section' => 'bootstrap_banner'
    ) );

    // Link button class
    $wp_customize->add_setting('bootstrap_banner[link_class]', array(
        'type' => 'option',
        'default' => 'btn-primary'
    ));
    $wp_customize->add_control('bootstrap_banner[link_class]', array(
        'type' => 'select',
        'label' => __('Button style'),
        'description' => __('Bootstrap class for button colour'),
        'choices' => array(
            'btn-primary' => 'Primary (blue)',
            'btn-danger' => 'Danger (red)',
            'btn-warning' => 'Warning (yellow)',
            'btn-success' => 'Success (green)',
            'btn-info' => 'Info (turquoise)',
            'btn-secondary' => 'Secondary (grey)',
            'btn-light' => 'Light (light grey)',
            'btn-dark' => 'Dark (dark grey)',
            'btn-outline-primary' => 'Outline - Primary (blue)',
            'btn-outline-danger' => 'Outline - Danger (red)',
            'btn-outline-warning' => 'Outline - Warning (yellow)',
            'btn-outline-success' => 'Outline - Success (green)',
            'btn-outline-info' => 'Outline - Info (turquoise)',
            'btn-outline-secondary' => 'Outline - Secondary (grey)',
            'btn-outline-light' => 'Outline - Light (light grey)',
            'btn-outline-dark' => 'Outline - Dark (dark grey)',
            'btn-link' => 'Link (link-text)',
        ),
        'section' => 'bootstrap_banner'
    ) );

    // Button large / sm / block
    $wp_customize->add_setting('bootstrap_banner[link_btn_lg]', array('type' => 'option'));
    $wp_customize->add_control('bootstrap_banner[link_btn_lg]', array(
        'type' => 'checkbox',
        'label' => __('Large link button'),
        'section' => 'bootstrap_banner'
    ) );
    $wp_customize->add_setting('bootstrap_banner[link_btn_sm]', array('type' => 'option'));
    $wp_customize->add_control('bootstrap_banner[link_btn_sm]', array(
        'type' => 'checkbox',
        'label' => __('Small link button'),
        'section' => 'bootstrap_banner'
    ) );
    $wp_customize->add_setting('bootstrap_banner[link_btn_block]', array('type' => 'option'));
    $wp_customize->add_control('bootstrap_banner[link_btn_block]', array(
        'type' => 'checkbox',
        'label' => __('Block button'),
        'section' => 'bootstrap_banner'
    ) );

    // Dismissal expiration
    $wp_customize->add_setting('bootstrap_banner[dismiss_expiry]', array(
        'type' => 'option',
        'default' => '14'
    ));
    $wp_customize->add_control('bootstrap_banner[dismiss_expiry]', array(
        'type' => 'number',
        'label' => __('Dismissal expiration'),
        'description' => __('Number of days that the dismissal cookie lasts for.'),
        'section' => 'bootstrap_banner'
    ) );

    // Show dismiss button
    $wp_customize->add_setting('bootstrap_banner[dismiss_btn]', array(
        'type' => 'option',
        'default' => true
    ));
    $wp_customize->add_control('bootstrap_banner[dismiss_btn]', array(
        'type' => 'checkbox',
        'label' => __('Show dismiss button?'),
        'description' => __('Small x dismiss button in the top-right. Adds a cookie to remember preference.'),
        'section' => 'bootstrap_banner'
    ) );

    // Regenerate dismissal ID
    $wp_customize->add_setting('bootstrap_banner[dismiss_id]', array('type' => 'option'));
    $wp_customize->add_control(
        new WP_Bootstrap_Banner_Dismiss_ID_Control(
            $wp_customize,
            'bootstrap_banner[dismiss_id]',
            array(
                'label' => __( 'Regenerate dismissal ID' ),
                'description' => __('Click to set a new dismissal ID, so that alert is visible to all users immediately.'),
                'section' => 'bootstrap_banner',
            )
        )
    );

    // Alert - before
    $wp_customize->add_setting('bootstrap_banner[alert_before]', array(
        'type' => 'option',
        'default' => '<div class="bootstrap-banner container">'
    ));
    $wp_customize->add_control('bootstrap_banner[alert_before]', array(
        'type' => 'text',
        'label' => __('Before header'),
        'description' => __('HTML to prefix the alert with'),
        'section' => 'bootstrap_banner'
    ) );
    // Alert - after
    $wp_customize->add_setting('bootstrap_banner[alert_after]', array(
        'type' => 'option',
        'default' => '</div>'
    ));
    $wp_customize->add_control('bootstrap_banner[alert_after]', array(
        'type' => 'text',
        'label' => __('After header'),
        'description' => __('HTML to suffix the alert with'),
        'section' => 'bootstrap_banner'
    ) );

    // Header - before
    $wp_customize->add_setting('bootstrap_banner[header_before]', array(
        'type' => 'option',
        'default' => '<h4 class="bootstrap-banner-heading alert-heading">'
    ));
    $wp_customize->add_control('bootstrap_banner[header_before]', array(
        'type' => 'text',
        'label' => __('Before header'),
        'description' => __('HTML to prefix header with'),
        'section' => 'bootstrap_banner'
    ) );
    // Header - after
    $wp_customize->add_setting('bootstrap_banner[header_after]', array(
        'type' => 'option',
        'default' => '</h4>'
    ));
    $wp_customize->add_control('bootstrap_banner[header_after]', array(
        'type' => 'text',
        'label' => __('After header'),
        'description' => __('HTML to suffix header with'),
        'section' => 'bootstrap_banner'
    ) );

    // Link - before
    $wp_customize->add_setting('bootstrap_banner[link_before]', array(
        'type' => 'option',
        'default' => '<p class="bootstrap-banner-btn-p mb-0">'
    ));
    $wp_customize->add_control('bootstrap_banner[link_before]', array(
        'type' => 'text',
        'label' => __('Before link'),
        'description' => __('HTML to prefix the link with'),
        'section' => 'bootstrap_banner'
    ) );
    // Link - after
    $wp_customize->add_setting('bootstrap_banner[link_after]', array(
        'type' => 'option',
        'default' => '</p>'
    ));
    $wp_customize->add_control('bootstrap_banner[link_after]', array(
        'type' => 'text',
        'label' => __('After link'),
        'description' => __('HTML to suffix the link with'),
        'section' => 'bootstrap_banner'
    ) );

}
add_action('customize_register', 'bootstrap_banner_theme_customizer');




//
// Banner output
//

// Shortcode
function bootstrap_banner($atts_raw=array()) {
    // All possible keys with default values
    $defaults = array(
        'enabled' => true,
        'colour' => 'alert-primary',
        'header_text' => '',
        'body_text' => '',
        'link_text' => '',
        'link_url' => '',
        'link_class' => 'btn-primary',
        'link_new_window' => false,
        'link_btn_lg' => false,
        'link_btn_sm' => false,
        'link_btn_block' => false,
        'dismiss_btn' => true,
        'dismiss_expiry' => '14',
        'dismiss_id' => '',
        'alert_before' => '<div class="bootstrap-banner container">',
        'alert_after' => '</div>',
        'header_before' => '<h4 class="bootstrap-banner-heading alert-heading">',
        'header_after' => '</h4>',
        'link_before' => '<p class="bootstrap-banner-btn-p mb-0">',
        'link_after' => '</p>'
    );

    // Merge defaults with settings from the Customizer
    $options = shortcode_atts($defaults, get_option('bootstrap_banner'));

    // Merge settings with anything supplied from the shortcode / function call
    $options = shortcode_atts($options, $atts_raw);

    // Return if banner is disabled
    if(!$options['enabled']){
        return;
    }

    // Return if we have a dismissal cookie
    if(isset($_COOKIE['bootstrap_banner_dismiss_id']) && $_COOKIE['bootstrap_banner_dismiss_id'] == $options['dismiss_id']) {
        return;
    }

    // Trim whitespace from everything (being paranoid)
    $trim_keys = array(
        'header_text',
        'body_text',
        'link_text',
        'link_url',
        'dismiss_id',
        'dismiss_expiry',
        'alert_before',
        'alert_after',
        'header_before',
        'header_after',
        'link_before',
        'link_after'
    );
    foreach($trim_keys as $key){
        $options[$key] = trim($options[$key]);
    }

    // Check that we have a dismissal ID - generate one and save if not
    if(!strlen($options['dismiss_id'])){
        $options['dismiss_id'] = wp_generate_password(12, false);
        update_option('bootstrap_banner', $options);
    }

    // Generate the contents of the alert
    $contents = '';
    if(strlen($options['header_text'])){
        $contents .= $options['header_before'].$options['header_text'].$options['header_after'];
    }
    if(strlen($options['body_text'])){
        $contents .= '<div class="bootstrap-banner-body">'.$options['body_text'].'</div>';
    }
    if(strlen($options['link_text']) && strlen($options['link_url'])){
        $btn_classes = array('bootstrap-banner-btn', 'btn', 'mt-2');
        $btn_classes[] = $options['link_class'];
        if($options['link_btn_lg']) $btn_classes[] = 'btn-lg';
        if($options['link_btn_sm']) $btn_classes[] = 'btn-sm';
        if($options['link_btn_block']) $btn_classes[] = 'btn-block';
        $target = '';
        if($options['link_new_window']) $target = 'target="_blank"';
        $contents .= $options['link_before'].'<a class="'.implode(' ', $btn_classes).'" href="'.$options['link_url'].'" '.$target.'>'.$options['link_text'].'</a>'.$options['link_after'];
    }
    // Return if banner has no contents
    if(!strlen($contents)){
        return;
    }

    // Build the alert
    $alert_classes = array('bootstrap-banner-alert', 'mt-3', 'alert', $options['colour']);
    $alert_dismiss_btn = '';
    if($options['dismiss_btn']){
        $alert_classes = array_merge($alert_classes, array('alert-dismissible', 'fade', 'show'));
        $alert_dismiss_btn = '<button type="button" class="bootstrap-banner-close close" data-dismiss="alert" data-dismiss-id="'.$options['dismiss_id'].'" data-dismiss-expiry="'.$options['dismiss_expiry'].'" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    }
    $alert = $options['alert_before'].'<div class="'.implode(' ', $alert_classes).'">'.$alert_dismiss_btn.$contents.'</div>'.$options['alert_after'];

    // Build the JavaScript
    ob_start(); ?>
    <script type="text/javascript">
    var close_btn = document.getElementsByClassName('bootstrap-banner-close');
    var bootstrap_banner_close = function() {
        var dismiss_id = this.getAttribute("data-dismiss-id");
        var dismiss_expiry = this.getAttribute("data-dismiss-expiry");
        var dismiss_date = new Date();
        dismiss_date.setDate(dismiss_date.getDate() + parseInt(dismiss_expiry));
        console.log(dismiss_date, dismiss_date.toUTCString());
        document.cookie = 'bootstrap_banner_dismiss_id='+dismiss_id+'; expires='+dismiss_date.toUTCString()+'; path=/';
    };
    for (var i = 0; i < close_btn.length; i++) {
        close_btn[i].addEventListener('click', bootstrap_banner_close, false);
    }
    </script>
    <?php
    $js = ob_get_contents();
    ob_end_clean();

    // Return the output
    return $alert.$js;
}
add_shortcode('bootstrap-banner', 'bootstrap_banner');
