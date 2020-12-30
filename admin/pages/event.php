<?php
if (isset($_POST['action'])) {
  if ($_POST['action'] == "add") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $categoryId = $_POST['category'];
    $cost = $_POST['cost'];

    $error = "";
    $target_dir = "../images/events/";
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
        if (
          mysqli_query(
            $con,
            'insert into event(event_name, event_id_category, description, image, cost)
          values("' . $name . '",' . $categoryId . ',"' . $description . '","' . $img_name . '",' . $cost . ')'
          )
        ) {
          echo "<script>alert('Update success.\\n')</script>";
        } else {
          echo "<script>alert('Sorry, there was an error updating database.\\n')</script>";
        }
      } else {
        echo "<script>alert('Sorry, there was an error uploading your image.\\n')</script>";
      }
    }
  }

  if ($_POST['action'] == "delete") {
    $id = $_POST['id'];
    $target = mysqli_fetch_array(mysqli_query($con, 'select * from event where id = ' . $id));

    if (is_file('../images/events/' . $target['image'])) {
      unlink('../images/events/' . $target['image']);
    }

    if (mysqli_query($con, 'delete from event where id = ' . $id)) {
      echo "<script>alert('Update success.')</script>";
    } else {
      echo "<script>alert('Sorry, there was an error deleting database.\\n')</script>";
    }
  }

  if ($_POST['action'] == "change") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $categoryId = $_POST['category'];
    $description = $_POST['description'];
    $cost = $_POST['cost'];

    // check if user upload a new image
    if ($_FILES["image"]["name"]) {
      $error = "";
      $target_dir = "../images/events/";
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
      if ($_FILES["image"]["name"]) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
          if (
            mysqli_query($con, 'update event
		      set
		      event_name ="' . $name . '", description="' . $description . '", cost=' . $cost . ', event_id_category=' . $categoryId . ', image = "' . $img_name . '"
          where id=' . $id)
          ) {
            echo "<script>alert('Update success.\\n')</script>";
          } else {
            echo "<script>alert('Sorry, there was an error updating database.\\n')</script>";
          }
        } else {
          echo "<script>alert('Sorry, there was an error uploading your image.\\n')</script>";
        }
      } else {
        if (
          mysqli_query($con, 'update event
		      set
		      event_name ="' . $name . '", description="' . $description . '", cost=' . $cost . ', event_id_category=' . $categoryId . '
          where id=' . $id)
        ) {
          echo "<script>alert('Update success.\\n')</script>";
        } else {
          echo "<script>alert('Sorry, there was an error updating database.\\n')</script>";
        }
      }
    }
  }
}

