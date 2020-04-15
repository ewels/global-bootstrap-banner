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

// Theme customiser
function bootstrap_banner_theme_customizer( $wp_customize ) {

    // Regeneration button custom control
    class WP_Bootstrap_Banner_Dismiss_ID_Control extends WP_Customize_Control {
        public $type = 'button';
        public function render_content() {
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
                <button type="button" class="button" id="_customize-bootstrap-banner-regen-btn" onclick="document.getElementById('_customize-input-<?php echo esc_attr($this->id); ?>').value = '<?php echo wp_generate_password(12, false); ?>'; this.classList.add('disabled'); this.classList.add('button-primary');">Refresh Dismissal ID</button>
                <input type="hidden" name="_customize-input-<?php echo esc_attr($this->id); ?>" id="_customize-input-<?php echo esc_attr($this->id); ?>" <?php $this->link(); ?>>
            </label>
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
    $wp_customize->add_setting('bootstrap_banner[colour]', array('type' => 'option'));
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
    $wp_customize->add_setting('bootstrap_banner[header]', array('type' => 'option'));
    $wp_customize->add_control('bootstrap_banner[header]', array(
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
        'description' => __('Number of days that the dismissal cookie lasts for. Use -1 for "forever"'),
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
    $wp_customize->add_setting('bootstrap_banner[dismiss_id]', array(
        'type' => 'option',
        'default' => wp_generate_password(12, false)
    ));
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

}
add_action('customize_register', 'bootstrap_banner_theme_customizer');
