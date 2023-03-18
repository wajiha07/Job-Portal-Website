(function($) {
    "use strict";
    
    var map, mapSidebar, markers, CustomHtmlIcon, group;
    var markerArray = [];

    $.extend($.apusThemeCore, {
        /**
         *  Initialize scripts
         */
        job_map_init: function() {
            var self = this;

            if ($('#jobs-google-maps').length) {
                L.Icon.Default.imagePath = 'wp-content/themes/superio/images/';
            }
            
            setTimeout(function(){
                self.mapInit();
            }, 50);
            
        },
        
        mapInit: function() {
            var self = this;

            var $window = $(window);

            if (!$('#jobs-google-maps').length) {
                return;
            }

            map = L.map('jobs-google-maps', {
                scrollWheelZoom: false
            });

            markers = new L.MarkerClusterGroup({
                showCoverageOnHover: false
            });

            CustomHtmlIcon = L.HtmlIcon.extend({
                options: {
                    html: "<div class='map-popup'></div>",
                    iconSize: [30, 30],
                    iconAnchor: [22, 30],
                    popupAnchor: [0, -30]
                }
            });

            $window.on('pxg:refreshmap', function() {
                map._onResize();
                setTimeout(function() {
                    
                    if(markerArray.length > 0 ){
                        group = L.featureGroup(markerArray);
                        map.fitBounds(group.getBounds()); 
                    }
                }, 100);
            });

            $window.on('pxg:simplerefreshmap', function() {
                map._onResize();
            });

            if ( superio_job_map_opts.map_service == 'mapbox' ) {
                var tileLayer = L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/'+superio_job_map_opts.mapbox_style+'/tiles/{z}/{x}/{y}?access_token='+ superio_job_map_opts.mapbox_token, {
                    attribution: " &copy;  <a href='https://www.mapbox.com/about/maps/'>Mapbox</a> &copy;  <a href='http://www.openstreetmap.org/copyright'>OpenStreetMap</a> <strong><a href='https://www.mapbox.com/map-feedback/' target='_blank'>Improve this map</a></strong>",
                    maxZoom: 18,
                });
            } else if ( superio_job_map_opts.map_service == 'here' ) {

                var hereTileUrl = 'https://2.base.maps.ls.hereapi.com/maptile/2.1/maptile/newest/'+superio_job_map_opts.here_style+'/{z}/{x}/{y}/512/png8?apiKey='+ superio_job_map_opts.here_map_api_key +'&ppi=320';
                var tileLayer = L.tileLayer(hereTileUrl, {
                    attribution: " &copy;  <a href='https://www.mapbox.com/about/maps/'>Here</a> &copy; <strong><a href='https://www.mapbox.com/map-feedback/' target='_blank'>Improve this map</a></strong>",
                    maxZoom: 18,
                });

            } else {
                if ( superio_job_map_opts.custom_style != '' ) {
                    try {
                        var custom_style = $.parseJSON(superio_job_map_opts.custom_style);
                        var tileLayer = L.gridLayer.googleMutant({
                            type: 'roadmap',
                            styles: custom_style
                        });

                    } catch(err) {
                        var tileLayer = L.gridLayer.googleMutant({
                            type: 'roadmap'
                        });
                    }
                } else {
                    var tileLayer = L.gridLayer.googleMutant({
                        type: 'roadmap'
                    });
                }
            }

            

            map.addLayer(tileLayer);

            // check archive/single page
            if ( !$('#jobs-google-maps').is('.single-job-map') ) {
                self.updateMakerCards();
            } else {
                var $item = $('.single-listing-wrapper');
                
                if ( $item.data('latitude') !== "" && $item.data('latitude') !== "" ) {
                    var zoom = (typeof MapWidgetZoom !== "undefined") ? MapWidgetZoom : 15;
                    self.addMakerToMap($item);
                    map.addLayer(markers);

                    map.setView([$item.data('latitude'), $item.data('longitude')], zoom);
                    $(window).on('update:map', function() {
                        map.setView([$item.data('latitude'), $item.data('longitude')], zoom);
                    });
                } else {
                    $('#jobs-google-maps').hide();
                }
            }
        },
        updateMakerCards: function() {
            var self = this;
            var $items = $('.main-items-wrapper .map-item');
            
            if (!$items.length) {
                return;
            }

            if ($('#jobs-google-maps').length && typeof map !== "undefined") {
                map.removeLayer(markers);
                markers = new L.MarkerClusterGroup({
                    showCoverageOnHover: false
                });
                $items.each(function(i, obj) {
                    self.addMakerToMap($(obj), true);
                });

                map.addLayer(markers);

                if(markerArray.length > 0 ){
                    group = L.featureGroup(markerArray);
                    map.fitBounds(group.getBounds()); 
                }
            }
        },
        addMakerToMap: function($item, archive) {
            var self = this;
            var marker;

            if ( $item.data('latitude') == "" || $item.data('longitude') == "") {
                return;
            }

            if ( $item.data('img')) {
                var img_logo = "<img src='" + $item.data('img') + "' alt=''>";
                var mapPinHTML = "<div class='map-popup'><div class='icon-wrapper has-img is-job'>" + img_logo + "</div></div>";
            } else {
                var mapPinHTML = "<div class='map-popup'><div class='icon-wrapper is-candidate'></div></div>";
            }

            marker = L.marker([$item.data('latitude'), $item.data('longitude')], {
                icon: new CustomHtmlIcon({ html: mapPinHTML })
            });

            if (typeof archive !== "undefined") {

                $item.on('mouseenter', function() {
                    $(marker._icon).find('.map-popup').addClass('map-popup-selected');
                }).on('mouseleave', function(){
                    $(marker._icon).find('.map-popup').removeClass('map-popup-selected');
                });

                var html_output = '';
                if ( $item.hasClass('job_listing') ) {
                    var logo_html = '';
                    if ( $item.data('img') ) {
                        logo_html = "<div class='employer-logo'><div class='image-wrapper image-loaded'>" +
                                    "<img src='" + $item.data('img') + "' alt=''>" +
                                "</div></div>";
                    }

                    var title_html = '';
                    if ( $item.find('.job-title').length ) {
                        title_html = "<div class='job-title'>" + $item.find('.job-title').html() + "</div>";
                    }
                    var category_html = '';
                    if ( $item.find('.category-job').length ) {
                        category_html = "<div class='category-job'>" + $item.find('.category-job').html() + "</div>";
                    }
                    var location_html = '';
                    if ( $item.find('.job-location').length ) {
                        location_html = "<div class='job-location'>" + $item.find('.job-location').html() + "</div>";
                    }
                    var meta_html =  "<div class='job-metas'>" + category_html + location_html + "</div>";

                    html_output = "<div class='maps-popup-style job-list'>" +
                        "<div class='inner'>" + logo_html +
                            "<div class='job-list-content'>" + title_html + meta_html + "</div>" +
                        "</div>" + 
                    "</div>";
                } else if ( $item.hasClass('employer') ) {
                    var logo_html = '';
                    if ( $item.data('img') ) {
                        logo_html = "<div class='employer-logo'><div class='image-wrapper image-loaded'>" +
                                    "<img src='" + $item.data('img') + "' alt=''>" +
                                "</div></div>";
                    }

                    var title_html = '';
                    if ( $item.find('.employer-title').length ) {
                        title_html = "<div class='job-title'>" + $item.find('.employer-title').html() + "</div>";
                    }
                    var meta_html = '';
                    if ( $item.find('.employer-metas').length ) {
                        meta_html = "<div class='job-metas'>" + $item.find('.employer-metas').html() + "</div>";
                    }

                    html_output = "<div class='maps-popup-style job-list'>" +
                        "<div class='inner'>" + logo_html +
                            "<div class='job-list-content'>" + title_html + meta_html + "</div>" +
                        "</div>" + 
                    "</div>";
                } else {
                    var logo_html = '';
                    if ( $item.data('img') ) {
                        logo_html = "<div class='employer-logo'><div class='image-wrapper image-loaded'>" +
                                    "<img src='" + $item.data('img') + "' alt=''>" +
                                "</div></div>";
                    }

                    var title_html = '';
                    if ( $item.find('.candidate-title').length ) {
                        title_html = "<div class='job-title'>" + $item.find('.candidate-title').html() + "</div>";
                    }
                    var meta_html = '';
                    if ( $item.find('.job-metas').length ) {
                        meta_html = "<div class='job-metas'>" + $item.find('.job-metas').html() + "</div>";
                    }

                    html_output = "<div class='maps-popup-style job-list'>" +
                        "<div class='inner'>" + logo_html +
                            "<div class='job-list-content'>" + title_html + meta_html + "</div>" +
                        "</div>" + 
                    "</div>";
                }

                marker.bindPopup(html_output).openPopup();
            }

            markers.addLayer(marker);
            markerArray.push(L.marker([$item.data('latitude'), $item.data('longitude')]));
        },
        
    });

    $.apusThemeExtensions.job_map = $.apusThemeCore.job_map_init;

    
})(jQuery);
