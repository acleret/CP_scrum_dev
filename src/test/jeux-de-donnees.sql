ALTER TABLE `inter_dev_projet`
  DROP FOREIGN KEY `inter_dev_projet_ibfk_1`,
  DROP FOREIGN KEY `inter_dev_projet_ibfk_2`;
ALTER TABLE `projet`
  DROP FOREIGN KEY `projet_ibfk_1`,
  DROP FOREIGN KEY `projet_ibfk_2`;
ALTER TABLE `sprint`
  DROP FOREIGN KEY `sprint_ibfk_1`;
ALTER TABLE `tache`
  DROP FOREIGN KEY `tache_ibfk_1`,
  DROP FOREIGN KEY `tache_ibfk_2`;
ALTER TABLE `us`
  DROP FOREIGN KEY `us_ibfk_1`;

TRUNCATE TABLE `projet`;
TRUNCATE TABLE `developpeur`;
TRUNCATE TABLE `inter_dev_projet`;

ALTER TABLE `inter_dev_projet`
  ADD CONSTRAINT `inter_dev_projet_ibfk_1` FOREIGN KEY (`DEV_id`) REFERENCES `developpeur` (`DEV_id`),
  ADD CONSTRAINT `inter_dev_projet_ibfk_2` FOREIGN KEY (`PRO_id`) REFERENCES `projet` (`PRO_id`);
ALTER TABLE `projet`
  ADD CONSTRAINT `projet_ibfk_1` FOREIGN KEY (`DEV_idProductOwner`) REFERENCES `developpeur` (`DEV_id`),
  ADD CONSTRAINT `projet_ibfk_2` FOREIGN KEY (`DEV_idScrumMaster`) REFERENCES `developpeur` (`DEV_id`);
ALTER TABLE `sprint`
  ADD CONSTRAINT `sprint_ibfk_1` FOREIGN KEY (`PRO_id`) REFERENCES `projet` (`PRO_id`);
ALTER TABLE `tache`
  ADD CONSTRAINT `tache_ibfk_1` FOREIGN KEY (`DEV_id`) REFERENCES `developpeur` (`DEV_id`),
  ADD CONSTRAINT `tache_ibfk_2` FOREIGN KEY (`US_id`) REFERENCES `us` (`US_id`);
ALTER TABLE `us`
  ADD CONSTRAINT `us_ibfk_1` FOREIGN KEY (`SPR_id`) REFERENCES `sprint` (`SPR_id`);

INSERT INTO `developpeur` (`DEV_prenom`, `DEV_nom`, `DEV_pseudo`, `DEV_mdp`, `DEV_mail`, `DEV_urlAvatar`, `DEV_date_creation`) VALUES
("devprenom01", "devnom01", "devpseudo01", "devmdp01", "dev@mail01", "", Now()),
("devprenom02", "devnom02", "devpseudo02", "devmdp02", "dev@mail02", "", Now()),
("devprenom03", "devnom03", "devpseudo03", "devmdp03", "dev@mail03", "", Now()),
("devprenom04", "devnom04", "devpseudo04", "devmdp04", "dev@mail04", "", Now()),
("devprenom05", "devnom05", "devpseudo05", "devmdp05", "dev@mail05", "", Now()),
("devprenom06", "devnom06", "devpseudo06", "devmdp06", "dev@mail06", "", Now()),
("devprenom07", "devnom07", "devpseudo07", "devmdp07", "dev@mail07", "", Now()),
("devprenom08", "devnom08", "devpseudo08", "devmdp08", "dev@mail08", "", Now()),
("devprenom09", "devnom09", "devpseudo09", "devmdp09", "dev@mail09", "", Now()),
("devprenom10", "devnom10", "devpseudo10", "devmdp10", "dev@mail10", "", Now()),
("devprenom11", "devnom11", "devpseudo11", "devmdp11", "dev@mail11", "", Now()),
("devprenom12", "devnom12", "devpseudo12", "devmdp12", "dev@mail12", "", Now()),
("devprenom13", "devnom13", "devpseudo13", "devmdp13", "dev@mail13", "", Now()),
("devprenom14", "devnom14", "devpseudo14", "devmdp14", "dev@mail14", "", Now()),
("devprenom15", "devnom15", "devpseudo15", "devmdp15", "dev@mail15", "", Now()),
("devprenom16", "devnom16", "devpseudo16", "devmdp16", "dev@mail16", "", Now()),
("devprenom17", "devnom17", "devpseudo17", "devmdp17", "dev@mail17", "", Now()),
("devprenom18", "devnom18", "devpseudo18", "devmdp18", "dev@mail18", "", Now()),
("devprenom19", "devnom19", "devpseudo19", "devmdp19", "dev@mail19", "", Now()),
("devprenom20", "devnom20", "devpseudo20", "devmdp20", "dev@mail20", "", Now()),
("devprenom21", "devnom21", "devpseudo21", "devmdp21", "dev@mail21", "", Now()),
("devprenom22", "devnom22", "devpseudo22", "devmdp22", "dev@mail22", "", Now()),
("devprenom23", "devnom23", "devpseudo23", "devmdp23", "dev@mail23", "", Now()),
("devprenom24", "devnom24", "devpseudo24", "devmdp24", "dev@mail24", "", Now()),
("devprenom25", "devnom25", "devpseudo25", "devmdp25", "dev@mail25", "", Now()),
("devprenom26", "devnom26", "devpseudo26", "devmdp26", "dev@mail26", "", Now()),
("devprenom27", "devnom27", "devpseudo27", "devmdp27", "dev@mail27", "", Now()),
("devprenom28", "devnom28", "devpseudo28", "devmdp28", "dev@mail28", "", Now()),
("devprenom29", "devnom29", "devpseudo29", "devmdp29", "dev@mail29", "", Now()),
("devprenom30", "devnom30", "devpseudo30", "devmdp30", "dev@mail30", "", Now());

