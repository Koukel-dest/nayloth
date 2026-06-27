-- ============================================
-- NAYLOTH Database Initialization Script
-- ============================================

-- 1. Schema
DROP DATABASE IF EXISTS NAYLOTH;
CREATE DATABASE NAYLOTH;
USE NAYLOTH;

CREATE TABLE `user` (
    `id_user` CHAR(36) NOT NULL,
    `prenom` VARCHAR(100) NOT NULL,
    `nom` VARCHAR(100) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `pwd` CHAR(60) NOT NULL,
    `u_role` ENUM('admin', 'manager', 'agent') NOT NULL,
    PRIMARY KEY (`id_user`)
) CHARSET = utf8mb4;

CREATE TABLE `client` (
    `id_client` CHAR(36) NOT NULL,
    `nom` VARCHAR(255) NOT NULL,
    `siret` CHAR(14) NOT NULL,
    `contact_email` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id_client`),
    UNIQUE (`siret`),
    UNIQUE (`contact_email`)
) CHARSET = utf8mb4;

CREATE TABLE `contrat` (
    `id_contrat` CHAR(36) NOT NULL,
    `titre` VARCHAR(255) NOT NULL,
    `statut_contrat` ENUM('en_attente','actif','clos','annule') NOT NULL,
    `quota_agents` INT NOT NULL,
    `date_debut` DATE NOT NULL,
    `date_fin` DATE,
    `client_id` CHAR(36) NOT NULL,
    `admin_id` CHAR(36) NOT NULL,
    `manager_id` CHAR(36) NOT NULL,
    PRIMARY KEY (`id_contrat`)
) CHARSET = utf8mb4;

CREATE TABLE `affectation` (
    `id_affectation` CHAR(36) NOT NULL,
    `date_debut` DATE NOT NULL,
    `date_fin` DATE,
    `statut_affectation` ENUM(
        'active',
        'terminee',
        'suspendue'
    ) NOT NULL,
    `contrat_id` CHAR(36) NOT NULL,
    `agent_id` CHAR(36) NOT NULL,
    `manager_id` CHAR(36) NOT NULL,
    PRIMARY KEY (`id_affectation`)
) CHARSET = utf8mb4;

CREATE TABLE `competence` (
    `id_competence` CHAR(36) NOT NULL,
    `nom` VARCHAR(100) NOT NULL,
    `description` TEXT,
    PRIMARY KEY (`id_competence`),
    UNIQUE (`nom`)
) CHARSET = utf8mb4;

CREATE TABLE `agent_competence` (
    `id_agent_competence` CHAR(36) NOT NULL,
    `agent_id` CHAR(36) NOT NULL,
    `competence_id` CHAR(36) NOT NULL,
    PRIMARY KEY (`id_agent_competence`)
) CHARSET = utf8mb4;

CREATE TABLE `devis` (
    `id_devis` CHAR(36) NOT NULL,
    `montant_ht` DECIMAL(10, 2) NOT NULL,
    `statut_devis` ENUM(
        'en_attente',
        'accepte',
        'refuse'
    ) NOT NULL,
    `cree_le` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `contrat_id` CHAR(36),
    PRIMARY KEY (`id_devis`)
) CHARSET = utf8mb4;

CREATE TABLE `facture` (
    `id_facture` CHAR(36) NOT NULL,
    `montant_ttc` DECIMAL(10, 2) NOT NULL,
    `date_echeance` DATE NOT NULL,
    `statut_paiement` ENUM(
        'en_attente',
        'payee',
        'retard'
    ) NOT NULL,
    `contrat_id` CHAR(36) NOT NULL,
    PRIMARY KEY (`id_facture`)
) CHARSET = utf8mb4;

CREATE TABLE `notification` (
    `id_notification` CHAR(36) NOT NULL,
    `message` TEXT NOT NULL,
    `cree_le` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `user_id` CHAR(36) NOT NULL,
    PRIMARY KEY (`id_notification`)
) CHARSET = utf8mb4;

-- 2. Constraints
ALTER TABLE `user`
ADD CONSTRAINT `uq_user_email`
UNIQUE (`email`);

ALTER TABLE `contrat`
ADD CONSTRAINT `fk_contrat_client`
FOREIGN KEY (`client_id`) REFERENCES `client` (`id_client`),
ADD CONSTRAINT `fk_contrat_admin`
FOREIGN KEY (`admin_id`) REFERENCES `user` (`id_user`),
ADD CONSTRAINT `fk_contrat_manager`
FOREIGN KEY (`manager_id`) REFERENCES `user` (`id_user`);

ALTER TABLE `affectation`
ADD CONSTRAINT `fk_affectation_contrat`
FOREIGN KEY (`contrat_id`) REFERENCES `contrat` (`id_contrat`),
ADD CONSTRAINT `fk_affectation_agent`
FOREIGN KEY (`agent_id`) REFERENCES `user` (`id_user`),
ADD CONSTRAINT `fk_affectation_manager`
FOREIGN KEY (`manager_id`) REFERENCES `user` (`id_user`);

ALTER TABLE `agent_competence`
ADD CONSTRAINT `uq_agentcompetence_agentid_competence_id`
UNIQUE (`agent_id`, `competence_id`),
ADD CONSTRAINT `fk_agentcompetence_agent`
FOREIGN KEY (`agent_id`) REFERENCES `user` (`id_user`),
ADD CONSTRAINT `fk_agentcompetence_competence`
FOREIGN KEY (`competence_id`) REFERENCES `competence` (`id_competence`);

ALTER TABLE `devis`
ADD CONSTRAINT `fk_devis_contrat`
FOREIGN KEY (`contrat_id`) REFERENCES `contrat` (`id_contrat`);

ALTER TABLE `facture`
ADD CONSTRAINT `fk_facture_contrat`
FOREIGN KEY (`contrat_id`) REFERENCES `contrat` (`id_contrat`);

ALTER TABLE `notification`
ADD CONSTRAINT `fk_notification_user`
FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`);

