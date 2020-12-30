<?php
if (isset($_POST['action'])) {
  if ($_POST['action'] == "add") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    if (mysqli_query($con, '
    insert into user(user_name, email, phone_number, address)
    values("' . $name . '","' . $email . '","' . $phone . '","' . $address . '")')) {
      echo "<script>alert('Update success.\\n')</script>";
    } else {
      echo "<script>alert('Sorry, there was an error updating database.\\n')</script>";
    }
  }

  if (($_POST['action']) == "delete") {
    $id = $_POST['id'];

    if (mysqli_query($con, 'delete from user where id = ' . $id)) {
      echo "<script>alert('Update success.')</script>";
    } else {
      echo "<script>alert('Sorry, there was an error deleting database.\\n')</script>";
    }
  }

  if ($_POST['action'] == "change") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    if (mysqli_query($con, 'update user
      set
      user_name ="' . $name . '", email="' . $email . '", phone_number="' . $phone . '", address="' . $address . '"
      where id=' . $id)) {
      echo "<script>alert('Update success.\\n')</script>";
    } else {
      echo "<script>alert('Sorry, there was an error updating database.\\n')</script>";
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
      var address = $("#" + id).children('td[data-target=address]').text();
      $('form.changeForm input[name="id"]').val(id);
      $('form.changeForm input[name="name"]').val(name);
      $('form.changeForm input[name="phone"]').val(phone);
      $('form.changeForm input[name="email"]').val(email);
      $('form.changeForm input[name="address"]').val(address);
    };

    // get table values
    $.ajax({
      type: 'GET',
      dataType: 'json',
      contentType: 'application/json',
      url: 'pages/user_ajax.php',
      success: function(result) {
        var r = '';
        for (var i = 0; i < result.length; i++) {
          r += '<tr id="' + result[i].id + '">';
          r += '<td>' + parseInt(i + 1) + '</td>';
          r += '<td data-target="name">' + result[i].user_name + '</td>';
          r += '<td data-target="email">' + result[i].email + '</td>';
          r += '<td data-target="phone">' + result[i].phone_number + '</td>';
          r += '<td data-target="address">' + result[i].address + '</td>';
          r += '<td>';
          r += '<form method="post">';
          r += '<input type="hidden" name="action" value="delete">';
          r += '<input type="hidden" name="id" value="' + result[i].id + '">';
          r += '<input type="submit" value="delete" class="btn btn-outline-primary btn-sm" onclick="return confirm(\'Are you sure?\')">';
          r += '</form>';
          r += '<input type="button" class="btn btn-outline-primary btn-sm" value="change" onclick="$.fn.change(' + result[i].id + ');$.fn.scrollDown()">';
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
            <h4 class="card-title ">Users List</h4>
            <p class="card-category">Here is a subtitle for this table</p>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead class="text-primary">
                  <th>ID</th>
                  <th>User Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Address</th>
                  <th>Action</th>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                  <!-- Add button -->
                  <tr align="center">
                    <td colspan="6">
                      <button type="button" class="btn btn-primary addForm" onclick="$.fn.scrollDown()">Add user</button>
                    </td>
                  </tr>
                  <!-- Add form -->
                  <tr>
                    <td colspan="6" class="addForm" style="display:none;">
                      <span><b>Input information of new user :</b></span>
                      <p></p>
                      <form class="addForm" method="post" action="#">
                        <div class="form-group">
                          <label class="bmd-label-floating">User name</label>
                          <input type="text" pattern="^[-a-zA-Z0-9-()]+(\s+[-a-zA-Z0-9-()]+)*$" minlength="2" title="Name has 2 or more characters and has no special characters or number" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                          <label class="bmd-label-floating">Email</label>
                          <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                          <label class="bmd-label-floating">Phone</label>
                          <input type="tel" class="form-control" pattern="[0-9]{10}" title="Enter a phone number with ten numbers" name="phone" required>
                        </div>
                        <div class="form-group">
                          <label class="bmd-label-floating">Address</label>
                          <input type="text" pattern="^[-a-zA-Z0-9-()/]+(\s+[-a-zA-Z0-9-()/]+)*$" minlength="5" title="Address do not contain special characters excep - and /" class="form-control" name="address" required>
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
                    <td colspan="6" class="changeForm" style="display:none;">
                      <span><b>Change information of this user :</b></span>
                      <p></p>
                      <form class="changeForm" method="post">
                        <div class="form-group">
                          <label class="bmd-label-floating">User name</label>
                          <input type="text" pattern="^[-a-zA-Z0-9-()]+(\s+[-a-zA-Z0-9-()]+)*$" minlength="2" title="Name only has 2 or more characters and has no special characters or number" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                          <label class="bmd-label-floating">Email</label>
                          <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                          <label class="bmd-label-floating">Phone</label>
                          <input type="tel" class="form-control" pattern="[0-9]{10}" title="Enter a phone number with ten numbers" name="phone" required>
                        </div>
                        <div class="form-group">
                          <label class="bmd-label-floating">Address</label>
                          <input type="text" pattern="^[-a-zA-Z0-9-()/]+(\s+[-a-zA-Z0-9-()/]+)*$" minlength="5" title="Address do not contain special characters excep - and /" class="form-control" name="address" required>
                        </div>
                        <input type="hidden" name="id">
                        <input type="hidden" name="action" value="change">
                        <input type="submit" class="btn btn-primary" value="submit">
                        <input type="reset" class="btn btn-primary changeForm" value="cancel">
                      </form>
                    </td>
                  </tr>
                  <!-- End change user form -->
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>