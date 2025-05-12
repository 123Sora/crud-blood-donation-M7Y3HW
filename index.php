<?php
include 'blood_db.php';

$whereClauses = ["deleted_at IS NULL"];
$searchTerm = "";
$bloodGroupFilter = "";

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = $conn->real_escape_string($_GET['search']);
    $whereClauses[] = "(name LIKE '%$searchTerm%' OR phone LIKE '%$searchTerm%' OR city LIKE '%$searchTerm%')";
}

if (isset($_GET['blood_group']) && !empty($_GET['blood_group'])) {
    $bloodGroupFilter = $conn->real_escape_string($_GET['blood_group']);
    $whereClauses[] = "blood_group = '$bloodGroupFilter'";
}

$sql = "SELECT * FROM donors";
if (!empty($whereClauses)) {
    $sql .= " WHERE " . implode(" AND ", $whereClauses);
}
$sql .= " ORDER BY created_at DESC";

$result = $conn->query($sql);
$donors = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $donors[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Donation System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Blood Donation</h2>
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addDonorModal">Add New Donor</button>

        <div class="row mb-3">
            <div class="col-md-6">
                <form method="GET" class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
            <div class="col-md-4">
                <form method="GET">
                    <select class="form-select" name="blood_group" onchange="this.form.submit()">
                        <option value="">Filter by Blood Group</option>
                        <option value="A+" <?php if ($bloodGroupFilter === 'A+') echo 'selected'; ?>>A+</option>
                        <option value="A-" <?php if ($bloodGroupFilter === 'A-') echo 'selected'; ?>>A-</option>
                        <option value="B+" <?php if ($bloodGroupFilter === 'B+') echo 'selected'; ?>>B+</option>
                        <option value="B-" <?php if ($bloodGroupFilter === 'B-') echo 'selected'; ?>>B-</option>
                        <option value="AB+" <?php if ($bloodGroupFilter === 'AB+') echo 'selected'; ?>>AB+</option>
                        <option value="AB-" <?php if ($bloodGroupFilter === 'AB-') echo 'selected'; ?>>AB-</option>
                        <option value="O+" <?php if ($bloodGroupFilter === 'O+') echo 'selected'; ?>>O+</option>
                        <option value="O-" <?php if ($bloodGroupFilter === 'O-') echo 'selected'; ?>>O-</option>
                    </select>
                </form>
            </div>
        </div>

        <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-<?php echo $_GET['message_type']; ?> alert-dismissible fade show" role="alert">
                <?php echo $_GET['message']; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Blood Group</th>
                    <th>Phone</th>
                    <th>Last Donation</th>
                    <th>City | Province</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($donors)): ?>
                    <tr><td colspan="8">No donors found.</td></tr>
                <?php else: ?>
                    <?php foreach ($donors as $donor): ?>
                        <tr>
                            <td><?php echo $donor['id']; ?></td>
                            <td><?php echo htmlspecialchars($donor['name']); ?></td>
                            <td>
                                <?php if (!empty($donor['image'])): ?>
                                    <img src="images_uploads/<?php echo htmlspecialchars($donor['image']); ?>" alt="<?php echo htmlspecialchars($donor['name']); ?>" width="60" >
                                <?php else: ?>
                                        No Image
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($donor['blood_group']); ?></td>
                            <td><?php echo htmlspecialchars($donor['phone']); ?></td>
                            <td><?php echo htmlspecialchars($donor['last_donation']); ?></td>
                            <td><?php echo htmlspecialchars($donor['city']); ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#viewDonorModal<?php echo $donor['id']; ?>">View</button>
                                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editDonorModal<?php echo $donor['id']; ?>">Edit</button>
                                <form method="POST" action="delete_blood.php" class="d-inline">
                                    <input type="hidden" name="id" value="<?php echo $donor['id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <div class="modal fade" id="viewDonorModal<?php echo $donor['id']; ?>" tabindex="-1" aria-labelledby="viewDonorModalLabel<?php echo $donor['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="viewDonorModalLabel<?php echo $donor['id']; ?>">Donor Details</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <?php include 'view_blood.php'; ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="editDonorModal<?php echo $donor['id']; ?>" tabindex="-1" aria-labelledby="editDonorModalLabel<?php echo $donor['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editDonorModalLabel<?php echo $donor['id']; ?>">Edit Donor</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <?php include 'edit_blood.php'; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="modal fade" id="addDonorModal" tabindex="-1" aria-labelledby="addDonorModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDonorModalLabel">Add New Blood Donor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php include 'create.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#addDonorModal').on('hidden.bs.modal', function () {
                $(this).find('form').trigger('reset');
            });
        });
    </script>
</body>
</html>