-- 3. Add type_prestation column
ALTER TABLE `contrat`
ADD COLUMN `type_prestation` ENUM('gardiennage','securite_incendie','surveillance','telesurveillance','autre')
NOT NULL DEFAULT 'gardiennage'
AFTER `titre`;

-- 4. Triggers
DROP TRIGGER IF EXISTS `tg_contrat_1`;
DROP TRIGGER IF EXISTS `tg_devis_1`;
DROP TRIGGER IF EXISTS `tg_affectation_1`;
DROP TRIGGER IF EXISTS `tg_affectation_2`;
DROP TRIGGER IF EXISTS `tg_facture_1`;
DROP TRIGGER IF EXISTS `tg_facture_2`;
DROP TRIGGER IF EXISTS `tg_contrat_3`;
DROP TRIGGER IF EXISTS `tg_contrat_4`;
DROP TRIGGER IF EXISTS `tg_contrat_5`;
DROP TRIGGER IF EXISTS `tg_contrat_6`;
DROP TRIGGER IF EXISTS `tg_affectation_3`;
DROP TRIGGER IF EXISTS `tg_affectation_4`;
DROP TRIGGER IF EXISTS `tg_affectation_5`;
DROP TRIGGER IF EXISTS `tg_affectation_6`;

DELIMITER $$

CREATE TRIGGER `tg_contrat_1`
BEFORE UPDATE ON `contrat`
FOR EACH ROW
BEGIN
    IF ((old.date_fin IS NULL AND new.date_fin IS NOT NULL) OR old.date_fin <> new.date_fin)
    AND new.statut_contrat <> 'clos' THEN
    SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'tg_contrat_1';
    END IF;
END$$

CREATE TRIGGER `tg_devis_1`
AFTER UPDATE ON `devis`
FOR EACH ROW
BEGIN
    IF (new.statut_devis = 'accepte')
    THEN UPDATE `contrat`
    SET `statut_contrat` = 'actif'
    WHERE `id_contrat` = new.contrat_id;
    END IF;
END$$

CREATE TRIGGER `tg_affectation_1`
BEFORE UPDATE ON `affectation`
FOR EACH ROW
BEGIN
    IF (((old.date_fin <> new.date_fin)
    OR (old.date_fin IS NULL AND new.date_fin IS NOT NULL))
    AND (new.statut_affectation <> 'terminee'))
    THEN SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'tg_affectation_1';
    END IF;
END$$

