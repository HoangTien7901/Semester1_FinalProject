<?php
if (isset($_POST['action'])) {
  if ($_POST['action'] == "change") {
    $account_name = $_POST['account_name'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    if (
    mysqli_query($con, 'update user
      set
      user_name = "' . $account_name . '", phone_number = "' . $phone_number . '" ,address = "' . $address . '",email = "' . $email . '"
      where role = "admin"'))
    {
      echo "<script>alert('Update success');</script>";
    } else {
      echo "<script>alert('Sorry, there was an error updating your profile');</script>";
    }
  }
}
?>
<script>
  $(document).ready(function() {
    // get original data from database
    $.ajax({
      url: 'pages/profile_ajax.php',
      dataType: 'json',
      contentType: 'application/json',
      success: function(result) {
        var account_name = result.user_name;
        var phone_number = result.phone_number;
        var address = result.address;
        var email = result.email;
        $('form input[data-target="account_name"]').val(account_name);
        $('form input[data-target="phone"]').val(phone_number);
        $('form input[data-target="address"]').val(address);
        $('form input[data-target="email"]').val(email);
        $('form input[data-target="account_name"]').focus();
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
            <h4 class="card-title">Edit Profile</h4>
            <p class="card-category">Complete your profile</p>
          </div>
          <div class="card-body">
            <form id="#profileForm" method="post">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="bmd-label-floating">Account Name</label>
                    <input type="text" class="form-control" pattern="^[-a-zA-Z-()]+(\s+[-a-zA-Z-()]+)*$" minlength="2" data-target="account_name" name="account_name">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="bmd-label-floating">Email address</label>
                    <input type="email" class="form-control" data-target="email" name="email">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-8">
                  <div class="form-group">
                    <label class="bmd-label-floating">Address</label>
                    <input type="text" class="form-control" pattern="^[-a-zA-Z0-9-&()/]+(\s+[-a-zA-Z0-9&-()/]+)*$" minlength="5" data-target="address" name="address">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Phone number</label>
                    <input type="text" class="form-control" pattern="[0-9]{10}" data-target="phone" name="phone_number">
                  </div>
                </div>
              </div>
              <input type="submit" class="btn btn-primary pull-right" value="Update Profile">
              <input type="hidden" name="action" value="change">
              <div class="clearfix"></div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>