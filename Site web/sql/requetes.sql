-- Insertion des marques
INSERT INTO marques (nom_marque)
VALUES ('Mercedes'),
    ('Audi'),
    ('Porsche');
-- Insertion d'une Porsche pour le test
INSERT INTO voiture (
        modele,
        id_marque,
        prix,
        datesortie,
        kilometrage,
        disponibilite,
        boite_de_vitesse,
        carburant,
        puissance,
        couleur,
        provenance,
        details
    )
VALUES (
        '911 GT3 RS',
        3,
        235000.00,
        '2023-01-01',
        500,
        TRUE,
        'Automatique PDK',
        'Essence',
        525,
        'Rouge Indien',
        'Allemagne',
        'La quintessence de la performance sur circuit, homologuée pour la route. Avec son moteur boxer 4.0L atmosphérique développant 525 ch, elle offre des sensations pures.'
    );
-- Insertion d'une Audi pour le test
INSERT INTO voiture (
        modele,
        id_marque,
        prix,
        datesortie,
        kilometrage,
        disponibilite,
        boite_de_vitesse,
        carburant,
        puissance,
        couleur,
        provenance,
        details
    )
VALUES (
        'Audi RS6 ABT',
        2,
        8100000.00,
        '2023-01-01',
        300,
        TRUE,
        'Automatique PDK',
        'Essence',
        525,
        'Full Black',
        'Allemagne',
        'L’Audi RS6 ABT est une version ultra-performante et exclusive du break RS6, optimisée par le préparateur allemand ABT, avec des moteurs puissants allant jusqu’à 800-1000 chevaux et des éditions limitées prestigieuses.'
    );
-- Insertion d'une Porsche pour le test
INSERT INTO voiture (
        modele,
        id_marque,
        prix,
        datesortie,
        kilometrage,
        disponibilite,
        boite_de_vitesse,
        carburant,
        puissance,
        couleur,
        provenance,
        details
    )
VALUES (
        'Porsche Macane',
        3,
        4750000.00,
        '2023-01-01',
        15000,
        TRUE,
        'Automatique PDK',
        'Essence',
        380,
        'Rouge',
        'Allemagne',
        'Découvrez cette superbe Porsche Macan rouge, une parfaite alliance entre élégance, performance et confort. Son design sportif et raffiné attire immédiatement le regard, avec une carrosserie rouge éclatante qui souligne son caractère dynamique et moderne. À l’intérieur, vous profitez d’un habitacle haut de gamme, équipé de matériaux de qualité, de sièges confortables et de technologies avancées pour une expérience de conduite exceptionnelle.

Sous le capot, ce SUV offre des performances puissantes et une tenue de route remarquable, fidèle à l’ADN sportif de Porsche. Idéale pour la ville comme pour les longs trajets, cette Porsche Macan garantit sécurité, plaisir et prestige à chaque kilomètre.

Une voiture parfaite pour ceux qui recherchent à la fois luxe, puissance et style.'
    );
-- Insertion des images pour la Porsche (idvoiture = 4)
INSERT INTO image (url_image, idvoiture, priorite)
VALUES (
        'porsche/gt3rs/porsche-gt3-rs-rouge.jpg',
        4,
        1
    ),
    (
        'porsche/gt3rs/porsche-gt3-rs-interieur.jpeg',
        4,
        0
    ),
    (
        'porsche/gt3rs/porsche-gt3-rs-pneu.jpeg',
        4,
        0
    ),
    (
        'porsche/gt3rs/porsche-gt3-rs-siege.jpeg',
        4,
        0
    );
-- Insertion des images pour l'Audi (idvoiture = 5)
INSERT INTO image (url_image, idvoiture, priorite)
VALUES ('audi/Audi-rs6-abt-black.png', 5, 1),
    (
        'audi/Audi-rs6-abt-black_interieur.png',
        5,
        0
    ),
    ('audi/Audi-rs6-abt-black_arriere.png', 5, 0),
    ('audi/Audi-rs6-abt-black_pneu.png', 5, 0);
-- Insertion des images pour la Porsche (idvoiture = 6)
INSERT INTO image (url_image, idvoiture, priorite)
VALUES (
        'porsche/macane/Porsche-macane-rouge.png',
        6,
        1
    ),
    (
        'porsche/macane/Porsche-macane-rouge-interieur.png',
        6,
        0
    ),
    (
        'porsche/macane/Porsche-macane-rouge-pneu.png',
        6,
        0
    ),
    (
        'porsche/macane/Porsche-macane-rouge-arriere.png',
        6,
        0
    );
INSERT INTO Service (
        nom_service,
        titre_service,
        description_service,
        image_service
    )
VALUES (
        'Entretien',
        'Révision complète',
        'Vérification générale du véhicule',
        'entretien.jpg'
    ),
    (
        'Nettoyage',
        'Nettoyage premium',
        'Nettoyage intérieur et extérieur',
        'nettoyage.jpg'
    ),
    (
        'Garantie',
        'Extension de garantie',
        'Extension de garantie 2 ans',
        'garantie.jpg'
    );
-- Insertion du contenu pour la Section Hero (Ligne 1)
INSERT INTO contenu (lignecontenu, titre, texte, page)
VALUES (
        1,
        'Votre partenaire de confiance pour les voitures d''occasionss depuis 2009',
        'Consulter le catalogue',
        'accueil'
    );
-- Insertion du contenu pour la Section À propos
INSERT INTO contenu (lignecontenu, titre, texte, page)
VALUES (
        1,
        'À propos de SuperCar',
        'Depuis 2009, SuperCar est votre partenaire de confiance dans l\'acquisition de voitures d\'occasionss. Nous importons des véhicules de qualité supérieure en provenance des plus grands marchés automobiles mondiaux.',
        'apropos'
    ),
    (
        2,
        'Importation mondiale',
        'Véhicules d\'occasionss en provenance du Japon, Singapour, Afrique du Sud, États-Unis, Chine, Allemagne et France',
        'apropos'
    ),
    (
        3,
        '4 Entrepôts',
        'Nos 4 entrepôts stratégiquement placés nous permettent de stocker un large inventaire et d\'assurer des livraisons rapides.',
        'apropos'
    ),
    (
        4,
        'Siège Social',
        'Essayez tous nos modèles dans notre showroom principal',
        'apropos'
    );
-- Insertion du contenu pour la Section Processus
INSERT INTO contenu (lignecontenu, titre, texte, page)
VALUES (
        1,
        'Découverte',
        'Explorez notre catalogue et sélectionnez le modèle qui vous intéresse parmi notre large sélection de véhicules d''occasions importés.',
        'processus'
    ),
    (
        2,
        'Essai au Siège Social',
        'Testez une voiture d''essai de chaque modèle dans notre showroom. Nos conseillers vous accompagnent pour trouver le véhicule idéal.',
        'processus'
    ),
    (
        3,
        'Livraison',
        'Recevez un véhicule d''occasions identique, livré directement depuis nos entrepôts. Rapide, sécurisé et sans surprises.',
        'processus'
    );

-- Insertion d'un compte Administrateur (Mot de passe: cedric123)
INSERT INTO admin (nom, prenom, mail, mot_de_passe)
VALUES (
    'Admin', 
    'Cedric', 
    'cedric@supercar.com', 
    '$2y$10$507uRrxzJLNDCZK5PLq7l.MZE4YeM2AtrBKGFrSRw6DEdnrbDUaS6'
);