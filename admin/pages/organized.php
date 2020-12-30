<?php
// category list for select
$categories = mysqli_query($con, 'select event_id as id, name from category_event');
$categories_array = array();
while ($category = mysqli_fetch_array($categories)) {
  array_push($categories_array, $category);
}

// event list for select
$events = mysqli_query($con, 'select id, event_name, event_id_category as category_id from event');
$events_array = array();
while ($event = mysqli_fetch_array($events)) {
  array_push($events_array, $event);
}

// user list for select
$users = mysqli_query($con, 'select id, user_name from user');
$users_array = array();
while ($user = mysqli_fetch_array($users)) {
  array_push($users_array, $user);
}

// review list for select
$reviews = mysqli_query($con, 'select id, content from review');
$reviews_array = array();
while ($review = mysqli_fetch_array($reviews)) {
  array_push($reviews_array, $review);
}

// staff list for select
$staffs = mysqli_query($con, 'select id, name from staff');
$staffs_array = array();
while ($staff = mysqli_fetch_array($staffs)) {
  array_push($staffs_array, $staff);
}

if (isset($_POST['action'])) {
  if ($_POST['action'] == 'add') {
    $categoryId = $_POST['category'];
    $themeId = $_POST['theme'];

    $userId = $_POST['user'];
    // $target_user = mysqli_query($con, 'select user_name from user where id = ' . $userId);
    // $user = mysqli_fetch_array($target_user);
    // $user_name = $user['user_name'];

    $reviewId = $_POST['review'];

    $date =  date('Y-m-d', strtotime($_POST['date']));
    $staffId = $_POST['staff'];

    $error = "";
    $target_dir = "../images/organized_events/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $img_name = basename($_FILES["image"]["name"]);

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
      $check = getimagesize($_FILES["image"]["tmp_name"]);
      if ($check !== false) {
        $uploadOk = 1;
      } else {
        $error .= "File is not an image.\\n";
        $uploadOk = 0;
      }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
      $error .= "File already exists.\\n";
      $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 1024 * 1024 * 5) {
      $error .= "Your file is too large (larger than 5MB).\\n";
      $uploadOk = 0;
    }

    // Allow certain file formats
    if (
      $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif"
    ) {
      $error .= "Only JPG, JPEG, PNG & GIF files are allowed.\\n";
      $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      $error .= "Sorry, your image was not uploaded.";
      echo "<script>alert('" . $error . "')</script>";
      // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        if (mysqli_query($con, '
          insert into organized_events(event_id, event_id_category, image, user_id, review_id, date, staff_id)
          values(' . $themeId . ',' . $categoryId . ',"' . $img_name . '",' . $userId . ',' . $reviewId . ',"' . $date . '",' . $staffId . ')
          ')) {
          echo "<script>alert('Update success.\\n')</script>";
        } else {
          // delete trash value
          unlink($target_file);

          echo "<script>alert('Sorry, there was an error updating database.\\n')</script>";
        }
      } else {
        echo "<script>alert('Sorry, there was an error uploading your file.\\n')</script>";
      }
    }
  }

  if ($_POST['action'] == 'change') {
    $id = $_POST['id'];
    $categoryId = $_POST['category'];
    $themeId = $_POST['theme'];
    $userId = $_POST['user'];
    $reviewId = $_POST['review'];
    $date =  date('Y-m-d', strtotime($_POST['date']));
    $staffId = $_POST['staff'];

    // check if admin upload a new image
    if ($_FILES["image"]['name']) {
      $error = "";
      $target_dir = "../images/organized_events/";
      $target_file = $target_dir . basename($_FILES["image"]["name"]);
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
      $img_name = basename($_FILES["image"]["name"]);

      // Check if image file is a actual image or fake image
      if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
          $uploadOk = 1;
        } else {
          $error .= "File is not an image.\\n";
          $uploadOk = 0;
        }
      }

      // Check file size
      if ($_FILES["image"]["size"] > 1024 * 1024 * 5) {
        $error .= "Your file is too large (larger than 5MB).\\n";
        $uploadOk = 0;
      }

      // Allow certain file formats
      if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
      ) {
        $error .= "Only JPG, JPEG, PNG & GIF files are allowed.\\n";
        $uploadOk = 0;
      }
    } else {
      $uploadOk = 1;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      $error .= "Sorry, your image was not uploaded.";
      echo "<script>alert('" . $error . "')</script>";
      // if everything is ok, try to upload file
    } else {
      if ($_FILES["image"]['name']) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
          if (mysqli_query($con, '
          update organized_events
          set
          event_id = ' . $themeId . ', event_id_category = ' . $categoryId . ', image = "' . $img_name . '",
          user_id=' . $userId . ', review_id=' . $review_id . ', date="' . $date . '", staff_id = ' . $staffId . '
          where id = ' . $id)) {
            echo "<script>alert('Update success.\\n')</script>";
          } else {
            unlink($target_file);
            echo "<script>alert('Sorry, there was an error updating database.\\n')</script>";
          }
        } else {
          echo "<script>alert('Sorry, there was an error uploading your file.\\n')</script>";
        }
      } else {
        if (mysqli_query($con, '
          update organized_events
          set
          event_id = ' . $themeId . ', event_id_category = ' . $categoryId . ',
          user_id=' . $userId . ', review_id=' . $reviewId . ', date="' . $date . '", staff_id = ' . $staffId . '
          where id = ' . $id)) {
          echo "<script>alert('Update success.\\n')</script>";
        } else {
          echo "<script>alert('Sorry, there was an error updating database.\\n')</script>";
        }
      }
    };
  }

  if ($_POST['action'] == 'delete') {
    $id = $_POST['id'];

    // get review id and image name
    $target_row = mysqli_query($con, 'select * from organized_events where id = ' . $id);
    $target = mysqli_fetch_array($target_row);
    $image_name = $target['image'];
    $review_id = $target['review_id'];
    if (isset($image_name)) {
      unlink('../images/organized_events/' . $image_name);
    }

    if (
      mysqli_query($con, 'delete from review where id = ' . $review_id) &&
      mysqli_query($con, 'delete from organized_events where id = ' . $id)
    ) {
    } else {
      echo "<script>alert('Sorry, there was an error deleting database.')</script>";
    }
  }
}
?>

