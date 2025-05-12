<?php
if (!isset($donor)) {
    echo "Error: \$donor is not defined.  This file should be included from index.php, after fetching donor data.";
    exit; 
}
?>
<form action="add_update_blood.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="action" value="update">
    <input type="hidden" name="id" value="<?php echo $donor['id']; ?>">
    <input type="hidden" name="old_image" value="<?php echo htmlspecialchars($donor['image']); ?>">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($donor['name']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" class="form-control" id="image" name="image">
        <?php if (!empty($donor['image'])): ?>
            <img src="images_uploads/<?php echo htmlspecialchars($donor['image']); ?>" alt="Current Image" class="img-thumbnail mt-2" width="100">
            <small class="form-text text-muted">Leave blank to keep the current image.</small>
        <?php endif; ?>
    </div>
    <div class="mb-3">
        <label for="blood_group" class="form-label">Blood Group</label>
        <select class="form-select" id="blood_group" name="blood_group" required>
            <option value="">Select Blood Group</option>
            <option value="A+" <?php if ($donor['blood_group'] === 'A+') echo 'selected'; ?>>A+</option>
            <option value="A-" <?php if ($donor['blood_group'] === 'A-') echo 'selected'; ?>>A-</option>
            <option value="B+" <?php if ($donor['blood_group'] === 'B+') echo 'selected'; ?>>B+</option>
            <option value="B-" <?php if ($donor['blood_group'] === 'B-') echo 'selected'; ?>>B-</option>
            <option value="AB+" <?php if ($donor['blood_group'] === 'AB+') echo 'selected'; ?>>AB+</option>
            <option value="AB-" <?php if ($donor['blood_group'] === 'AB-') echo 'selected'; ?>>AB-</option>
            <option value="O+" <?php if ($donor['blood_group'] === 'O+') echo 'selected'; ?>>O+</option>
            <option value="O-" <?php if ($donor['blood_group'] === 'O-') echo 'selected'; ?>>O-</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>
        <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($donor['phone']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="last_donation" class="form-label">Last Donation Date</label>
        <input type="date" class="form-control" id="last_donation" name="last_donation" value="<?php echo htmlspecialchars($donor['last_donation']); ?>">
    </div>
    <div class="mb-3">
        <label for="city" class="form-label">City</label>
        <input type="text" class="form-control" id="city" name="city" value="<?php echo htmlspecialchars($donor['city']); ?>">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Update Donor</button>
    </div>
</form>
