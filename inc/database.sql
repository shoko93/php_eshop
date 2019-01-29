BEGIN;

CREATE TABLE categories (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name TEXT NOT NULL
);

INSERT INTO categories (id, name) VALUES
  (1, 'books'),
  (2, 'electronics'),
  (3, 'groceries');

CREATE TABLE products (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  category_id INTEGER NOT NULL REFERENCES categories (id),
  name TEXT NOT NULL,
  price INTEGER NOT NULL
);

INSERT INTO products (category_id, name, price) VALUES
  (1, 'PHPプログラミング', 1500),
  (1, 'Rubyプログラミング', 1250),
  (1, 'Javaプログラミング', 2000),
  (1, 'C#プログラミング', 1750),
  (2, 'ヘッドホン', 2000),
  (2, 'イヤホン', 1500),
  (2, 'モバイルバッテリー', 3000),
  (2, 'マウス', 2500),
  (3, 'チョコレート', 200),
  (3, 'カップラーメン', 500),
  (3, 'インスタントカレー', 1000),
  (3, 'アップルジュース', 300);

CREATE TABLE books (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  product_id INTEGER NOT NULL REFERENCES products (id),
  author TEXT NOT NULL,
  publisher TEXT NOT NULL,
  format INTEGER NOT NULL
);

INSERT INTO books (product_id, author, publisher, format) VALUES
  (1, '田中太郎', 'OO出版', 1),
  (2, '田中花子', 'XX出版', 3),
  (3, '佐藤太郎', 'XX出版', 2),
  (4, '佐藤花子', 'OO出版', 1);

CREATE TABLE electronics (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  product_id INTEGER NOT NULL REFERENCES products (id),
  model_number TEXT NOT NULL,
  brand TEXT NOT NULL
);

INSERT INTO electronics (product_id, model_number, brand) VALUES
  (5, 'H100', 'OO電機'),
  (6, 'E110', 'XX電機'),
  (7, 'M220', 'XX電機'),
  (8, 'BT10', 'OO電機');

CREATE TABLE groceries (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  product_id INTEGER NOT NULL REFERENCES products (id),
  brand TEXT NOT NULL
);

INSERT INTO groceries (product_id, brand) VALUES
  ( 9, 'OO製菓'),
  (10, 'XX食品'),
  (11, 'OO食品'),
  (12, 'XX飲料');

CREATE TABLE user_login (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name TEXT NOT NULL,
  email TEXT NOT NULL,
  password TEXT NOT NULL
);

CREATE TABLE user_phone (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  user_id INTEGER NOT NULL REFERENCES user_login (id),
  label TEXT NOT NULL,
  phone_number TEXT NOT NULL
);

CREATE TABLE user_address (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  user_id INTEGER NOT NULL REFERENCES user_login (id),
  name_to TEXT NOT NULL,
  label TEXT NOT NULL,
  postcode TEXT NOT NULL,
  prefecture TEXT NOT NULL,
  address TEXT NOT NULL,
  gift INTEGER DEFAULT 0,
  comment TEXT DEFAULT NULL,
  phone_id INTEGER NOT NULL
);

CREATE TABLE temp_customer (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name TEXT NOT NULL,
  email TEXT NOT NULL,
  phone_number TEXT NOT NULL,
  postcode TEXT NOT NULL,
  prefecture TEXT NOT NULL,
  address TEXT NOT NULL
);

CREATE TABLE order_record (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  user_id INTEGER DEFAULT 0,
  address_id INTEGER DEFAULT 0,
  customer_id INTEGER DEFAULT 0,
  payment INTEGER NOT NULL,
  paid INTEGER DEFAULT 0,
  shipped INTEGER DEFAULT 0
);

CREATE TABLE order_product (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  order_id INTEGER NOT NULL REFERENCES order_record (id),
  product_id INTEGER NOT NULL REFERENCES products (id),
  quantity INTEGER NOT NULL
);

COMMIT;
