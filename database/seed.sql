-- V4__seed_dev.sql

-- USERS (3 de chaque rôle)
INSERT INTO `user` VALUES
('550e8400-e29b-41d4-a716-446655439999', 'MOI', 'all', 'moi@test.com', '$2y$10$TcSkJsjCThsntOFt.8vkDet1t6CgDF/7i4D5NGfBEl1znDaICwMYm', 'admin'),
('550e8400-e29b-41d4-a716-446655440000', 'Alice', 'Admin', 'alice@test.com', '$2y$10$abcdefghijklmnopqrstuuVwxyz0123456789abcdefghijklmnop', 'admin'),
('550e8400-e29b-41d4-a716-446655440001', 'Bernard', 'Admin', 'bernard@test.com', '$2y$10$abcdefghijklmnopqrstuuVwxyz0123456789abcdefghijklmnop', 'admin'),
('550e8400-e29b-41d4-a716-446655440002', 'Claire', 'Admin', 'claire@test.com', '$2y$10$abcdefghijklmnopqrstuuVwxyz0123456789abcdefghijklmnop', 'admin'),
('550e8400-e29b-41d4-a716-446655440003', 'David', 'Manager', 'david@test.com', '$2y$10$abcdefghijklmnopqrstuuVwxyz0123456789abcdefghijklmnop', 'manager'),
('550e8400-e29b-41d4-a716-446655440004', 'Emma', 'Manager', 'emma@test.com', '$2y$10$abcdefghijklmnopqrstuuVwxyz0123456789abcdefghijklmnop', 'manager'),
('550e8400-e29b-41d4-a716-446655440005', 'Fabien', 'Manager', 'fabien@test.com', '$2y$10$abcdefghijklmnopqrstuuVwxyz0123456789abcdefghijklmnop', 'manager'),
('550e8400-e29b-41d4-a716-446655440006', 'Gabriel', 'Agent', 'gabriel@test.com', '$2y$10$abcdefghijklmnopqrstuuVwxyz0123456789abcdefghijklmnop', 'agent'),
('550e8400-e29b-41d4-a716-446655440007', 'Hugo', 'Agent', 'hugo@test.com', '$2y$10$abcdefghijklmnopqrstuuVwxyz0123456789abcdefghijklmnop', 'agent'),
('550e8400-e29b-41d4-a716-446655440008', 'Iris', 'Agent', 'iris@test.com', '$2y$10$abcdefghijklmnopqrstuuVwxyz0123456789abcdefghijklmnop', 'agent');

-- CLIENT
INSERT INTO `client` (`id_client`, `nom`, `siret`, `contact_email`) VALUES
('550e8400-e29b-41d4-a716-446655440009', 'Entreprise A', '12345678901234', 'contact@entreprise-a.com'),
('550e8400-e29b-41d4-a716-446655440010', 'Entreprise B', '98765432109876', 'contact@entreprise-b.com'),
('550e8400-e29b-41d4-a716-446655440011', 'Entreprise C', '11111111111111', 'contact@entreprise-c.com');

-- COMPETENCE
INSERT INTO `competence` (`id_competence`, `nom`, `description`) VALUES
('550e8400-e29b-41d4-a716-446655440012', 'PHP', 'Développement backend PHP'),
('550e8400-e29b-41d4-a716-446655440013', 'SQL', 'Bases de données relationnelles'),
('550e8400-e29b-41d4-a716-446655440014', 'JavaScript', 'Développement frontend JS');

-- CONTRATS
-- 2x clos (pour tester date_fin et facture)
-- 2x en_attente (pour tester passage en actif)
-- 2x en_attente sans devis (pour tester blocage passage en actif)
-- 2x actif (pour tester affectations)
-- 2x clos sans date_fin (pour tester tg_contrat_1 cas qui passe)
INSERT INTO `contrat` (`id_contrat`, `titre`, `statut_contrat`, `quota_agents`, `date_debut`, `date_fin`, `client_id`, `admin_id`, `manager_id`) VALUES
-- clos avec date_fin (pour factures et test date_fin)
('550e8400-e29b-41d4-a716-446655440015', 'Contrat Clos A', 'clos', 5, '2025-01-01', '2025-12-31', '550e8400-e29b-41d4-a716-446655440009', '550e8400-e29b-41d4-a716-446655440000', '550e8400-e29b-41d4-a716-446655440003'),
('550e8400-e29b-41d4-a716-446655440016', 'Contrat Clos B', 'clos', 5, '2025-01-01', '2025-12-31', '550e8400-e29b-41d4-a716-446655440010', '550e8400-e29b-41d4-a716-446655440001', '550e8400-e29b-41d4-a716-446655440004'),
-- clos sans date_fin (pour tester tg_contrat_1 cas qui passe)
('550e8400-e29b-41d4-a716-446655440017', 'Contrat Clos Sans Date A', 'clos', 3, '2025-01-01', NULL, '550e8400-e29b-41d4-a716-446655440009', '550e8400-e29b-41d4-a716-446655440000', '550e8400-e29b-41d4-a716-446655440003'),
('550e8400-e29b-41d4-a716-446655440018', 'Contrat Clos Sans Date B', 'clos', 3, '2025-01-01', NULL, '550e8400-e29b-41d4-a716-446655440010', '550e8400-e29b-41d4-a716-446655440001', '550e8400-e29b-41d4-a716-446655440004'),
-- actif (pour tester affectations)
('550e8400-e29b-41d4-a716-446655440019', 'Contrat Actif A', 'actif', 3, '2026-01-01', NULL, '550e8400-e29b-41d4-a716-446655440009', '550e8400-e29b-41d4-a716-446655440000', '550e8400-e29b-41d4-a716-446655440003'),
('550e8400-e29b-41d4-a716-446655440020', 'Contrat Actif B', 'actif', 3, '2026-01-01', NULL, '550e8400-e29b-41d4-a716-446655440010', '550e8400-e29b-41d4-a716-446655440001', '550e8400-e29b-41d4-a716-446655440004'),
-- en_attente avec devis en_attente (pour tester passage en actif via devis)
('550e8400-e29b-41d4-a716-446655440021', 'Contrat Attente Devis A', 'en_attente', 2, '2026-01-01', NULL, '550e8400-e29b-41d4-a716-446655440009', '550e8400-e29b-41d4-a716-446655440000', '550e8400-e29b-41d4-a716-446655440003'),
('550e8400-e29b-41d4-a716-446655440022', 'Contrat Attente Devis B', 'en_attente', 2, '2026-01-01', NULL, '550e8400-e29b-41d4-a716-446655440010', '550e8400-e29b-41d4-a716-446655440001', '550e8400-e29b-41d4-a716-446655440004'),
-- en_attente sans devis (pour tester blocage passage en actif)
('550e8400-e29b-41d4-a716-446655440023', 'Contrat Sans Devis A', 'en_attente', 2, '2026-01-01', NULL, '550e8400-e29b-41d4-a716-446655440009', '550e8400-e29b-41d4-a716-446655440000', '550e8400-e29b-41d4-a716-446655440003'),
('550e8400-e29b-41d4-a716-446655440024', 'Contrat Sans Devis B', 'en_attente', 2, '2026-01-01', NULL, '550e8400-e29b-41d4-a716-446655440010', '550e8400-e29b-41d4-a716-446655440001', '550e8400-e29b-41d4-a716-446655440004');

