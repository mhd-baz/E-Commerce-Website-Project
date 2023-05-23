USE `streetNchic`;

INSERT INTO categories VALUES
    ('Tee-Shirt'),
    ('Pantalons'),
    ('Chaussures');

INSERT INTO produits VALUES
    ("Tee-Shirt", "ts01", "Tee-Shirt Uni Noir", "25", "4" ),
    ("Tee-Shirt", "ts02", "Tee-Shirt Uni Jaune", "20", "3" ),
    ("Tee-Shirt", "ts03", "Tee-Shirt manche longue en Coton", "35", "2" ),
    ("Tee-Shirt", "ts04", "Tee-Shirt manche longue tendance", "25", "3" ),
    ("Tee-Shirt", "ts05", "Tee-Shirt blanc uni", "18", "5" ),
    ("Pantalons", "p01", "Pantalon chino marine", "20", "5" ),
    ("Pantalons", "p02", "Jogging pour un week-end d&eacutecontract&eacute", "10", "5" ),
    ("Pantalons", "p03", "Bermuda chino uni aqua", "29.99", "3"  ),
    ("Pantalons", "p04", "Jean straight bleu", "49.99", "3" ),
    ("Pantalons", "p05", "Pantalon de costume extra slim - Noir", "39.99", "5" ),
    ("Chaussures", "ch01", "Basket basse - Bleu Marine", "29.99", "5" ),
    ("Chaussures", "ch02", "Baskets blanches - Blanc", "39.99", "2" ),
    ("Chaussures", "ch03", "Espadrilles ray&eacutees - Bleu Marine", "10", "5"  ),
    ("Chaussures", "ch04", "Chaussures montantes en cuir - Beige", "49.99", "4" ),
    ("Chaussures", "ch05", "Baskets esprit retro - Blanc", "39.99", "5" );

INSERT INTO users (username, password) VALUES 
    ('admin', '$2y$10$HLIziGf6UZmIzD9SP/5tJOpFCpPJVywHHtNrlJIorG46eBAwJWNnm');