<script>
  $(document).ready(function() {
    // toggle add form
    $('button.addForm, input.addForm').click(function() {
      $('td.addForm').toggle();
      if ($('td.changeForm').css("display") != "none") {
        $('td.changeForm').toggle();
      }
    });

    // toggle change form
    $('button.changeForm, input.changeForm').click(function() {
      $('td.changeForm').toggle();
    });

    // change theme option base on selected category
    $("form select[name=category]").change(function() {
      var categoryId = $(this).children("option:selected").val();
      $.ajax({
        type: 'GET',
        url: 'pages/organized_ajax.php',
        dataType: 'json',
        contentType: 'application/json',
        data: {
          action: 'changeCategory',
          categoryId: categoryId
        },
        success: function(result) {
          r = '';
          for ($i = 0, $n = result.length; $i < $n; $i++) {
            r += '<option value=' + result[$i]['id'] + '>' + result[$i]['event_name'] + '</option>';
          }
          $('form select[name=theme]').html(r);
        }
      });
    });

    $.fn.change = function(value) {
      if ($('td.changeForm').css("display") == "none") {
        $('td.changeForm').toggle();
        if ($('td.addForm').css("display") != "none") {
          $('td.addForm').toggle();
        }
      }
      var id = value;
      var categoryId = $("#" + id).children('td[data-target=category]').attr('data-id');
      var themeId = $("#" + id).children('td[data-target=theme]').attr('data-id');
      var image = $("#image" + id).attr("src");
      var userId = $("#" + id).children('td[data-target=user]').attr('data-id');
      var reviewId = $("#" + id).children('td[data-target=review]').attr('data-id');
      var date = $("#" + id).children('td[data-target=date]').text();
      var staffId = $("#" + id).children('td[data-target=staff]').attr('data-id');
      $('form.changeForm input[name="id"]').val(id);
      $('form.changeForm select[name=category]').val(categoryId);
      $('form.changeForm select[name=theme]').val(themeId);
      $('#reviewImg').attr("src", image);
      $('form.changeForm select[name=user]').val(userId);
      $('form.changeForm select[name=review]').val(reviewId);
      $('form.changeForm input[name="date"]').val(date);
      $('form.changeForm select[name=staff]').val(staffId);
    };

    $.fn.getData = function() {
      $.ajax({
        url: 'pages/organized_ajax.php',
        dataType: 'json',
        contentType: 'application/json',
        success: function(result) {
          var r = '';
          for (var i = 0; i < result.length; ++i) {
            r += '<tr id="' + result[i].id + '">';
            r += '<td>' + parseInt(i + 1) + '</td>';
            r += '<td data-target="category" data-id="' + result[i].category_id + '">' + result[i].category_name + '</td>';
            r += '<td data-target="theme" data-id="' + result[i].theme_id + '">' + result[i].event_name + '</td>';
            r += '<td><a href="../images/organized_events/' + result[i].image + '" target="_blank"><image id="image' + result[i].id + '" src="../images/organized_events/' + result[i].image + '" width="120" height="80" title="Click to see full image"></a></td>';
            r += '<td data-target="user" data-id="' + result[i].user_id + '">' + result[i].user_name + '</td>';
            r += '<td data-target="review" data-id="' + result[i].review_id + '">' + result[i].review + '</td>';
            r += '<td data-target="date">' + result[i].date + '</td>';
            r += '<td data-target="staff" data-id="' + result[i].staff_id + '">' + result[i].staff + '</td>';
            r += '<td>';
            r += '<form method="post" id="delete' + result[i].id + '">';
            r += '<input type="hidden" name="action" value="delete">';
            r += '<input type="hidden" name="id" value="' + result[i].id + '">';
            r += '<input type="submit" value="delete" class="btn btn-outline-primary btn-sm" onclick="return confirm(\'Are you sure?\')">';
            r += '</form>';
            r += '<input type="button" class="btn btn-outline-primary btn-sm" value="Change" onclick="$.fn.change(' + result[i].id + ');$.fn.scrollDown()">';
            r += '</td>';
            r += '</tr>';
          }
          $('tbody').html(r);
        }
      });
    };

    $.fn.getData();
  });
