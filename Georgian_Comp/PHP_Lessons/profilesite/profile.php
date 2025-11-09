<?php
require_once __DIR__ . '/./config.php';
require_once __DIR__ . '/./classes/ProfileRepository.php';

$id = (int)($_GET['id'] ?? 0);
$repo = new ProfileRepository();
$profile = $repo->find($id);

if (!$profile) {
    http_response_code(404);
    exit('Profile not found.');
}

$title = $profile['name'];
require_once __DIR__ . '/./templates/header.php';
?>
<div class="card">
  <img src="<?= htmlspecialchars($profile['image_path']) ?>" alt="<?= htmlspecialchars($profile['name']) ?>">
  <h2><?= htmlspecialchars($profile['name']) ?></h2>
  <p class="muted"><?= htmlspecialchars($profile['email']) ?></p>
  <p><?= nl2br(htmlspecialchars($profile['bio'])) ?></p>
</div>
<?php require_once __DIR__ . '/./templates/footer.php'; ?>
