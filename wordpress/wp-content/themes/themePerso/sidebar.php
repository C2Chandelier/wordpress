<p class="text-danger">je suis la sidebar</p>
<?php
$pages = get_pages();
foreach ($pages as $page){
    $link = get_page_link($page);
    echo '<button onclick="document.location.href=\''.$link.'\'">Page</button>';
    //echo '<a href="'.$link.'">Page</a>';
}