INSERT INTO `projet`(`PRO_nom`, `PRO_client`, `PRO_description`, `PRO_date_creation`, `DEV_idProductOwner`, `DEV_idScrumMaster`) VALUES
("projet001", "clientprojet001", "descriptionprojet001", Now(), 1, 1),
("projet002", "clientprojet002", "descriptionprojet002", Now(), 1, 2),
("projet003", "clientprojet003", "descriptionprojet003", Now(), 2, 2),
("projet004", "clientprojet004", "descriptionprojet004", Now(), 2, 1),
("projet005", "clientprojet005", "descriptionprojet005", Now(), 1, 1),
("projet006", "clientprojet006", "descriptionprojet006", Now(), 1, 2),
("projet007", "clientprojet007", "descriptionprojet007", Now(), 2, 2),
("projet008", "clientprojet008", "descriptionprojet008", Now(), 2, 1),
("projet009", "clientprojet009", "descriptionprojet009", Now(), 1, 1),
("projet010", "clientprojet010", "descriptionprojet010", Now(), 1, 1),
("projet011", "clientprojet011", "descriptionprojet011", Now(), 1, 1),
("projet012", "clientprojet012", "descriptionprojet012", Now(), 1, 1),
("projet013", "clientprojet013", "descriptionprojet013", Now(), 1, 1),
("projet014", "clientprojet014", "descriptionprojet014", Now(), 1, 1),
("projet015", "clientprojet015", "descriptionprojet015", Now(), 1, 1),
("projet016", "clientprojet016", "descriptionprojet016", Now(), 1, 1),
("projet017", "clientprojet017", "descriptionprojet017", Now(), 1, 1),
("projet018", "clientprojet018", "descriptionprojet018", Now(), 1, 1),
("projet019", "clientprojet019", "descriptionprojet019", Now(), 1, 1),
("projet020", "clientprojet020", "descriptionprojet020", Now(), 1, 1),
("projet021", "clientprojet021", "descriptionprojet021", Now(), 1, 1),
("projet022", "clientprojet022", "descriptionprojet022", Now(), 1, 1),
("projet023", "clientprojet023", "descriptionprojet023", Now(), 1, 1),
("projet024", "clientprojet024", "descriptionprojet024", Now(), 1, 1),
("projet025", "clientprojet025", "descriptionprojet025", Now(), 1, 1),
("projet026", "clientprojet026", "descriptionprojet026", Now(), 1, 1),
("projet027", "clientprojet027", "descriptionprojet027", Now(), 1, 1),
("projet028", "clientprojet028", "descriptionprojet028", Now(), 1, 1),
("projet029", "clientprojet029", "descriptionprojet029", Now(), 1, 1),
("projet030", "clientprojet030", "descriptionprojet030", Now(), 1, 1),
("projet031", "clientprojet031", "descriptionprojet031", Now(), 1, 1),
("projet032", "clientprojet032", "descriptionprojet032", Now(), 1, 1),
("projet033", "clientprojet033", "descriptionprojet033", Now(), 1, 1),
("projet034", "clientprojet034", "descriptionprojet034", Now(), 1, 1),
("projet035", "clientprojet035", "descriptionprojet035", Now(), 1, 1),
("projet036", "clientprojet036", "descriptionprojet036", Now(), 1, 1),
("projet037", "clientprojet037", "descriptionprojet037", Now(), 1, 1),
("projet038", "clientprojet038", "descriptionprojet038", Now(), 1, 1),
("projet039", "clientprojet039", "descriptionprojet039", Now(), 1, 1),
("projet040", "clientprojet040", "descriptionprojet040", Now(), 1, 1),
("projet041", "clientprojet041", "descriptionprojet041", Now(), 1, 1),
("projet042", "clientprojet042", "descriptionprojet042", Now(), 1, 1),
("projet043", "clientprojet043", "descriptionprojet043", Now(), 1, 1),
("projet044", "clientprojet044", "descriptionprojet044", Now(), 1, 1),
("projet045", "clientprojet045", "descriptionprojet045", Now(), 1, 1),
("projet046", "clientprojet046", "descriptionprojet046", Now(), 1, 1),
("projet047", "clientprojet047", "descriptionprojet047", Now(), 1, 1),
("projet048", "clientprojet048", "descriptionprojet048", Now(), 1, 1),
("projet049", "clientprojet049", "descriptionprojet049", Now(), 1, 1),
("projet040", "clientprojet040", "descriptionprojet040", Now(), 1, 1),
("projet041", "clientprojet041", "descriptionprojet041", Now(), 1, 1),
("projet042", "clientprojet042", "descriptionprojet042", Now(), 1, 1),
("projet043", "clientprojet043", "descriptionprojet043", Now(), 1, 1),
("projet044", "clientprojet044", "descriptionprojet044", Now(), 1, 1),
("projet045", "clientprojet045", "descriptionprojet045", Now(), 1, 1),
("projet046", "clientprojet046", "descriptionprojet046", Now(), 1, 1),
("projet047", "clientprojet047", "descriptionprojet047", Now(), 1, 1),
("projet048", "clientprojet048", "descriptionprojet048", Now(), 1, 1),
("projet049", "clientprojet049", "descriptionprojet049", Now(), 1, 1),
("projet050", "clientprojet050", "descriptionprojet050", Now(), 1, 1),
("projet051", "clientprojet051", "descriptionprojet051", Now(), 1, 1),
("projet052", "clientprojet052", "descriptionprojet052", Now(), 1, 1),
("projet053", "clientprojet053", "descriptionprojet053", Now(), 1, 1),
("projet054", "clientprojet054", "descriptionprojet054", Now(), 1, 1),
("projet055", "clientprojet055", "descriptionprojet055", Now(), 1, 1),
("projet056", "clientprojet056", "descriptionprojet056", Now(), 1, 1),
("projet057", "clientprojet057", "descriptionprojet057", Now(), 1, 1),
("projet058", "clientprojet058", "descriptionprojet058", Now(), 1, 1),
("projet059", "clientprojet059", "descriptionprojet059", Now(), 1, 1),
("projet060", "clientprojet060", "descriptionprojet060", Now(), 1, 1),
("projet061", "clientprojet061", "descriptionprojet061", Now(), 1, 1),
("projet062", "clientprojet062", "descriptionprojet062", Now(), 1, 1),
("projet063", "clientprojet063", "descriptionprojet063", Now(), 1, 1),
("projet064", "clientprojet064", "descriptionprojet064", Now(), 1, 1),
("projet065", "clientprojet065", "descriptionprojet065", Now(), 1, 1),
("projet066", "clientprojet066", "descriptionprojet066", Now(), 1, 1),
("projet067", "clientprojet067", "descriptionprojet067", Now(), 1, 1),
("projet068", "clientprojet068", "descriptionprojet068", Now(), 1, 1),
("projet069", "clientprojet069", "descriptionprojet069", Now(), 1, 1),
("projet070", "clientprojet070", "descriptionprojet070", Now(), 1, 1),
("projet071", "clientprojet071", "descriptionprojet071", Now(), 1, 1),
("projet072", "clientprojet072", "descriptionprojet072", Now(), 1, 1),
("projet073", "clientprojet073", "descriptionprojet073", Now(), 1, 1),
("projet074", "clientprojet074", "descriptionprojet074", Now(), 1, 1),
("projet075", "clientprojet075", "descriptionprojet075", Now(), 1, 1),
("projet076", "clientprojet076", "descriptionprojet076", Now(), 1, 1),
("projet077", "clientprojet077", "descriptionprojet077", Now(), 1, 1),
("projet078", "clientprojet078", "descriptionprojet078", Now(), 1, 1),
("projet079", "clientprojet079", "descriptionprojet079", Now(), 1, 1),
("projet080", "clientprojet080", "descriptionprojet080", Now(), 1, 1),
("projet081", "clientprojet081", "descriptionprojet081", Now(), 1, 1),
("projet082", "clientprojet082", "descriptionprojet082", Now(), 1, 1),
("projet083", "clientprojet083", "descriptionprojet083", Now(), 1, 1),
("projet084", "clientprojet084", "descriptionprojet084", Now(), 1, 1),
("projet085", "clientprojet085", "descriptionprojet085", Now(), 1, 1),
("projet086", "clientprojet086", "descriptionprojet086", Now(), 1, 1),
("projet087", "clientprojet087", "descriptionprojet087", Now(), 1, 1),
("projet088", "clientprojet088", "descriptionprojet088", Now(), 1, 1),
("projet089", "clientprojet089", "descriptionprojet089", Now(), 1, 1),
("projet090", "clientprojet090", "descriptionprojet090", Now(), 1, 1),
("projet091", "clientprojet091", "descriptionprojet091", Now(), 1, 1),
("projet092", "clientprojet092", "descriptionprojet092", Now(), 1, 1),
("projet093", "clientprojet093", "descriptionprojet093", Now(), 1, 1),
("projet094", "clientprojet094", "descriptionprojet094", Now(), 1, 1),
("projet095", "clientprojet095", "descriptionprojet095", Now(), 1, 1),
("projet096", "clientprojet096", "descriptionprojet096", Now(), 1, 1),
("projet097", "clientprojet097", "descriptionprojet097", Now(), 1, 1),
("projet098", "clientprojet098", "descriptionprojet098", Now(), 1, 1),
("projet099", "clientprojet099", "descriptionprojet099", Now(), 1, 1),
("projet100", "clientprojet100", "descriptionprojet100", Now(), 1, 1),
("projet101", "clientprojet101", "descriptionprojet101", Now(), 1, 1),
("projet102", "clientprojet102", "descriptionprojet102", Now(), 1, 1),
("projet103", "clientprojet103", "descriptionprojet103", Now(), 1, 1),
("projet104", "clientprojet104", "descriptionprojet104", Now(), 1, 1),
("projet105", "clientprojet105", "descriptionprojet105", Now(), 1, 1),
("projet106", "clientprojet106", "descriptionprojet106", Now(), 1, 1),
("projet107", "clientprojet107", "descriptionprojet107", Now(), 1, 1),
("projet108", "clientprojet108", "descriptionprojet108", Now(), 1, 1),
("projet109", "clientprojet109", "descriptionprojet109", Now(), 1, 1);

