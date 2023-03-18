<style>
   span.select2-selection__clear {
      display: none !important;
   }
</style>
<div class="jd-featured-jobs-box">
   <div class="row" >
<!-- ......................... -->
<div class="elementor-container elementor-column-gap-extended" >
   <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-158bd5d" data-id="158bd5d" data-element_type="column" >
      <div class="elementor-widget-wrap elementor-element-populated" >
         <div class="elementor-element elementor-element-2c63080 elementor-widget elementor-widget-apus_element_job_board_pro_search_form" data-id="2c63080" data-element_type="widget" data-widget_type="apus_element_job_board_pro_search_form.default">
<div class="elementor-widget-container" >
               <!--  -->
<div class="widget-job-search-form" >
<form action="/jobs/" id="nhr-job-searching-form" class="form-search filter-listing-form-wrapper" method="GET" style="box-shadow:0px 10px 20px rgba(102, 120, 156, 0.15); border-radius: 50px!important;
">
      <div class="filter-listing-form horizontal" style="background: #FFFFFF; border:none">
         <div class="main-inner clearfix">
            <div class="content-main-inner">
               <div class="row">
                  <div class="col-xs-12 col-md-2 has-border">
                     <div class="form-group form-group-title  ">
                        <div class="form-group-inner inner has-icon">
                           <i class="flaticon-magnifiying-glass"></i>
                           <?php $Jobtitle = isset($_GET['filter-title']) ? trim($_GET['filter-title']) : ''; ?>
                           <input type="text" name="filter-title" class="form-control " value="<?php echo $Jobtitle; ?>"id="nhr-job-searching-form-title"  placeholder="Job title...">
                        
                        </div>
                     </div>
                     <!-- /.form-group -->
                  </div>
                  <div class="col-xs-12 col-md-2 has-border">
                     <div class="form-group form-group-location   tax-select-field">
                        <div class="form-group-inner inner has-icon">
                           <i class="flaticon-location"></i>
                           <?php $FilterLocation = isset($_GET['filter-location']) ? trim($_GET['filter-location']) : ''; ?>
                                        <input type="text" name="filter-location" class="form-control" value="<?php echo $FilterLocation; ?>" id="nhr-job-searching-form-location" placeholder="Region">
                        </div>
                     </div>
                     <!-- /.form-group -->
                  </div>
                  <div class="col-xs-12 col-md-3 has-border">
                     <div class="form-group form-group-category   tax-select-field">
                        <div class="form-group-inner inner has-icon">
                           <i class="flaticon-briefcase-1"></i>
                           <select name="filter-contract-type" id="nhr-job-searching-form-contract-type" class="form-control pac-target-input">
                                       <option value="">
                                        Select Contract Type
                                       </option>
                                       <?php
                                       $FilterContractType = isset($_GET['filter-contract-type']) ? trim($_GET['filter-contract-type']) : '';
                                       foreach (get_contract_types() as $ContractType) :
                                          if (empty($ContractType->Value)) {
                                             continue;
                                          }
                                       ?>
                                          <option <?php echo (($FilterContractType == $ContractType->Code) ? 'selected' : ''); ?> value="<?php echo $ContractType->Code; ?>">
                                             <?php echo $ContractType->Value; ?>
                                          </option>
                                       <?php endforeach ?>
                                    </select>
                        </div>
                     </div>
                     <!-- /.form-group -->
                  </div>
                  <!-- new -->
                  <div class="col-xs-12 col-md-3 has-border">
                     <div class="form-group form-group-category   tax-select-field">
                        <div class="form-group-inner inner has-icon">
                           <i class="flaticon-briefcase-1"></i>
                           <select name="filter-sector" id="nhr-job-searching-form-sector" class="form-control pac-target-input">
                                       <option value="">
                                       Select Sector
                                       </option>
                                       <?php
                                       $FilterSector = isset($_GET['filter-sector']) ? trim($_GET['filter-sector']) : '';
                                       foreach (get_sectors() as $Sector) :
                                          if (empty($Sector->Value)) {
                                             continue;
                                          }
                                       ?>
                                          <option <?php echo (($FilterSector == $Sector->Code) ? 'selected' : ''); ?> value="<?php echo $Sector->Code; ?>">
                                             <?php echo $Sector->Value; ?>
                                          </option>
                                       <?php endforeach ?>
                                       </select>
                        </div>
                     </div>
                     <!-- /.form-group -->
                  </div>
                  <!-- ns -->
                  <div class="wrapper-submit flex-middle col-xs-12 col-md-2">
                     <button class="btn-submit btn btn-theme btn-inverse" type="submit" id="nhr-job-searching-form-submit-btn">
                     Search                                   
                   </button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </form>
