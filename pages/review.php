<?php
$categories = mysqli_query($con, 'select event_id, name from category_event');
$categories_array = array();
while ($category = mysqli_fetch_array($categories)) {
  array_push($categories_array, $category);
}
?>
<script>
$(document).ready(function() {
    $('input.addForm').click(function() {});
    //add content
    $("form.addForm").submit(function(review) {
        var reviewInfor = $(this).serializeArray(); //lay va ma hoa cac thanh phan form thanh mang
        $("form.addForm").trigger("reset"); // reset value in form
        review.preventDefault(); // stop form from sending data
        var user_name = reviewInfor[0].value;
        var event_id = reviewInfor[1].value;
        var content = reviewInfor[2].value;

        $.ajax({
            type: "GET",
            dataType: 'json',
            contentType: 'application/json',
            url: 'pages/review_ajax.php',
            data: {
                action: "addReview",
                user_name: user_name,
                event_id: event_id,
                content: content,
            },
            success: function(result) {
                var r = '';
                for (var i = 0; i < 5; ++i) {
                    r += '<ul>';
                    r += '<li>';
                    r += '<article>';
                    r += '<header>';
                    r += '<address>';
                    r += 'By:';
                    r += result[i].user_name + '<br>';
                    r += 'About event:' + result[i].category_name;
                    r += '</address>';
                    r += '<time>' + result[i].date + '</time>';
                    r += '</header>';
                    r += '<div class="comcont">'
                    r += '<p>' + result[i].content + '</p>';
                    r += '</div>'
                    r += '</article>';
                    r += '</li>';
                    r += '</ul>';
                }
                $('.contents').html(r);
            }

        });
    });

    $.ajax({
        type: 'GET',
        dataType: 'json',
        contentType: 'application/json',
        url: 'pages/review_ajax.php',
        success: function(result) {
            var r = '';
            for (var i = 0; i < 5; i++) {
                r += '<ul>';
                r += '<li>';
                r += '<article>';
                r += '<header>';
                r += '<address>';
                r += 'By:';
                r += result[i].user_name + '<br>';
                r += 'About event:' + result[i].category_name;
                r += '</address>';
                r += '<time>' + result[i].date + '</time>';
                r += '</header>';
                r += '<div class="comcont">'
                r += '<p>' + result[i].content + '</p>';
                r += '</div>'
                r += '</article>';
                r += '</li>';
                r += '</ul>';

            }
            $('.contents').html(r);
        }
    });
});
</script>
<!-- Top Background Image Wrapper -->
<div class="bgded" style="background-image:url('images/background/br9.jpg');">
    <div class="wrapper overlay">
        <div id="breadcrumb" class="hoc clear">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#">Review</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- End Top Background Image Wrapper -->

<div class="wrapper row3">
    <main class="hoc container clear">
        <!-- main body -->
        <!-- ################################################################################################ -->
        <div class="content">
            <!-- ################################################################################################ -->
            <div id="comments">
                <h2>Comments</h2>
                <div class="contents"></div>
                <h2>Write A Comment</h2>
                <tr>
                    <td colspan="5" class="addForm">
                        <form class="addForm">
                            <div class="form-group">
                                <label class="bmd-label-static">User Name</label>
                                <input type="text" class="form-control" name="user_name" required>
                            </div>
                            <div class="form-group">
                                <label class="bmd-label-static">Category Name</label>
                                <select class="custom-select" name="category">
                                    <?php for ($i = 0, $n = count($categories_array); $i < $n; $i++) { ?>
                                    <option value="<?= $categories_array[$i]['event_id'] ?>">
                                        <?= $categories_array[$i]['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
            </div>
            <div class="form-group">
                <label class="bmd-label-static">Comment</label>
                <input type="text" class="form-control" name="content" required>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="submit" style="background-color:6edef4;">
                <input type="reset" class="btn btn-primary addForm" value="reset" style="background-color:6edef4;">
                <input type="hidden" name="action" value="addReview">
            </div>
            </form>
            </td>
            </tr>
        </div>
</div>
</main>
</div>
<style>
    .bgded{
        height : 500px;  
    }
</style>