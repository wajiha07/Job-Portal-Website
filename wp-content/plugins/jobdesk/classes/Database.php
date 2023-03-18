<?php

namespace JobDesk\Classes;

use Exception;

/**
 * Class Database
 */

class Database {

  public static $settingsTable = "jobdesk_dynamic_settings";
  public static $jobsApiConfigurationsTable = "jobdesk_api_setup";
  public static $applyJobFormFields = "jobdesk_apply_job_form";

  public static function init() {
    try {
      global $wpdb;
      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

      # creating table to store readers reward codes
      $createSettingsTable = "CREATE TABLE " . self::$settingsTable . " (
                id INT(255) PRIMARY KEY AUTO_INCREMENT,
                logo_width INT(3),
                logo_height INT(3),
                logo_height_flex ENUM('true', 'false'),
                logo_width_flex ENUM('true', 'false'),
                logo_link_to_homepage ENUM('true', 'false'),
                contact_number VARCHAR(20),
                email VARCHAR(255),
                address TEXT
            )";

      $createJobsApiConfigurationsTable = "CREATE TABLE " . self::$jobsApiConfigurationsTable . " (
                id INT(1) PRIMARY KEY AUTO_INCREMENT,
                all_jobs_endpoint TEXT,
                top_jobs_endpoint TEXT,
                single_job_endpoint TEXT,
                code_table_endpoint TEXT,
                apply_job_endpoint TEXT,
                client_key VARCHAR(255),
                parse_cv_endpoint TEXT,
                parse_cv_appclientid VARCHAR(255),
                parse_cv_token VARCHAR(255),
                parse_cv_language VARCHAR(2)
            )";