</div>
<!-- ..................... -->
 </div>
</div>
</div>
</div>
</div>
<!--  -->
<?php

      $page_no = isset($_GET['page_no']) ? intval($_GET['page_no']) : 1;
      $total_elements = count($featured_jobs);

      function paginationUrlBuilder($pn, $dont_modify = false)
      {
         $custom_get_array = [];
         foreach ($_GET as $k => $v) {
            if ($k == 'page_no') {
               $custom_get_array[$k] = $dont_modify ? $pn : $v + $pn;
            } else {
               $custom_get_array[$k] = $v;
            }
         }
         if (!isset($custom_get_array['page_no'])) {
            $custom_get_array['page_no'] = $dont_modify ? $pn : 1 + $pn;
         }
         if ($custom_get_array['page_no'] == 0) {
            $custom_get_array['page_no'] = 1;
         }
         $query = build_query($custom_get_array);
         return $query;
      }

      if ($featured_jobs && $total_elements > 0) :

         $start_element = ($page_no - 1) * 10;
         $end_element = ($total_elements < ($page_no * 10)) ? $total_elements : ($page_no * 10);

      ?>

<main id="main" class="site-main layout-type-default" role="main" style="margin:20px">
      <div class="jobs-listing-wrapper main-items-wrapper" data-display_mode="list">
       <div class="jobs-alert-ordering-wrapper">
         <div class="results-count" style="font-size:20px; color: #05264E;">
            Showing <span class="first"><?php echo $start_element + 1; ?></span> – <span class="last"><?php echo $end_element; ?></span> of <?php echo $total_elements; ?> results
         </div>
       </div>
      
