jQuery(document).ready(function($) {
	    var page = 0;
         // Initialize datepickers
            $("#from-date, #to-date").datepicker({
                dateFormat: 'yy-mm-dd'
            });

           


    function load_posts(page, append) {
	      //page++;
        var category = $('#apf-category').val();
        var city = $('#apf-city').val();
        var time = $('#apf-time').val();
        var fromDate = $('#from-date').val();
        var toDate = $('#to-date').val();
        var locations = $('#location').val();
        
        var dtype = $('#apf-load-more').data('type');
        if(dtype == '') dtype = 'apf_load_posts'; 
        

        $.ajax({
            url: apf_ajax.ajax_url,
            type: 'post',
            data: {
                action: ''+dtype+'',
                page: page,
                category: category,
                city: city,
                time: time,
                from_date: fromDate,
                to_date: toDate,
                locations: locations
                
            },
            beforeSend: function() {
                $('#apf-load-more-text').text('Loading...').prop('disabled', true);;
            },
            success: function(response) {
               /*  if (append) {
                    $('#apf-posts-container').append(response);
                } else {
                    $('#apf-posts-container').html(response);
                }

                $('#apf-load-more-text').text('Load More');
			   $('#apf-load-more').data('page', page + 1); */
			    var data = JSON.parse(response);
                if (data.posts) {  
               // alert(page); alert('page log kiya');
                    if(page == 1) $('#apf-posts-container').html(data.posts);  else $('#apf-posts-container').append(data.posts);
                    if(data.noevents) $('#apf-posts-container').html(data.posts);
                    else $(".noevents").hide();
                
                    $('#apf-load-more-text').text('Load More').prop('disabled', false);
					$('#apf-load-more').data('page', page + 1);
                    
					
					console.log(data.has_more);
                    // Hide the "Load More" button if there are no more posts
                    if (!data.has_more) {
                        $('#apf-load-more').hide();
                    }
                    else
                    {
                         $('#apf-load-more').show();
                    }
					
                } else {  
                     $('#apf-load-more').hide();
                }
            }
        });
    }

    $('#apf-category, #apf-city').on('change', function() {
        load_posts(1, false);
    });
    
    $(' #customdateFilter').on('click', function() {
        load_posts(1, false);
    });
 
    
    $('#apf-time').on('change', function() {
         var time = $('#apf-time').val();
         if(time != 'custom')
         {  
             load_posts(1, false);
              $('#custom-date-range').hide();       
         }
         else
         {
                 if ($(this).val() === 'custom') {
                    $('#custom-date-range').show();
                } else {
                    $('#custom-date-range').hide();                    
                }
         }
    });


    $('#apf-load-more').on('click', function() {
        var page = $(this).data('page');
        load_posts(page, true);
    });
    
    
    
    
    function load_postsL(page, append) {
	      //page++;
        var category = $('#apf-categoryL').val();
        var city = $('#apf-cityL').val();
        var locations = $('#locationL').val();
        
        var dtype = $('#apf-load-moreL').data('type');
        if(dtype == '') dtype = 'apf_load_posts'; 
        

        $.ajax({
            url: apf_ajax.ajax_url,
            type: 'post',
            data: {
                action: ''+dtype+'',
                page: page,
                category: category,
                city: city,
                locations: locations
                
            },
            beforeSend: function() {
                $('#apf-load-more-textL').text('Loading...').prop('disabled', true);;
            },
            success: function(response) {
               /*  if (append) {
                    $('#apf-posts-container').append(response);
                } else {
                    $('#apf-posts-container').html(response);
                }

                $('#apf-load-more-text').text('Load More');
			   $('#apf-load-more').data('page', page + 1); */
			    var data = JSON.parse(response);
                if (data.posts) {  
               // alert(page); alert('page log kiya');
                    if(page == 1) $('#apf-posts-containerL').html(data.posts);  else $('#apf-posts-containerL').append(data.posts);
                    if(data.noevents) $('#apf-posts-containerL').html(data.posts);
                    else $(".noevents").hide();
                
                    $('#apf-load-more-textL').text('Load More').prop('disabled', false);
					$('#apf-load-moreL').data('page', page + 1);
                    
					
					console.log(data.has_more);
                    // Hide the "Load More" button if there are no more posts
                    if (!data.has_more) {
                        $('#apf-load-moreL').hide();
                    }
                    else
                    {
                         $('#apf-load-moreL').show();
                    }
					
                } else {  
                     $('#apf-load-moreL').hide();
                }
            }
        });
    }

    $('#apf-categoryL, #apf-cityL').on('change', function() {
        load_postsL(1, false);
    });

    



    $('#apf-load-moreL').on('click', function() {
        var page = $(this).data('page');
        load_postsL(page, true);
    });

    // Initial load
    load_posts(1, false);
    
     // Initial load
    load_postsL(1, false);

    // Auto-suggest functionality for city filter
    $('#apf-city-search').on('input', function() {
        var search = $(this).val().toLowerCase();
        $('#apf-city option').each(function() {
            var text = $(this).text().toLowerCase();
            if (text.indexOf(search) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
    
    
    
    
});

jQuery.noConflict();
jQuery(document).ready(function($) {
    // Set the number of items to show initially and how many to load each time
    var itemsToShow = 20; // Number of items to show initially
    var itemsToLoad = 20; // Number of items to load on "Load More"

    // For each section with the 'load-more-section' class
    $('.load-more-section .w-grid-list').each(function() {
        var $section = $(this);
        var $items = $section.children('div'); // Assuming each child div is an item
        var totalItems = $items.length;

        // Initially hide all items except the first few
        $items.hide().slice(0, itemsToShow).show();

        // If there are more items than the initial set, add a "Load More" button
        if (totalItems > itemsToShow) {
            $section.append('<div class="g-loadmore " bis_skin_checked="1"><div class="g-preloader type_1" bis_skin_checked="1"> <div bis_skin_checked="1"></div>				</div> <button class="load-more-btn w-btn us-btn-style_1" fdprocessedid="psmt1p"> <span class="w-btn-label">Load More</span> </button></div>');
        }

        // Click event for the "Load More" button
        $section.find('.load-more-btn').on('click', function() {
            var visibleItems = $section.children('div:visible').length;

            // Show more items
            $items.slice(visibleItems, visibleItems + itemsToLoad).fadeIn();

            // Hide "Load More" button if all items are shown
            if (visibleItems + itemsToLoad >= totalItems) {
                $(this).fadeOut();
            }
        });
    });
});