-- DEVIS
-- 2x en_attente liés aux contrats en_attente (pour tester passage en accepte)
-- 2x en_attente liés aux contrats en_attente (pour tester passage en refuse)
INSERT INTO `devis` (`id_devis`, `montant_ht`, `statut_devis`, `contrat_id`) VALUES
('550e8400-e29b-41d4-a716-446655440025', 5000.00, 'en_attente', '550e8400-e29b-41d4-a716-446655440021'),
('550e8400-e29b-41d4-a716-446655440026', 5000.00, 'en_attente', '550e8400-e29b-41d4-a716-446655440022'),
('550e8400-e29b-41d4-a716-446655440027', 3000.00, 'en_attente', '550e8400-e29b-41d4-a716-446655440021'),
('550e8400-e29b-41d4-a716-446655440028', 3000.00, 'en_attente', '550e8400-e29b-41d4-a716-446655440022');

-- AFFECTATIONS
-- 2x active (pour tester blocage date_fin)
-- 2x terminee (pour tester date_fin qui passe)
INSERT INTO `affectation` (`id_affectation`, `date_debut`, `date_fin`, `statut_affectation`, `contrat_id`, `agent_id`, `manager_id`) VALUES
('550e8400-e29b-41d4-a716-446655440029', '2026-01-01', NULL, 'active', '550e8400-e29b-41d4-a716-446655440019', '550e8400-e29b-41d4-a716-446655440006', '550e8400-e29b-41d4-a716-446655440003'),
('550e8400-e29b-41d4-a716-446655440030', '2026-01-01', NULL, 'active', '550e8400-e29b-41d4-a716-446655440020', '550e8400-e29b-41d4-a716-446655440007', '550e8400-e29b-41d4-a716-446655440004'),
('550e8400-e29b-41d4-a716-446655440031', '2025-01-01', '2025-12-31', 'terminee', '550e8400-e29b-41d4-a716-446655440015', '550e8400-e29b-41d4-a716-446655440007', '550e8400-e29b-41d4-a716-446655440003'),
('550e8400-e29b-41d4-a716-446655440032', '2025-01-01', '2025-12-31', 'terminee', '550e8400-e29b-41d4-a716-446655440016', '550e8400-e29b-41d4-a716-446655440008', '550e8400-e29b-41d4-a716-446655440004');

-- FACTURES (liées aux contrats clos uniquement)
INSERT INTO `facture` (`id_facture`, `montant_ttc`, `date_echeance`, `statut_paiement`, `contrat_id`) VALUES
('550e8400-e29b-41d4-a716-446655440033', 6000.00, '2026-03-01', 'en_attente', '550e8400-e29b-41d4-a716-446655440015'),
('550e8400-e29b-41d4-a716-446655440034', 7200.00, '2026-04-01', 'payee', '550e8400-e29b-41d4-a716-446655440016');

-- AGENT_COMPETENCE
INSERT INTO `agent_competence` (`id_agent_competence`, `agent_id`, `competence_id`) VALUES
('550e8400-e29b-41d4-a716-446655440035', '550e8400-e29b-41d4-a716-446655440006', '550e8400-e29b-41d4-a716-446655440012'),
('550e8400-e29b-41d4-a716-446655440036', '550e8400-e29b-41d4-a716-446655440007', '550e8400-e29b-41d4-a716-446655440013'),
('550e8400-e29b-41d4-a716-446655440037', '550e8400-e29b-41d4-a716-446655440008', '550e8400-e29b-41d4-a716-446655440014');