INSERT IGNORE INTO `inter_dev_projet` (`DEV_id`, `PRO_id`) VALUES
(1, 1), (2, 1), (1, 2), (2, 3), (1, 4), (8, 98), (14, 98), (15, 38), (2, 55), (6, 15),
(22, 14), (23, 108), (24, 72), (4, 81), (9, 8), (15, 20), (18, 106), (24, 33), (15, 86), (21, 60),
(26, 57), (21, 45), (21, 49), (13, 67), (25, 76), (11, 19), (9, 91), (1, 3), (25, 55), (11, 2),
(9, 62), (25, 69), (7, 103), (17, 103), (30, 64), (9, 36), (15, 88), (19, 53), (21, 89), (27, 84),
(21, 1), (26, 79), (27, 68), (16, 109), (11, 26), (9, 100), (26, 84), (18, 15), (8, 92), (3, 13),
(3, 7), (2, 45), (20, 79), (7, 34), (27, 101), (18, 74), (25, 50), (15, 87), (26, 12), (10, 53),
(8, 55), (27, 107), (24, 84), (13, 100), (23, 62), (18, 75), (5, 33), (11, 65), (1, 28), (4, 6),
(21, 15), (1, 93), (1, 24), (29, 53), (13, 94), (17, 67), (26, 24), (29, 13), (12, 40), (27, 74),
(1, 65), (23, 70), (21, 51), (26, 80), (27, 70), (14, 99), (13, 89), (5, 24), (22, 66), (10, 12),
(25, 96), (29, 29), (6, 27), (2, 40), (27, 87), (16, 66), (5, 3), (12, 6), (23, 56), (25, 8),
(26, 82), (22, 103), (28, 55), (18, 55), (4, 109), (12, 51), (18, 93), (30, 55), (25, 12), (24, 15),
(26, 42), (23, 16), (14, 20), (19, 99), (7, 49), (20, 18), (24, 68), (19, 71), (3, 60), (12, 38),
(17, 2), (14, 75), (27, 81), (10, 40), (4, 76), (10, 74), (26, 104), (27, 109), (16, 29), (16, 27),
(28, 47), (19, 24), (14, 15), (9, 10), (12, 12), (16, 2), (17, 38), (23, 3), (3, 49), (2, 63),
(25, 42), (15, 58), (13, 102), (20, 39), (21, 14), (8, 34), (28, 65), (30, 103), (11, 99), (4, 17),
(2, 58), (1, 102), (30, 98), (7, 109), (3, 90), (15, 19), (17, 64), (30, 24), (6, 19), (15, 70),
(17, 12), (5, 59), (25, 45), (14, 96), (21, 79), (4, 86), (14, 79), (22, 25), (2, 33), (12, 100),
(6, 8), (13, 20), (23, 103), (7, 7), (17, 28), (28, 103), (29, 105), (29, 6), (5, 64), (3, 46),
(27, 75), (2, 71), (16, 26), (9, 30), (14, 37), (3, 76), (29, 21), (11, 14), (2, 42), (18, 21),
(5, 84), (26, 10), (13, 13), (27, 108), (26, 73), (29, 9), (13, 53), (25, 41), (17, 91), (27, 100),
(30, 28), (1, 95), (25, 46), (24, 25), (19, 40), (24, 52), (26, 107), (30, 63), (29, 20), (2, 14),
(29, 48), (28, 108), (8, 49), (12, 80), (4, 91), (1, 6), (10, 45), (23, 19), (24, 106), (29, 96),
(7, 40), (3, 89), (14, 76), (13, 50), (4, 46), (16, 52), (11, 101), (8, 47), (15, 56), (8, 31),
(18, 92), (22, 55), (10, 90), (28, 54), (14, 107), (9, 101), (19, 65), (16, 90), (5, 50), (16, 49),
(9, 24), (15, 72), (9, 58), (29, 81), (5, 61), (29, 7), (12, 31), (5, 42), (25, 10), (15, 91),
(4, 16), (10, 6), (7, 11), (10, 41), (18, 90), (9, 31), (14, 101), (12, 10), (15, 25), (17, 60),
(23, 77), (25, 70), (9, 18), (2, 34), (21, 108), (16, 35), (30, 92), (8, 79), (26, 40), (16, 104),
(9, 34), (12, 8), (8, 32), (25, 32), (24, 35), (9, 71), (29, 15), (9, 78), (19, 37), (25, 65),
(27, 71), (8, 12), (4, 100), (19, 47), (8, 44), (5, 92), (15, 53), (11, 82), (27, 19), (17, 68),
(6, 97), (17, 53), (14, 34), (17, 5), (15, 17), (25, 60), (24, 88), (7, 5), (7, 91), (20, 84),
(7, 14), (20, 78), (4, 52), (19, 46), (12, 99), (21, 8), (22, 81), (8, 97), (20, 50), (19, 62),
(26, 58), (16, 98), (29, 65), (2, 43), (13, 33), (22, 98), (9, 11), (3, 107), (25, 71), (21, 95),
(9, 44), (3, 42), (6, 108), (22, 41), (1, 77), (6, 52), (25, 72), (29, 93), (26, 55), (10, 4),
(10, 99), (12, 60), (18, 63), (3, 71), (6, 23), (1, 16), (29, 8), (4, 62), (4, 85), (23, 46),
(6, 24), (25, 22), (13, 19), (23, 52), (2, 16), (3, 62), (11, 34), (11, 17), (3, 95), (7, 71),
(30, 74), (13, 106), (18, 40), (6, 22), (12, 82), (12, 19), (4, 105), (8, 28), (13, 69), (14, 64),
(15, 92), (9, 83), (12, 101), (3, 102), (1, 44), (26, 46), (19, 90), (11, 105), (7, 84), (30, 69),
(14, 106), (11, 9), (4, 51), (25, 47), (27, 64), (18, 73), (12, 108), (8, 51), (27, 41), (7, 43),
(4, 38), (28, 88), (26, 29), (28, 5), (29, 76), (11, 62), (26, 78), (11, 30), (17, 43), (18, 22),
(3, 82), (10, 93), (8, 43), (14, 109), (24, 57), (1, 21), (8, 87), (11, 48), (4, 48), (13, 55),
(9, 65), (4, 9), (12, 25), (4, 42), (12, 41), (11, 12), (8, 82), (18, 64), (13, 104), (14, 14),
(12, 48), (11, 27), (5, 45), (26, 26), (16, 19), (14, 31), (4, 18), (20, 40), (22, 109), (3, 68),
(15, 43), (22, 84), (29, 91), (15, 21), (20, 97), (14, 5), (30, 80), (4, 80), (11, 10), (30, 76),
(27, 110), (25, 61), (21, 76), (19, 29), (3, 101), (24, 40), (19, 30), (24, 26), (19, 21), (7, 9),
(18, 98), (1, 100), (28, 71), (14, 21), (19, 96), (9, 26), (11, 35), (24, 10), (18, 80), (20, 24),
(7, 99), (16, 30), (30, 79), (17, 86), (26, 5), (6, 98), (28, 84), (27, 34), (15, 22), (23, 4),
(14, 78), (10, 70), (27, 8), (11, 18), (24, 96), (27, 17), (23, 69), (30, 99), (2, 50), (29, 90),
(6, 37), (23, 61), (20, 9), (9, 40), (24, 66), (4, 79), (1, 20), (26, 61), (18, 32), (22, 64),
(8, 26), (19, 19), (23, 35), (28, 86), (22, 17), (26, 13), (25, 68), (19, 20), (19, 41), (8, 33),
(17, 21), (27, 37), (9, 19), (1, 80), (2, 56), (2, 57), (19, 67), (28, 75), (1, 10), (13, 71),
(1, 52), (5, 105), (8, 106), (16, 31), (5, 104), (18, 107), (3, 99), (28, 82), (30, 56), (1, 101),
(4, 53), (23, 63), (17, 108), (23, 36), (15, 55), (21, 78), (14, 33), (2, 51), (13, 105), (23, 67),
(11, 22), (24, 50), (10, 101), (4, 13), (11, 32), (16, 55), (26, 27), (24, 89), (21, 46), (20, 85),
(15, 39), (1, 13), (27, 47), (24, 98), (25, 31), (30, 91), (14, 1), (1, 86), (17, 17), (1, 22),
(16, 24), (30, 16), (22, 87), (22, 7), (21, 90), (4, 54), (5, 46), (28, 68), (12, 71), (9, 81),
(15, 84), (20, 62), (27, 23), (2, 96), (13, 87), (2, 49), (11, 71), (22, 37), (8, 67), (12, 88),
(25, 30), (20, 32), (29, 2), (9, 20), (19, 28), (6, 43), (14, 48), (18, 34), (17, 31), (19, 25),
(4, 36), (7, 67), (29, 30), (5, 13), (20, 44), (27, 57), (20, 52), (16, 58), (17, 26), (25, 103),
(30, 104), (5, 1), (1, 83), (9, 9), (22, 23), (8, 29), (21, 100), (2, 35), (23, 55), (24, 107),
(2, 32), (15, 26), (21, 57), (20, 35), (14, 74), (10, 59), (21, 13), (22, 53), (3, 6), (21, 96),
(14, 108), (18, 81), (27, 1), (12, 7), (16, 106), (30, 93), (30, 107), (23, 89), (4, 4), (7, 50),
(6, 93), (3, 66), (27, 98), (20, 45), (27, 61), (12, 91), (22, 73), (3, 37), (11, 28), (6, 59),
(5, 80), (29, 57), (20, 109), (5, 85), (9, 28), (6, 79), (23, 51), (26, 102), (21, 102), (4, 2),
(28, 101), (25, 24), (20, 53), (12, 45), (15, 95), (14, 22), (28, 16), (17, 16), (24, 44), (20, 37),
(14, 45), (23, 74), (3, 52), (22, 83), (29, 42), (7, 81), (7, 94), (22, 63), (3, 85), (30, 40),
(20, 21), (11, 11), (16, 39), (18, 82), (22, 49), (24, 51), (15, 80), (4, 55), (18, 1), (28, 30),
(17, 47), (28, 6), (2, 37), (24, 34), (10, 105), (4, 75), (12, 23), (27, 42), (17, 55), (3, 19),
(16, 5), (17, 56), (9, 25), (10, 71), (26, 86), (26, 77), (22, 56), (13, 6), (18, 68), (3, 72),
(4, 59), (13, 34), (4, 63), (9, 79), (21, 56), (28, 81), (11, 108), (23, 44), (17, 90), (20, 71),
(12, 104), (9, 74), (1, 14), (10, 100), (30, 38), (1, 55), (28, 102), (25, 81), (28, 80), (6, 92),
(17, 18), (6, 72), (1, 35), (3, 8), (2, 21), (3, 47), (5, 54), (21, 26), (9, 56), (21, 47),
(28, 99), (19, 27), (27, 79), (15, 5), (16, 14), (4, 88), (11, 80), (20, 8), (7, 64), (17, 19),
(7, 82), (2, 25), (25, 104), (6, 95), (3, 79), (15, 99), (24, 80), (14, 102), (8, 27), (17, 105),
(9, 97), (13, 7), (11, 90), (18, 65), (19, 22), (25, 16), (11, 104), (9, 52), (7, 27), (1, 74),
(19, 5), (6, 18), (14, 77), (24, 85), (15, 18), (4, 101), (18, 44), (10, 49), (16, 42), (15, 24),
(21, 44), (13, 101), (14, 8), (3, 77), (16, 87), (9, 59), (3, 81), (8, 8), (19, 83), (25, 102),
(13, 60), (6, 40), (25, 82), (25, 26), (17, 20), (11, 46), (12, 1), (26, 44), (12, 17), (16, 43),
(16, 103), (27, 76), (12, 30), (8, 35), (20, 22), (27, 82), (18, 95), (14, 105), (8, 88), (17, 48),
(28, 41), (26, 98), (25, 35), (2, 5), (13, 68), (11, 33), (21, 74), (27, 44), (25, 109), (17, 44),
(11, 20), (10, 100), (28, 98), (27, 86), (11, 58), (20, 37), (4, 56), (30, 45), (29, 32), (25, 22),
(2, 82), (26, 32), (17, 24), (12, 76), (25, 9), (10, 82), (7, 36), (16, 10), (14, 25), (25, 26),
(5, 101), (19, 29), (2, 108), (2, 4), (24, 6), (5, 9), (19, 4), (24, 11), (30, 23), (14, 103),
(14, 57), (14, 83), (14, 58), (10, 39), (23, 11), (21, 70), (21, 64), (9, 18), (6, 25), (14, 86),
(28, 50), (6, 38), (5, 90), (13, 105), (10, 23), (1, 66), (16, 46), (17, 57), (1, 66), (16, 44),
(20, 103), (15, 73), (20, 7), (25, 14), (17, 23), (25, 9), (4, 2), (11, 38), (6, 52), (19, 92),
(21, 35), (14, 48), (26, 15), (11, 63), (13, 9), (27, 84), (12, 92), (29, 10), (1, 5), (20, 12),
(15, 102), (23, 56), (1, 108), (27, 96), (8, 85), (5, 60), (13, 103), (23, 66), (11, 102), (14, 64),
(11, 44), (24, 14), (30, 6), (24, 27), (4, 102), (3, 75), (4, 45), (10, 9), (22, 82), (14, 97),
(20, 8), (8, 86), (25, 109), (14, 16), (3, 101), (27, 71), (20, 74), (28, 77), (16, 85), (27, 2),
(30, 73), (6, 84), (23, 2), (4, 95), (12, 53), (14, 9), (8, 85), (27, 89), (7, 31), (25, 65),
(10, 30), (27, 100), (7, 14), (10, 39), (14, 19), (15, 98), (27, 49), (2, 97), (2, 24), (30, 40),
(19, 50), (6, 77), (13, 35), (9, 73), (20, 92), (7, 73), (4, 50), (18, 88), (27, 66), (10, 75),
(24, 93), (20, 24), (3, 59), (27, 96), (13, 49), (22, 63), (3, 12), (20, 36), (3, 107), (1, 102),
(30, 5), (18, 53), (14, 75), (2, 23), (1, 79), (2, 14), (27, 46), (27, 47), (4, 107), (7, 14),
(25, 61), (15, 32), (27, 3), (24, 66), (15, 71), (11, 106), (1, 92), (30, 82), (8, 95), (24, 59),
(18, 64), (13, 99), (20, 45), (6, 94), (21, 2), (3, 100), (9, 103), (6, 21), (27, 101), (8, 86),
(14, 92), (5, 35), (26, 89), (25, 95), (24, 24), (27, 8), (27, 45), (4, 36), (25, 13), (4, 88),
(3, 52), (22, 80), (26, 28), (25, 58), (21, 93), (19, 64), (16, 75), (18, 45), (9, 48), (16, 81),
(12, 79), (16, 32), (5, 40), (12, 5), (10, 63), (4, 107), (22, 29), (19, 107), (11, 49), (26, 3),
(26, 50), (1, 72), (17, 35), (9, 38), (4, 100), (17, 86), (25, 45), (22, 78), (21, 37), (14, 58),
(9, 25), (1, 30), (21, 63), (26, 81), (5, 89), (11, 56), (8, 85), (4, 49), (17, 31), (29, 96),
(1, 29), (3, 18), (11, 63), (3, 82), (3, 84), (24, 32), (12, 104), (26, 47), (27, 89), (8, 107),
(10, 86), (16, 24), (3, 75), (9, 107), (8, 64), (9, 108), (30, 100), (17, 25), (22, 29), (20, 40),
(12, 52), (20, 17), (20, 60), (20, 97), (12, 85), (7, 75), (13, 92), (2, 72), (4, 91), (10, 67),
(5, 95), (6, 71), (30, 80), (22, 2), (12, 100), (27, 36), (23, 61), (30, 80), (21, 91), (22, 85),
(27, 51), (20, 76), (29, 102), (18, 97), (13, 96), (22, 29), (21, 73), (1, 95), (5, 2), (23, 106),
(5, 44), (24, 11), (21, 1), (19, 71), (30, 85), (23, 23), (23, 28), (12, 109), (28, 59), (2, 27),
(24, 7), (1, 32), (28, 94), (23, 99), (5, 102), (22, 65), (2, 4), (28, 46), (16, 10), (18, 73),
(1, 9), (7, 9), (11, 84), (2, 108), (1, 81), (9, 36), (23, 103), (16, 39), (12, 43), (27, 51),
(17, 22), (26, 83), (28, 89), (13, 98), (15, 90), (2, 14), (17, 101), (7, 75), (22, 24), (2, 67),
(15, 108), (23, 46), (4, 92), (16, 33), (22, 67), (30, 64), (13, 70), (9, 6), (17, 107), (17, 39),
(18, 37), (19, 80), (8, 10), (20, 1), (15, 62), (25, 108), (22, 4), (29, 36), (2, 31), (9, 29),
(28, 101), (1, 13), (6, 99), (19, 66), (4, 31), (12, 92), (11, 52), (28, 36), (11, 13), (26, 16),
(17, 74), (14, 70), (15, 59), (23, 58), (25, 16), (2, 80), (4, 12), (12, 43), (21, 87), (4, 77),
(3, 102), (2, 9), (11, 30), (9, 7), (14, 109), (22, 26), (7, 95), (4, 103), (1, 95), (10, 78),
(30, 66), (2, 91), (3, 29), (30, 26), (30, 97), (4, 22), (23, 52), (15, 3), (13, 61), (22, 47),
(26, 14), (13, 94), (29, 90), (22, 45), (19, 55), (26, 19), (7, 14), (15, 90), (7, 69), (14, 7),
(19, 7), (24, 76), (19, 26), (25, 47), (17, 6), (1, 25), (7, 53), (9, 23), (17, 12), (3, 109),
(8, 1), (3, 50), (14, 23), (11, 41), (12, 75), (18, 55), (23, 5), (27, 39), (23, 75), (20, 74),
(26, 24), (14, 19), (18, 79), (10, 38), (28, 96), (19, 39), (13, 88), (28, 44), (24, 104), (5, 34),
(4, 37), (20, 61), (29, 105), (13, 109), (4, 43), (9, 32), (9, 81), (6, 92), (27, 24), (17, 31);
