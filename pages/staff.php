<?php
$staffs = mysqli_query($con, "select * from staff where id < 4");
?>
<style>
    .staff ul {
        list-style-type: none;
        text-align: center;
    }

    .staff li {
        display: inline-block;
        width: 25%;
        line-height: 40px;
        margin-left: 40px;
        margin-right: 40px;
    }

    .staff li img {
        width: 100%;
        height: 250;
    }

    .staff li:hover {
        transform: scale(1.1);
    }

    @media screen and (max-width: 650px) {
        .staff li {
            width: 100%;
            display: block;
        }
    }

    .staff p {
        text-align: left;
        margin-left: 20px;
    }

    .card {
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }
</style>
<!-- Start slideshow -->
<div id="myimage" class="wrapper bgded overlay" style="background-image:url( 'images/background/br3.jpg');">
    <div id="myimage2" class="staff" style='background-image:url("images/staff/staff.jpg");'>
        <ul>
            <?php $num_row = mysqli_num_rows($staffs);
            while ($staff = mysqli_fetch_array($staffs)) { ?>
                <li>
                    <div class="card">
                        <img <?= 'src="images/staff/' . $staff['image'] . '"' ?>>
                        <div class="container_content">
                            <h2 style="color:black;"><strong><?= $staff['name'] ?></strong></h2>
                            <p style="color:grey;"><?= $staff['position'] ?></p>
                            <p style="color:black;"><?= $staff['description'] ?></p>
                            <p><?= $staff['email'] ?></p>
                        </div>
                    </div>
                </li>
            <?php } ?>

        </ul>
    </div>
</div>