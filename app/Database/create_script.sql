DROP DATABASE IF EXISTS foropatos;

CREATE DATABASE foropatos;

USE foropatos;

CREATE TABLE IF NOT EXISTS users(
  username VARCHAR(20),
  email VARCHAR(50),
  passwd VARCHAR(100),
  is_active TINYINT(1) DEFAULT 1,
  permissions TINYINT(1) DEFAULT 0,
  PRIMARY KEY(username)
);

CREATE TABLE IF NOT EXISTS recipes(
  id INT UNSIGNED AUTO_INCREMENT,
  slug VARCHAR(20),
  src VARCHAR(100),
  title VARCHAR(30),
  description VARCHAR(100),
  admixtures VARCHAR(200) DEFAULT 'Cat - "3kg",ipsum - 0.5g,Twitch - <em>Aged like a fine egg</em>',
  making TEXT DEFAULT 'Cat ipsum dolor sit amet, twitch tail in permanent irritation, get poop stuck in paws jumping out of litter box and run around the house scream meowing and smearing hot cat mud all over pushed the mug off the table, vommit food and eat it again. Cat ipsum dolor sit amet, twitch tail in permanent irritation, get poop stuck in paws jumping out of litter box and run around the house scream meowing and smearing hot cat mud all over pushed the mug off the table, vommit food and eat it again. Cat ipsum dolor sit amet, twitch tail in permanent irritation, get poop stuck in paws jumping out of litter box and run around the house scream meowing and smearing hot cat mud all over pushed the mug off the table, vommit food and eat it again.<br/> Cat ipsum dolor sit amet, twitch tail in permanent irritation, get poop stuck in paws jumping out of litter box and run around the house scream meowing and smearing hot cat mud all over pushed the mug off the table, vommit food and eat it again.',
  ratings INT DEFAULT 0,
  points FLOAT DEFAULT 0,
  difficulty TINYINT,
  PRIMARY KEY(id),
  KEY(slug)
);

CREATE TABLE IF NOT EXISTS comments(
  id INT UNSIGNED AUTO_INCREMENT,
  username VARCHAR(50),
  recipe_slug VARCHAR(25),
  recipe_rating INT,
  comment_text VARCHAR(200),
  date_time DATETIME DEFAULT NOW(),
  PRIMARY KEY(id),
  FOREIGN KEY(username) REFERENCES users(username),
  FOREIGN KEY(recipe_slug) REFERENCES recipes(slug)
);

CREATE TABLE IF NOT EXISTS messages(
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
VALUES ('effy', 'effy@mail.com', '$2y$10$8c9K8lZY5Jv83Cvz/xz9pOwhXSXdQ.XU1pKUSQaHbIqWTMJTp1ckO', 1),
  ('effynoadmin', 'effy@noadmin.com', '$2y$10$8c9K8lZY5Jv83Cvz/xz9pOwhXSXdQ.XU1pKUSQaHbIqWTMJTp1ckO', 0);

-- Set default images
INSERT INTO recipes (slug, src, title, description, difficulty)
VALUES
  ('la-pikaburger', 'public/assets/imgs/recipes/burger.png', 'La Pikaburger', 'La Pikaburg...<br/>Pika... pikaaa... ¡achú!', 2),
  ('mediterranean-salad', 'public/assets/imgs/recipes/salad.png', 'Ensalada mediterránea', 'La verdadera ensalada mediterránea... ¿Con cebolla o sin cebolla?', 1),
  ('ramen', 'public/assets/imgs/recipes/ramen.png', 'Ramen', 'Fideos de esos... japoneses.', 2),
  ('cupcakes', 'public/assets/imgs/recipes/cupcake.png', 'Cupcakes', '<i>Capqueiqs</i> de todos los sabores y colores.', 3),
  ('comida-mascotas', 'public/assets/imgs/recipes/petfood.png', 'Comida casera para mascotas', 'Aprende a cocinar para tu mejor amigo de manera segura', 3),
  ('recetas-con-atun', 'public/assets/imgs/recipes/tuna.png', 'Recetas con atún en lata', 'Todo lo que puedes hacer con una lata de atún y... ¿más?', 1);