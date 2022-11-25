DROP DATABASE IF EXISTS web_recetas;

CREATE DATABASE web_recetas;

USE web_recetas;

CREATE TABLE IF NOT EXISTS users(
  username VARCHAR(20),
  email VARCHAR(50),
  passwd VARCHAR(100),
  activo TINYINT(1) DEFAULT 1,
  permissions TINYINT(1) DEFAULT 0,
  PRIMARY KEY(username)
);

CREATE TABLE IF NOT EXISTS recipes(
  id INT UNSIGNED AUTO_INCREMENT,
  slug VARCHAR(20),
  src VARCHAR(100),
  title VARCHAR(20),
  short_description VARCHAR(100),
  description TEXT DEFAULT 'Cat ipsum dolor sit amet, twitch tail in permanent irritation, get poop stuck in paws jumping out of litter box and run around the house scream meowing and smearing hot cat mud all over pushed the mug off the table, vommit food and eat it again. Cat ipsum dolor sit amet, twitch tail in permanent irritation, get poop stuck in paws jumping out of litter box and run around the house scream meowing and smearing hot cat mud all over pushed the mug off the table, vommit food and eat it again. Cat ipsum dolor sit amet, twitch tail in permanent irritation, get poop stuck in paws jumping out of litter box and run around the house scream meowing and smearing hot cat mud all over pushed the mug off the table, vommit food and eat it again. Cat ipsum dolor sit amet, twitch tail in permanent irritation, get poop stuck in paws jumping out of litter box and run around the house scream meowing and smearing hot cat mud all over pushed the mug off the table, vommit food and eat it again.',
  PRIMARY KEY(id),
  KEY(slug)
);

CREATE TABLE IF NOT EXISTS comments(
  id INT UNSIGNED AUTO_INCREMENT,
  username VARCHAR(50),
  recipe_slug VARCHAR(20),
  comment_text VARCHAR(200),
  date_time DATETIME DEFAULT NOW(),
  PRIMARY KEY(id),
  FOREIGN KEY(username) REFERENCES users(username),
  FOREIGN KEY(recipe_slug) REFERENCES recipes(slug)
);

CREATE TABLE IF NOT EXISTS messages(
  id INT UNSIGNED AUTO_INCREMENT,
  username VARCHAR(50),
  msg_text VARCHAR(500),
  date_time DATETIME,
  PRIMARY KEY(id),
  FOREIGN KEY(username) REFERENCES users(username)
);

-- Set default admin
INSERT INTO users (username, email, passwd, permissions)
VALUES ('effyelle', 'effy@mail.com', '$2y$10$8c9K8lZY5Jv83Cvz/xz9pOwhXSXdQ.XU1pKUSQaHbIqWTMJTp1ckO', 1);

-- Set default images
INSERT INTO recipes (slug, src, title, short_description)
VALUES
  ('la-pikaburger', 'public/assets/imgs/recipes/burger.png', 'La Pikaburger', 'La Pikaburg...<br/>Pika... pikaaa... ¡achú!'),
  ('mediterranean-salad', 'public/assets/imgs/recipes/salad.png', 'Ensalada mediterránea', 'La verdadera ensalada mediterránea... ¿Con cebolla o sin cebolla?'),
  ('ramen', 'public/assets/imgs/recipes/ramen.png', 'Ramen', 'Fideos de esos... japoneses'),
  ('cupcakes', 'public/assets/imgs/recipes/cupcake.png', 'Cupcakes', ''),
  ('comida-mascotas', 'public/assets/imgs/recipes/petfood.png', 'Comida casera para mascotas', 'Aprende a cocinar para tu mejor amigo de manera segura'),
  ('recetas-con-atun', 'public/assets/imgs/recipes/tuna.png', 'Recetas con atún en lata', 'Todo lo que puedes hacer con una lata de atún y... ¿más?');
  
  INSERT INTO comments (username, recipe_slug, comment_text) VALUES ('effyelle', 'cupcakes', 'comentario');