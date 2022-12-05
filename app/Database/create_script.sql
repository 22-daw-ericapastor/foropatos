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
  uploaded_date DATETIME DEFAULT NOW(),
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
  issue_slug VARCHAR(20) UNIQUE,
  msg_text VARCHAR(500),
  date_time DATETIME DEFAULT NOW(),
  is_read TINYINT(1) DEFAULT 0,
  PRIMARY KEY(id),
  FOREIGN KEY(username) REFERENCES users(username)
);

-- Set default admin
INSERT INTO users (username, email, passwd, permissions)
VALUES ('user0', 'correo@email', '$2y$10$OOirP9Cl3o4fy.BIKIvIquDN.mmDryXo14whDVS2xWsuy5RB6s47m', 1);

-- Default users
INSERT INTO users(username, email, passwd)
VALUES
  ('user1', 'correo@email', '$2y$10$OOirP9Cl3o4fy.BIKIvIquDN.mmDryXo14whDVS2xWsuy5RB6s47m'),
  ('user2', 'correo@email', '$2y$10$OOirP9Cl3o4fy.BIKIvIquDN.mmDryXo14whDVS2xWsuy5RB6s47m'),
  ('user3', 'correo@email', '$2y$10$OOirP9Cl3o4fy.BIKIvIquDN.mmDryXo14whDVS2xWsuy5RB6s47m'),
  ('user4', 'correo@email', '$2y$10$OOirP9Cl3o4fy.BIKIvIquDN.mmDryXo14whDVS2xWsuy5RB6s47m'),
  ('user5', 'correo@email', '$2y$10$OOirP9Cl3o4fy.BIKIvIquDN.mmDryXo14whDVS2xWsuy5RB6s47m'),
  ('user6', 'correo@email', '$2y$10$OOirP9Cl3o4fy.BIKIvIquDN.mmDryXo14whDVS2xWsuy5RB6s47m'),
  ('user7', 'correo@email', '$2y$10$OOirP9Cl3o4fy.BIKIvIquDN.mmDryXo14whDVS2xWsuy5RB6s47m'),
  ('user8', 'correo@email', '$2y$10$OOirP9Cl3o4fy.BIKIvIquDN.mmDryXo14whDVS2xWsuy5RB6s47m'),
  ('user9', 'correo@email', '$2y$10$OOirP9Cl3o4fy.BIKIvIquDN.mmDryXo14whDVS2xWsuy5RB6s47m'),
  ('user10', 'correo@email', '$2y$10$OOirP9Cl3o4fy.BIKIvIquDN.mmDryXo14whDVS2xWsuy5RB6s47m'),
  ('user11', 'correo@email', '$2y$10$OOirP9Cl3o4fy.BIKIvIquDN.mmDryXo14whDVS2xWsuy5RB6s47m'),
  ('user12', 'correo@email', '$2y$10$OOirP9Cl3o4fy.BIKIvIquDN.mmDryXo14whDVS2xWsuy5RB6s47m'),
  ('user13', 'correo@email', '$2y$10$OOirP9Cl3o4fy.BIKIvIquDN.mmDryXo14whDVS2xWsuy5RB6s47m'),
  ('user14', 'correo@email', '$2y$10$OOirP9Cl3o4fy.BIKIvIquDN.mmDryXo14whDVS2xWsuy5RB6s47m');

-- Set default recipes
INSERT INTO recipes (slug, src, title, description, difficulty)
VALUES
  ('la-pikaburger', 'assets/imgs/recipes/burger.png', 'La Pikaburger', 'La Pikaburg... Pika... pikaaa... ¡achú!', 2),
  ('mediterranean-salad', 'assets/imgs/recipes/salad.png', 'Ensalada mediterránea', 'La verdadera ensalada mediterránea... ¿Con cebolla o sin cebolla?', 1),
  ('ramen', 'assets/imgs/recipes/ramen.png', 'Ramen', 'Fideos de esos... japoneses.', 2),
  ('cupcakes', 'assets/imgs/recipes/cupcake.png', 'Cupcakes', '<i>Capqueiqs</i> de todos los sabores y colores.', 3),
  ('comida-casera-para-mascotas', 'assets/imgs/recipes/petfood.png', 'Comida casera para mascotas', 'Aprende a cocinar para tu mejor amigo de manera segura', 3),
  ('recetas-con-atun-en-lata', 'assets/imgs/recipes/tuna.png', 'Recetas con atún en lata', 'Todo lo que puedes hacer con una lata de atún y... ¿más?', 1);
  
-- Initial messages
INSERT INTO messages (username, issue, issue_slug, msg_text)
VALUES
  ('user4', 'qwe', 'qwe', 'wqe'),
  ('user7', 'qwe', 'qwe1', 'wqe'),
  ('user3', 'qwe', 'qwe2', 'wqe'),
  ('user8', 'qwe', 'qwe3', 'wqe'),
  ('user10', 'qwe', 'qw4e', 'wqe'),
  ('user5', 'qwe', 'qwe5', 'wqe'),
  ('user9', 'qwe', 'qwe6', 'wqe'),
  ('user2', 'qwe', 'qwe7', 'wqe'),
  ('user0', 'qwe', 'qwe8', 'wqe'),
  ('user14', 'qwe', 'qw9e', 'wqe'),
  ('user6', 'qwe', 'qwe0', 'wqe'),
  ('user3', 'qwe', 'qw1e', 'wqe'),
  ('user13', 'qwe', 'qw2e', 'wqe'),
  ('user6', 'qwe', 'qw3e', 'wqe'),
  ('user12', 'qwe', 'qwe4', 'wqe');
  