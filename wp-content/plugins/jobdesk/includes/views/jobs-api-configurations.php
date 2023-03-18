<?php

use JobDesk\Classes\Database;

# to show a cancellable admin notice
function notify(string $msg, string $type, bool $is_dismissible = true)
{
  $dismissible = ($is_dismissible == true) ? "is-dismissible" : '';
  $notice_board = "<div style='margin-left: 2px;margin-right: 10px;' class='notice notice-$type $dismissible'>" .
    "<p>$msg</p>" .
    "</div>";
  echo $notice_board;
}

if (isset($_POST['save-api-setup'])) {

  $client_key = trim($_POST['client_key']);
  $all_jobs_endpoint = trim($_POST['all_jobs_endpoint']);
  $top_jobs_endpoint = trim($_POST['top_jobs_endpoint']);
  $single_job_endpoint = trim($_POST['single_job_endpoint']);
  $apply_job_endpoint = trim($_POST['apply_job_endpoint']);
  $code_table_endpoint = trim($_POST['code_table_endpoint']);
  $parse_cv_endpoint = trim($_POST['parse_cv_endpoint']);
  $parse_cv_token = trim($_POST['parse_cv_token']);
  $parse_cv_appclientid = trim($_POST['parse_cv_appclientid']);

  $updated = Database::updateJobsApiConfigurations(
    $client_key,
    $all_jobs_endpoint,
    $single_job_endpoint,
    $top_jobs_endpoint,
    $apply_job_endpoint,
    $code_table_endpoint,
    $parse_cv_token,
    $parse_cv_appclientid,
    $parse_cv_endpoint
  );

  notify(
    ($updated == 'success') ? "API setup completed successfully!" : "Failed to setup API!",
    ($updated == 'success') ? "success" : "error"
  );
}

$jobsApiConfigurations = Database::getJobsApiConfigurations();

?>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<h1 class="nhr-dss-dash-title">Jobs API configurations</h1>
<hr>

<form method="post" class="dss-setting-form column" id="jobdesk-api-setup-form">

  <label for="client_key">Client key</label>
  <input type="text" class="mb-2" name="client_key" id="client_key" placeholder="523BE189-EG81-4D0F-8FBA-F3BBB35BD2B9" value="<?php echo (isset($_POST['client_key']) ? trim($_POST['client_key']) : $jobsApiConfigurations->client_key); ?>" required />

  <label for="all_jobs_endpoint">All jobs endoint</label>
  <input type="url" class="mb-2" name="all_jobs_endpoint" id="all_jobs_endpoint" value="<?php echo (isset($_POST['all_jobs_endpoint']) ? trim($_POST['all_jobs_endpoint']) : $jobsApiConfigurations->all_jobs_endpoint); ?>" required />

  <label for="top_jobs_endpoint">Top jobs endpoint</label>
  <input type="url" class="mb-2" name="top_jobs_endpoint" id="top_jobs_endpoint" value="<?php echo (isset($_POST['top_jobs_endpoint']) ? trim($_POST['top_jobs_endpoint']) : $jobsApiConfigurations->top_jobs_endpoint); ?>" required />

  <label for="single_job_endpoint">Single job endpoint</label>
  <input type="url" class="mb-2" name="single_job_endpoint" id="single_job_endpoint" value="<?php echo (isset($_POST['single_job_endpoint']) ? trim($_POST['single_job_endpoint']) : $jobsApiConfigurations->single_job_endpoint); ?>" required />

  <label for="apply_job_endpoint">Apply job endpoint</label>
  <input type="url" class="mb-2" name="apply_job_endpoint" id="apply_job_endpoint" value="<?php echo (isset($_POST['apply_job_endpoint']) ? trim($_POST['apply_job_endpoint']) : $jobsApiConfigurations->apply_job_endpoint); ?>" required />

  <label for="code_table_endpoint">Code table endpoint</label>
  <input type="url" class="mb-2" name="code_table_endpoint" id="code_table_endpoint" value="<?php echo (isset($_POST['code_table_endpoint']) ? trim($_POST['code_table_endpoint']) : $jobsApiConfigurations->code_table_endpoint); ?>" required />

  <div class="inline-inputs">
    <button type="submit" class="btn btn-primary" id="save-api-setup-btn" name="save-api-setup">Save</button>
    <button type="button" class="btn btn-danger" id="reset-api-setup-btn">Reset</button>
  </div>
</form>
