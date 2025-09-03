BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS "User" (
	"id"	INTEGER NOT NULL,
	"name"	TEXT,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "user collection" (
	"id"	INTEGER NOT NULL,
	"card_id"	INTEGER NOT NULL,
	"amount"	INTEGER,
	"user_id"	INTEGER NOT NULL,
	PRIMARY KEY("id" AUTOINCREMENT),
	FOREIGN KEY("user_id") REFERENCES "User"("id"),
	FOREIGN KEY("card_id") REFERENCES "Carte"("id")
);
CREATE TABLE IF NOT EXISTS "Carte" (
	"id"	INTEGER NOT NULL,
	"name"	TEXT,
	"rarity"	TEXT,
	"category"	TEXT,
	"size"	REAL,
	PRIMARY KEY("id" AUTOINCREMENT)
);
INSERT INTO "User" VALUES (1,'user1');
INSERT INTO "user collection" VALUES (1,1,5,1);
INSERT INTO "user collection" VALUES (2,2,0,1);
INSERT INTO "user collection" VALUES (3,3,1,1);
INSERT INTO "user collection" VALUES (4,4,3,1);
INSERT INTO "user collection" VALUES (5,5,1,1);
INSERT INTO "Carte" VALUES (1,'nuage1','common','humeur',9.0);
INSERT INTO "Carte" VALUES (2,'nuage2','common','troll',2300.0);
INSERT INTO "Carte" VALUES (3,'nuage3','rare','pixel','0,2');
INSERT INTO "Carte" VALUES (4,'nuage4','rare','humeur',11000.0);
INSERT INTO "Carte" VALUES (5,'nuage5','secret','troll',730.0);
COMMIT;