// category list for select
$categories = mysqli_query($con, 'select event_id, name from category_event');
$categories_array = array();
while ($category = mysqli_fetch_array($categories)) {
  array_push($categories_array, $category);
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

    $.fn.change = function(value) {
      if ($('td.changeForm').css("display") == "none") {
        $('td.changeForm').toggle();
        if ($('td.addForm').css("display") != "none") {
          $('td.addForm').toggle();
        }
      }
      var id = value;
      var name = $("#" + id).children('td[data-target=name]').text();
      var description = $("#" + id).children('td[data-target=description]').text();
      var categoryId = $("#" + id).children('td[data-target=eventname]').attr('data-categoryId');
      var image = $("#image" + id).attr("src");
      var cost = $("#" + id).children('td[data-target=cost]').text();
      $('form.changeForm input[name="id"]').val(id);
      $('form.changeForm input[name="name"]').val(name);
      $('form.changeForm input[name="description"]').val(description);
      $('form.changeForm select').val(categoryId);
      $('#reviewImg').attr("src", image);
      $('form.changeForm input[name="cost"]').val(cost);
    };

    $.ajax({
      type: 'GET',
      dataType: 'json',
      contentType: 'application/json',
      url: 'pages/event_ajax.php',
      success: function(result) {
        var r = '';
        for (var i = 0; i < result.length; i++) {
          r += '<tr id="' + result[i].id + '">';
          r += '<td>' + parseInt(i + 1) + '</td>';
          r += '<td data-target="name">' + result[i].name + '</td>';
          r += '<td data-target="eventname" data-categoryId="' + result[i].category_id + '">' + result[i].event_name + '</td>';
          r += '<td data-target="description">' + result[i].description + '</td>';
          r += '<td><image id="image' + result[i].id + '" src="../images/events/' + result[i].image + '" width="100" height="60" title="Event image"></td>';
          r += '<td data-target="cost">' + result[i].cost + '</td>';
          r += '<td>';
          r += '<form method="post">';
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
  });
</script>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Event</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead class=" text-primary">
                  <th>ID</th>
                  <th>Name</th>
                  <th>Category</th>
                  <th>Description</th>
                  <th>Image</th>
                  <th>Cost</th>
                  <th>Action</th>
                </thead>
                <tbody></tbody>
                <tfoot>
                  <!-- Add button -->
                  <tr align="center">
                    <td colspan="20">
                      <button type="button" class="btn btn-primary addForm" onclick="$.fn.scrollDown()">Add event</button>
                    </td>
                  </tr>
                  <!-- Add form -->
                  <tr>
                    <td colspan="20" class="addForm" style="display:none;">
                      <span><b>Input information of new event :</b></span>
                      <p></p>
                      <form class="addForm" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                          <label class="bmd-label-floating">Event name</label>
                          <input type="text" pattern="^[-a-zA-Z-()]+(\s+[-a-zA-Z-()]+)*$" minlength="2" title="Event name has 2 or more characters and has no special characters or number" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                          <label class="bmd-label-floating">Category name</label>
                          <select class="custom-select" name="category">
                            <?php for ($i = 0, $n = count($categories_array); $i < $n; $i++) { ?>
                              <option value="<?= $categories_array[$i]['event_id'] ?>"><?= $categories_array[$i]['name'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label class="bmd-label-floating">Description</label>
                          <input type="text" pattern="^[-a-zA-Z0-9-&/\.'()]+(\s+[-a-zA-Z0-9-&/\.'()]+)*$" minlength="4" class="form-control" name="description" required>
                        </div>
                        <label class="bmd-label-floating">Image</label>
                        <br>
                        <input class="custom-file-input" type="file" style="opacity:1;" accept="image/x-png,image/jpg,image/jpeg" name="image" required>
                        <hr>
                        <div class="form-group">
                          <label class="bmd-label-floating">Cost</label>
                          <input type="number" min="1" class="form-control" name="cost" required>
                        </div>
                        <input type="submit" class="btn btn-primary" value="submit">
                        <input type="reset" class="btn btn-primary addForm" value="cancel">
                        <input type="hidden" name="action" value="add">
                      </form>
                    </td>
                  </tr>
                  <!-- End add form -->

                  <!-- Change form -->
                  <tr>
                    <td colspan="20" class="changeForm" style="display:none;">
                      <span><b>Change information of this event :</b></span>
                      <p></p>
                      <form class="changeForm" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                          <label class="bmd-label-floating">Event name</label>
                          <input type="text" pattern="^[-a-zA-Z-'()]+(\s+[-a-zA-Z-'()]+)*$" minlength="2" title="Event name has 2 or more characters and has no special characters or number" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                          <label class="bmd-label-floating">Category name</label>
                          <select class="custom-select" name="category">
                            <?php for ($i = 0, $n = count($categories_array); $i < $n; $i++) { ?>
                              <option value="<?= $categories_array[$i]['event_id'] ?>"><?= $categories_array[$i]['name'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label class="bmd-label-floating">Description</label>
                          <input type="text" pattern="^[-a-zA-Z0-9-&/\.'\x22,()]+(\s+[-a-zA-Z0-9-&/\.'\x22,()]+)*$" minlength="4" title="Description has 2 or more characters and has no special characters or number" class="form-control" name="description" required>
                        </div>
                        <label class="bmd-label-floating">Current Image</label>
                        <br>
                        <image src="" id="reviewImg" width="300" height="200" name="image"></image>
                        <p></p>
                        <label class="bmd-label-floating">Choose new image</label>
                        <br>
                        <input type="file" style="opacity:1;" accept="image/x-png,image/jpg,image/jpeg" name="image">
                        <hr>
                        <div class="form-group">
                          <input type="number" min="1" class="form-control" title="Cost" name="cost" required>
                        </div>
                        <input type="hidden" name="id">
                        <input type="hidden" name="action" value="change">
                        <input type="submit" class="btn btn-primary" value="submit">
                        <input type="reset" class="btn btn-primary changeForm" value="cancel">
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