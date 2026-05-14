-- V4__seed_dev.sql

-- USERS
INSERT INTO `user` VALUES
('550e8400-e29b-41d4-a716-446655440000', 'Alice', 'Dupont', 'alice@test.com', '$2y$10$abcdefghijklmnopqrstuuVwxyz0123456789abcdefghijklmnop', 'admin'),
('550e8400-e29b-41d4-a716-446655440001', 'Bernard', 'Dupont', 'bernard@test.com', '$2y$10$abcdefghijklmnopqrstuuVwxyz0123456789abcdefghijklmnop', 'admin'),
('550e8400-e29b-41d4-a716-446655440002', 'Claire', 'Dupont', 'claire@test.com', '$2y$10$abcdefghijklmnopqrstuuVwxyz0123456789abcdefghijklmnop', 'admin'),
('550e8400-e29b-41d4-a716-446655440003', 'David', 'Martin', 'david@test.com', '$2y$10$abcdefghijklmnopqrstuuVwxyz0123456789abcdefghijklmnop', 'manager'),
('550e8400-e29b-41d4-a716-446655440004', 'Emma', 'Martin', 'emma@test.com', '$2y$10$abcdefghijklmnopqrstuuVwxyz0123456789abcdefghijklmnop', 'manager'),
('550e8400-e29b-41d4-a716-446655440005', 'Fabien', 'Martin', 'fabien@test.com', '$2y$10$abcdefghijklmnopqrstuuVwxyz0123456789abcdefghijklmnop', 'manager'),
('550e8400-e29b-41d4-a716-446655440006', 'Gabriel', 'Durand', 'gabriel@test.com', '$2y$10$abcdefghijklmnopqrstuuVwxyz0123456789abcdefghijklmnop', 'agent'),
('550e8400-e29b-41d4-a716-446655440007', 'Hugo', 'Durand', 'hugo@test.com', '$2y$10$abcdefghijklmnopqrstuuVwxyz0123456789abcdefghijklmnop', 'agent'),
('550e8400-e29b-41d4-a716-446655440008', 'Iris', 'Durand', 'iris@test.com', '$2y$10$abcdefghijklmnopqrstuuVwxyz0123456789abcdefghijklmnop', 'agent');

-- CLIENT
INSERT INTO `client` VALUES
('550e8400-e29b-41d4-a716-446655440009', '12345678901234', 'contact@entreprise-a.com'),
('550e8400-e29b-41d4-a716-446655440010', '98765432109876', 'contact@entreprise-b.com'),
('550e8400-e29b-41d4-a716-446655440011', '11111111111111', 'contact@entreprise-c.com');

-- COMPETENCE
INSERT INTO `competence` (`id_competence`, `nom`, `description`) VALUES
('550e8400-e29b-41d4-a716-446655440012', 'PHP', 'Développement backend PHP'),
('550e8400-e29b-41d4-a716-446655440013', 'SQL', 'Bases de données relationnelles'),
('550e8400-e29b-41d4-a716-446655440014', 'JavaScript', 'Développement frontend JS');

-- CONTRAT (un en_attente, un actif, un clos)
INSERT INTO `contrat` (`id_contrat`, `titre`, `statut_contrat`, `quota_agents`, `date_debut`, `date_fin`, `client_id`, `admin_id`, `manager_id`) VALUES
('550e8400-e29b-41d4-a716-446655440015', 'Contrat En Attente', 'en_attente', 3, '2026-01-01', NULL, '550e8400-e29b-41d4-a716-446655440009', '550e8400-e29b-41d4-a716-446655440000', '550e8400-e29b-41d4-a716-446655440003'),
('550e8400-e29b-41d4-a716-446655440016', 'Contrat Actif', 'actif', 2, '2026-01-01', NULL, '550e8400-e29b-41d4-a716-446655440010', '550e8400-e29b-41d4-a716-446655440001', '550e8400-e29b-41d4-a716-446655440004'),
('550e8400-e29b-41d4-a716-446655440017', 'Contrat Clos', 'clos', 5, '2025-01-01', '2025-12-31', '550e8400-e29b-41d4-a716-446655440011', '550e8400-e29b-41d4-a716-446655440002', '550e8400-e29b-41d4-a716-446655440005');

-- DEVIS
INSERT INTO `devis` (`id_devis`, `montant_ht`, `statut_devis`, `contrat_id`) VALUES
('550e8400-e29b-41d4-a716-446655440018', 5000.00, 'en_attente', '550e8400-e29b-41d4-a716-446655440015'),
('550e8400-e29b-41d4-a716-446655440019', 8000.00, 'accepte', '550e8400-e29b-41d4-a716-446655440016'),
('550e8400-e29b-41d4-a716-446655440020', 3000.00, 'refuse', '550e8400-e29b-41d4-a716-446655440017');

-- AFFECTATION
INSERT INTO `affectation` (`id_affectation`, `date_debut`, `date_fin`, `statut_affectation`, `contrat_id`, `agent_id`, `manager_id`) VALUES
('550e8400-e29b-41d4-a716-446655440021', '2026-01-01', NULL, 'active', '550e8400-e29b-41d4-a716-446655440016', '550e8400-e29b-41d4-a716-446655440006', '550e8400-e29b-41d4-a716-446655440003'),
('550e8400-e29b-41d4-a716-446655440022', '2026-02-01', NULL, 'active', '550e8400-e29b-41d4-a716-446655440016', '550e8400-e29b-41d4-a716-446655440007', '550e8400-e29b-41d4-a716-446655440004'),
('550e8400-e29b-41d4-a716-446655440023', '2025-01-01', '2025-12-31', 'terminee', '550e8400-e29b-41d4-a716-446655440017', '550e8400-e29b-41d4-a716-446655440008', '550e8400-e29b-41d4-a716-446655440005');

-- FACTURE
INSERT INTO `facture` (`id_facture`, `montant_ttc`, `date_echeance`, `statut_paiement`, `contrat_id`) VALUES
('550e8400-e29b-41d4-a716-446655440024', 3600.00, '2026-03-01', 'en_attente', '550e8400-e29b-41d4-a716-446655440017'),
('550e8400-e29b-41d4-a716-446655440025', 7200.00, '2026-04-01', 'payee', '550e8400-e29b-41d4-a716-446655440017'),
('550e8400-e29b-41d4-a716-446655440026', 1800.00, '2026-05-01', 'retard', '550e8400-e29b-41d4-a716-446655440017');

-- AGENT_COMPETENCE
INSERT INTO `agent_competence` (`id_agent_competence`, `agent_id`, `competence_id`) VALUES
('550e8400-e29b-41d4-a716-446655440027', '550e8400-e29b-41d4-a716-446655440006', '550e8400-e29b-41d4-a716-446655440012'),
('550e8400-e29b-41d4-a716-446655440028', '550e8400-e29b-41d4-a716-446655440007', '550e8400-e29b-41d4-a716-446655440013'),
('550e8400-e29b-41d4-a716-446655440029', '550e8400-e29b-41d4-a716-446655440008', '550e8400-e29b-41d4-a716-446655440014');