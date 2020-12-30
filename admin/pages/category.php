<?php
if (isset($_POST['action'])) {
	if ($_POST['action'] == 'add') {
		$name = $_POST['name'];
		$description = $_POST['description'];

		$error = "";
		$target_dir = "../images/category/";
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
				if (mysqli_query($con, 'insert into category_event(name, image, description) values("' . $name . '","' . $img_name . '","' . $description . '")')) {
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
		$event_id = $_POST['id'];
		$name = $_POST['name'];
		$description = $_POST['description'];

		// check if admin upload a new image
		if ($_FILES["image"]['name']) {
			$error = "";
			$target_dir = "../images/category/";
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
			if ($_FILES["image"]['name']) {
				if (move_uploaded_file($_FILES["image"]["tmp_name"], "../images/category/" . $img_name)) {
					if (
						mysqli_query($con, 'update category_event
					set
					name="' . $name . '",image="' . $img_name . '",description="' . $description . '"
					where event_id=' . $event_id)
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
					mysqli_query($con, 'update category_event
					set
					name="' . $name . '", description="' . $description . '"
					where event_id=' . $event_id)
				) {
					echo "<script>alert('Update success.\\n')</script>";
				} else {
					echo "<script>alert('Sorry, there was an error updating database.\\n')</script>";
				}
			}
		}
	}

	if ($_POST['action'] == "delete") {
		$event_id = $_POST['id'];

		$target = mysqli_fetch_array(mysqli_query($con, 'select * from category_event where event_id = ' . $event_id));
		if (is_file('../images/category/' . $target['image'])) {
			unlink('../images/category/' . $target['image']);
		}

		if (mysqli_query($con, 'delete from category_event where event_id = ' . $event_id)) {
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
			var image = $("#image" + id).attr("src");
			$('form.changeForm input[name="id"]').val(id);
			$('form.changeForm input[name="name"]').val(name);
			$('#reviewImg').attr("src", image);
			$('form.changeForm input[name="description"]').val(description);
		};

		$.ajax({
			type: 'GET',
			dataType: 'json',
			contentType: 'application/json',
			url: 'pages/category_ajax.php',
			success: function(result) {
				var r = '';
				for (var i = 0; i < result.length; i++) {
					r += '<tr id="' + result[i].event_id + '">';
					r += '<td>' + parseInt(i + 1) + '</td>';
					r += '<td data-target="name">' + result[i].name + '</td>';
					r += '<td><image id="image' + result[i].event_id + '" src="../images/category/' + result[i].image + '" width="300" height="200"></image></td>'
					r += '<td data-target="description">' + result[i].description + '</td>';
					r += '<td>';
					r += '<form method="post">';
					r += '<input type="hidden" name="action" value="delete">';
					r += '<input type="hidden" name="id" value="' + result[i].event_id + '">';
					r += '<input type="submit" value="Delete" class="btn btn-outline-primary btn-sm" onclick="return confirm(\'Are you sure?\')">'
					r += '</form>';
					r += '<input type="button" class="btn btn-outline-primary btn-sm" value="Change" onclick="$.fn.change(' + result[i].event_id + ');$.fn.scrollDown()">';
					r += '</td>';
					r += '</tr>';
				}
				$('tbody').html(r);
			}
		});
	});
</script>

<div class="content">
	<div class="container-fluih">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header card-header-primary">
						<h4 class="card-title ">Categories event</h4>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table">
								<thead class=" text-primary">
									<th>ID</th>
									<th>Name</th>
									<th>Image</th>
									<th>Description</th>
									<th>Action</th>
								</thead>
								<tbody>
								</tbody>
								<tfoot>
									<!-- Add button -->
									<tr align="center">
										<td colspan="5">
											<button type="button" class="btn btn-primary addForm" onclick="$.fn.scrollDown()">Add category</button>
										</td>
									</tr>
									<!-- Add form -->
									<tr>
										<td colspan="5" class="addForm" style="display:none;">
											<span><b>Input information of new category :</b></span>
											<p></p>
											<form class="addForm" method="post" enctype="multipart/form-data">
												<div class="form-group">
													<label class="bmd-label-floating">Name</label>
													<input type="text" pattern="^[-a-zA-Z0-9-]+(\s+[-a-zA-Z0-9-]+)*$" minlength="2" title="Category name must has 2 or more characters and has no special characters or number" class="form-control" name="name" required>
												</div>
												<label class="bmd-label-floating">Image</label>
												<br>
												<input class="custom-file-input" type="file" style="opacity:1;" accept="image/x-png,image/jpg,image/jpeg" name="image" required>
												<hr>
												<div class="form-group">
													<label class="bmd-label-floating">Description</label>
													<input type="text" pattern="^[-a-zA-Z0-9-&/\.'?\x22,()]+(\s+[-a-zA-Z0-9-&/\.'?\x22,()]+)*$" minlength="4" title="Description must has 2 or more characters and has no special characters" class="form-control" name="description" required>
												</div>
												<input type="hidden" name="action" value="add">
												<input type="submit" class="btn btn-primary" value="submit">
												<input type="reset" class="btn btn-primary addForm" value="cancel">
											</form>
										</td>
									</tr>
									<!-- End add form -->

									<!-- Change form -->
									<tr>
										<td colspan="6" class="changeForm" style="display:none;">
											<span><b>Change information of this category :</b></span>
											<p></p>
											<form class="changeForm" method="post" enctype="multipart/form-data">
												<div class="form-group">
													<label class="bmd-label-floating">Name</label>
													<input type="text" pattern="^[-a-zA-Z0-9-]+(\s+[-a-zA-Z0-9-]+)*$" minlength="2" title="Category name must has 2 or more characters and has no special characters or number" class="form-control" name="name" required>
												</div>
												<label class="bmd-label-floating">Current image</label>
												<br>
												<image src="" id="reviewImg" width="300" height="200" name="image"></image>
												<p></p>
												<label class="bmd-label-floating">Choose new image</label>
												<br>
												<input type="file" style="opacity:1;" accept="image/x-png,image/jpg,image/jpeg" name="image">
												<hr>
												<div class="form-group">
													<label class="bmd-label-floating">Description</label>
													<input type="text" pattern="^[-a-zA-Z0-9-&/\.'?\x22,()]+(\s+[-a-zA-Z0-9-&/\.'?\x22,()]+)*$" minlength="4" title="Description must has 2 or more characters and has no special characters or number" class="form-control" name="description" required>
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