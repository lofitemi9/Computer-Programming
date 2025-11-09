USE Temiloluwa200632787 --(switch to your datbase name when teting my code or esle you have your own database);

DROP TABLE IF EXISTS orders;

CREATE TABLE orders (
  id             INT UNSIGNED NOT NULL AUTO_INCREMENT,
  customer_name  VARCHAR(100) NOT NULL,
  phone          VARCHAR(25)  NOT NULL,
  email          VARCHAR(150) NOT NULL,
  size           VARCHAR(20)  NOT NULL,
  crust          VARCHAR(20)  NOT NULL,
  toppings_text  VARCHAR(255) NULL,
  quantity       INT UNSIGNED NOT NULL DEFAULT 1,
  special_notes  TEXT NULL,
  raw_payload    JSON NULL,
  created_at     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