CREATE TRIGGER `tg_affectation_2`
BEFORE INSERT ON `affectation`
FOR EACH ROW
BEGIN
    DECLARE `v_date_debut` DATE;

    SELECT `date_debut` INTO `v_date_debut`
    FROM `contrat`
    WHERE (`id_contrat` = new.contrat_id);

    IF (new.date_debut < v_date_debut)
    THEN SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'tg_affectation_2';
    END IF;
END$$

CREATE TRIGGER `tg_facture_1`
BEFORE INSERT ON `facture`
FOR EACH ROW
BEGIN
    DECLARE `v_statut_contrat` VARCHAR(20);

    SELECT `statut_contrat` INTO `v_statut_contrat`
    FROM `contrat`
    WHERE (`id_contrat` = new.contrat_id);

    IF (v_statut_contrat <> 'clos')
    THEN SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'tg_facture_1';
    END IF;
END$$

CREATE TRIGGER `tg_facture_2`
BEFORE INSERT ON `facture`
FOR EACH ROW
BEGIN
    DECLARE `v_date_fin` DATE;

    SELECT `date_fin` INTO `v_date_fin`
    FROM `contrat`
    WHERE (`id_contrat` = new.contrat_id);

    IF (new.date_echeance < v_date_fin)
    THEN SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'tg_facture_2';
    END IF;
END$$

CREATE TRIGGER `tg_contrat_3`
BEFORE INSERT ON `contrat`
FOR EACH ROW
BEGIN
    DECLARE `v_u_role` VARCHAR(20);

    SELECT `u_role` INTO `v_u_role`
    FROM `user`
    WHERE (`id_user` = new.admin_id);

    IF(`v_u_role` <> 'admin')
    THEN SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'tg_contrat_3';
    END IF;
END$$

CREATE TRIGGER `tg_contrat_4`
BEFORE UPDATE ON `contrat`
FOR EACH ROW
BEGIN
    DECLARE `v_u_role` VARCHAR(20);

    SELECT `u_role` INTO `v_u_role`
    FROM `user`
    WHERE (`id_user` = new.admin_id);

    IF((`v_u_role` <> 'admin') AND (old.admin_id <> new.admin_id))
    THEN SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'tg_contrat_4';
    END IF;
END$$

CREATE TRIGGER `tg_contrat_5`
BEFORE INSERT ON `contrat`
FOR EACH ROW
BEGIN
    DECLARE `v_u_role` VARCHAR(20);

    SELECT `u_role` INTO `v_u_role`
    FROM `user`
    WHERE (`id_user` = new.manager_id);

    IF(`v_u_role` <> 'manager')
    THEN SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'tg_contrat_5';
    END IF;
END$$

CREATE TRIGGER `tg_contrat_6`
BEFORE UPDATE ON `contrat`
FOR EACH ROW
BEGIN
    DECLARE `v_u_role` VARCHAR(20);

    SELECT `u_role` INTO `v_u_role`
    FROM `user`
    WHERE (`id_user` = new.manager_id);

    IF((`v_u_role` <> 'manager') AND (old.manager_id <> new.manager_id))
    THEN SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'tg_contrat_6';
    END IF;
END$$

CREATE TRIGGER `tg_affectation_3`
BEFORE INSERT ON `affectation`
FOR EACH ROW
BEGIN
    DECLARE `v_u_role` VARCHAR(20);

    SELECT `u_role` INTO `v_u_role`
    FROM `user`
    WHERE (`id_user` = new.manager_id);

    IF(`v_u_role` <> 'manager')
    THEN SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'tg_affectation_3';
    END IF;
END$$

CREATE TRIGGER `tg_affectation_4`
BEFORE UPDATE ON `affectation`
FOR EACH ROW
BEGIN
    DECLARE `v_u_role` VARCHAR(20);

    SELECT `u_role` INTO `v_u_role`
    FROM `user`
    WHERE (`id_user` = new.manager_id);

    IF((`v_u_role` <> 'manager') AND (old.manager_id <> new.manager_id))
    THEN SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'tg_affectation_4';
    END IF;
END$$

