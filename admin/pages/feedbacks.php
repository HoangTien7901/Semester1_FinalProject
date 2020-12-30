<?php
require_once "../connect.php";
$feedbacks = mysqli_query($con, 'select * from feedback');
?>
<div class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header card-header-primary">
        <h3 class="card-title">Feedbacks</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <!-- feedback list:  -->
            <?php while ($feedback = mysqli_fetch_array($feedbacks)) { ?>
              <div class="alert alert-info alert-with-icon" data-notify="container">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <i class="material-icons">close</i>
                </button>
                <span data-notify="message"><b>From <?= $feedback['name'] ?></b>: <?= $feedback['content'] ?></span>
              </div>
            <?php } ?>
            <!-- end feedback list:  -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>