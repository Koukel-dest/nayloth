CREATE DATABASE `nayloth`;
USE `nayloth`;

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