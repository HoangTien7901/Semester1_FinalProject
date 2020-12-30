                    <?php
                    require 'connect.php';
                    $sql = "SELECT event_id, name FROM category_event";
                    $categories = mysqli_query($con, $sql);
                    ?>

<!-- Top Background Image Wrapper -->
<div id="imagegallery" class="bgded" style="background-image:url('images/background/br3.jpg');">
    <div class="wrapper overlay">
        <div id="breadcrumb" class="hoc clear">
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="#">Gallery</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- End Top Background Image Wrapper -->

<div class="wrapper row3">
    <main class="hoc container clear">
        <!-- main body -->

        <div class="content">
            <div class="child-page-listing">
                <?php foreach($categories as $category) { ?>
                <br>
                <h2><?=$category['name']?></h2>
                <div class="grid-container">
                    <?php 
                    $sql = "SELECT image_name FROM gallery WHERE category_id = ". $category['event_id'] ;
                    $images = mysqli_query($con, $sql);
                    foreach($images as $image) { ?>
                    <article class="location-listing">
                        <div class="location-image">
                            <a href="<?='images/Gallery1/'.$image['image_name']?>" target="_blank"><img class="img" <?='src="images/Gallery1/'.$image['image_name'].'"'; ?>></a>
                        </div>
                    </article>
                    <?php } ?>
                </div>
                <br>
                    <?php }?>
                <!-- end grid container -->
            </div>
        </div>
        <!-- / main body -->
        <div class="clear"></div>
    </main>
</div>
<style>
.img {
    width: 100%;
    /* need to overwrite inline dimensions */
    height: 180px;
}

h2 {
    margin-bottom: .5em;
}

.grid-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
    grid-gap: 1em;
}

#imagegallery{
    filter: brightness(130%);
}
</style>