</script>

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title">Organized Events</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead class="text-primary">
                  <th width="5%">ID</th>
                  <th width="7.5%">Category</th>
                  <th width="7.5%">Theme</th>
                  <th width="17.5%">Image</th>
                  <th width="5%">User</th>
                  <th width="22.5%">Review</th>
                  <th width="15%">Date</th>
                  <th width="10%">Staff</th>
                  <th width="10%">Action</th>
                </thead>

                <tbody>
                </tbody>

                <tfoot>
                  <!-- Add button -->
                  <tr align="center">
                    <td colspan="20">
                      <button type="button" class="btn btn-primary addForm" onclick="$.fn.scrollDown()">Add organized event</button>
                    </td>
                  </tr>
                  <!-- Add form -->
                  <tr>
                    <td colspan="20" class="addForm" style="display:none;">
                      <span><b>Input information of new organized event :</b></span>
                      <p></p>
                      <form class="addForm" method="post" action="#" enctype="multipart/form-data">
                        <div class="form-group">
                          <label class="bmd-label-floating">Category</label>
                          <select class="custom-select" name="category">
                            <?php for ($i = 0, $n = count($categories_array); $i < $n; $i++) { ?>
                              <option value="<?= $categories_array[$i]['id'] ?>"><?= $categories_array[$i]['name'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <hr>
                        <div class="form-group">
                          <label class="bmd-label-floating">Theme</label>
                          <select class="custom-select" name="theme">
                            <?php for ($i = 0, $n = count($events_array); $i < $n; $i++) { ?>
                              <option value="<?= $events_array[$i]['id'] ?>"><?= $events_array[$i]['event_name'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <label class="bmd-label-floating">Image</label>
                        <br>
                        <input class="custom-file-input" type="file" style="opacity:1;" accept="image/x-png,image/jpg,image/jpeg" name="image" required>
                        <hr>
                        <div class="form-group">
                          <label class="bmd-label-floating">User</label>
                          <select class="custom-select" name="user">
                            <?php for ($i = 0, $n = count($users_array); $i < $n; $i++) { ?>
                              <option value="<?= $users_array[$i]['id'] ?>"><?= $users_array[$i]['user_name'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label class="bmd-label-floating">Review</label>
                          <select class="custom-select" name="review">
                            <?php for ($i = 0, $n = count($reviews_array); $i < $n; $i++) { ?>
                              <option value="<?= $reviews_array[$i]['id'] ?>"><?= $reviews_array[$i]['id'] ?>. <?= $reviews_array[$i]['content'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label class="bmd-label-floating">Date</label>
                          <input type="date" class="form-control" name="date" required>
                        </div>
                        <div class="form-group">
                          <label class="bmd-label-floating">Staff</label>
                          <select class="custom-select" name="staff">
                            <?php for ($i = 0, $n = count($staffs_array); $i < $n; $i++) { ?>
                              <option value="<?= $staffs_array[$i]['id'] ?>"><?= $staffs_array[$i]['name'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <input type="submit" class="btn btn-primary" value="submit">
                        <input type="reset" class="btn btn-primary addForm" value="close">
                        <input type="hidden" name="action" value="add">
                      </form>
                    </td>
                  </tr>
                  <!-- End add form -->

                  <!-- Change form -->
                  <tr>
                    <td colspan="20" class="changeForm" style="display:none;">
                      <span><b>Change information of this organized event :</b></span>
                      <p></p>
                      <form class="changeForm" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                          <label class="bmd-label-floating">Category</label>
                          <select class="custom-select" name="category">
                            <?php for ($i = 0, $n = count($categories_array); $i < $n; $i++) { ?>
                              <option value="<?= $categories_array[$i]['id'] ?>"><?= $categories_array[$i]['name'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <hr>
                        <div class="form-group">
                          <label class="bmd-label-floating">Theme</label>
                          <select class="custom-select" name="theme">
                            <?php for ($i = 0, $n = count($events_array); $i < $n; $i++) { ?>
                              <option value="<?= $events_array[$i]['id'] ?>"><?= $events_array[$i]['event_name'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <label class="bmd-label-floating">Current image</label>
                        <br>
                        <image src="" id="reviewImg" width="300" height="200" name="image"></image>
                        <p></p>
                        <label class="bmd-label-floating">Choose new image</label>
                        <br>
                        <input class="custom-file-input" type="file" style="opacity:1;" accept="image/x-png,image/jpg,image/jpeg" name="image">
                        <hr>
                        <div class="form-group">
                          <label class="bmd-label-floating">User</label>
                          <select class="custom-select" name="user">
                            <?php for ($i = 0, $n = count($users_array); $i < $n; $i++) { ?>
                              <option value="<?= $users_array[$i]['id'] ?>"><?= $users_array[$i]['user_name'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label class="bmd-label-floating">Review</label>
                          <select class="custom-select" name="review">
                            <?php for ($i = 0, $n = count($reviews_array); $i < $n; $i++) { ?>
                              <option value="<?= $reviews_array[$i]['id'] ?>"><?= $reviews_array[$i]['id'] ?>. <?= $reviews_array[$i]['content'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label class="bmd-label-floating">Date</label>
                          <input type="date" class="form-control" name="date" required>
                        </div>
                        <div class="form-group">
                          <label class="bmd-label-floating">Staff</label>
                          <select class="custom-select" name="staff">
                            <?php for ($i = 0, $n = count($staffs_array); $i < $n; $i++) { ?>
                              <option value="<?= $staffs_array[$i]['id'] ?>"><?= $staffs_array[$i]['name'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <input type="hidden" name="id">
                        <input type="hidden" name="action" value="change">
                        <input type="submit" class="btn btn-primary" value="submit">
                        <input type="reset" class="btn btn-primary changeForm" value="Close">
                      </form>
                    </td>
                  </tr>
                  <!-- End change form -->
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>