<?php
$categories = mysqli_query($con, "select * from category_event");
$events = mysqli_query($con, "select * from event");
$events_array = array();
while ($event = mysqli_fetch_array($events)) {
    array_push($events_array, $event);
}
?>
<div id="myimage" class="bgded" style="background-image:url('images/background/br3.jpg');">
    <div class="wrapper overlay">
        <div id="breadcrumb" class="hoc clear">
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="#">Events</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="wrapper row3">
    <section class="hoc container clear">
        <div class="">
            <br>
            <h6 class="heading" align="center">Our events</h6>
            <p>
                With different themes for each event, we always offer advice based on your venue or event type, place an
                emphasis on providing the highest level
                of customer service, and always strive to do things the right way.
            </p>
        </div>
    </section>
</div>
<?php while ($category = mysqli_fetch_array($categories)) { ?>
<div class="wrapper row3" id="event<?= $category['event_id'] ?>">
    <div class="wrapper bgded"
        style="background-image:url('images/category/<?= $category['image'] ?>'); width: 100%; height: 100%;">
        <div class="hoc split clear">
            <section style="height:100%;">
                <h2 class="heading"><?= $category['name'] ?></h2>
                <?php for ($i = 0, $n = count($events_array); $i < $n; $i++) {
                        if ($events_array[$i]['event_id_category'] == $category['event_id']) { ?>
                <ul class="nospace group elements" style="margin-bottom:20px;">
                    <li>
                        <article>
                            <h1><?= $events_array[$i]['event_name'] ?></h1>
                            <p><?= $events_array[$i]['description'] ?></p>
                            <p><strong>Cost:</strong> <?= $events_array[$i]['cost'] ?> $</p>

                        </article>
                    </li>
                </ul>
                <?php }
                    } ?>
            </section>
        </div>
    </div>
</div>
<?php } ?>