
🗂️ Project Structure
CSS-PHP-Project/
│
├── conf/
│   ├── database.php      # PDO helper
│   ├── env.php           # db settings
│
├── css/
│   └── styles.css        # full custom CSS (no frameworks)
│
├── img/
│   └── hero.webp         # homepage hero image (plus products later)
│
├── inc/
│   ├── header.php        # shared header/nav
│   ├── footer.php        # shared footer
│
├── sql/                  # database tables (admins + products)
│
├── templates/            # public-facing pages
│   ├── about.php
│   ├── contact.php
│   ├── login.php
│   ├── register.php
│   ├── shop.php
│   ├── product.php
│
├── admin/
│   ├── products.php      # admin dashboard
│   ├── product-create.php
│   ├── product-edit.php
│   ├── product-delete.php
│
├── index.php             # homepage
└── README.md             # this file :)
