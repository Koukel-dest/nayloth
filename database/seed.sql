-- USERS
INSERT INTO `user` VALUES
('550e8400-e29b-41d4-a716-446655440000', 'Alice', 'Dupont', 'alice@test.com', '$2y$10$abcdefghijklmnopqrstuuVwxyz0123456789abcdefghijklmnop', 'admin'),
('550e8400-e29b-41d4-a716-446655440001', 'Bob', 'Martin', 'bob@test.com', '$2y$10$abcdefghijklmnopqrstuuVwxyz0123456789abcdefghijklmnop', 'manager'),
('550e8400-e29b-41d4-a716-446655440002', 'Charlie', 'Durand', 'charlie@test.com', '$2y$10$abcdefghijklmnopqrstuuVwxyz0123456789abcdefghijklmnop', 'agent'),
('550e8400-e29b-41d4-a716-446655440003', 'Diana', 'Leroy', 'diana@test.com', '$2y$10$abcdefghijklmnopqrstuuVwxyz0123456789abcdefghijklmnop', 'agent');

-- CLIENT
INSERT INTO `client` VALUES
('550e8400-e29b-41d4-a716-446655440004', '12345678901234', 'contact@entreprise.com');

-- COMPETENCE
INSERT INTO `competence` (`id_competence`, `nom`, `description`) VALUES
('550e8400-e29b-41d4-a716-446655440005', 'PHP', 'Développement backend PHP'),
('550e8400-e29b-41d4-a716-446655440006', 'SQL', 'Bases de données relationnelles');

-- CONTRAT
INSERT INTO `contrat` (`id_contrat`, `titre`, `statut_contrat`, `quota_agents`, `date_debut`, `date_fin`, `client_id`, `admin_id`, `manager_id`) VALUES
('550e8400-e29b-41d4-a716-446655440007', 'Contrat Test', 'en_attente', 3, '2026-01-01', NULL, '550e8400-e29b-41d4-a716-446655440004', '550e8400-e29b-41d4-a716-446655440000', '550e8400-e29b-41d4-a716-446655440001');

-- DEVIS
INSERT INTO `devis` (`id_devis`, `montant_ht`, `statut_devis`, `contrat_id`) VALUES
('550e8400-e29b-41d4-a716-446655440008', 5000.00, 'en_attente', '550e8400-e29b-41d4-a716-446655440007');