CREATE TRIGGER `tg_affectation_5`
BEFORE INSERT ON `affectation`
FOR EACH ROW
BEGIN
    DECLARE `v_u_role` VARCHAR(20);

    SELECT `u_role` INTO `v_u_role`
    FROM `user`
    WHERE (`id_user` = new.agent_id);

    IF(`v_u_role` <> 'agent')
    THEN SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'tg_affectation_5';
    END IF;
END$$

CREATE TRIGGER `tg_affectation_6`
BEFORE UPDATE ON `affectation`
FOR EACH ROW
BEGIN
    DECLARE `v_u_role` VARCHAR(20);

    SELECT `u_role` INTO `v_u_role`
    FROM `user`
    WHERE (`id_user` = new.agent_id);

    IF((`v_u_role` <> 'agent') AND (old.agent_id <> new.agent_id))
    THEN SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'tg_affectation_6';
    END IF;
END$$

DELIMITER ;

-- 5. Seed data
INSERT INTO `user` VALUES
('550e8400-e29b-41d4-a716-446655440000', 'Alice', 'Admin', 'alice@test.com', '$2y$10$abcdefghijklmnopqrstuuVwxyz0123456789abcdefghijklmnop', 'admin'),
('550e8400-e29b-41d4-a716-446655440001', 'Bernard', 'Admin', 'bernard@test.com', '$2y$10$abcdefghijklmnopqrstuuVwxyz0123456789abcdefghijklmnop', 'admin'),
('550e8400-e29b-41d4-a716-446655440002', 'Claire', 'Admin', 'claire@test.com', '$2y$10$abcdefghijklmnopqrstuuVwxyz0123456789abcdefghijklmnop', 'admin'),
('550e8400-e29b-41d4-a716-446655440003', 'David', 'Manager', 'david@test.com', '$2y$10$abcdefghijklmnopqrstuuVwxyz0123456789abcdefghijklmnop', 'manager'),
('550e8400-e29b-41d4-a716-446655440004', 'Emma', 'Manager', 'emma@test.com', '$2y$10$abcdefghijklmnopqrstuuVwxyz0123456789abcdefghijklmnop', 'manager'),
('550e8400-e29b-41d4-a716-446655440005', 'Fabien', 'Manager', 'fabien@test.com', '$2y$10$abcdefghijklmnopqrstuuVwxyz0123456789abcdefghijklmnop', 'manager'),
('550e8400-e29b-41d4-a716-446655440006', 'Gabriel', 'Agent', 'gabriel@test.com', '$2y$10$abcdefghijklmnopqrstuuVwxyz0123456789abcdefghijklmnop', 'agent'),
('550e8400-e29b-41d4-a716-446655440007', 'Hugo', 'Agent', 'hugo@test.com', '$2y$10$abcdefghijklmnopqrstuuVwxyz0123456789abcdefghijklmnop', 'agent'),
('550e8400-e29b-41d4-a716-446655440008', 'Iris', 'Agent', 'iris@test.com', '$2y$10$abcdefghijklmnopqrstuuVwxyz0123456789abcdefghijklmnop', 'agent');

INSERT INTO `client` (`id_client`, `nom`, `siret`, `contact_email`) VALUES
('550e8400-e29b-41d4-a716-446655440009', 'Entreprise A', '12345678901234', 'contact@entreprise-a.com'),
('550e8400-e29b-41d4-a716-446655440010', 'Entreprise B', '98765432109876', 'contact@entreprise-b.com'),
('550e8400-e29b-41d4-a716-446655440011', 'Entreprise C', '11111111111111', 'contact@entreprise-c.com');

INSERT INTO `competence` (`id_competence`, `nom`, `description`) VALUES
('550e8400-e29b-41d4-a716-446655440012', 'PHP', 'Développement backend PHP'),
('550e8400-e29b-41d4-a716-446655440013', 'SQL', 'Bases de données relationnelles'),
('550e8400-e29b-41d4-a716-446655440014', 'JavaScript', 'Développement frontend JS');

