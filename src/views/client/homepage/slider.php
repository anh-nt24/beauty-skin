<div id="carouselSliders" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php
            foreach (SLIDER_IMAGES as $key => $url) {
                $activeClass = ($key == 0) ? 'active' : '';
                echo "<div class='carousel-item $activeClass'>";
                echo "<img class='d-block w-100' src='$url' alt='Slide $key'>";
                echo "</div>";
            }
        ?>
    </div>
    <a class="carouselSliderButton carousel-control-prev" href="#carouselSliders" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </a>
    <a class="carouselSliderButton carousel-control-next" href="#carouselSliders" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </a>
</div>