<?php

use JobDesk\Classes\Database;

$jac = Database::getJobsApiConfigurations();
$applyJobFormFields = Database::getApplyJobFormFields();

echo "<script>const applyJobFormFields = JSON.parse(`" . json_encode($applyJobFormFields) . "`);</script>";

require_once plugin_dir_path(__FILE__) . "language-codes.php";

?>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<h1 class="nhr-dss-dash-title">Apply Form</h1>
<hr>

<form method="post" class="dss-setting-form" id="jobdesk-apply-job-form-fields-form">

  <div class="jd-dss-form-side left">

    <?php foreach ($applyJobFormFields as $field) : ?>

      <label for="<?php echo $field->field_name . 'Label' ?>">
        <?php
        $arr = preg_split('/(?=[A-Z])/', $field->field_name);
        if (strlen($field->field_name) > 2) {
          $label = $arr[1] . (count($arr) > 2 ? ' ' . $arr[2] : '');
        } else {
          echo ($field->field_name == "CVFile1" ? "Attachment" : $field->field_name);
        }
        echo $label;
        ?>
      </label>

      <div class="jd-apply-job-form-field">
        <input class="jd-apply-job-form-field-name" type="checkbox" name="<?php echo $field->field_name ?>" id="<?php echo $field->field_name ?>" value="<?php echo $field->field_name ?>" <?php echo ($field->enabled == 'true' ? 'checked' : '') ?> />
        <input placeholder="<?php echo $field->field_name ?>" class="jd-apply-job-form-field-label" type="text" name="<?php echo $field->field_name . 'Label' ?>" id="<?php echo $field->field_name . 'Label' ?>" value="<?php echo $field->display_name ?>" <?php echo ($field->enabled == 'true' ? 'required' : 'disabled') ?> />
      </div>

    <?php endforeach ?>

  </div>

  <div class="jd-dss-form-side right">
    <label for="parse_cv_endpoint">Parse CV endpoint</label>
    <input type="url" class="mb-2" name="parse_cv_endpoint" id="parse_cv_endpoint" value="<?php echo (isset($_POST['parse_cv_endpoint']) ? trim($_POST['parse_cv_endpoint']) : $jac->parse_cv_endpoint); ?>" required />

    <label for="parse_cv_token">Parse CV `token`</label>
    <input type="text" class="mb-2" name="parse_cv_token" id="parse_cv_token" value="<?php echo (isset($_POST['parse_cv_token']) ? trim($_POST['parse_cv_token']) : $jac->parse_cv_token); ?>" required />

    <label for="parse_cv_appclientid">Parse CV `appclientid`</label>
    <input type="text" class="mb-2" name="parse_cv_appclientid" id="parse_cv_appclientid" value="<?php echo (isset($_POST['parse_cv_appclientid']) ? trim($_POST['parse_cv_appclientid']) : $jac->parse_cv_appclientid); ?>" required />

    <label for="parse_cv_language">Language Code</label>
    <select class="mb-2" name="parse_cv_language" id="parse_cv_language">
      <?php foreach ($language_codes as $code => $country) : ?>
        <option <?php echo (($jac->parse_cv_language && $code === $jac->parse_cv_language) || $code === "en" ? "selected" : "") ?> value="<?php echo $code ?>">
          <?php echo $country . "  ($code)" ?>
        </option>
      <?php endforeach ?>
    </select>

    <button type="submit" class="btn btn-primary" id="save-apply-job-form-fields-btn">Save</button>
  </div>

</form>

<script>
  jQuery(document).ready(() => {

    jQuery('.jd-apply-job-form-field input[type="checkbox"]').change(({
      target
    }) => {
      if (!target.checked) {
        jQuery(target).next("input[type='text']").attr('disabled', true).removeAttr('required')
      } else {
        jQuery(target).next("input[type='text']").removeAttr('disabled').attr('required', true)
      }
    })

    jQuery("#jobdesk-apply-job-form-fields-form").submit((event) => {

      event.preventDefault()

      jQuery("#save-apply-job-form-fields-btn").text("Saving...").attr("disabled", true)

      let fields = []
      let parse_cv_data = {
        token: document.querySelector("#parse_cv_token").value,
        appclientid: document.querySelector("#parse_cv_appclientid").value,
        endpoint: document.querySelector("#parse_cv_endpoint").value,
        language: document.querySelector("#parse_cv_language").value
      }

      jQuery("#jobdesk-apply-job-form-fields-form .jd-apply-job-form-field").each((_i, fieldContainer) => {
        let field_name = fieldContainer.querySelector(".jd-apply-job-form-field-name")
        let display_name = fieldContainer.querySelector(".jd-apply-job-form-field-label")
        fields.push({
          field_name: field_name.value,
          display_name: display_name.value,
          enabled: field_name.checked ? true : false
        })
      })

      jQuery.ajax({
        type: "post",
        url: ajaxurl,
        data: {
          action: "jd_ajax_handler_function",
          save_apply_job_form_fields: true,
          fields,
          parse_cv_data
        },
        success(data) {
          data = JSON.parse(data)
          if (data.success) {
            swal("Success", data.message, "success")
          } else {
            swal("Error!", data.message, "error")
          }
          jQuery("#save-apply-job-form-fields-btn").text("Save").removeAttr("disabled")
        }
      })

    })

  })
</script>
