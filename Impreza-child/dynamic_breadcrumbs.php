<?php
function generate_breadcrumbs() {
    $pathArray = array_filter(explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/')));
    array_unshift($pathArray, 'Home'); // Add 'Home' as the first element

    $breadcrumbHtml = '<nav aria-label="breadcrumb"><div class="breadcrumb">';

    foreach ($pathArray as $index => $part) {
        $part = ucwords($part); // Capitalize the first character of each word
        if ($index === array_key_last($pathArray)) {
            $breadcrumbHtml .= '<span class="breadcrumb-item active" aria-current="page">' . htmlspecialchars($part) . '</span>';
        } else {
            $href = '/' . implode('/', array_slice($pathArray, 1, $index)); // Adjust the slice to skip 'Home'
            $breadcrumbHtml .= '<span class="breadcrumb-item"><a href="' . htmlspecialchars($href) . '">' . htmlspecialchars($part) . '</a></span> &gt; ';
        }
    }

    $breadcrumbHtml .= '</div></nav>';
    return $breadcrumbHtml;
}
?>