<?php require './includes/db.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php require './includes/links.php' ?>
</head>

<body>
    <div class="container mt-5 text-center">
        <h3 class="mb-4">User details</h3>

        <div class="mb-3">
            <input type="text" id="searchBox" class="form-control" placeholder="Search by name, email, or city...">
        </div>

        <table class="table table-hover shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>City</th>
                    <th>Joined At</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>

            <tbody id="userTable">
                <?php
                $sql = "SELECT * FROM users";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($id, $name, $email, $gender, $city, $created_at);

                    while ($stmt->fetch()) {
                ?>
                        <tr>
                            <td><?= $id ?></td>
                            <td><?= $name ?></td>
                            <td><?= $email ?></td>
                            <td><?= $gender ?></td>
                            <td><?= $city ?></td>
                            <td><?= $created_at ?></td>
                            <td>
                                <a href="./update.php?id=<?= $id ?>">
                                    <i class="fa-solid fa-edit text-success"></i>
                                </a>
                            </td>
                            <td>
                                <a href="#" onclick="deleteRecord(<?= $id ?>)">
                                    <i class="fa-solid fa-trash text-danger"></i>
                                </a>
                            </td>
                        </tr>

                    <?php
                    }
                } else {
                    ?>

                    <tr>
                        <td colspan="8" class="text-danger">No records found.</td>
                    </tr>
                <?php
                }
                $stmt->close();
                ?>
            </tbody>
        </table>

        <a href="./index.php" class="text-decoration-none">Click here</a> to go to hompage.
    </div>

    <script>
        $(document).ready(function() {
            $("#searchBox").on("keyup", function() {
                let query = $(this).val();

                $.ajax({
                    type: "GET",
                    url: "ajax.php",
                    data: {
                        query: query,
                        action: 'search'
                    },
                    dataType: "json",
                    success: function(response) {
                        let tableContent = '';
                        if (response.length > 0) {
                            response.forEach(function(user) {
                                tableContent +=

                                    `
                                <tr>
                                   <td>${user.id}</td>
                                   <td>${user.name}</td>
                                   <td>${user.email}</td>
                                   <td>${user.gender}</td>
                                   <td>${user.city}</td>
                                   <td>${user.created_at}</td>
                                   <td>
                                       <a href="./update.php?id=${user.id}">
                                          <i class="fa-solid fa-edit text-success"></i>
                                       </a>
                                   </td>
                                   <td>
                                       <a href="#" onclick="deleteRecord(${user.id})">
                                          <i class="fa-solid fa-trash text-danger"></i>
                                       </a>
                                   </td>
                                </tr>
                                `
                            });
                        } else {
                            tableContent = ` <tr>
                                                <td colspan="8" class="text-danger">No records found</td>
                                             </tr> `
                        }

                        $("#userTable").html(tableContent);
                    }
                });
            })
        })

        function deleteRecord(id) {
            if (confirm("Are you sure you want to delete this record?")) {
                $.ajax({
                    type: "POST",
                    url: "./ajax.php",
                    data: {
                        id: id,
                        action: 'delete'
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.code === 200) {
                            alert(response.msg);
                            location.reload();
                        } else {
                            alert(response.msg);
                        }
                    }
                });
            }
        }
    </script>
</body>

</html>