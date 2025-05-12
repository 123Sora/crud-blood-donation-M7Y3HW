<?php
include 'blood_db.php';

if (isset($_POST['action']) && ($_POST['action'] === 'create' || $_POST['action'] === 'update')) {
    $name = $conn->real_escape_string($_POST['name']);
    $blood_group = $conn->real_escape_string($_POST['blood_group']);
    $phone = $conn->real_escape_string($_POST['phone']);

    $last_donation = !empty($_POST['last_donation']) ? "'" . $conn->real_escape_string($_POST['last_donation']) . "'" : "NULL";
    $city = $conn->real_escape_string($_POST['city']);

    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'images_uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $imageName = uniqid() . '_' . $_FILES['image']['name'];
        $imagePath = $uploadDir . $imageName;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            $image = $imageName;
        } else {
            $message = "Failed to upload image.";
            $message_type = "danger";
            header("Location: index.php?message=" . urlencode($message) . "&message_type=" . $message_type);
            exit();
        }
    }

    if ($_POST['action'] === 'create') {
        $sql = "INSERT INTO donors (name, blood_group, phone, last_donation, city, image) VALUES ('$name', '$blood_group', '$phone', $last_donation, '$city', '$image')";
        if ($conn->query($sql) === TRUE) {
            $message = "New donor created successfully.";
            $message_type = "success";
        } else {
            $message = "Error creating donor: " . $conn->error;
            $message_type = "danger";
        }
    } elseif ($_POST['action'] === 'update') {
        $id = $conn->real_escape_string($_POST['id']);
        $old_image = $conn->real_escape_string($_POST['old_image']);

        if ($image) {
            // New image uploaded
            if (!empty($old_image) && file_exists('images_uploads/' . $old_image)) {
                unlink('images_uploads/' . $old_image); 
            }
            $sql = "UPDATE donors SET name='$name', blood_group='$blood_group', phone='$phone', last_donation=$last_donation, city='$city', image='$image', updated_at=NOW() WHERE id=$id";
        } else {
            // No new image uploaded, keep the old one
             $sql = "UPDATE donors SET name='$name', blood_group='$blood_group', phone='$phone', last_donation=$last_donation, city='$city', updated_at=NOW() WHERE id=$id";
        }

        if ($conn->query($sql) === TRUE) {
            $message = "Donor updated successfully.";
            $message_type = "success";
        } else {
            $message = "Error updating donor: " . $conn->error;
            $message_type = "danger";
        }
    }
    header("Location: index.php?message=" . urlencode($message) . "&message_type=" . $message_type);
    exit();
} else {
    header("Location: index.php");
    exit();
}
?>
