<?php
if (isset($_POST['action'])) {
  if ($_POST['action'] == "add") {
    $content = $_POST['content'];
    $date = date('Y-m-d', strtotime($_POST['date']));

    if (
      mysqli_query($con, '
    insert into review(content, date)
    values("' . $content . '","' . $date . '")')
    ) {
      echo "<script>alert('Update success.')</script>";
    } else {
      echo "<script>alert('Sorry, there was an error updating your file.')</script>";
    }
  }

  if ($_POST['action'] == "delete") {
    $id = $_POST['id'];
    
    if (mysqli_query($con, 'delete from review where id = ' . $id)) {
      echo "<script>alert('Update success.')</script>";
    } else {
      echo "<script>alert('Sorry, there was an error deleting database.\\n')</script>";
    }
  }

  if ($_POST['action'] == "change") {
    $id = $_POST['id'];
    $content = $_POST['content'];
    $date = date('Y-m-d', strtotime($_POST['date']));

    if (mysqli_query($con, 'update review
		set
		content="' . $content . '", date="' . $date . '"
		where id=' . $id)) {
      echo "<script>alert('Update success.')</script>";
    } else {
      echo "<script>alert('Sorry, there was an error updating your file.')</script>";
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
      var content = $("#" + id).children('td[data-target=content]').text();
      var date = $("#" + id).children('td[data-target=date]').text();
      $('form.changeForm input[name="id"]').val(id);
      $('form.changeForm input[name="content"]').val(content);
      $('form.changeForm input[name="date"]').val(date);
    };

    $.ajax({
      url: 'pages/review_ajax.php',
      dataType: 'json',
      contentType: 'application/json',
      success: function(result) {
        var r = '';
        for (var i = 0; i < result.length; ++i) {
          r += '<tr id="' + result[i].id + '">';
          r += '<td>' + parseInt(i + 1) + '</td>';
          r += '<td data-target="content" style="width:350px;">' + result[i].content + '</td>';
          r += '<td data-target="date">' + result[i].date + '</td>';
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
            <h4 class="card-title ">Reviews List</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead class="text-primary">
                  <th>ID</th>
                  <th>Content</th>
                  <th>Date</th>
                  <th>Action</th>
                </thead>

                <tbody>
                </tbody>

                <tfoot>
                  <!-- Add buttons -->
                  <tr align="center">
                    <td colspan="20">
                      <button type="button" class="btn btn-primary addForm" onclick="$.fn.scrollDown()">Add review</button>
                    </td>
                  </tr>
                  <!-- Add form -->
                  <tr>
                    <td colspan="20" class="addForm" style="display:none;">
                      <span><b>Input information of new review :</b></span>
                      <p></p>
                      <form class="addForm" method="post" action="#">
                        <div class="form-group">
                          <label class="bmd-label-floating">Content</label>
                          <input type="text" pattern="^[-a-zA-Z0-9-/'\.()]+(\s+[-a-zA-Z0-9-/'\.()]+)*$" minlength="3" title="Content must have 2 or more characters and has no special characters" class="form-control" name="content" required>
                        </div>
                        <div class="form-group">
                          <label class="bmd-label-floating">Date</label>
                          <input type="date" class="form-control" name="date" required>
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
                      <span><b>Change information of this review:</b></span>
                      <p></p>
                      <form class="changeForm" method="post">
                        <div class="form-group">
                          <label class="bmd-label-floating">Content</label>
                          <input type="text" pattern="^[-a-zA-Z0-9-/'\.()]+(\s+[-a-zA-Z0-9-/'\.()]+)*$" minlength="3" title="Content must have 2 or more characters and has no special characters" class="form-control" name="content" required>
                        </div>
                        <div class="form-group">
                          <label class="bmd-label-floating">Date</label>
                          <input type="date" class="form-control" name="date" required>
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