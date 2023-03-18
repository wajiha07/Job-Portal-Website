<?php

namespace JobDesk\Classes;




class JobdeskSettings
{

  function __construct()
  {
    AdminPages::init();
    Database::init();
    add_action('admin_enqueue_scripts', [$this, 'addAdminScripts']);
    add_action('after_setup_theme', [$this, 'registerCustomLogo']);
    add_action('wp_ajax_Jobdesk_Settings_AjaxHandler', [$this, 'Jobdesk_Settings_AjaxHandler']);
    $this->addShortCodes();
  }

  function addAdminScripts()
  {
    wp_enqueue_media();
    wp_enqueue_script('jobdesk-admin', plugin_dir_url(dirname(__FILE__)) . 'assets/js/admin.js', ['jquery'], false, true);
  }

  function Jobdesk_Settings_AjaxHandler($hook)
  {

    if (isset($_POST['changeSiteLogo'])) {
      $id = intval($_POST['post_id']);
      $prefix = $GLOBALS['wpdb']->prefix;
      $isImageLogoEnabled = ($GLOBALS['wpdb']->get_row("SELECT * FROM " . $prefix . "options WHERE option_name = 'site_logo'", ARRAY_A)) ? true : false;
      if ($isImageLogoEnabled) {
        echo $GLOBALS['wpdb']->update(
          $prefix . 'options',
          ['option_value' => $id],
          ['option_name' => 'site_logo']
        ) ? 'success' : 'error';
      } else {
        echo $GLOBALS['wpdb']->insert(
          $prefix . 'options',
          [
            'option_name' => 'site_logo',
            'option_value' => $id
          ],
          ['%s', '%d']
        ) ? 'success' : 'error';
      }
    } else if (isset($_POST['reset_api_setup'])) {
      if (is_admin()) {
        echo Database::resetJobsApiConfigurations();
      } else {
        echo 'unauthorized';
      }
    }

    wp_die();
  }

  function registerCustomLogo()
  {

    $jobdeskSettings = Database::getJobdeskSettings();
    add_theme_support('custom-logo', [
      'height'               => $jobdeskSettings->logo_height,
      'width'                => $jobdeskSettings->logo_width,
      'flex-height'          => true,
      'flex-width'           => $jobdeskSettings->logo_width_flex,
      'header-text'          => array('site-title', 'site-description'),
      'unlink-homepage-logo' => !($jobdeskSettings->logo_link_to_homepage == 'true')
    ]);
  }

  function displayCustomLogo()
  {

    ob_start();

    if (function_exists('the_custom_logo')) {

      $jobdeskSettings = Database::getJobdeskSettings();
      $custom_logo_id = get_theme_mod('custom_logo');
      $logo = wp_get_attachment_image_src($custom_logo_id, 'full');

      $JD_Jobdesk_Settings_logo_width = "width: $jobdeskSettings->logo_width" . "px";
      if ($jobdeskSettings->logo_width_flex == 'true') {
        $JD_Jobdesk_Settings_logo_width = "max-width: $jobdeskSettings->logo_width" . "px; width: auto;";
      }

      $JD_Jobdesk_Settings_logo_height = "height: $jobdeskSettings->logo_height" . "px";
      if ($jobdeskSettings->logo_height_flex == 'true') {
        $JD_Jobdesk_Settings_logo_height = "max-height: $jobdeskSettings->logo_height" . "px; height: auto;";
      }

?>

      <style>
        #jobdesk-logo {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
          color: inherit;
        }
      </style>

      <?php if (has_custom_logo()) : ?>

        <?php if ($jobdeskSettings->logo_link_to_homepage == 'true') : ?>
          <a href="<?php echo get_bloginfo('url') ?>">
          <?php endif ?>

          <img class="jobdesk-logo" style="<?php echo $JD_Jobdesk_Settings_logo_width;
                                            $JD_Jobdesk_Settings_logo_height; ?>" src="<?php echo esc_url($logo[0]) ?>" alt="<?php echo get_bloginfo('name') ?>" />

          <?php if ($jobdeskSettings->logo_link_to_homepage == 'true') : ?>
          </a>
        <?php endif ?>

      <?php else : ?>

        <?php if ($jobdeskSettings->logo_link_to_homepage == 'true') : ?>
          <a href="<?php echo get_bloginfo('url') ?>">
          <?php endif ?>

          <h1 class="jobdesk-logo"><?php echo get_bloginfo('name') ?></h1>

          <?php if ($jobdeskSettings->logo_link_to_homepage == 'true') : ?>
          </a>
        <?php endif ?>

<?php endif;
    }

    $logo = ob_get_clean();
    return $logo;
  }

  function addShortCodes()
  {

    add_shortcode('jobdesk-logo', [$this, 'displayCustomLogo']);

    add_shortcode('jobdesk-number', function () {
      $jobdeskSettings = Database::getJobdeskSettings();
      return "<span class='jobdesk-number'>$jobdeskSettings->contact_number</span>";
    });

    add_shortcode('jobdesk-address', function () {
      $jobdeskSettings = Database::getJobdeskSettings();
      return "<p class='jobdesk-address'>$jobdeskSettings->address</p>";
    });

    add_shortcode('jobdesk-email', function () {
      $jobdeskSettings = Database::getJobdeskSettings();
      return "<span class='jobdesk-email'>$jobdeskSettings->email</span>";
    });

    add_shortcode('jobdesk-title', function () {
      $jobdeskSettings = Database::getJobdeskSettings();
      return get_bloginfo('name');
    });

    add_shortcode('jobdesk-subtitle', function () {
      $jobdeskSettings = Database::getJobdeskSettings();
      return get_bloginfo('description');
    });
  }
}
