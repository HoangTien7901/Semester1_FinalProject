<?php
if (isset($_POST['action'])) {
  if ($_POST['action'] == 'add') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $position = $_POST['position'];
    $description = $_POST['description'];

    $error = "";
    $target_dir = "../images/staff/";
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
        insert into staff(name, phone_number, email, position, image, description)
        values("' . $name . '","' . $phone . '","' . $email . '",
        "' . $position . '","' . $img_name . '","' . $description . '")')) {
          echo "<script>alert('Update success.\\n')</script>";
        } else {
          echo "<script>alert('Sorry, there was an error updating database.\\n')</script>";
        }
      } else {
        echo "<script>alert('Sorry, there was an error uploading your file.\\n')</script>";
      }
    }
  }

  if ($_POST['action'] == "change") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $position = $_POST['position'];
    $description = $_POST['description'];

    // check if admin upload a new image
    if ($_FILES["image"]['name']) {
      $error = "";
      $target_dir = "../images/staff/";
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
      $error .= "Sorry, your file was not uploaded.";
      echo "<script>alert('" . $error . "')</script>";
      // if everything is ok, try to upload file
    } else {
      // update with new image
      if ($_FILES["image"]['name']) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], "../images/staff/" . $img_name)) {
          if (
            mysqli_query($con, 'update staff
          set
          name ="' . $name . '", phone_number="' . $phone . '", email="' . $email . '", position="' . $position . '", image="' . $img_name . '", description="' . $description . '"
          where id=' . $id)
          ) {
            echo "<script>alert('Update success.')</script>";
          } else {
            echo "<script>alert('Sorry, there was an error updating database.\\n')</script>";
          }
        } else {
          echo "<script>alert('Sorry, there was an error uploading your image.\\n')</script>";
        }
      } else {
        // update with no new image
        if (
          mysqli_query($con, 'update staff
        set
        name ="' . $name . '", phone_number="' . $phone . '", email="' . $email . '", position="' . $position . '", description="' . $description . '"
        where id=' . $id)
        ) {
          echo "<script>alert('Update success.')</script>";
        } else {
          echo "<script>alert('Sorry, there was an error updating database.\\n')</script>";
        }
      }
    }
  }

  if ($_POST['action'] == "delete") {
    $id = $_POST['id'];
    
    $target = mysqli_fetch_array(mysqli_query($con, 'select * from staff where id = ' . $id));
    if (is_file('../images/staff/' . $target['image'])) {
      unlink('../images/staff/' . $target['image']);
    }

    if (mysqli_query($con, 'delete from staff where id = ' . $id)) {
      echo "<script>alert('Update success.')</script>";
    } else {
      echo "<script>alert('Sorry, there was an error deleting database.\\n')</script>";
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

    $.fn.change = function(value) {
      if ($('td.changeForm').css("display") == "none") {
        $('td.changeForm').toggle();
        if ($('td.addForm').css("display") != "none") {
          $('td.addForm').toggle();
        }
      }
      var id = value;
      var name = $("#" + id).children('td[data-target=name]').text();
      var phone = $("#" + id).children('td[data-target=phone]').text();
      var email = $("#" + id).children('td[data-target=email]').text();
      var position = $("#" + id).children('td[data-target=position]').text();
      var description = $("#" + id).children('td[data-target=description]').text();
      var image = $("#image" + id).attr("src");
      $('form.changeForm input[name="id"]').val(id);
      $('form.changeForm input[name="name"]').val(name);
      $('form.changeForm input[name="phone"]').val(phone);
      $('form.changeForm input[name="email"]').val(email);
      $('#reviewImg').attr("src", image);
      $('form.changeForm input[name="position"]').val(position);
      $('form.changeForm input[name="description"]').val(description);
    };

    $.fn.getData = function() {
      $.ajax({
        url: 'pages/staff_ajax.php',
        dataType: 'json',
        contentType: 'application/json',
        success: function(result) {
          var r = '';
          for (var i = 0; i < result.length; ++i) {
            r += '<tr id="' + result[i].id + '">';
            r += '<td>' + parseInt(i + 1) + '</td>';
            r += '<td data-target="name">' + result[i].name + '</td>';
            r += '<td data-target="phone">' + result[i].phone_number + '</td>';
            r += '<td data-target="email">' + result[i].email + '</td>';
            r += '<td data-target="position">' + result[i].position + '</td>';
            r += '<td><image id="image' + result[i].id + '" src="../images/staff/' + result[i].image + '" width="100" height="60" title="Staff image"></td>';
            r += '<td data-target="description">' + result[i].description + '</td>';
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
            <h4 class="card-title ">Staffs List</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead class="text-primary">
                  <th>ID</th>
                  <th>Name</th>
                  <th>Phone</th>
                  <th>Email</th>
                  <th>Position</th>
                  <th>Image</th>
                  <th>Description</th>
                  <th>Action</th>
                </thead>

                <tbody>
                </tbody>

                <tfoot>
                  <!-- Add button -->
                  <tr align="center">
                    <td colspan="20">
                      <button type="button" class="btn btn-primary addForm" onclick="$.fn.scrollDown()">Add staff</button>
                    </td>
                  </tr>
                  <!-- Add form -->
                  <tr>
                    <td colspan="20" class="addForm" style="display:none;">
                      <span><b>Input information of new staff :</b></span>
                      <p></p>
                      <form class="addForm" method="post" action="#" enctype="multipart/form-data">
                        <div class="form-group">
                          <label class="bmd-label-floating">Name</label>
                          <input type="text" pattern="^[-a-zA-Z0-9-()]+(\s+[-a-zA-Z0-9-()]+)*$" minlength="2" title="Name only has 2 or more characters and has no special characters or number" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                          <label class="bmd-label-floating">Phone</label>
                          <input type="tel" class="form-control" name="phone" pattern="[0-9]{10}" title="Please enter a phone number with ten numbers" required>
                        </div>
                        <div class="form-group">
                          <label class="bmd-label-floating">Email</label>
                          <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                          <label class="bmd-label-floating">Position</label>
                          <input type="text" class="form-control" name="position" pattern="^[-a-zA-Z0-9-&/()]+(\s+[-a-zA-Z0-9-&/()]+)*$" minlength="4" required>
                        </div>
                        <label class="bmd-label-floating">Image</label>
                        <br>
                        <input class="custom-file-input" type="file" style="opacity:1;" accept="image/x-png,image/jpg,image/jpeg" name="image" required>
                        <hr>
                        <div class="form-group">
                          <label class="bmd-label-floating">Description</label>
                          <input type="text" class="form-control" name="description" pattern="^[-a-zA-Z0-9-&/\.()]+(\s+[-a-zA-Z0-9-&/\.()]+)*$" minlength="4" required>
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
                      <span><b>Change information of this staff :</b></span>
                      <p></p>
                      <form class="changeForm" method="post" enctype="multipart/form-data" action="#">
                        <div class="form-group">
                          <label class="bmd-label-floating">Name</label>
                          <input type="text" class="form-control" pattern="^[-a-zA-Z0-9-()]+(\s+[-a-zA-Z0-9-()]+)*$" minlength="2" name="name" required>
                        </div>
                        <div class="form-group">
                          <label class="bmd-label-floating">Phone</label>
                          <input type="tel" class="form-control" name="phone" pattern="[0-9]{10}" title="Please enter a phone number with ten numbers!" required>
                        </div>
                        <div class="form-group">
                          <label class="bmd-label-floating">Email</label>
                          <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                          <label class="bmd-label-floating">Position</label>
                          <input type="text" class="form-control" pattern="^[-a-zA-Z0-9-&/()]+(\s+[-a-zA-Z0-9-&/()]+)*$" minlength="4" name="position" required>
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
                          <label class="bmd-label-floating">Description</label>
                          <input type="text" class="form-control" pattern="^[-a-zA-Z0-9-&\'.()]+(\s+[-a-zA-Z0-9-&\'.()]+)*$" minlength="4" name="description" required>
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