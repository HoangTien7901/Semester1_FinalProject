<script>
  $(document).ready(function() {
    $.fn.getData = function() {
      $.ajax({
        url: 'pages/events_ajax.php',
        dataType: 'json',
        contentType: 'application/json',
        success: function(result) {
          var r = '';
          for (var i = 0; i < result.length; ++i) {
            r += '<tr id="' + result[i].id + '">';
            r += '<td>' + parseInt(i + 1) + '</td>';
            r += '<td data-target="category">' + result[i].category_name + '</td>';
            r += '<td data-target="event">' + result[i].event_name + '</td>';
            r += '<td><a href="../images/organized_events/' + result[i].image + '" target="_blank"><image id="image' + result[i].id + '" src="../images/organized_events/' + result[i].image + '" width="100" height="60" title="Click to see full image"></a></td>';
            r += '<td data-target="review">' + result[i].review + '</td>';
            r += '<td data-target="date">' + result[i].date + '</td>';
            r += '<td data-target="staff">' + result[i].staff + '</td>';
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
            <h4 class="card-title ">Your Events</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead class="text-primary">
                  <th>ID</th>
                  <th>Category</th>
                  <th>Theme</th>
                  <th>Image</th>
                  <th>Your review</th>
                  <th>Date</th>
                  <th>Staff</th>
                </thead>

                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>