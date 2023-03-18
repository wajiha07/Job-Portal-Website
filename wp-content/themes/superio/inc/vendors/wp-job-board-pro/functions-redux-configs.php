<?php

function superio_wp_job_board_pro_redux_config($sections, $sidebars, $columns) {
    
    $sections[] = array(
        'icon' => 'el el-pencil',
        'title' => esc_html__('Jobs Settings', 'superio'),
        'fields' => array(
            array(
                'id' => 'show_job_breadcrumbs',
                'type' => 'switch',
                'title' => esc_html__('Breadcrumbs', 'superio'),
                'default' => 1
            ),
            array(
                'title' => esc_html__('Breadcrumbs Background Color', 'superio'),
                'subtitle' => '<em>'.esc_html__('The breadcrumbs background color of the site.', 'superio').'</em>',
                'id' => 'job_breadcrumb_color',
                'type' => 'color',
                'transparent' => false,
            ),
            array(
                'id' => 'job_breadcrumb_image',
                'type' => 'media',
                'title' => esc_html__('Breadcrumbs Background', 'superio'),
                'subtitle' => esc_html__('Upload a .jpg or .png image that will be your breadcrumbs.', 'superio'),
            ),
            array(
                'id' => 'jobs_general_settings',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3> '.esc_html__('Other Settings', 'superio').'</h3>',
            ),
            array(
                'id' => 'job_show_full_phone',
                'type' => 'switch',
                'title' => esc_html__('Show Full Phone Number', 'superio'),
                'default' => 0,
            ),
        )
    );
    // Archive settings
    $sections[] = array(
        'title' => esc_html__('Job Archives', 'superio'),
        'subsection' => true,
        'fields' => array(
            array(
                'id' => 'jobs_general_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('General Setting', 'superio').'</h3>',
            ),
            array(
                'id' => 'jobs_fullwidth',
                'type' => 'switch',
                'title' => esc_html__('Is Full Width?', 'superio'),
                'default' => false
            ),
            array(
                'id' => 'jobs_layout_type',
                'type' => 'select',
                'title' => esc_html__('Jobs Layout', 'superio'),
                'subtitle' => esc_html__('Choose a default layout archive job.', 'superio'),
                'options' => array(
                    'default' => esc_html__('Default', 'superio'),
                    'fullwidth' => esc_html__('Full Width', 'superio'),
                    'half-map' => esc_html__('Half Map', 'superio'),
                    'top-map' => esc_html__('Top Map', 'superio'),
                ),
                'default' => 'default',
            ),
            array(
                'id' => 'jobs_layout_sidebar',
                'type' => 'image_select',
                'compiler' => true,
                'title' => esc_html__('Sidebar Layout', 'superio'),
                'subtitle' => esc_html__('Select a sidebar layout', 'superio'),
                'options' => array(
                    'main' => array(
                        'title' => esc_html__('Main Content', 'superio'),
                        'alt' => esc_html__('Main Content', 'superio'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen1.png'
                    ),
                    'left-main' => array(
                        'title' => esc_html__('Left - Main Sidebar', 'superio'),
                        'alt' => esc_html__('Left - Main Sidebar', 'superio'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen2.png'
                    ),
                    'main-right' => array(
                        'title' => esc_html__('Main - Right Sidebar', 'superio'),
                        'alt' => esc_html__('Main - Right Sidebar', 'superio'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen3.png'
                    ),
                ),
                'default' => 'main-right',
                'required' => array('jobs_layout_type', '=', array('default', 'top-map')),
            ),

            array(
                'id' => 'jobs_show_filter_top',
                'type' => 'switch',
                'title' => esc_html__('Show Filter Top', 'superio'),
                'default' => false,
                'required' => array('jobs_layout_type', '=', array('default', 'top-map')),
            ),

            array(
                'id' => 'jobs_filter_top_sidebar',
                'type' => 'select',
                'title' => esc_html__('Jobs Filter Top Sidebar', 'superio'),
                'subtitle' => esc_html__('Choose a sidebar for job filter sidebar.', 'superio'),
                'options' => array(
                    'jobs-filter-top-sidebar' => esc_html__('Jobs Filter Top Sidebar', 'superio'),
                    'jobs-filter-top2-sidebar' => esc_html__('Jobs Filter Top 2 Sidebar', 'superio'),
                ),
                'default' => 'jobs-filter-top-sidebar',
                'required' => array('jobs_show_filter_top', '=', true),
            ),


            array(
                'id' => 'jobs_show_offcanvas_filter',
                'type' => 'switch',
                'title' => esc_html__('Show Offcanvas Filter', 'superio'),
                'default' => false,
                'required' => array('jobs_layout_sidebar', '=', array('main')),
            ),

            array(
                'id' => 'jobs_filter_sidebar',
                'type' => 'select',
                'title' => esc_html__('Jobs Filter Sidebar', 'superio'),
                'subtitle' => esc_html__('Choose a sidebar for job filter sidebar.', 'superio'),
                'options' => array(
                    'jobs-filter-sidebar' => esc_html__('Jobs Filter Sidebar', 'superio'),
                    'jobs-filter2-sidebar' => esc_html__('Jobs Filter 2 Sidebar', 'superio'),
                ),
                'default' => 'jobs-filter-sidebar'
            ),

            array(
                'id' => 'jobs_display_mode',
                'type' => 'select',
                'title' => esc_html__('Jobs display mode', 'superio'),
                'subtitle' => esc_html__('Choose a default display mode for archive job.', 'superio'),
                'options' => array(
                    'grid' => esc_html__('Grid', 'superio'),
                    'list' => esc_html__('List', 'superio'),
                ),
                'default' => 'list'
            ),
            array(
                'id' => 'jobs_inner_list_style',
                'type' => 'select',
                'title' => esc_html__('Jobs list item style', 'superio'),
                'subtitle' => esc_html__('Choose a job list style.', 'superio'),
                'options' => array(
                    'list' => esc_html__('List Default', 'superio'),
                    'list-v1' => esc_html__('List V1', 'superio'),
                    'list-v2' => esc_html__('List V2', 'superio'),
                    'list-v3' => esc_html__('List V3', 'superio'),
                    'list-v4' => esc_html__('List V4', 'superio'),
                    'list-v5' => esc_html__('List V5', 'superio'),
                ),
                'default' => 'list',
                'required' => array('jobs_display_mode', '=', array('list'))
            ),
            array(
                'id' => 'jobs_inner_grid_style',
                'type' => 'select',
                'title' => esc_html__('Jobs grid item style', 'superio'),
                'subtitle' => esc_html__('Choose a job grid style.', 'superio'),
                'options' => array(
                    'grid' => esc_html__('Grid Default', 'superio'),
                    'grid-v1' => esc_html__('Grid V1', 'superio'),
                    'grid-v2' => esc_html__('Grid V2', 'superio'),
                ),
                'default' => 'grid',
                'required' => array('jobs_display_mode', '=', array('grid'))
            ),
            array(
                'id' => 'jobs_columns',
                'type' => 'select',
                'title' => esc_html__('Job Columns', 'superio'),
                'options' => $columns,
                'default' => 3
            ),
            array(
                'id' => 'jobs_pagination',
                'type' => 'select',
                'title' => esc_html__('Pagination Type', 'superio'),
                'options' => array(
                    'default' => esc_html__('Default', 'superio'),
                    'loadmore' => esc_html__('Load More Button', 'superio'),
                    'infinite' => esc_html__('Infinite Scrolling', 'superio'),
                ),
                'default' => 'default'
            ),
            array(
                'id' => 'job_placeholder_image',
                'type' => 'media',
                'title' => esc_html__('Placeholder Image', 'superio'),
                'subtitle' => esc_html__('Upload a .jpg or .png image that will be your placeholder.', 'superio'),
            ),

            array(
                'title' => esc_html__('Job Urgent Background Color', 'superio'),
                'subtitle' => '<em>'.esc_html__('The job urgent background color of the site.', 'superio').'</em>',
                'id' => 'job_urgent_background_color',
                'type' => 'color',
                'transparent' => false,
            ),

            array(
                'title' => esc_html__('Job Featured Background Color', 'superio'),
                'subtitle' => '<em>'.esc_html__('The job featured background color of the site.', 'superio').'</em>',
                'id' => 'job_featured_background_color',
                'type' => 'color',
                'transparent' => false,
            ),
        )
    );
    
    
    // Job Page
    $sections[] = array(
        'title' => esc_html__('Single Job', 'superio'),
        'subsection' => true,
        'fields' => array(
            array(
                'id' => 'job_general_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('General Setting', 'superio').'</h3>',
            ),
            array(
                'id' => 'job_fullwidth',
                'type' => 'switch',
                'title' => esc_html__('Is Full Width?', 'superio'),
                'default' => false
            ),
            array(
                'id' => 'job_layout_type',
                'type' => 'select',
                'title' => esc_html__('Job Layout', 'superio'),
                'subtitle' => esc_html__('Choose a default layout single job.', 'superio'),
                'options' => array(
                    'v1' => esc_html__('Version 1', 'superio'),
                    'v2' => esc_html__('Version 2', 'superio'),
                    'v3' => esc_html__('Version 3', 'superio'),
                    'v4' => esc_html__('Version 4', 'superio'),
                    'v5' => esc_html__('Version 5', 'superio'),
                ),
                'default' => 'v1',
            ),
            array(
                'id' => 'show_job_social_share',
                'type' => 'switch',
                'title' => esc_html__('Show Social Share', 'superio'),
                'default' => 1
            ),
            array(
                'id' => 'job_block_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('Job Block Setting', 'superio').'</h3>',
            ),
            array(
                'id' => 'job_releated_show',
                'type' => 'switch',
                'title' => esc_html__('Show Jobs Related', 'superio'),
                'default' => 1
            ),
            array(
                'id' => 'job_releated_number',
                'title' => esc_html__('Number of related jobs to show', 'superio'),
                'default' => 4,
                'min' => '1',
                'step' => '1',
                'max' => '50',
                'type' => 'slider',
                'required' => array('job_releated_show', '=', true)
            ),
        )
    );
	
    return $sections;
}
add_filter( 'superio_redux_framwork_configs', 'superio_wp_job_board_pro_redux_config', 10, 3 );


// employers
function superio_wp_job_board_pro_employer_redux_config($sections, $sidebars, $columns) {
    
    $sections[] = array(
        'icon' => 'el el-pencil',
        'title' => esc_html__('Employer Settings', 'superio'),
        'fields' => array(
            array(
                'id' => 'show_employer_breadcrumbs',
                'type' => 'switch',
                'title' => esc_html__('Breadcrumbs', 'superio'),
                'default' => 1
            ),
            array(
                'title' => esc_html__('Breadcrumbs Background Color', 'superio'),
                'subtitle' => '<em>'.esc_html__('The breadcrumbs background color of the site.', 'superio').'</em>',
                'id' => 'employer_breadcrumb_color',
                'type' => 'color',
                'transparent' => false,
            ),
            array(
                'id' => 'employer_breadcrumb_image',
                'type' => 'media',
                'title' => esc_html__('Breadcrumbs Background', 'superio'),
                'subtitle' => esc_html__('Upload a .jpg or .png image that will be your breadcrumbs.', 'superio'),
            ),
        )
    );
    // Archive settings
    $sections[] = array(
        'title' => esc_html__('Employer Archives', 'superio'),
        'subsection' => true,
        'fields' => array(
            array(
                'id' => 'employers_general_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('General Setting', 'superio').'</h3>',
            ),
            array(
                'id' => 'employers_fullwidth',
                'type' => 'switch',
                'title' => esc_html__('Is Full Width?', 'superio'),
                'default' => false
            ),
            array(
                'id' => 'employers_layout_type',
                'type' => 'select',
                'title' => esc_html__('Employers Layout', 'superio'),
                'subtitle' => esc_html__('Choose a default layout archive job.', 'superio'),
                'options' => array(
                    'default' => esc_html__('Default', 'superio'),
                    'half-map' => esc_html__('Half Map', 'superio'),
                    'top-map' => esc_html__('Top Map', 'superio'),
                ),
                'default' => 'default',
            ),
            array(
                'id' => 'employers_layout_sidebar',
                'type' => 'image_select',
                'compiler' => true,
                'title' => esc_html__('Sidebar Layout', 'superio'),
                'subtitle' => esc_html__('Select a sidebar layout', 'superio'),
                'options' => array(
                    'main' => array(
                        'title' => esc_html__('Main Content', 'superio'),
                        'alt' => esc_html__('Main Content', 'superio'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen1.png'
                    ),
                    'left-main' => array(
                        'title' => esc_html__('Left - Main Sidebar', 'superio'),
                        'alt' => esc_html__('Left - Main Sidebar', 'superio'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen2.png'
                    ),
                    'main-right' => array(
                        'title' => esc_html__('Main - Right Sidebar', 'superio'),
                        'alt' => esc_html__('Main - Right Sidebar', 'superio'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen3.png'
                    ),
                ),
                'default' => 'main-right',
                'required' => array('employers_layout_type', '=', array('default', 'top-map')),
            ),

            array(
                'id' => 'employers_display_mode',
                'type' => 'select',
                'title' => esc_html__('Employers display mode', 'superio'),
                'subtitle' => esc_html__('Choose a default display mode for archive employer.', 'superio'),
                'options' => array(
                    'grid' => esc_html__('Grid', 'superio'),
                    'list' => esc_html__('List', 'superio'),
                ),
                'default' => 'list'
            ),
            array(
                'id' => 'employers_inner_list_style',
                'type' => 'select',
                'title' => esc_html__('Employers list item style', 'superio'),
                'subtitle' => esc_html__('Choose a employer list style.', 'superio'),
                'options' => array(
                    'list' => esc_html__('List Default', 'superio'),
                    'list-v1' => esc_html__('List V1', 'superio'),
                    'list-v2' => esc_html__('List V2', 'superio'),
                ),
                'default' => 'list',
                'required' => array('employers_display_mode', '=', array('list'))
            ),
            array(
                'id' => 'employers_inner_grid_style',
                'type' => 'select',
                'title' => esc_html__('Employers grid item style', 'superio'),
                'subtitle' => esc_html__('Choose a employer grid style.', 'superio'),
                'options' => array(
                    'grid' => esc_html__('Grid Default', 'superio'),
                    'grid-v1' => esc_html__('Grid V1', 'superio'),
                    'grid-v2' => esc_html__('Grid V2', 'superio'),
                    'grid-v3' => esc_html__('Grid V3', 'superio'),
                ),
                'default' => 'grid',
                'required' => array('employers_display_mode', '=', array('grid'))
            ),

            array(
                'id' => 'employers_columns',
                'type' => 'select',
                'title' => esc_html__('Employer Columns', 'superio'),
                'options' => $columns,
                'default' => 4,
            ),
            array(
                'id' => 'employers_pagination',
                'type' => 'select',
                'title' => esc_html__('Pagination Type', 'superio'),
                'options' => array(
                    'default' => esc_html__('Default', 'superio'),
                    'loadmore' => esc_html__('Load More Button', 'superio'),
                    'infinite' => esc_html__('Infinite Scrolling', 'superio'),
                ),
                'default' => 'default'
            ),
            array(
                'title' => esc_html__('Employer Featured Background Color', 'superio'),
                'subtitle' => '<em>'.esc_html__('The employer featured background color of the site.', 'superio').'</em>',
                'id' => 'employer_featured_background_color',
                'type' => 'color',
                'transparent' => false,
            ),
        )
    );
    
    
    // Employer Page
    $sections[] = array(
        'title' => esc_html__('Single Employer', 'superio'),
        'subsection' => true,
        'fields' => array(
            array(
                'id' => 'employer_general_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('General Setting', 'superio').'</h3>',
            ),
            array(
                'id' => 'employer_layout_type',
                'type' => 'select',
                'title' => esc_html__('Employer Layout', 'superio'),
                'subtitle' => esc_html__('Choose a default layout single employer.', 'superio'),
                'options' => array(
                    'v1' => esc_html__('Version 1', 'superio'),
                    'v2' => esc_html__('Version 2', 'superio'),
                    'v3' => esc_html__('Version 3', 'superio'),
                ),
                'default' => 'v1',
            ),

            array(
                'id' => 'employer_fullwidth',
                'type' => 'switch',
                'title' => esc_html__('Is Full Width?', 'superio'),
                'default' => false
            ),
            array(
                'id' => 'show_employer_description',
                'type' => 'switch',
                'title' => esc_html__('Show Description', 'superio'),
                'default' => 1
            ),
            array(
                'id' => 'show_employer_socials',
                'type' => 'switch',
                'title' => esc_html__('Show Socials', 'superio'),
                'default' => 1
            ),
            array(
                'id' => 'show_employer_video',
                'type' => 'switch',
                'title' => esc_html__('Show Video', 'superio'),
                'default' => 1
            ),
            
            array(
                'id' => 'show_employer_photos',
                'type' => 'switch',
                'title' => esc_html__('Show Photos', 'superio'),
                'default' => 1
            ),
            array(
                'id' => 'show_employer_members',
                'type' => 'switch',
                'title' => esc_html__('Show Members', 'superio'),
                'default' => 1
            ),
            array(
                'id' => 'show_employer_open_jobs',
                'type' => 'switch',
                'title' => esc_html__('Show Open Jobs', 'superio'),
                'default' => 1
            ),
            array(
                'id' => 'show_employer_social_share',
                'type' => 'switch',
                'title' => esc_html__('Show Social Share', 'superio'),
                'default' => 1
            ),
        )
    );
    
    return $sections;
}
add_filter( 'superio_redux_framwork_configs', 'superio_wp_job_board_pro_employer_redux_config', 10, 3 );


// candidates
function superio_wp_job_board_pro_candidate_redux_config($sections, $sidebars, $columns) {
    
    $sections[] = array(
        'icon' => 'el el-pencil',
        'title' => esc_html__('Candidate Settings', 'superio'),
        'fields' => array(
            array(
                'id' => 'show_candidate_breadcrumbs',
                'type' => 'switch',
                'title' => esc_html__('Breadcrumbs', 'superio'),
                'default' => 1
            ),
            array(
                'title' => esc_html__('Breadcrumbs Background Color', 'superio'),
                'subtitle' => '<em>'.esc_html__('The breadcrumbs background color of the site.', 'superio').'</em>',
                'id' => 'candidate_breadcrumb_color',
                'type' => 'color',
                'transparent' => false,
            ),
            array(
                'id' => 'candidate_breadcrumb_image',
                'type' => 'media',
                'title' => esc_html__('Breadcrumbs Background', 'superio'),
                'subtitle' => esc_html__('Upload a .jpg or .png image that will be your breadcrumbs.', 'superio'),
            ),
        )
    );
    // Archive settings
    $sections[] = array(
        'title' => esc_html__('Candidate Archives', 'superio'),
        'subsection' => true,
        'fields' => array(
            array(
                'id' => 'candidates_general_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('General Setting', 'superio').'</h3>',
            ),
            array(
                'id' => 'candidates_fullwidth',
                'type' => 'switch',
                'title' => esc_html__('Is Full Width?', 'superio'),
                'default' => false
            ),
            array(
                'id' => 'candidates_layout_type',
                'type' => 'select',
                'title' => esc_html__('Candidates Layout', 'superio'),
                'subtitle' => esc_html__('Choose a default layout archive job.', 'superio'),
                'options' => array(
                    'default' => esc_html__('Default', 'superio'),
                    'half-map' => esc_html__('Half Map', 'superio'),
                    'top-map' => esc_html__('Top Map', 'superio'),
                ),
                'default' => 'default',
            ),
            array(
                'id' => 'candidates_layout_sidebar',
                'type' => 'image_select',
                'compiler' => true,
                'title' => esc_html__('Sidebar Layout', 'superio'),
                'subtitle' => esc_html__('Select a sidebar layout', 'superio'),
                'options' => array(
                    'main' => array(
                        'title' => esc_html__('Main Content', 'superio'),
                        'alt' => esc_html__('Main Content', 'superio'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen1.png'
                    ),
                    'left-main' => array(
                        'title' => esc_html__('Left - Main Sidebar', 'superio'),
                        'alt' => esc_html__('Left - Main Sidebar', 'superio'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen2.png'
                    ),
                    'main-right' => array(
                        'title' => esc_html__('Main - Right Sidebar', 'superio'),
                        'alt' => esc_html__('Main - Right Sidebar', 'superio'),
                        'img' => get_template_directory_uri() . '/inc/assets/images/screen3.png'
                    ),
                ),
                'default' => 'main-right',
                'required' => array('candidates_layout_type', '=', array('default', 'top-map')),
            ),

            array(
                'id' => 'candidates_display_mode',
                'type' => 'select',
                'title' => esc_html__('Candidates display mode', 'superio'),
                'subtitle' => esc_html__('Choose a default display mode for archive candidate.', 'superio'),
                'options' => array(
                    'grid' => esc_html__('Grid', 'superio'),
                    'list' => esc_html__('List', 'superio'),
                ),
                'default' => 'list'
            ),

            array(
                'id' => 'candidates_inner_list_style',
                'type' => 'select',
                'title' => esc_html__('Candidates list item style', 'superio'),
                'subtitle' => esc_html__('Choose a candidate list style.', 'superio'),
                'options' => array(
                    'list' => esc_html__('List Default', 'superio'),
                    'list-v1' => esc_html__('List V1', 'superio'),
                    'list-v2' => esc_html__('List V2', 'superio'),
                ),
                'default' => 'list',
                'required' => array('candidates_display_mode', '=', array('list'))
            ),
            array(
                'id' => 'candidates_inner_grid_style',
                'type' => 'select',
                'title' => esc_html__('Candidates grid item style', 'superio'),
                'subtitle' => esc_html__('Choose a candidate grid style.', 'superio'),
                'options' => array(
                    'grid' => esc_html__('Grid Default', 'superio'),
                    'grid-v1' => esc_html__('Grid V1', 'superio'),
                ),
                'default' => 'grid',
                'required' => array('candidates_display_mode', '=', array('grid'))
            ),
            array(
                'id' => 'candidates_columns',
                'type' => 'select',
                'title' => esc_html__('Candidate Columns', 'superio'),
                'options' => $columns,
                'default' => 4,
                'required' => array('candidates_display_mode', '=', array('grid'))
            ),
            array(
                'id' => 'candidates_pagination',
                'type' => 'select',
                'title' => esc_html__('Pagination Type', 'superio'),
                'options' => array(
                    'default' => esc_html__('Default', 'superio'),
                    'loadmore' => esc_html__('Load More Button', 'superio'),
                    'infinite' => esc_html__('Infinite Scrolling', 'superio'),
                ),
                'default' => 'default'
            ),
            array(
                'id' => 'candidate_placeholder_image',
                'type' => 'media',
                'title' => esc_html__('Placeholder Image', 'superio'),
                'subtitle' => esc_html__('Upload a .jpg or .png image that will be your placeholder.', 'superio'),
            ),
            array(
                'title' => esc_html__('Candidate Urgent Background Color', 'superio'),
                'subtitle' => '<em>'.esc_html__('The candidate urgent background color of the site.', 'superio').'</em>',
                'id' => 'candidate_urgent_background_color',
                'type' => 'color',
                'transparent' => false,
            ),

            array(
                'title' => esc_html__('Candidate Featured Background Color', 'superio'),
                'subtitle' => '<em>'.esc_html__('The candidate featured background color of the site.', 'superio').'</em>',
                'id' => 'candidate_featured_background_color',
                'type' => 'color',
                'transparent' => false,
            ),
        )
    );
    
    
    // Candidate Page
    $sections[] = array(
        'title' => esc_html__('Single Candidate', 'superio'),
        'subsection' => true,
        'fields' => array(
            array(
                'id' => 'candidate_general_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('General Setting', 'superio').'</h3>',
            ),
            array(
                'id' => 'candidate_layout_type',
                'type' => 'select',
                'title' => esc_html__('Candidate Layout', 'superio'),
                'subtitle' => esc_html__('Choose a default layout archive candidate.', 'superio'),
                'options' => array(
                    'v1' => esc_html__('Version 1', 'superio'),
                    'v2' => esc_html__('Version 2', 'superio'),
                    'v3' => esc_html__('Version 3', 'superio'),
                ),
                'default' => 'v1',
            ),
            array(
                'id' => 'candidate_fullwidth',
                'type' => 'switch',
                'title' => esc_html__('Is Full Width?', 'superio'),
                'default' => false
            ),
            array(
                'id' => 'show_candidate_description',
                'type' => 'switch',
                'title' => esc_html__('Show Description', 'superio'),
                'default' => 1
            ),
            array(
                'id' => 'show_candidate_video',
                'type' => 'switch',
                'title' => esc_html__('Show Video', 'superio'),
                'default' => 1
            ),
            array(
                'id' => 'show_candidate_map_location',
                'type' => 'switch',
                'title' => esc_html__('Show Map Location', 'superio'),
                'default' => 1
            ),
            array(
                'id' => 'show_candidate_education',
                'type' => 'switch',
                'title' => esc_html__('Show Education', 'superio'),
                'default' => 1
            ),
            array(
                'id' => 'show_candidate_experience',
                'type' => 'switch',
                'title' => esc_html__('Show Experience', 'superio'),
                'default' => 1
            ),
            array(
                'id' => 'show_candidate_portfolios',
                'type' => 'switch',
                'title' => esc_html__('Show Portfolios', 'superio'),
                'default' => 1
            ),
            array(
                'id' => 'show_candidate_skill',
                'type' => 'switch',
                'title' => esc_html__('Show Skill', 'superio'),
                'default' => 1
            ),
            array(
                'id' => 'show_candidate_award',
                'type' => 'switch',
                'title' => esc_html__('Show Award', 'superio'),
                'default' => 1
            ),
            array(
                'id' => 'show_candidate_social_share',
                'type' => 'switch',
                'title' => esc_html__('Show Social Share', 'superio'),
                'default' => 1
            ),
            array(
                'id' => 'show_candidate_invite_apply_job',
                'type' => 'select',
                'title' => esc_html__('Show Invite Candidate Apply Job', 'superio'),
                'options' => array(
                    'always' => esc_html__('Always Show', 'superio'),
                    'show_loggedin' => esc_html__('Show when Employer Logged in', 'superio'),
                    'none-register-employer' => esc_html__('None Register and Employer', 'superio'),
                    'hide' => esc_html__('Hide', 'superio'),
                ),
                'default' => 'always',
            ),
            array(
                'id' => 'candidate_block_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('Candidate Block Setting', 'superio').'</h3>',
            ),
            array(
                'id' => 'candidate_releated_show',
                'type' => 'switch',
                'title' => esc_html__('Show Candidates Related', 'superio'),
                'default' => 1
            ),
            array(
                'id' => 'candidate_releated_number',
                'title' => esc_html__('Number of related candidates to show', 'superio'),
                'default' => 4,
                'min' => '1',
                'step' => '1',
                'max' => '50',
                'type' => 'slider',
                'required' => array('candidate_releated_show', '=', true)
            ),
            array(
                'id' => 'candidate_releated_columns',
                'type' => 'select',
                'title' => esc_html__('Related Candidates Columns', 'superio'),
                'options' => $columns,
                'default' => 3,
                'required' => array('candidate_releated_show', '=', true)
            ),
        )
    );
    
    return $sections;
}
add_filter( 'superio_redux_framwork_configs', 'superio_wp_job_board_pro_candidate_redux_config', 10, 3 );


function superio_wp_job_board_pro_register_form_redux_config($sections, $sidebars, $columns) {
    // Register Form
    $sections[] = array(
        'title' => esc_html__('Register Form', 'superio'),
        'fields' => array(
            array(
                'id' => 'register_general_setting',
                'icon' => true,
                'type' => 'info',
                'raw' => '<h3 style="margin: 0;"> '.esc_html__('General Setting', 'superio').'</h3>',
            ),
            array(
                'id' => 'register_form_enable_candidate',
                'type' => 'switch',
                'title' => esc_html__('Enable Register Candidate', 'superio'),
                'default' => true,
            ),
            array(
                'id' => 'register_form_enable_employer',
                'type' => 'switch',
                'title' => esc_html__('Enable Register Employer', 'superio'),
                'default' => true,
            ),
        )
    );
    
    return $sections;
}
add_filter( 'superio_redux_framwork_configs', 'superio_wp_job_board_pro_register_form_redux_config', 11, 3 );
