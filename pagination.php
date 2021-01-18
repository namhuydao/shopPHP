<?php

// Connect database

require_once('database.php');

$limit = 5;

if (isset($_POST['page_no'])) {
    $page_no = $_POST['page_no'];
} else {
    $page_no = 1;
}

$offset = ($page_no - 1) * $limit;

$query = "SELECT * FROM product LIMIT $offset, $limit";

$result = mysqli_query($conn, $query);

$output = "";

if (mysqli_num_rows($result) > 0) {

    $output .= "<table class='table'>
		    <thead>
		        <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Content</th>
                        <th>Action</th>
                    </tr>
		    </thead>
	         <tbody>";
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= '<tr>
	                    <td>'.$row["id"]. '</td>
                        <td>'.$row["name"].'</td>
                        <td>'.$row["description"].'</td>
                        <td>'.$row["content"].'</td>
                        <td><button data-toggle="modal" data-target="#editModal" class="btn btn-primary btn-sm editBtn">Edit</button>
                           <button class="btn btn-danger btn-sm deleteBtn" data-toggle="modal" data-target="#deleteModal">Delete</button>
                        </td>        
		            </tr>';
    }
    $output .= "</tbody>
		</table>";

    $sql = "SELECT * FROM product";

    $records = mysqli_query($conn, $sql);

    $totalRecords = mysqli_num_rows($records);

    $totalPage = ceil($totalRecords / $limit);

    $output .= "<ul class='pagination justify-content-center' style='margin:20px 0'>";

    for ($i = 1; $i <= $totalPage; $i++) {
        if ($i == $page_no) {
            $active = "active";
        } else {
            $active = "";
        }

        $output .= "<li class='page-item $active'><a class='page-link' id='$i' href=''>$i</a></li>";
    }

    $output .= "</ul>";

    echo $output;

}
