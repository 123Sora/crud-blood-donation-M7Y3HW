<?php
if (!isset($donor)) {
    echo "<p>Error: Donor data is not available.</p>";
    exit; 
}
?>

<div class="card">
  <div class="card-body">
    <h5 class="card-title">Donor Details</h5>
    <ul class="list-group list-group-flush">
      <li class="list-group-item"><strong>ID:</strong> <?php echo htmlspecialchars($donor['id']); ?></li>
      <li class="list-group-item"><strong>Name:</strong> <?php echo htmlspecialchars($donor['name']); ?></li>
      <li class="list-group-item">
        <strong>Image:</strong>
        <?php if (!empty($donor['image'])): ?>
          <img src="images_uploads/<?php echo htmlspecialchars($donor['image']); ?>" alt="<?php echo htmlspecialchars($donor['name']); ?>" width="100" class="img-thumbnail">
        <?php else: ?>
          No Image
        <?php endif; ?>
      </li>
      <li class="list-group-item"><strong>Blood Group:</strong> <?php echo htmlspecialchars($donor['blood_group']); ?></li>
      <li class="list-group-item"><strong>Phone:</strong> <?php echo htmlspecialchars($donor['phone']); ?></li>
      <li class="list-group-item"><strong>Last Donation:</strong> <?php echo htmlspecialchars($donor['last_donation']); ?></li>
      <li class="list-group-item"><strong>City:</strong> <?php echo htmlspecialchars($donor['city']); ?></li>
       <li class="list-group-item"><strong>Created At:</strong> <?php echo htmlspecialchars($donor['created_at']); ?></li>
        <li class="list-group-item"><strong>Updated At:</strong> <?php echo htmlspecialchars($donor['updated_at']); ?></li>
    </ul>
  </div>
</div>