INSERT INTO `contrat` (`id_contrat`, `titre`, `type_prestation`, `statut_contrat`, `quota_agents`, `date_debut`, `date_fin`, `client_id`, `admin_id`, `manager_id`) VALUES
('550e8400-e29b-41d4-a716-446655440015', 'Contrat Clos A', 'gardiennage', 'clos', 5, '2025-01-01', '2025-12-31', '550e8400-e29b-41d4-a716-446655440009', '550e8400-e29b-41d4-a716-446655440000', '550e8400-e29b-41d4-a716-446655440003'),
('550e8400-e29b-41d4-a716-446655440016', 'Contrat Clos B', 'gardiennage', 'clos', 5, '2025-01-01', '2025-12-31', '550e8400-e29b-41d4-a716-446655440010', '550e8400-e29b-41d4-a716-446655440001', '550e8400-e29b-41d4-a716-446655440004'),
('550e8400-e29b-41d4-a716-446655440017', 'Contrat Clos Sans Date A', 'gardiennage', 'clos', 3, '2025-01-01', NULL, '550e8400-e29b-41d4-a716-446655440009', '550e8400-e29b-41d4-a716-446655440000', '550e8400-e29b-41d4-a716-446655440003'),
('550e8400-e29b-41d4-a716-446655440018', 'Contrat Clos Sans Date B', 'gardiennage', 'clos', 3, '2025-01-01', NULL, '550e8400-e29b-41d4-a716-446655440010', '550e8400-e29b-41d4-a716-446655440001', '550e8400-e29b-41d4-a716-446655440004'),
('550e8400-e29b-41d4-a716-446655440019', 'Contrat Actif A', 'gardiennage', 'actif', 3, '2026-01-01', NULL, '550e8400-e29b-41d4-a716-446655440009', '550e8400-e29b-41d4-a716-446655440000', '550e8400-e29b-41d4-a716-446655440003'),
('550e8400-e29b-41d4-a716-446655440020', 'Contrat Actif B', 'gardiennage', 'actif', 3, '2026-01-01', NULL, '550e8400-e29b-41d4-a716-446655440010', '550e8400-e29b-41d4-a716-446655440001', '550e8400-e29b-41d4-a716-446655440004'),
('550e8400-e29b-41d4-a716-446655440021', 'Contrat Attente Devis A', 'gardiennage', 'en_attente', 2, '2026-01-01', NULL, '550e8400-e29b-41d4-a716-446655440009', '550e8400-e29b-41d4-a716-446655440000', '550e8400-e29b-41d4-a716-446655440003'),
('550e8400-e29b-41d4-a716-446655440022', 'Contrat Attente Devis B', 'gardiennage', 'en_attente', 2, '2026-01-01', NULL, '550e8400-e29b-41d4-a716-446655440010', '550e8400-e29b-41d4-a716-446655440001', '550e8400-e29b-41d4-a716-446655440004'),
('550e8400-e29b-41d4-a716-446655440023', 'Contrat Sans Devis A', 'gardiennage', 'en_attente', 2, '2026-01-01', NULL, '550e8400-e29b-41d4-a716-446655440009', '550e8400-e29b-41d4-a716-446655440000', '550e8400-e29b-41d4-a716-446655440003'),
('550e8400-e29b-41d4-a716-446655440024', 'Contrat Sans Devis B', 'gardiennage', 'en_attente', 2, '2026-01-01', NULL, '550e8400-e29b-41d4-a716-446655440010', '550e8400-e29b-41d4-a716-446655440001', '550e8400-e29b-41d4-a716-446655440004');

INSERT INTO `devis` (`id_devis`, `montant_ht`, `statut_devis`, `contrat_id`) VALUES
('550e8400-e29b-41d4-a716-446655440025', 5000.00, 'en_attente', '550e8400-e29b-41d4-a716-446655440021'),
('550e8400-e29b-41d4-a716-446655440026', 5000.00, 'en_attente', '550e8400-e29b-41d4-a716-446655440022'),
('550e8400-e29b-41d4-a716-446655440027', 3000.00, 'en_attente', '550e8400-e29b-41d4-a716-446655440021'),
('550e8400-e29b-41d4-a716-446655440028', 3000.00, 'en_attente', '550e8400-e29b-41d4-a716-446655440022');

