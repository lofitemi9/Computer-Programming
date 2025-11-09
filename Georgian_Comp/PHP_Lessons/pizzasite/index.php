<?php
// this is the layout only. the form is poste to save_order.php which does the DB work
include __DIR__ . '/templates/header.php';
?>

<form action="save_order.php" method="post" class="card">
  <fieldset>
    <legend>Your Info</legend>
    <label>Full Name
      <input type="text" name="customer_name" required placeholder="Mandatory">
    </label>
    <label>Phone
      <input type="tel" name="phone" required placeholder="Mandatory">
    </label>
    <label>Email
      <input type="email" name="email" required placeholder="Mandatory">
    </label>
  </fieldset>

  <fieldset>
    <legend>Your Pizza</legend>
    <div class="row">
      <label>Size*
        <select name="size" required>
          <option value="small">Small</option>
          <option value="medium">Medium</option>
          <option value="large">Large</option>
          <option value="xl">XL</option>
        </select>
      </label>
      <label>Crust*
        <select name="crust" required>
          <option value="regular">Regular</option>
          <option value="thin">Thin</option>
          <option value="stuffed">Stuffed</option>
          <option value="gluten_free">Gluten Free</option>
        </select>
      </label>
      <label>Quantity*
        <input type="number" name="quantity" min="1" value="1">
      </label>
    </div>

    <div class="toppings">
      <p>Toppings (optional):</p>
      <div class="grid">
        <?php
        $toppings = ['Pepperoni', 'Mushrooms', 'Onions', 'Green Peppers', 'Black Olives', 'Bacon', 'Ham', 'Pineapple', 'Extra Cheese', 'Jalapenos', 'Tomatoes', 'Spinach', 'Chicken', 'Sausage', 'Feta'];
        foreach ($toppings as $i => $name):
          $id = 'top_' . $i;
        ?>
          <label class="chip" for="<?= $id ?>">
            <input id="<?= $id ?>" type="checkbox" name="toppings[]" value="<?= htmlspecialchars($name) ?>">
            <span><?= htmlspecialchars($name) ?></span>
          </label>
        <?php endforeach; ?>
      </div>
    </div>

    <label>Special Notes
      <textarea name="special_notes" rows="3" placeholder="whatever your allergic to or anything"></textarea>
    </label>
  </fieldset>

  <button type="submit" class="btn-primary">Place Order</button>
</form>

<?php include __DIR__ . '/templates/footer.php'; ?>