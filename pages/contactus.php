<?php

$categories = mysqli_query($con, "select * from category_event");

// get information about three newest events
$organized_events = mysqli_query($con, "
select oe.date as date, oe.staff as staff, ce.name as category_name, event.event_name as theme_name, user.user_name as name, review.content as review, oe.image as image
from organized_events oe, category_event ce, user, event, review
where oe.user_id = user.id and oe.event_id = event.id and oe.event_id_category = ce.event_id and review.id = oe.review_id
order by oe.date desc limit 3
");
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
        // change slide every 3 seconds
        setInterval(function() {
            $.fn.toNextSlide();
        }, 4000);
    });
</script>
<div class="bgded" style="background-image:url('images/background/br3.jpg');">
    <div class="wrapper overlay">
        <div id="breadcrumb" class="hoc clear">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#">Contact us</a></li>
            </ul>
        </div>
    </div>
</div>
<div>
    <div class="contactUs">
        <br><br>
        <span class="title">CONTACT US</span>
        <br>
        <div class="row content">
            <div class="col-md-6">
                <!-- Start slideshow -->
                <div class="slideshow-container">
                    <?php $num_row = mysqli_num_rows($categories);
                    while ($category = mysqli_fetch_array($categories)) { ?>
                        <div class="wrapper bgded mySlides" style="background-image:url('images/category/<?= $category['image'] ?>'); height:400px;">
                            <div class="hoc split clear">
                            </div>
                        </div>
                    <?php } ?>
                    <p style="padding:5px;"></p>

                </div>
                <!-- The dots/circles -->
                <div style="text-align:center; height:20px">
                    <?php for ($i = 0; $i < $num_row; $i++) { ?>
                        <span style="width:10px;height:10px;margin-bottom:20px;margin-top:-5px;" class="dot <?= $i == 0 ? 'activeDot' : '' ?>"></span>
                    <?php } ?>
                </div>
                <!-- End slideshow -->
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-1">
                        <h4>
                            <i class="fa fa-map-marker" aria-hidden="true" style="color:#FF6347;"></i>
                        </h4>
                    </div>
                    <div class="col-md-11 ">
                        <h4>
                            JADON Event Services
                        </h4>

                        Address:24-26 Phan Liem street
                        ward Da Kao,district 1<br />
                        Tel:<a href="tel:001234567890">001234567890</a><br />
                        Mail:<a href="mailto:huynguyenquang151@gmail.com">huynguyenquang151@gmail.com</a><br>

                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        <h4>
                            <i class="fa fa-credit-card" aria-hidden="true" style="color:orange;"></i>
                        </h4>
                    </div>
                    <div class="col-md-11">
                        <h4><span>Connect</span></h4>
                        <ul class="faico clear">
                            <li><a class="faicon-facebook" href="https://www.facebook.com/callmeNguyenHuy" target="_blank"><i class="fa fa-facebook" style="margin-top:10px;"></i></a></li>
                            <li><a class="faicon-twitter" href="https://twitter.com/Huy50094824" target="_blank"><i class="fa fa-twitter" style="margin-top:10px;"></i></a></li>
                            <li><a class="faicon-google-plus" href="https://mail.google.com/mail/u/0/?tab=mm#inbox" target="_blank"><i class="fa fa-google-plus" style="margin-top:10px;"></i></a></li>
                        </ul>
                        <br><br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        <h4>
                            <i class="fa fa-usd" aria-hidden="true" style="color:#6495ED;"></i>
                        </h4>
                    </div>
                    <div class="col-md-11">
                        <h4>
                            <span>Payment Accepted</span>
                        </h4>
                        <div>American Express, Cash, Check, Discover, Mastercard, Visa
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>