INSERT INTO `affectation` (`id_affectation`, `date_debut`, `date_fin`, `statut_affectation`, `contrat_id`, `agent_id`, `manager_id`) VALUES
('550e8400-e29b-41d4-a716-446655440029', '2026-01-01', NULL, 'active', '550e8400-e29b-41d4-a716-446655440019', '550e8400-e29b-41d4-a716-446655440006', '550e8400-e29b-41d4-a716-446655440003'),
('550e8400-e29b-41d4-a716-446655440030', '2026-01-01', NULL, 'active', '550e8400-e29b-41d4-a716-446655440020', '550e8400-e29b-41d4-a716-446655440007', '550e8400-e29b-41d4-a716-446655440004'),
('550e8400-e29b-41d4-a716-446655440031', '2025-01-01', '2025-12-31', 'terminee', '550e8400-e29b-41d4-a716-446655440015', '550e8400-e29b-41d4-a716-446655440007', '550e8400-e29b-41d4-a716-446655440003'),
('550e8400-e29b-41d4-a716-446655440032', '2025-01-01', '2025-12-31', 'terminee', '550e8400-e29b-41d4-a716-446655440016', '550e8400-e29b-41d4-a716-446655440008', '550e8400-e29b-41d4-a716-446655440004');

INSERT INTO `facture` (`id_facture`, `montant_ttc`, `date_echeance`, `statut_paiement`, `contrat_id`) VALUES
('550e8400-e29b-41d4-a716-446655440033', 6000.00, '2026-03-01', 'en_attente', '550e8400-e29b-41d4-a716-446655440015'),
('550e8400-e29b-41d4-a716-446655440034', 7200.00, '2026-04-01', 'payee', '550e8400-e29b-41d4-a716-446655440016');

INSERT INTO `agent_competence` (`id_agent_competence`, `agent_id`, `competence_id`) VALUES
('550e8400-e29b-41d4-a716-446655440035', '550e8400-e29b-41d4-a716-446655440006', '550e8400-e29b-41d4-a716-446655440012'),
('550e8400-e29b-41d4-a716-446655440036', '550e8400-e29b-41d4-a716-446655440007', '550e8400-e29b-41d4-a716-446655440013'),
('550e8400-e29b-41d4-a716-446655440037', '550e8400-e29b-41d4-a716-446655440008', '550e8400-e29b-41d4-a716-446655440014');

-- 6. Test triggers
UPDATE `contrat` SET `date_fin` = '2025-04-25'
WHERE `id_contrat` = '550e8400-e29b-41d4-a716-446655440015';

UPDATE `devis` SET `statut_devis` = 'accepte'
WHERE `id_devis` = '550e8400-e29b-41d4-a716-446655440025';

UPDATE `devis` SET `statut_devis` = 'refuse'
WHERE `id_devis` = '550e8400-e29b-41d4-a716-446655440026';

UPDATE `affectation` SET `date_fin` = '2025-10-25'
WHERE `id_affectation` = '550e8400-e29b-41d4-a716-446655440031';

INSERT INTO `affectation` (`id_affectation`, `date_debut`, `date_fin`, `statut_affectation`, `contrat_id`, `agent_id`, `manager_id`) VALUES
('550e8400-e29b-41d4-a716-446655440050', '2026-01-01', NULL, 'active', '550e8400-e29b-41d4-a716-446655440019', '550e8400-e29b-41d4-a716-446655440006', '550e8400-e29b-41d4-a716-446655440003');

INSERT INTO `affectation` (`id_affectation`, `date_debut`, `date_fin`, `statut_affectation`, `contrat_id`, `agent_id`, `manager_id`) VALUES
('550e8400-e29b-41d4-a716-446655440051', '2026-06-01', NULL, 'active', '550e8400-e29b-41d4-a716-446655440019', '550e8400-e29b-41d4-a716-446655440006', '550e8400-e29b-41d4-a716-446655440003');

INSERT INTO `facture` (`id_facture`, `montant_ttc`, `date_echeance`, `statut_paiement`, `contrat_id`) VALUES
('550e8400-e29b-41d4-a716-446655440053', 5000.00, '2026-03-01', 'en_attente', '550e8400-e29b-41d4-a716-446655440015');

INSERT INTO `facture` (`id_facture`, `montant_ttc`, `date_echeance`, `statut_paiement`, `contrat_id`) VALUES
('550e8400-e29b-41d4-a716-446655440055', 5000.00, '2026-06-01', 'en_attente', '550e8400-e29b-41d4-a716-446655440015');

-- ============================================
-- Database initialization complete
-- ============================================
