<?php
$categories = mysqli_query($con, "select * from category_event");

// get information about four newest events
$organized_events = mysqli_query($con, "
select oe.date as date,oe.id as id,oe.review_id as review_id, staff.name as staff, ce.name as category_name, event.event_name as theme_name, user.user_name as name, review.content as review, oe.image as image
from organized_events oe, category_event ce, user, event, review, staff
where oe.user_id = user.id and oe.event_id = event.id and oe.event_id_category = ce.event_id and review.id = oe.review_id and staff.id = oe.staff_id
order by oe.date desc limit 4
");
$reviews =mysqli_query($con,"select * from review");
$reviews_array = array();
while ($review = mysqli_fetch_array($reviews)) {
	array_push($reviews_array, $review);
}
?>
<!-- script for changing slides -->
<script>
$(document).ready(function() {
    // interact with dots
    $(".dot").click(function() {
        var n = $(".dot").index(this);
        $(".mySlides").each(function(index) {
            if (n != index) {
                $(".mySlides:nth-of-type(" + parseInt(index + 1) + ")").hide();
                $(".dot:nth-of-type(" + parseInt(index + 1) + ")").removeClass("activeDot");
            } else {
                $(".mySlides:nth-of-type(" + parseInt(index + 1) + ")").show();
                $(".dot:nth-of-type(" + parseInt(index + 1) + ")").addClass("activeDot");
            }
        });
    });

    // show default slide
    $(".mySlides:nth-of-type(" + 1 + ")").show();

    $.fn.toNextSlide = function() {
        var n = $(".dot.activeDot").index();
        n += 1;

        $(".mySlides:nth-of-type(" + parseInt(n) + ")").hide();
        $(".dot:nth-of-type(" + parseInt(n) + ")").removeClass("activeDot");

        if (n == $(".dot").length) {
            n = 1;
            $(".mySlides:nth-of-type(" + parseInt(n) + ")").show();
            $(".dot:nth-of-type(" + parseInt(n) + ")").addClass("activeDot");
        } else {
            n += 1;
            $(".mySlides:nth-of-type(" + parseInt(n) + ")").show();
            $(".dot:nth-of-type(" + parseInt(n) + ")").addClass("activeDot");
        }
    }

    // change to next slide
    $(".next").click(function() {
        $.fn.toNextSlide();
    });

    // change to previous slide
    $(".prev").click(function() {
        var n = $(".dot.activeDot").index();
        n += 1;

        $(".mySlides:nth-of-type(" + parseInt(n) + ")").css("display", "none");
        $(".dot:nth-of-type(" + parseInt(n) + ")").removeClass("activeDot");

        if (n == 1) {
            n = $(".dot").length;
            $(".mySlides:nth-of-type(" + parseInt(n) + ")").css("display", "block");
            $(".dot:nth-of-type(" + parseInt(n) + ")").addClass("activeDot");
        } else {
            n -= 1;
            $(".mySlides:nth-of-type(" + parseInt(n) + ")").css("display", "block");
            $(".dot:nth-of-type(" + parseInt(n) + ")").addClass("activeDot");
        }
    });

    // change slide every 3 seconds
    setInterval(function() {
        $.fn.toNextSlide();
    }, 5000);
});
</script>

<div id="myimage" class="bgded" style="background-image:url('images/background/br1.jpg');">
    <div class="wrapper overlay">
        <article id="pageintro" class="hoc clear">
            <h3 class="heading">JADON Event Management Services</h3>
            <p>Our experience over the years allows us to provide efficient, economical service,
                so that your event can occur on time and on budget. Customer service is Our number
                one priority, and we stand ready to provide You with the finest equipment in the industry.
                Delivered when you want it, when you need it, seven days a week, twenty-four hours a day!</p>
            <a href="#mainContent" class="btn">See more!</a>
        </article>
    </div>
</div>
<!-- End Top Background Image Wrapper -->


<div class="wrapper row3" id="mainContent">
    <!-- Start slideshow -->
    <div class="slideshow-container">
        <?php $num_row = mysqli_num_rows($categories);
    while ($category = mysqli_fetch_array($categories)) { ?>
        <div class="wrapper bgded mySlides"
            style="background-image:url('images/category/<?= $category['image'] ?>'); width: 100%; height: 90%;">
            <div class="hoc split clear">
                <section>
                    <h2 class="heading"><?= $category['name'] ?></h2>
                    <ul class="nospace group elements">
                        <li>
                            <article><a href="#"><i class="fa fa-wpexplorer"></i></a>
                                <p><?= $category['description'] ?></p>
                            </article>
                        </li>
                    </ul>
                </section>
            </div>
        </div>
        <?php } ?>
        <p style="padding:3px;"></p>
        <!-- Left right buttons -->
        <a class="prev fa fa-chevron-left"></a>
        <a class="next fa fa-chevron-right"></a>
    </div>
    <!-- The dots/circles -->
    <div style="text-align:center">
        <?php for ($i = 0; $i < $num_row; $i++) { ?>
        <span class="dot <?= $i == 0 ? 'activeDot' : '' ?>"></span>
        <?php } ?>
    </div>
    <!-- End slideshow -->
</div>
<div class="wrapper row3">
    <section class="hoc container clear">
        <div class="sectiontitle">
            <h6 class="heading">Here are some events that we has just organized!</h6>
        </div>
        <div class="group latest">
            <?php $count = 0;
      while ($organized_event = mysqli_fetch_array($organized_events)) {
        $count++; ?>
            <article class="one_quarter <?= $count == 1 ? 'first' : '' ?>">
                <figure>
                    <a href="#"><img src="images/organized_events/<?= $organized_event['image']?>"
                            alt="Event image"></a>
                    <figcaption>
                        <time datetime="<?= $organized_event['date'] ?>">
                            <strong><?= date("d", strtotime($organized_event['date'])) ?></strong>
                            <em><?= date("M", strtotime($organized_event['date'])) ?></em>
                        </time>
                    </figcaption>
                </figure>
                <div class="txtwrap">
                    <h4 class="heading"><?= $organized_event['category_name'] ?></h4>
                    <ul class="nospace meta">
                        <li><i class="fa fa-user"></i> <a href="#"><?= $organized_event['staff'] ?></a></li>
                        <li><i class="fa fa-tag"></i> <a href="#"><?= $organized_event['theme_name'] ?></a></li>
                    </ul>
                    <?php for ($i = 0, $n = count($reviews_array); $i < $n; $i++) {
							                if ($reviews_array[$i]['id'] == $organized_event['review_id']) { ?>
                    <li>
                        <div class="container">
                            <div id="review<?= $organized_event['id'] ?>" class="collapse">
                                <p>From: <?= $organized_event['name'] ?>, <?= $reviews_array[$i]['content'] ?> </p>
                            </div>
                            <a href="#review<?=  $organized_event['id'] ?>" aria-expanded="false"
                                data-toggle="collapse">See
                                More &raquo;</a>
                        </div>
                    </li>
                    <?php } }?>

                </div>
            </article>
            <?php } ?>
        </div>
        <div class="clear"></div>
    </section>
</div>
<div id="myimage" class="wrapper bgded overlay" style="background-image:url( 'images/background/br6.jpg');">
    <div id="myimage2" class="hoc container testimonials clear ">
        <article><img src="images/background/br8.jpg" height="50" alt="">
            <blockquote>CEO of JADON event management service, Inc</blockquote>
            <h6 class="heading">Admin</h6>
        </article>
    </div>
</div>
<div class="wrapper row3">
    <main class="hoc container clear">
        <div class="sectiontitle">
            <h6 class="heading">What does the press say about us?</h6>
        </div>
        <!-- main body -->
        <div class="group">
            <div class="one_half first">
                <h6 class="heading"><b>The New York Times</b></h6>
                <p>We will definitely use JADON event management services for our next event and will highly recommend
                    them to others. It was such a no-fuss experience and
                    very refreshing to patronize a business with such professionalism.</p>
            </div>
            <div class="one_half">
                <ul class="nospace group">
                    <li class="one_half first btmspace-50">
                        <article>
                            <h6 class="heading font-x1"><b>The Washington Post</b></h6>
                            <p class="nospace">We will recommend JADON event management services for a better experience
                                for your event.
                                With professionals and enthusiasm, they can give you the best event ever.</p>
                        </article>
                    </li>
                    <li class="one_half btmspace-50">
                        <article>
                            <h6 class="heading font-x1"><b>The Wall Street Journal.</b></h6>
                            <p class="nospace">9/10 for quality with affordable price, friendly staffs and more!</p>
                        </article>
                    </li>
                </ul>
            </div>
        </div>
        <!-- / main body -->
        <div class="clear"></div>
    </main>
</div>
<?php
require_once "pages/staff.php";
?>
<style>
#myimage {
    filter: brightness(200%);
}

#myimage2 {
    filter: brightness(50%);
}
</style>