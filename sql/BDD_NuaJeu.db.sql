CREATE TABLE IF NOT EXISTS Carte (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    rarity VARCHAR(50),
    category VARCHAR(50),
    size FLOAT
);

CREATE TABLE IF NOT EXISTS User (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS user_collection (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    card_id INT NOT NULL,
    amount INT,
    user_id INT NOT NULL,
    FOREIGN KEY(user_id) REFERENCES User(id),
    FOREIGN KEY(card_id) REFERENCES Carte(id)
);

INSERT INTO User (id, name) VALUES (1, 'user1');

INSERT INTO Carte (id, name, rarity, category, size) VALUES
(1, 'nuage1','common','humeur',9.0),
(2, 'nuage2','common','troll',2300.0),
(3, 'nuage3','rare','pixel',0.2),
(4, 'nuage4','rare','humeur',11000.0),
(5, 'nuage5','secret','troll',730.0);

INSERT INTO user_collection (id, card_id, amount, user_id) VALUES
(1,1,5,1),
(2,2,0,1),
(3,3,1,1),
(4,4,3,1),
(5,5,1,1);
