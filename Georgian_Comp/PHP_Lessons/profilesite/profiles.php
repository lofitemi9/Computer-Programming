<?php
$title = 'All Profiles';
require_once __DIR__ . '/./config.php';
require_once __DIR__ . '/./classes/ProfileRepository.php';
require_once __DIR__ . '/./templates/header.php';

$repo = new ProfileRepository();
$profiles = $repo->all();
?>
<h2>All Profiles</h2>

<?php if (!$profiles): ?>
  <p class="muted">No profiles yet. Create one above!</p>
<?php else: ?>
  <div class="grid">
    <?php foreach ($profiles as $profile): ?>
      <div class="card">
        <img src="<?= htmlspecialchars($profile['image_path']) ?>" alt="<?= htmlspecialchars($profile['name']) ?>">
        <h3><?= htmlspecialchars($profile['name']) ?></h3>
        <p class="muted"><?= htmlspecialchars($profile['email']) ?></p>
        <p><?= nl2br(htmlspecialchars($profile['bio'])) ?></p>
        <a class="button" href="profile.php?id=<?= (int)$profile['id'] ?>">View Profile</a>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php require_once __DIR__ . '/./templates/footer.php'; ?>
