<?php
if (isset($_POST['action'])) {
  if ($_POST['action'] == "change") {
    $id = $_POST['id'];
    $content = $_POST['content'];
    $date = date('Y-m-d', strtotime($_POST['date']));

    mysqli_query($con, 'update review
		set
		content="' . $content . '", date="' . $date . '"
				where id=' . $id);
  }
}
?>

<script>
  $(document).ready(function() {
    // toggle add form
    $('button.addForm, input.addForm').click(function() {
      $('.addForm').toggle();
    });

    // toggle change form
    $('button.changeForm, input.changeForm').click(function() {
      $('.changeForm').toggle();
    });

    $.fn.change = function(value) {
      if ($('.changeForm').css("display") == "none") {
        $('.changeForm').toggle();
      }
      var id = value;
      var content = $("#" + id).children('td[data-target=content]').text();
      var date = $("#" + id).children('td[data-target=date]').text();
      $('form.changeForm input[name="id"]').val(id);
      $('form.changeForm input[name="content"]').val(content);
      $('form.changeForm input[name="date"]').val(date);
    };

    $.fn.getData = function() {
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
            r += '<input type="button" class="btn btn-outline-primary btn-sm" value="Change" onclick="$.fn.change(' + result[i].id + ')">';
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
            <h4 class="card-title ">Reviews List</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead class="text-primary">
                  <th width="10%">ID</th>
                  <th width="50%">Content</th>
                  <th width="20%">Date</th>
                  <th width="20%">Action</th>
                </thead>

                <tbody>
                </tbody>

                <tfoot>
                  <!-- Change form -->
                  <tr>
                    <td colspan="20" class="changeForm" style="display:none;">
                      <span><b>Change information of this review:</b></span>
                      <p></p>
                      <form class="changeForm" style="display:none;" method="post">
                        <div class="form-group">
                          <input type="text" pattern="^[-a-zA-Z0-9-/'\.()]+(\s+[-a-zA-Z0-9-/'\.()]+)*$" minlength="3" title="Content must have 2 or more characters and has no special characters" class="form-control" name="content" required>
                        </div>
                        <div class="form-group">
                          <input type="date" class="form-control" name="date" required>
                        </div>
                        <input type="hidden" name="id">
                        <input type="hidden" name="action" value="change">
                        <input type="submit" class="btn btn-primary" value="submit">
                        <input type="reset" class="btn btn-primary changeForm" value="Close" style="display:none;">
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