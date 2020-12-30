<?php
$categories = mysqli_query($con, 'select event_id, name from category_event');
$categories_array = array();
while ($category = mysqli_fetch_array($categories)) {
	array_push($categories_array, $category);
}

if (isset($_POST['action'])) {
	if ($_POST['action'] == "delete") {
		$id = $_POST['id'];
		$target_image = mysqli_query($con, 'select * from gallery where id = ' . $id);
		$target = mysqli_fetch_array(mysqli_query($con, 'select * from gallery where id = ' . $id));

		if (is_file('../images/Gallery1/' . $target['image_name'])) {
			unlink('../images/Gallery1/' . $target['image_name']);
		}

		if (mysqli_query($con, 'delete from gallery where id = ' . $id)) {
			echo "<script>alert('Update success.')</script>";
		} else {
			echo "<script>alert('Sorry, there was an error deleting database.\\n')</script>";
		}
	}

	if ($_POST['action'] == 'add') {
		$name = $_POST['name'];
		$categoryId = $_POST['category'];

		$error = "";
		$target_dir = "../images/Gallery1/";
		$target_file = $target_dir . basename($_FILES["image"]["name"]);
		$target_name = $target_dir . $_POST['name'];
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

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
		if ($_FILES["image"]["size"] > 2097152) {
			$error .= "Your file is too large (larger than 2MB).\\n";
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
			$error .= "Sorry, your file was not uploaded.";
			echo "<script>alert('" . $error . "')</script>";
			// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
				rename($target_file, $target_name);
				if (mysqli_query($con, 'insert into gallery(image_name, category_id) values("' . $name . '", ' . $categoryId . ')')) {
					echo "<script>alert('Update success.')</script>";
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
		$new_name = $_POST['name'];
		$categoryId = $_POST['category'];

		// check if admin upload a new image
		if ($_FILES["image"]["name"]) {
			// initialize variables to upload image
			$name = basename($_FILES["image"]["name"]);
			$error = "";
			$target_dir = "../images/Gallery1/";
			$target_file = $target_dir . $name;
			$target_name = $target_dir . $new_name;
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

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
			if ($_FILES['image']['name']) {
				// update when there is a new image
				if (move_uploaded_file($_FILES["image"]["tmp_name"], "../images/Gallery1/" . $new_name)) {
					if (mysqli_query($con, 'update gallery
					set
					image_name="' . $new_name . '"
					where id=' . $id)) {
						echo "<script>alert('Update success.');</script>";
					} else {
						echo "<script>alert('Sorry, there was an error updating database.\\n')</script>";
					}
				} else {
					echo "<script>alert('Sorry, there was an error uploading your file.\\n')</script>";
				}
			} else {
				// update when there is no new image
				$target = mysqli_fetch_array(mysqli_query($con, 'select * from gallery where id = ' . $id));
				$old_name = $target['image_name'];
				if (!rename('../images/Gallery1/' . $old_name, '../images/Gallery1/' . $new_name)) {
					echo "<script>alert('Sorry, there was an error changing image's name.');</script>";
				};

				if (mysqli_query($con, 'update gallery
					set
					image_name="' . $new_name . '", category_id = ' . $categoryId . '
					where id=' . $id)) {
					echo "<script>alert('Update success.');</script>";
				} else {
					echo "<script>alert('Sorry, there was an error updating database.\\n')</script>";
				}
			}
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
			var categoryId = $("#" + id).children('td[data-target=category]').attr('data-id');
			$('form.changeForm input[name="id"]').val(id);
			$('form.changeForm input[name="name"]').val(name);
			$('#imageReview').attr("src", "../images/Gallery1/" + name);
			$('form.changeForm select').val(categoryId);
		};

		$.ajax({
			type: 'GET',
			dataType: 'json',
			contentType: 'application/json',
			url: 'pages/gallery_ajax.php',
			success: function(result) {
				var r = '';
				for (var i = 0; i < result.length; i++) {
					r += '<tr id="' + result[i].id + '">';
					r += '<td>' + parseInt(i + 1) + '</td>';
					r += '<td data-target="name">' + result[i].image_name + '</td>';
					r += '<td data-target="category" data-id="' + result[i].category_id + '">' + result[i].category_name + '</td>';
					r += '<td data-target="image"><img src="../images/Gallery1/' + result[i].image_name + '" width="400px" height="300px"></td>';
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
	<div class="container-fluih">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header card-header-primary">
						<h4 class="card-title">Images list</h4>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table">
								<thead class=" text-primary">
									<th>ID</th>
									<th>Name</th>
									<th>Category</th>
									<th>Image</th>
									<th>Action</th>
								</thead>
								<tbody>
								</tbody>
								<tfoot>
									<!-- Add button -->
									<tr align="center">
										<td colspan="5">
											<button type="button" class="btn btn-primary addForm" onclick="$.fn.scrollDown()">Add image</button>
										</td>
									</tr>
									<!-- Add form -->
									<tr>
										<td colspan="5" class="addForm" style="display:none;">
											<span><b>Upload new image :</b></span>
											<p></p>
											<form class="addForm" method="post" enctype="multipart/form-data">
												<div class="form-group">
													<label class="bmd-label-floating">Image name</label>
													<input type="text" pattern="[\w]*.(?:jpg|png|jpeg|gif)" title="Image name must have valid extension(jpg/png/jpeg/gif) and has no special characters" class="form-control" name="name" required>
												</div>
												<input class="custom-file-input" type="file" style="opacity:1;" accept="image/x-png,image/jpg,image/jpeg" name="image" required>
												<div class="form-group">
													<label class="bmd-label-floating">Category name</label>
													<select class="custom-select" name="category">
														<?php for ($i = 0, $n = count($categories_array); $i < $n; $i++) { ?>
															<option value="<?= $categories_array[$i]['event_id'] ?>"><?= $categories_array[$i]['name'] ?></option>
														<?php } ?>
													</select>
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
											<span><b>Change information of this image :</b></span>
											<p></p>
											<form class="changeForm" method="post" enctype="multipart/form-data">
												<div class="form-group">
													<label class="bmd-label-floating">Image name</label>
													<input type="text" pattern="[\w]*.(?:jpg|png|jpeg|gif)" title="Image name must have valid extension(jpg/png/jpeg/gif) and has no special characters" class="form-control" name="name" required>
												</div>
												<label class="bmd-label-floating">Current name</label>
												<br>
												<image src="" title="Review image" id="imageReview" width="400px" height="300px"></image>
												<p></p>
												<label class="bmd-label-floating">Choose new image</label>
												<br>
												<input class="custom-file-input" type="file" style="opacity:1;" accept="image/x-png,image/jpg,image/jpeg" name="image">
												<div class="form-group">
													<label class="bmd-label-floating">Category name</label>
													<select class="custom-select" name="category">
														<?php for ($i = 0, $n = count($categories_array); $i < $n; $i++) { ?>
															<option value="<?= $categories_array[$i]['event_id'] ?>"><?= $categories_array[$i]['name'] ?></option>
														<?php } ?>
													</select>
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