      $createApplyJobFormFields = "CREATE TABLE " . self::$applyJobFormFields . " (
                id INT(2) PRIMARY KEY AUTO_INCREMENT,
                field_name VARCHAR(255) NOT NULL UNIQUE,
                display_name VARCHAR(255) NOT NULL,
                enabled ENUM('true', 'false')
            )";

      # executing the sql
      dbDelta($createSettingsTable);
      dbDelta($createJobsApiConfigurationsTable);
      dbDelta($createApplyJobFormFields);

      if (!self::getJobdeskSettings()) {
        $wpdb->insert(
          self::$settingsTable,
          [
            'logo_width' => 200,
            'logo_height' => 90,
            'logo_width_flex' => 'false',
            'logo_height_flex' => 'false',
            'logo_link_to_homepage' => 'true'
          ],
          ['%d', '%d', '%s', '%s', '%s']
        );
      }

      if (!self::getJobsApiConfigurations()) {
        $wpdb->insert(
          self::$jobsApiConfigurationsTable,
          [
            'client_key' => '',
            'all_jobs_endpoint' => '',
            'single_job_endpoint' => '',
            'top_jobs_endpoint' => '',
            'apply_job_endpoint' => '',
            'parse_cv_token' => '',
            'parse_cv_appclientid' => '',
            'parse_cv_endpoint' => '',
            'code_table_endpoint' => ''
          ],
          ['%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s']
        );
      }


      $fields = [
        'FirstName' => 'First Name',
        'LastName' => 'Last Name',
        'Phone' => 'Phone',
        'EmailAddress' => 'Email Address',
        'SalutationGender' => 'Gender',
        'StreetNumber' => ['Street Number', false],
        'Zip' => ['Zip', false],
        'Origin' => ['Origin', false],
        'City' => ['City', false],
        'Country' => ['Country', false],
        'Position' => ['Position', false],
        'CVFile1' => 'Attachment',
        'ApplicantComments' => 'Comments',
        'AgreeTermsAndConditions' => 'Terms and Conditions'
      ];
      foreach ($fields as $field_name => $display_name) {
        if (gettype($display_name) == 'array') {
          self::addNewFieldToApplyJobForm($field_name, $display_name[0], $display_name[1]);
        } else {
          self::addNewFieldToApplyJobForm($field_name, $display_name);
        }
      }
    } catch (Exception $e) {}
  }


  public static function getJobdeskSettings() {
    return $GLOBALS['wpdb']->get_row("SELECT * FROM " . self::$settingsTable . " WHERE id='1'", OBJECT);
  }

  public static function getJobsApiConfigurations() {
    return $GLOBALS['wpdb']->get_row("SELECT * FROM " . self::$jobsApiConfigurationsTable . " WHERE id='1'", OBJECT);
  }

  public static function getApplyJobFormFields() {
    return $GLOBALS['wpdb']->get_results("SELECT * FROM " . self::$applyJobFormFields, OBJECT);
  }

  public static function getApplyJobFormEnabledFields() {
    return $GLOBALS['wpdb']->get_results("SELECT * FROM " . self::$applyJobFormFields . " WHERE enabled = 'true'", OBJECT);
  }

  public static function getOneApplyJobFormField(string $field_name) {
    return $GLOBALS['wpdb']->get_row("SELECT * FROM " . self::$applyJobFormFields . " WHERE field_name='$field_name'", OBJECT);
  }

  public static function addNewFieldToApplyJobForm(string $field_name, string $display_name, bool $enabled = true) {
    if (!self::getOneApplyJobFormField($field_name)) {
      return $GLOBALS['wpdb']->insert(
        self::$applyJobFormFields,
        [
          'field_name' => $field_name,
          'display_name' => $display_name,
          'enabled' => $enabled ? 'true' : 'false'
        ],
        [ '%s', '%s', '%s' ]
      );
    } else {
      return false;
    }
  }

  public static function updateJobsApiConfigurations(
    string $client_key = '',
    string $all_jobs_endpoint = '',
    string $single_job_endpoint = '',
    string $top_jobs_endpoint = '',
    string $apply_job_endpoint = '',
    string $code_table_endpoint = ''
  ) {

    $updated = $GLOBALS['wpdb']->update(
    self::$jobsApiConfigurationsTable,
      [
        'client_key' => $client_key,
        'all_jobs_endpoint' => $all_jobs_endpoint,
        'single_job_endpoint' => $single_job_endpoint,
        'top_jobs_endpoint' => $top_jobs_endpoint,
        'apply_job_endpoint' => $apply_job_endpoint,
        'code_table_endpoint' => $code_table_endpoint
      ],
      [
        'id' => 1
      ]
    );

    return $updated ? 'success' : 'error';

  }


  public static function updateCVParsingEndpoints(
    string $parse_cv_token = '',
    string $parse_cv_appclientid = '',
    string $parse_cv_endpoint = '',
    string $parse_cv_language = ''
  ) {

    $updated = $GLOBALS['wpdb']->update(
    self::$jobsApiConfigurationsTable,
      [
        'parse_cv_token' => $parse_cv_token,
        'parse_cv_appclientid' => $parse_cv_appclientid,
        'parse_cv_endpoint' => $parse_cv_endpoint,
        'parse_cv_language' => $parse_cv_language
      ],
      [
        'id' => 1
      ]
    );

    return $updated ? 'success' : 'error';

  }


  public static function updateApplyJobFormField(string $field_name, string $display_name, bool $enabled) {

    return $GLOBALS['wpdb']->update(
      self::$applyJobFormFields,
      [
        'display_name' => $display_name,
        'enabled' => $enabled ? 'true' : 'false'
      ],
      [
        'field_name' => $field_name
      ]
    ) ? 'success' : 'error';

  }


  public static function resetJobsApiConfigurations() {
    $updated = $GLOBALS['wpdb']->update(
      self::$jobsApiConfigurationsTable,
      [
        'client_key' => '',
        'all_jobs_endpoint' => '',
        'single_job_endpoint' => '',
        'top_jobs_endpoint' => '',
        'apply_job_endpoint' => '',
        'code_table_endpoint' => ''
      ],
      [
        'id' => 1
      ]
    );

    return $updated ? 'success' : 'error';
  }


  public static function update(int $logo_width, int $logo_height, bool $logo_width_flex, bool $logo_height_flex, bool $logo_link_to_homepage, string $email, string $contact_number, string $address) {

    $updated = $GLOBALS['wpdb']->update(
    self::$settingsTable,
      [
        'logo_link_to_homepage' => $logo_link_to_homepage ? 'true' : 'false',
        'logo_width_flex' => $logo_width_flex ? 'true' : 'false',
        'logo_height_flex' => $logo_height_flex ? 'true' : 'false',
        'logo_width' => $logo_width,
        'logo_height' => $logo_height,
        'email' => $email,
        'contact_number' => $contact_number,
        'address' => $address,
      ],
      [
        'id' => 1
      ]
    );

    return $updated ? 'success' : 'error';

  }

}
