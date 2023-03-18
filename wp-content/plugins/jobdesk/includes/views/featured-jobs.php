<div class="jd-featured-jobs-box" >
    <div class="row" style="display: flex;flex-wrap: wrap;">
        <?php
        if ( $featured_jobs ) {
            $count = 0;
            foreach ( $featured_jobs as $row ) {
                $count ++;
                if($count == 7) {
                   break;             
                }
                ?>
<a href="/jobs?jobdesk_ref_code=<?php echo esc_attr( $row->RefCode ); ?>&job_type=<?php echo $row->JobType?>">
<div class="col-md-4 col-sm-6 col-xs-12 list-item  md-clearfix lg-clearfix sm-clearfix" >
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
               <h2 class="job-title" style="color:#05264E"><?php echo esc_html( $row->JobTitle );?></h2>
            </div>
             <div class="job-location" style="color:#66789C;margin:10px 0">
                  <i class="flaticon-location"></i>
                  <?php echo esc_html( $row->RegionCity );?>                    
               </div>
            <div class="job-metas">
               <div class="category-job" style="color:#66789C;">
                  <div class="job-category with-icon">
                     <i class="flaticon-briefcase-1"></i>
                     <?php echo esc_html( $row->JobType );?>
                  </div>
               </div>
               <div class="category-job" style="color:#66789C;">
                  <i class="flaticon-wall-clock"></i>
                  <?php echo date_i18n( "d-m-Y", strtotime( $row->Published) ); ?>                   
               </div>
            </div>
         </div>
      </div>
      <div class="job-metas-bottom">
         <div class="job-type with-title">
            <p class="type-job" style="color:#66789C; " ><?php echo esc_html( $row->ContractType );?></p>
         </div>
         <!-- <span class="urgent"><?php echo date_i18n( "d-m-Y", strtotime( $row->Published) ); ?> </span> -->
         <?php if ($row->PositionType == true)  { ?>
         <span class="type-job" style="color:#66789C; ">
             <!-- style="background-color:#cce6ff;color:#0077e6" -->
         <?php echo esc_html( $row->PositionType) ; ?> </span>
         <?php } ?>
      </div>
    <button class=view-jobs-btn>
      View Details</button>
   </article>
   
     </a>
</div>
                
                <?php
                
            }
        }
        ?>
         
    </div>
</div>