<div class="jobs-wrapper items-wrapper">

   <div class="row items-wrapper-list" style="display: flex;flex-wrap: wrap;">
     
     <?php for ($y = $start_element; $y < $end_element; $y++) { ?>
     
      <div class="item-job col-sm-6 col-md-4 col-xs-12 lg-clearfix md-clearfix sm-clearfix"> 
          <a href="?www=<?php echo $featured_jobs[$y]->RefCode; ?>&JobType=<?php echo $featured_jobs[$y]->JobType; ?>">  
         <article id="post-4540" class="map-item layout-job job-list v2 post-4540 job_listing type-job_listing status-publish hentry job_listing_type-full-time job_listing_category-design job_listing_category-development job_listing_location-new-york job_listing_tag-app job_listing_tag-jobs job_listing_tag-superio job_listing_tag-support is-featured is-urgent" data-latitude="40.69865478041131" data-longitude="-73.99426069264436" data-img="" style="height:300px;border-style: solid;background:#F5F7FE ;
         border: 1px solid rgba(60, 101, 245, 0.2); box-shadow: 0px 10px 20px rgba(102, 120, 156, 0.15);
        " >
                                   <!-- #99b3e6;  -->
          <div class="clearfix">
              <div class="employer-logo">       
                  <img loading="lazy" width="100" height="100" src="<?php echo plugin_dir_url(dirname(dirname(__FILE__))) . 'assets/images/job-logo.png'; ?>" class="attachment-thumbnail size-thumbnail wp-post-image" alt="">     
               </div>
               <div class="job-list-content">
                     <div class="title-wrapper flex-middle-sm">
                        <h2 class="job-title" style="color: #05264E;"><?php echo $featured_jobs[$y]->JobTitle; ?></h2>
                     </div>
                     <div class="job-location" style="margin:10px 0;  color:#66789C ">
                        <i class="flaticon-location"></i>
                        <?php echo $featured_jobs[$y]->RegionCity ;?>                    
                     </div>
                     <div class="job-metas" style="color:#66789C; ">
                        <div class="category-job">
                           <div class="job-category with-icon">
                              <i class="flaticon-briefcase-1"></i>
                              <?php echo $featured_jobs[$y]->JobType;?>
                           </div>
                        </div>
                        <div class="category-job">
                            <i class="flaticon-wall-clock"></i>
                            <?php echo date_i18n( "d-m-Y", strtotime( $featured_jobs[$y]->Published) ); ?>                   
                        </div>
                     </div>
                    </div>
                 </div>
                  <div class="job-metas-bottom" >
                     <div class="job-type with-title">
                        <p class="type-job"style="color:#66789C; " ><?php echo $featured_jobs[$y]->ContractType;?></p>
                     </div>
                  <!-- < class="urgent"><?php echo date_i18n( "d-m-Y", strtotime( $row->Published) ); ?> </ span> -->
                      <?php if ($featured_jobs[$y]->PositionType == true)  { ?>
                     <span class="type-job" style="color:#66789C; ">
                      <!-- style="background-color:#cce6ff;color:#0077e6" -->
                      <?php echo $featured_jobs[$y]->PositionType; ?> </span>
                      <?php } ?>
                  </div>
                   <button class=view-jobs-btn>
                    View Details</button>
         </article>

    </a>
                       
      </div>
                      
        <?php } ?>
   </div>       
</div>
</div>
</main>

            <?php if (($total_elements / 10) > 1) : ?>
               <div class="jobs-pagination-wrapper main-pagination-wrapper">
                  <ul class="pagination">

                     <?php if ($page_no != 1) : ?>
                        <li><a class="next page-numbers" href="?<?php echo paginationUrlBuilder(-1); ?>"><i class="ti-arrow-left"></i></a></li>
                     <?php endif; ?>

                     <?php for ($x = 1; $x <= $total_elements / 10 + 1; $x++) { ?>
                        <li>
                           <a class="page-numbers <?php echo ($page_no === $x ? 'current' : ''); ?>" href="?<?php echo paginationUrlBuilder($x, true); ?>">
                              <?php echo $x; ?>
                           </a>
                        </li>
                     <?php }

                     if ($page_no != floor($total_elements / 10) + 1) { ?>
                        <li>
                           <a class="next page-numbers" href="?<?php echo paginationUrlBuilder(1); ?>">
                              <i class="ti-arrow-right"></i>
                           </a>
                        </li>
                     <?php } ?>
                  </ul>
               </div>
            <?php endif; ?>

         </div>
      <?php else : ?>
         <div id="main-content" class="col-md-8 inner">
            <h3 class="text-center w-100 text-danger px-3 py-5 bg-primary h3 d-block" style="margin: 0;background: transparent;color: firebrick;width: 100%;height: 100%;padding: 50px;font-weight: normal;opacity: 1;">
               No job found!
            </h3>
         </div>
      <?php endif; ?>

   </div>
</div>
</div>

<script>
   let nhrJobSearchingForm = document.querySelector('#nhr-job-searching-form')
   let nhrJobSearchingFormSubmitBtn = nhrJobSearchingForm.querySelector('#nhr-job-searching-form-submit-btn')
   nhrJobSearchingFormSubmitBtn.addEventListener('click', (e) => {
      e.preventDefault()
      nhrJobSearchingForm.submit()
   })
</script>