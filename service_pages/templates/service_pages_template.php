<?php

/**
 * Template Name: Service Page
 *
 */

get_header();
$post_id = get_the_ID();
$title = get_field('title', $post_id);
$description = get_field('description', $post_id);
$raiting = get_field('raiting', $post_id);
$info = get_field('info', $post_id);
$image = get_field('image', $post_id);

?>
<div class="clear"></div>
</header> <!-- / END HOME SECTION  -->
<?php zerif_after_header_trigger(); ?>



<div class="container">
    <div class="row p-5">
        <div class="col-lg-6 ">
            <img class="image" src="<?php echo $image; ?>" />
        </div>
        <div class="col-lg-6">
            <div>

                <h1><?php echo $title; ?></h1>

                <div class="raiting-container">
                    <p><?php echo $raiting; ?></p>
                    <div class="star-rating-items" style="width: <?php echo $raiting; ?>em">
                        <div class="stars">
                            <span class="star-item">&#9733;</span>
                            <span class="star-item">&#9733;</span>
                            <span class="star-item">&#9733;</span>
                            <span class="star-item">&#9733;</span>
                            <span class="star-item">&#9733;</span>
                        </div>
                    </div>
                </div>

                <p><?php echo $description; ?></p>

                <button class="get-started-buttom"> Get Started Today </button>

                <div class="accordion-container">
                    <?php
                    if ($info) {
                        foreach ($info as $item) {
                            echo '<div class="accordion-item">';
                            echo '<a class="accordion" >' . $item['item_title'] . '</a>';
                            echo '<div class="panel"><p>' . $item['item_text'] . '</p></div>';
                            echo '</div>';
                        }
                    }
                    ?>
                </div>

                <span class="warning">*Prescription medications available only if prescribed by the healthcare provider after an online consultation.</span>

            </div>
        </div>
    </div>
</div>



<?php
$post_content = get_the_content();

if (!empty($post_content)) {
    $doc = new DOMDocument();
    libxml_use_internal_errors(true);
    $doc->loadHTML($post_content);
    libxml_clear_errors();

    $xpath = new DOMXPath($doc);
    $headings = $xpath->query('//h2|//h3');

    $output = '<div class="table-of-content">';

    foreach ($headings as $heading) {

        $text = $heading->nodeValue;

        $string = preg_replace("/[^a-zA-Z\s]/", "",  $text);

        $str = str_replace(" ", "_", $string);

        $output .= '<a href="#' . $str . '">' . $text . '</a>';
    }

    $output .= '</div>';

    echo $output;
}
?>



<div id="content" class="site-content">

    <div class="container">
        <div class="row">
            <?php zerif_before_page_content_trigger(); ?>

            <?php zerif_top_page_content_trigger(); ?>
            <div id="primary" class="content-area">

                <main itemscope itemtype="http://schema.org/WebPageElement" itemprop="mainContentOfPage" id="main" class="site-main">

                    <?php the_content(); ?>

                </main><!-- #main -->

            </div><!-- #primary -->
        </div>
    </div>
</div>

<?php get_footer(); ?>



<style>

.site-content {
    scroll-behavior: smooth;
}

    @media screen and (max-width: 450px) {
        .table-of-content {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding-left: 4em !important;
        }
    }

    .warning {
        display: block;
        margin-top: 1em;
    }

    .site-content {
        margin-top: 3em;
        margin-bottom: 3em;
    }

    h1,
    h2,
    h3,
    p,
    a,
    li {
        text-align: left;
    }

    .table-of-content {
        width: 100%;
        background-color: #2c63f3;
        padding: 0.8em;
        padding-right: 0;
        padding-left: 0;
    }

    .table-of-content a {
        color: white;
        margin-right: 1.5em;
        font-size: 14px;
    }

    .image {
        border-radius: 8px;
        width: 100%;
    }

    .get-started-buttom {
        background-color: #2c63f3;
        color: #fff;
        border-radius: 4px;
        width: 100%;
        text-align: center;
        margin: 0;
        margin-top: 1em;
    }

    /* */

    .stars {
        color: #ffcc00;
        font-size: 20px;
        cursor: pointer;
        display: flex;
        width: 5em;
    }

    .star:hover,
    .star:hover~.star {
        color: #ff9900;
    }

    .star:hover~input,
    .star:hover~input~.star {
        color: #ffcc00;
    }

    .star-rating-items {
        overflow: hidden;
        font-size: 20px;
    }

    span.star-item {
        width: 1em;
    }

    .raiting-container {
        display: flex;
        align-items: center;
    }

    .raiting-container p {
        margin-right: 0.5em;
        font-size: var(--glsr-text-lg);
        font-weight: 700;
        line-height: 1;
    }

    /* */

    .accordion {
        color: #444;
        cursor: pointer;
        width: 100%;
        border: none;
        outline: none;
        transition: 0.4s;
    }

    .panel {
        padding: 0 18px;
        background-color: white;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.2s ease-out;
    }

    .accordion:after {
        content: '\02795';
        font-size: 13px;
        color: #777;
        float: right;
        margin-left: 5px;
    }

    .active:after {
        content: "\2796";
    }

    .accordion-item {
        margin-top: 20px;
        padding-top: 20px;
        border-bottom: 1px solid rgba(0, 0, 0, .1);
        text-align: left;
    }
</style>



<script>
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.maxHeight) {
                panel.style.maxHeight = null;
            } else {
                panel.style.maxHeight = panel.scrollHeight + "px";
            }
        });
    }
</script>