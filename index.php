<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['user'])) {
    header('Location:signIn.php');
}

include './database.php';
include './function.php';
include './add.php';
$sql = "SELECT * FROM `product` WHERE 1 = 1";

if (isset($_GET['search']) && $_GET['search'] != '') {

    $sql = $sql . ' AND name like "%' . $_GET['search'] . '%"';
}
if (isset($_GET['select']) && $_GET['select'] != '') {
    $sql = $sql . " ORDER BY name " . $_GET['select'];
} else {
    $sql = $sql . " ORDER BY id DESC";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css"
          integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/index.css">
</head>

<body>
<!-- Modal EDIT -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="updateData.php" enctype="multipart/form-data">
                    <input type="hidden" name="update_id" id="update_id">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="desc">Description:</label>
                        <input type="text" id="description" name="description" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="content">Content:</label>
                        <input type="text" id="content" name="content" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="file" name="fileToUpload" id="fileToUpload" style="outline: none">
                    </div>
                    <div class="form-group">
                        <img width="100" id="updateImgId"/>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="updateData" class="btn btn-primary" value="Update">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal DELETE -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="delete.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="delete_id" id="delete_id">
                    Do you want to delete this data?
                </div>
                <div class="modal-footer">
                    <button type="submit" name="deleteData" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container">
    <form action="signOut.php" style="padding: 20px 0 0 0; text-align: right">
        <button type="submit" class="btn btn-secondary">Sign Out</button>
    </form>
</div>
<div class="container">
    <div class="row">
        <div class="col-12 text-center">
            <h1>Add Product</h1>
        </div>
        <div class="col-12">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="email">Name:</label>
                    <input type="text" name="name" class="form-control" id="email">
                </div>
                <div class="form-group">
                    <label for="desc">Description:</label>
                    <input type="text" name="description" class="form-control" id="desc">
                </div>
                <div class="form-group">
                    <label for="cont">Content:</label>
                    <input type="text" name="content" class="form-control" id="cont">
                </div>
                <div class="form-group">
                    <input type="file" name="fileToUpload" id="fileToUpload" style="outline: none">
                </div>
                <button type="submit" name="add" class="btn btn-primary">Add</button>
            </form>
        </div>
    </div>
</div>
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <form action="" method="GET" class="row" style="width: 100%;align-items: center;padding: 20px 0;">
                <div class="col-md-8">
                    <select name="select" class="filterSelect form-control form-control-sm" style="width: 10%">
                        <option value="">Sort</option>
                        <option value="ASC" <?php if (@$_GET['select'] == 'ASC') echo 'selected'; ?>>A-Z</option>
                        <option value="DESC" <?php if (@$_GET['select'] == 'DESC') echo 'selected'; ?>>Z-A</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" value="<?php echo @$_GET['search']; ?>"
                           placeholder="search by name">

                </div>
                <div class="col-md-1">
                    <button type="submit" name="searchBtn" class="btn btn-warning">Filter</button>
                </div>
            </form>
        </div>
        <div class="panel-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Content</th>
                    <th>Images</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td><?php echo $row['content']; ?></td>
                            <td class="imgtd"><img width="100" src="<?php echo $row['images']; ?>"/></td>
                            <?php
                            $status = $row['status'];
                            if ($status == 0) {
                                $strStatus = "<a class='btn btn-danger btn-sm' href=activate.php?id=" . $row['id'] . ">Deactivate</a>";
                            }
                            if ($status == 1) {
                                $strStatus = "<a class='btn btn-primary btn-sm' href=deactivate.php?id=" . $row['id'] . ">Activate</a>";
                            }
                            ?>
                            <td><?php echo $strStatus ?></td>
                            <td>
                                <button data-toggle="modal" data-target="#editModal"
                                        class="btn btn-primary btn-sm editBtn">Edit
                                </button>
                                <button class="btn btn-danger btn-sm deleteBtn" data-toggle="modal"
                                        data-target="#deleteModal">Delete
                                </button>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "0 results";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script src="assets/js/main.js"></script>
</body>

</html>