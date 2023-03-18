<?php

#hiding php errors

use JobDesk\Classes\Database;

ini_set('display_errors', false);

get_header();

$jobdesk_ref_code = sanitize_text_field($_GET['www']);
$jobsApiConfigurations = \JobDesk\Classes\Database::getJobsApiConfigurations();
if ($jobsApiConfigurations->single_job_endpoint) {
  $url = $jobsApiConfigurations->single_job_endpoint . $jobdesk_ref_code;
  $res = file_get_contents($url);
} else {
  $res = false;
}

?>

<link rel="stylesheet" href="<?php echo plugin_dir_url(dirname(dirname(__FILE__))) ?>/assets/css/needshare.min.css">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php

if (!$res) {

?>

  <div class="job-detail-header v1 bg-white">
    <div class="container bg-white">
      <div class="row bg-white">
        <div class="col-md-12 text-center px-5">
          <h3 class="text-center text-danger w-100">Job Not Found!</h3>
        </div>
      </div>
    </div>
  </div>

<?php } else {

  $applyJobFormFields = [];
  foreach (Database::getApplyJobFormEnabledFields() as $field) {
    $applyJobFormFields[$field->field_name] = $field;
  }

  $res_de = json_decode($res);

  # extracting the JobType form the query parameters
  $JobType = isset($_GET['JobType']) ? trim($_GET['JobType']) : 'Vollzeit';
  $params = array(
    'ClientKey' => $jobsApiConfigurations->client_key,
    'id' => '1',
    'LanguageCode' => 'de'
  );

  $url =  $jobsApiConfigurations->code_table_endpoint . '?' . http_build_query($params);
  $response = file_get_contents($url);
  $decode_r = json_decode($response);

?>
  <div class="jd-popup-area-shadow"></div>

  <div class="jd-popup-area">
    <div class="jd-popup-box" id="jd-popup-box">

      <div class="jd-popup-header">
        <div class="title">Apply for <span></span></div>
        <button class="jd-popup-close" title="Close">&times;</button>
      </div>

      <div class="jd-popup-automatic-section">
        <div class="file-drop-section">
          <img draggable="false" src="<?php echo plugin_dir_url(dirname(dirname(__FILE__))) . 'assets/images/drop-cv.png'; ?>" alt="Upload CV" id="current-file-drop-image" />
          <img draggable="false" alt="Upload CV" id="current-file-processing-animation" src="<?php echo plugin_dir_url(dirname(dirname(__FILE__))) . 'assets/images/file-loading.gif'; ?>" style="display: none;" />
          <input type="file" accept=".pdf,.doc,.docx" id="jd-popup-file-processor-input">
          <span id="jd-processing-text" style="display:none;color:red">Processing...</span>
          <span id="jd-drag-and-drop-text">Drag & drop CV here <label id="jd-popup-file-processor-input-label" for="jd-popup-file-processor-input">Browse</label></span>
          <br>
          <span style="margin-top: 5px;">Supported formats are PDF, Docx and Doc</span>
        </div>
        <div class="file-drop-info">
          <span>or</span>
        </div>
        <button id="jd-popup-fill-form-manually-btn">Enter information manually</button>
      </div>

      <div class="jd-popup-manual-section">

        <div class="jd-popup-go-back-text">
          <span id="jd-popup-go-back-btn">&larr;</span> Go back to upload your cv and we will fill the information for you
        </div>

        <div class="loader">
          <img src="https://flevix.com/wp-content/uploads/2019/07/Color-Loading-2.gif" alt="">
        </div>

        <!--Show Successful Message  -->
        <div class="jd-application-status-mas"></div>

        <div class="jd-job-apply-form-wrapper">
          <form class="jd-job-apply" method="post" enctype="multipart/form-data">

            <input style="display: none;" name="RefCode" type="text" value="<?php echo esc_attr($res_de->RefCode); ?>">
            <input style="display: none;" name="action" type="text" value="jd_job_apply">
            <input style="display: none;" name="ExternalRefCode" type="text" value="a">

            <div class="form-input-group">
              <?php if (isset($applyJobFormFields['Origin'])) : ?>
                <div class="form-input-group-component-4">
                  <div class="nhr-crb">
                    <?php
                    foreach ($decode_r as $row) :
                      $first_one_checked = ($decode_r[0] == $row) ? true : false;
                    ?>
                      <input <?php echo ($first_one_checked ? 'checked="true"' : '') ?> id="origin-<?php echo $row->Code; ?>" name="Origin" type="radio" value="<?php echo $row->Code; ?>" required />
                      <label for="origin-<?php echo $row->Code; ?>"><?php echo $row->Value; ?></label>
                    <?php endforeach; ?>
                  </div>
                </div>
              <?php endif; ?>

              <?php if (isset($applyJobFormFields['SalutationGender'])) : ?>
                <div class="form-input-group-component-3">
                  <select name="SalutationGender" id="Gender" class="gender wpcf7-form-control wpcf7-textarea form-control" required>
                    <option value="" selected>Select <?php _e($applyJobFormFields['SalutationGender']->display_name) ?></option>
                    <option value="1"><?php _e("Male") ?></option>
                    <option value="2"><?php _e("Female") ?></option>
                  </select>
                </div>
              <?php endif; ?>
            </div>

            <div class="form-input-group">
              <?php if (isset($applyJobFormFields['FirstName'])) : ?>
                <div class="form-input-group-component">
                  <input class="input-box wpcf7-form-control wpcf7-textarea form-control" name="FirstName" id="FirstName" type="text" placeholder="<?php _e($applyJobFormFields['FirstName']->display_name) ?>*" required>
                </div>
              <?php endif; ?>

              <?php if (isset($applyJobFormFields['LastName'])) : ?>
                <div class="form-input-group-component">
                  <input class="input-box wpcf7-form-control wpcf7-textarea form-control" name="LastName" id="LastName" type="text" placeholder="<?php _e($applyJobFormFields['LastName']->display_name) ?>*" required>
                </div>
              <?php endif; ?>
            </div>

            <div class="form-input-group">
              <?php if (isset($applyJobFormFields['EmailAddress'])) : ?>
                <div class="form-input-group-component">
                  <input class="input-box wpcf7-form-control wpcf7-textarea form-control" name="EmailAddress" id="EmailAddress" type="email" placeholder="<?php _e($applyJobFormFields['EmailAddress']->display_name) ?>*" required>
                </div>
              <?php
              endif;
              if (isset($applyJobFormFields['Phone'])) :
              ?>
                <div class="form-input-group-component">
                  <input class="input-box wpcf7-form-control wpcf7-textarea form-control" name="Phone" id="Phone" type="tel" placeholder="<?php _e($applyJobFormFields['Phone']->display_name) ?>">
                </div>
              <?php
              endif;
              if (isset($applyJobFormFields['StreetNumber'])) :
              ?>
                <div class="form-input-group-component">
                  <input class="input-box wpcf7-form-control wpcf7-textarea form-control" name="StreetNumber" id="StreetNumber" type="text" placeholder="<?php _e($applyJobFormFields['StreetNumber']->display_name) ?>*" required>
                </div>

              <?php
              endif;
              if (isset($applyJobFormFields['Zip'])) :
              ?>
                <div class="form-input-group-component">
                  <input class="input-box wpcf7-form-control wpcf7-textarea form-control" name="Zip" id="Zip" type="text" placeholder="<?php _e($applyJobFormFields['Zip']->display_name) ?>*" required>
                </div>
              <?php
              endif;
              if (isset($applyJobFormFields['City'])) :
              ?>
                <div class="form-input-group-component">
                  <input class="input-box wpcf7-form-control wpcf7-textarea form-control" name="City" id="City" type="text" placeholder="<?php _e($applyJobFormFields['City']->display_name) ?>*" required>
                </div>
              <?php
              endif;
              if (isset($applyJobFormFields['Country'])) :
              ?>
                <div class="form-input-group-component">
                  <input class="input-box wpcf7-form-control wpcf7-textarea form-control" name="Country" id="Country" type="text" placeholder="<?php _e($applyJobFormFields['Country']->display_name) ?>*" required>
                </div>
              <?php
              endif;
              if (isset($applyJobFormFields['Position'])) :
              ?>
                <div class="form-input-group-component">
                  <input class="input-box wpcf7-form-control wpcf7-textarea form-control" name="Position" id="Position" type="text" placeholder="<?php _e($applyJobFormFields['Position']->display_name) ?>*" required>
                </div>
              <?php endif; ?>
            </div>

            <?php if (isset($applyJobFormFields['ApplicantComments'])) : ?>
              <div class="form-input-group">
                <div class="form-group" style="margin: 0;">
                  <span class="wpcf7-form-control-wrap your-message">
                    <textarea id="Comment" placeholder="<?php _e($applyJobFormFields['ApplicantComments']->display_name) ?>" name="your-message" cols="64" rows="1" class="wpcf7-form-control wpcf7-textarea form-control" aria-invalid="false"></textarea>
                  </span>
                </div>
              </div>
            <?php endif; ?>

            <?php if (isset($applyJobFormFields['CVFile1'])) : ?>
              <div class="upload-cv-drop-section">
                <span>Drop your CV here <span class="required">*</span></span>
                <div class="jd-selected-cv-names"></div>
                <input name="CVFile1" id="CVFile1" type="file" required>
              </div>
            <?php endif; ?>

            <?php if (isset($applyJobFormFields['AgreeTermsAndConditions'])) : ?>
              <div class="agree-tnc-ig" style="margin-top:10px;margin-bottom: 10px;">
                <input type="checkbox" name="agree-tnc" id="agree-tnc" class="styled-checkbox" required />
                <label class="checkLabel" for="agree-tnc">
                  I agree with the <a href="#"><?php _e($applyJobFormFields['AgreeTermsAndConditions']->display_name) ?></a>
                </label>
              </div>
            <?php endif; ?>

            <div class="submit-button">
              <button id="apply-now-submit-btn" type="submit" class="button" name="submit" value="Apply Now">Apply Now</button>
            </div>
          </form>
        </div>
      </div>

      <?php if (isset($applyJobFormFields['AgreeTermsAndConditions'])) : ?>
        <script>
          jQuery(document).ready(() => {
            jQuery('#agree-tnc').change((e) => {
              jQuery('#apply-now-submit-btn').prop('disabled', jQuery('#agree-tnc').prop('checked') ? false : true);
            });
            jQuery('#apply-now-submit-btn').prop('disabled', jQuery('#agree-tnc').prop('checked') ? false : true);
          });
        </script>
      <?php endif; ?>

    </div>
  </div>

  <!--  -->
  <div class="job-detail-header v1"style="background:#F5F7FE!important; padding:70px 0!important">
    <div class="container">
      <div class="row flex-middle-sm">
        <div class="col-md-8 col-sm-7 col-xs-12">
          <div class="flex-middle-sm">
            <div class="employer-logo">

              <img width="100" height="100" src="<?php echo plugin_dir_url(dirname(dirname(__FILE__))) . 'assets/images/job-logo.png'; ?>" class="attachment-thumbnail size-thumbnail wp-post-image" alt="">
            </div>
            <div class="info-detail-job">
              <div class="title-wrapper flex-middle-sm">
                <h1 class="job-detail-title" style="color:#05264E;"><?php echo $res_de->JobTitle; ?></h1>
                <!--<span class="featured" data-toggle="tooltip" title="" data-original-title="featured"><i class="flaticon-tick"></i></span>-->
              </div>
              <div class="job-metas-detail">
                <div class="category-job">
                  <div class="job-category with-icon" style="color:#66789C; ">
                    <i class="flaticon-briefcase-1"></i>
                    <?php echo $JobType; ?>
                  </div>
                </div>
                <div class="job-location" style="color:#66789C; ">
                  <i class="flaticon-location"></i>
             <?php echo $res_de->Region2; ?>
                </div>
                <div class="job-deadline with-icon" style="color:#66789C; "><i class="flaticon-wall-clock"></i> <?php echo date_i18n("d-m-Y", strtotime($res_de->GoogleJob->validThrough)); ?></div>
                <!--<div class="job-salary with-icon"><i class="flaticon-money-1"></i> <span class="suffix">$</span><span class="price-text"><?php echo $res_de->GoogleJob->baseSalary; ?> </span></div>-->
              </div>
              <div class="job-metas-detail-bottom">
                <div class="job-type with-title">
                </div>
                <!-- <span class="urgent">Urgent</span> -->
              </div>
            </div>
          </div>
        </div>
        <div class="job-detail-buttons col-md-4 col-sm-5 col-xs-12">
          <div class="action">

            <!--<div class="deadline-time">Application ends: <strong><?php echo date_i18n("d-m-y", strtotime($res_de->GoogleJob->validThrough));  ?></strong></div>-->
            <div class="jd-action-buttons">
              <a href="#job-apply-internal-without-login-form-wrapper-4540" class="btn btn-apply btn-apply-job-internal-without-login filled jd-job-apply-now">Apply Now<i class="next flaticon-right-arrow"></i></a>
              <button id="jd-share-button-desktop" data-share-position="middleLeft">
              </button>
              <button id="jd-share-button-mobile" data-share-position="topCenter">
              </button>
            </div>

            <script src="<?php echo plugin_dir_url(dirname(dirname(__FILE__))) ?>/assets/js/needshare.min.js"></script>
            <script>
              new needShareDropdown(document.getElementById('jd-share-button-desktop'));
              new needShareDropdown(document.getElementById('jd-share-button-mobile'));
            </script>


            <div id="job-apply-internal-without-login-form-wrapper-4540" class="job-apply-email-form-wrapper mfp-hide">
              <div class="inner">
                <h2 class="widget-title">
                  <span>Apply for this job</span>
                </h2>
                <div class="register-form-wrapper">
                  <div class="container-form">
                    <form action="//apusthemes.com/wp-demo/superio-new/job/junior-graphic-designer-web/" class="cmb-form" method="post" id="_candidate_register_fields_apply" enctype="multipart/form-data" encoding="multipart/form-data">
                      <input type="hidden" name="wp_job_board_pro_register_apply_candidate_form" value="wp_job_board_pro_register_apply_candidate_form"><input type="hidden" name="job_id" value="4540"><input type="hidden" name="object_id" value="4540">
                      <!-- Begin CMB2 Fields -->
                      <input type="hidden" id="nonce_CMB2php_candidate_register_fields" name="nonce_CMB2php_candidate_register_fields" value="e34bd320e9">
                      <div class="cmb2-wrap form-table">
                        <div id="cmb2-metabox-_candidate_register_fields" class="cmb2-metabox cmb-field-list">
                          <div class="cmb-row cmb-type-text cmb2-id--candidate-email table-layout" data-fieldtype="text">
                            <div class="cmb-th">Email <span class="required">*</span></div>
                            <div class="cmb-td">
                              <input type="text" class="regular-text" name="_candidate_email" id="_candidate_email" value="" data-hash="5d52tsq4k6r0" placeholder="Email">
                            </div>
                          </div>
                          <div class="cmb-row cmb-type-hide-show-password cmb2-id--candidate-password" data-fieldtype="hide_show_password">
                            <div class="cmb-th">Password <span class="required">*</span></div>
                            <div class="cmb-td">
                              <span id="show_hide_password">
                                <input type="password" class="regular-text" name="_candidate_password" id="hide_show_password" value="" data-lpignore="1" autocomplete="off" data-hash="22je8icbor60" placeholder="Password"> <a id="toggle-password" name="toggle-password" title="Show"><span class="dashicons dashicons-hidden"></span></a>
                              </span>
                            </div>
                          </div>
                          <div class="cmb-row cmb-type-hide-show-password cmb2-id--candidate-confirmpassword" data-fieldtype="hide_show_password">
                            <div class="cmb-th">Confirm Password <span class="required">*</span></div>
                            <div class="cmb-td">
                              <span id="show_hide_password">
                                <input type="password" class="regular-text" name="_candidate_confirmpassword" id="hide_show_password" value="" data-lpignore="1" autocomplete="off" data-hash="2mtknu85a3fg" placeholder="Confirm Password"> <a id="toggle-password" name="toggle-password" title="Show"><span class="dashicons dashicons-hidden"></span></a>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <input type="hidden" class="cmb2-hidden" name="post_type" id="post_type" value="candidate" data-hash="2khp2m90olu0"><input type="hidden" class="cmb2-hidden" name="post_type" id="post_type" value="candidate" data-hash="2khp2m90olu0">
                      <!-- End CMB2 Fields -->
                      <div class="form-group">
                        <label for="register-terms-and-conditions">
                          <input type="checkbox" name="terms_and_conditions" value="on" id="register-terms-and-conditions" required="">
                          You accept our <a href="https://apusthemes.com/wp-demo/superio-new/terms/">Terms and Conditions and Privacy Policy</a>
                        </label>
                      </div>
                      <input type="submit" name="submit-cmb-register-apply-candidate" value="Apply now" class="button-primary">
                    </form>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  <!--  -->
  <div class="job-content-area container">
    <!-- Main content -->
    <div class="row content-job-detail">
      <div class="list-content-job col-xs-12 col-md-8">
        <!-- job description -->
        <div class="job-detail-description">
          <h3 class="title" style="color:#05264E;">Job Description</h3>
          <div style="color:#66789C;"><?php echo $res_de->GoogleJob->description; ?></p>
          </div>
        </div>

      </div>
      <div class="col-xs-12 col-md-4 sidebar-job">
        <aside class="widget widget_apus_job_info has-content" style="background:#F5F7FE">
          <h2 class="widget-title" style="color:#05264E;"><span>Job Overview</span></h2>
          <div class="job-detail-detail">
            <ul class="list">
              <li>
                <div class="icon">
                  <i class="flaticon-calendar"></i>
                </div>
                <div class="details">
                  <div class="text" style="color:#05264E;">Date Posted</div>
                  <div class="value"><?php echo date_i18n("d-m-Y", strtotime($res_de->GoogleJob->datePosted)); ?></div>
                </div>
              </li>
              <li>
                <div class="icon">
                  <i class="flaticon-location"></i>
                </div>
                <div class="details">
                  <div class="text" style="color:#05264E;">Location</div>
                  <div class="value">
                    <div class="job-location" style="color:#66789C;">
                     <?php echo $res_de->Region2; ?>

                    </div>
                  </div>
                </div>
              </li>
              <?php
              if ($res_de->GoogleJob->baseSalary == true) {
              ?>
                <li>
                  <div class="icon">
                    <i class="flaticon-money-1"></i>
                  </div>
                  <div class="details">
                    <div class="text" style="color:#05264E;">Offered Salary:</div>
                    <div class="value" style="color:#66789C;"><span class="suffix">$</span><span class="price-text"><?php echo $res_de->GoogleJob->baseSalary; ?></span> </div>
                  </div>
                </li>
              <?php
              }
              ?>
              <li>
                <div class="icon">
                  <i class="flaticon-waiting"></i>
                </div>
                <div class="details">
                  <div class="text" style="color:#05264E;">Expiration date</div>
                  <div class="value" style="color:#66789C;">
                    <?php echo date_i18n("d-m-Y", strtotime($res_de->GoogleJob->validThrough)); ?>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </aside>

      </div>
    </div>
  </div>
<?php

}

get_footer();


?>
