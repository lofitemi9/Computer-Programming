<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/OrderSaver.php';

$successMsg = $errorMsg = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    $db  = new Database();          // instance based dtabase
    $pdo = $db->getConnection();    // PDO handler

    $saver = new OrderSaver($pdo);  // this injects the PDO into the saver
    $id = $saver->save($_POST);

    $successMsg = "Order #{$id} saved!";
  } catch (Throwable $e) {
    $errorMsg = "Could not save order.";
  }
}

if (file_exists(__DIR__ . '/header.php')) include __DIR__ . '/header.php';
?>
<?php if ($successMsg): ?>
  <div class="alert success"><?= htmlspecialchars($successMsg) ?></div>
<?php elseif ($errorMsg): ?>
  <div class="alert error"><?= htmlspecialchars($errorMsg) ?></div>
<?php else: ?>
  <div class="alert">Submit the order form to save an order.</div>
<?php endif; ?>
<?php if (file_exists(__DIR__ . '/footer.php')) include __DIR__ . '/footer.php'; ?>