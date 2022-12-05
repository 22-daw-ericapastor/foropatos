DROP DATABASE IF EXISTS foropatos;

CREATE DATABASE foropatos;

USE foropatos;

CREATE TABLE users(
  username VARCHAR(20),
  email VARCHAR(50),
  passwd VARCHAR(100),
  is_active TINYINT(1) DEFAULT 1,
  permissions TINYINT(1) DEFAULT 0,
  PRIMARY KEY(username)
);

CREATE TABLE deleted_users(
  id INT UNSIGNED AUTO_INCREMENT,
  username VARCHAR(20),
  email VARCHAR(50),
  passwd VARCHAR(100),
  permissions TINYINT(1) DEFAULT 0,
  PRIMARY KEY(id)
);

CREATE TABLE recipes(
  slug VARCHAR(30),
  src VARCHAR(100),
  title VARCHAR(30),
  description VARCHAR(100),
  admixtures VARCHAR(200),
  making TEXT,
  ratings INT DEFAULT 0,
  points FLOAT DEFAULT 0,
  difficulty TINYINT DEFAULT 1,
  uploaded_date DATETIME DEFAULT NOW()foropatos,
  PRIMARY KEY(slug)
);

CREATE TABLE comments(
  id INT UNSIGNED AUTO_INCREMENT,
  username VARCHAR(50),
  recipe_slug VARCHAR(30),
  recipe_rating INT,
  comment_text VARCHAR(200),
  date_time DATETIME DEFAULT NOW(),
  PRIMARY KEY(id),
  FOREIGN KEY(username) REFERENCES users(username),
  FOREIGN KEY(recipe_slug) REFERENCES recipes(slug)
);

CREATE TABLE messages(
  id INT UNSIGNED AUTO_INCREMENT,
  username VARCHAR(50),
  issue VARCHAR(20),
  issue_slug VARCHAR(20),
  msg_text VARCHAR(500),
  date_time DATETIME DEFAULT NOW(),
  is_read TINYINT(1) DEFAULT 0,
  PRIMARY KEY(id),
  FOREIGN KEY(username) REFERENCES users(username)
);

-- Set default admin
INSERT INTO users (username, email, passwd, permissions)
VALUES ('effy', 'effy@correofalso.com', '$2y$10$8c9K8lZY5Jv83Cvz/xz9pOwhXSXdQ.XU1pKUSQaHbIqWTMJTp1ckO', 1),
  ('effynoadmin', 'effynoadmin@otrocorreofalso.com', '$2y$10$8c9K8lZY5Jv83Cvz/xz9pOwhXSXdQ.XU1pKUSQaHbIqWTMJTp1ckO', 0),
  ('effyadmin', 'effyadmin@estonoesotrocorreofalso.com', '$2y$10$8c9K8lZY5Jv83Cvz/xz9pOwhXSXdQ.XU1pKUSQaHbIqWTMJTp1ckO', 0);

-- Set default images
INSERT INTO recipes (slug, src, title, description, difficulty)
VALUES
  ('la-pikaburger', 'assets/imgs/recipes/burger.png', 'La Pikaburger', 'La Pikaburg... Pika... pikaaa... ¡achú!', 2),
  ('mediterranean-salad', 'assets/imgs/recipes/salad.png', 'Ensalada mediterránea', 'La verdadera ensalada mediterránea... ¿Con cebolla o sin cebolla?', 1),
  ('ramen', 'assets/imgs/recipes/ramen.png', 'Ramen', 'Fideos de esos... japoneses.', 2),
  ('cupcakes', 'assets/imgs/recipes/cupcake.png', 'Cupcakes', '<i>Capqueiqs</i> de todos los sabores y colores.', 3),
  ('comida-casera-para-mascotas', 'assets/imgs/recipes/petfood.png', 'Comida casera para mascotas', 'Aprende a cocinar para tu mejor amigo de manera segura', 3),
  ('recetas-con-atun-en-lata', 'assets/imgs/recipes/tuna.png', 'Recetas con atún en lata', 'Todo lo que puedes hacer con una lata de atún y... ¿más?', 1);
  