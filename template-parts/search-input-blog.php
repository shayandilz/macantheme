<?php
$url = $_SERVER["REQUEST_URI"];
$slugEN = strpos($url, 'en');
?>

<div class="search-box position-relative w-100 mx-auto mt-5">
    <div class="search-icon position-absolute text-center"><i class="bi bi-search search-icon text-danger"></i></div>

    <input class="z-2 position-absolute w-100 h-100 end-0 top-0 text-danger bg-transparent border-0"
           type="text"
           placeholder="<?php echo $slugEN ? 'Type in ...' : 'عبارت مورد نظرتان را تایپ کنید ... '; ?>"
           id="search-input">
    <svg class="search-border d-block w-100" version="1.1" xmlns="http://www.w3.org/2000/svg"
         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 671 111"
         style="enable-background:new 0 0 671 111;"
         xml:space="preserve">
        <path class="border-input" d="M335.5,108.5h-280c-29.3,0-53-23.7-53-53v0c0-29.3,23.7-53,53-53h280"/>
        <path class="border-input" d="M335.5,108.5h280c29.3,0,53-23.7,53-53v0c0-29.3-23.7-53-53-53h-280"/>
    </svg>
</div>