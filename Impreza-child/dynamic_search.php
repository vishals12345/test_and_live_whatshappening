<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// AJAX-Suchfunktion
function my_ajax_search() {
    $search_query = isset($_POST['search_query']) ? sanitize_text_field($_POST['search_query']) : '';

    // Überprüfen, ob das Suchfeld leer ist
    if (empty($search_query)) {
        echo '<div class="search-result">Keine Ergebnisse gefunden.</div>';
        wp_die();
    }

    $today = current_time('Ymd'); // Heutiges Datum im Format Ymd

    // Hauptabfrage für Beiträge
    $args = array(
        'post_type' => 'post', // Beitragstypen, die durchsucht werden sollen
        's' => $search_query,
        'posts_per_page' => 10,
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'end_date', // Name des benutzerdefinierten Feldes, das das Enddatum speichert
                'value' => $today,
                'compare' => '>=',
                'type' => 'DATE'
            )
        )
    );

    $query = new WP_Query($args);

    // Abfrage für Locations
    $location_args = array(
        'post_type' => 'location',
        's' => $search_query,
        'posts_per_page' => 10,
    );

    $location_query = new WP_Query($location_args);

    if ($query->have_posts() || $location_query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            echo '<div class="search-result">';
            echo '<a href="' . get_permalink() . '">' . get_the_title() . '</a>';
            echo '</div>';
        }

        // Locations anzeigen
        if ($location_query->have_posts()) {
            echo '<h4>Locations:</h4>';
            while ($location_query->have_posts()) {
                $location_query->the_post();
                $city = get_field('city');
                $city_term = get_term_by('name', $city, 'location_tag'); // Ersetzen Sie 'city_taxonomy' durch den tatsächlichen Taxonomie-Namen
                $city_slug = $city_term ? $city_term->slug : '';
                $location_cat = get_the_terms(get_the_ID(), 'location_cat');
                $location_cat_slug = $location_cat ? $location_cat[0]->slug : '';
                $location_url = home_url('/' . $city_slug . '/' . $location_cat_slug . '/' . get_post_field('post_name', get_the_ID()) . '/');
                echo '<div class="search-result">';
                echo '<a href="' . esc_url($location_url) . '">' . get_the_title() . '</a>';
                echo '</div>';
            }
        }

        // Link zur Suchseite hinzufügen
        echo '<div class="search-result">';
        echo '<a href="' . home_url('/') . '?s=' . urlencode($search_query) . '">Weitere Ergebnisse anzeigen</a>';
        echo '</div>';
    } else {
        echo '<div class="search-result">Keine Ergebnisse gefunden.</div>';
    }

    wp_die();
}
add_action('wp_ajax_my_ajax_search', 'my_ajax_search');
add_action('wp_ajax_nopriv_my_ajax_search', 'my_ajax_search');



// Shortcode für die Suchfunktion
function my_search_shortcode() {
    ob_start();
    ?>
    <div id="my-search-form" style="position: relative; height: 40px;">
        <input type="text" id="my-search-input" placeholder="Search ..." style="padding-left: 30px; height: 100%;">
        <div id="my-search-results" style="background-color: white; border: none; padding: 20px; position: absolute; z-index: 1000; width: 100%; display: none;"></div>
        <img src="<?php echo home_url('/wp-content/uploads/2024/12/icons8-search-24.png'); ?>" alt="Search Icon" style="position: absolute; left: 5px; top: 50%; transform: translateY(-50%);">
    </div>
    <script>
    jQuery(document).ready(function($) {
        $('#my-search-input').on('input', function() {
            var searchQuery = $(this).val();
            if (searchQuery.length === 0) {
                $('#my-search-results').empty().css({'border': 'none', 'background-color': 'transparent'}).hide();
                return;
            }
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: 'my_ajax_search',
                    search_query: searchQuery
                },
                success: function(response) {
                    if (response.trim() === '') {
                        $('#my-search-results').empty().css({'border': 'none', 'background-color': 'transparent'}).hide();
                    } else {
                        $('#my-search-results').html(response).css({'border': '1px solid grey', 'background-color': 'white', 'padding': '20px'}).show();
                    }
                }
            });
        });

        $('#my-search-input').on('keypress', function(e) {
            if (e.which == 13) { // Enter key pressed
                e.preventDefault();
                var searchQuery = $(this).val();
                if (searchQuery.length > 0) {
                    window.location.href = '<?php echo home_url('/'); ?>?s=' + encodeURIComponent(searchQuery);
                }
            }
        });

        $('#my-search-input').on('focus', function() {
            if ($('#my-search-results').children().length > 0) {
                $('#my-search-results').show();
            }
        });

        $(document).on('click', function(event) {
            if (!$(event.target).closest('#my-search-form').length) {
                $('#my-search-results').hide();
            }
        });
    });
    </script>
    <?php
    return ob_get_clean();
}
