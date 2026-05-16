-- date_fin sur contrat clos -> passe
UPDATE `contrat` SET `date_fin` = '2025-04-25'
WHERE `id_contrat` = '550e8400-e29b-41d4-a716-446655440015';

-- date_fin sur contrat actif -> bloque
UPDATE `contrat` SET `date_fin` = '2025-09-25'
WHERE `id_contrat` = '550e8400-e29b-41d4-a716-446655440019';

-- devis en accepte -> contrat passe en actif automatiquement
UPDATE `devis` SET `statut_devis` = 'accepte'
WHERE `id_devis` = '550e8400-e29b-41d4-a716-446655440025';

-- devis en refuse -> contrat ne change pas
UPDATE `devis` SET `statut_devis` = 'refuse'
WHERE `id_devis` = '550e8400-e29b-41d4-a716-446655440026';

-- date_fin sur affectation terminee -> passe
UPDATE `affectation` SET `date_fin` = '2025-10-25'
WHERE `id_affectation` = '550e8400-e29b-41d4-a716-446655440031';

-- date_fin sur affectation active -> bloque
UPDATE `affectation` SET `date_fin` = '2025-10-25'
WHERE `id_affectation` = '550e8400-e29b-41d4-a716-446655440029';

-- date_debut affectation = date_debut contrat -> passe
INSERT INTO `affectation` (`id_affectation`, `date_debut`, `date_fin`, `statut_affectation`, `contrat_id`, `agent_id`, `manager_id`) VALUES
('550e8400-e29b-41d4-a716-446655440050', '2026-01-01', NULL, 'active', '550e8400-e29b-41d4-a716-446655440019', '550e8400-e29b-41d4-a716-446655440006', '550e8400-e29b-41d4-a716-446655440003');

-- date_debut affectation > date_debut contrat -> passe
INSERT INTO `affectation` (`id_affectation`, `date_debut`, `date_fin`, `statut_affectation`, `contrat_id`, `agent_id`, `manager_id`) VALUES
('550e8400-e29b-41d4-a716-446655440051', '2026-06-01', NULL, 'active', '550e8400-e29b-41d4-a716-446655440019', '550e8400-e29b-41d4-a716-446655440006', '550e8400-e29b-41d4-a716-446655440003');

-- date_debut affectation < date_debut contrat -> bloque
INSERT INTO `affectation` (`id_affectation`, `date_debut`, `date_fin`, `statut_affectation`, `contrat_id`, `agent_id`, `manager_id`) VALUES
('550e8400-e29b-41d4-a716-446655440052', '2025-01-01', NULL, 'active', '550e8400-e29b-41d4-a716-446655440019', '550e8400-e29b-41d4-a716-446655440006', '550e8400-e29b-41d4-a716-446655440003');


-- facture sur contrat clos -> passe
INSERT INTO `facture` (`id_facture`, `montant_ttc`, `date_echeance`, `statut_paiement`, `contrat_id`) VALUES
('550e8400-e29b-41d4-a716-446655440053', 5000.00, '2026-03-01', 'en_attente', '550e8400-e29b-41d4-a716-446655440015');

-- facture sur contrat actif -> bloque
INSERT INTO `facture` (`id_facture`, `montant_ttc`, `date_echeance`, `statut_paiement`, `contrat_id`) VALUES
('550e8400-e29b-41d4-a716-446655440054', 5000.00, '2026-03-01', 'en_attente', '550e8400-e29b-41d4-a716-446655440019');


-- date_echeance apres date_fin contrat -> passe
INSERT INTO `facture` (`id_facture`, `montant_ttc`, `date_echeance`, `statut_paiement`, `contrat_id`) VALUES
('550e8400-e29b-41d4-a716-446655440055', 5000.00, '2026-06-01', 'en_attente', '550e8400-e29b-41d4-a716-446655440015');

-- date_echeance avant date_fin contrat -> bloque
INSERT INTO `facture` (`id_facture`, `montant_ttc`, `date_echeance`, `statut_paiement`, `contrat_id`) VALUES
('550e8400-e29b-41d4-a716-446655440056', 5000.00, '2024-01-01', 'en_attente', '550e8400-e29b-41d4-a716-446655440015');


-- admin dans admin_id -> passe
INSERT INTO `contrat` (`id_contrat`, `titre`, `statut_contrat`, `quota_agents`, `date_debut`, `date_fin`, `client_id`, `admin_id`, `manager_id`) VALUES
('550e8400-e29b-41d4-a716-446655440057', 'Test Admin OK', 'en_attente', 2, '2026-01-01', NULL, '550e8400-e29b-41d4-a716-446655440009', '550e8400-e29b-41d4-a716-446655440000', '550e8400-e29b-41d4-a716-446655440003');

-- manager dans admin_id -> bloque
INSERT INTO `contrat` (`id_contrat`, `titre`, `statut_contrat`, `quota_agents`, `date_debut`, `date_fin`, `client_id`, `admin_id`, `manager_id`) VALUES
('550e8400-e29b-41d4-a716-446655440058', 'Test Admin KO', 'en_attente', 2, '2026-01-01', NULL, '550e8400-e29b-41d4-a716-446655440009', '550e8400-e29b-41d4-a716-446655440003', '550e8400-e29b-41d4-a716-446655440003');


-- manager dans manager_id insert -> passe
INSERT INTO `contrat` (`id_contrat`, `titre`, `statut_contrat`, `quota_agents`, `date_debut`, `date_fin`, `client_id`, `admin_id`, `manager_id`) VALUES
('550e8400-e29b-41d4-a716-446655440059', 'Test Manager OK', 'en_attente', 2, '2026-01-01', NULL, '550e8400-e29b-41d4-a716-446655440009', '550e8400-e29b-41d4-a716-446655440000', '550e8400-e29b-41d4-a716-446655440003');

-- admin dans manager_id insert -> bloque
INSERT INTO `contrat` (`id_contrat`, `titre`, `statut_contrat`, `quota_agents`, `date_debut`, `date_fin`, `client_id`, `admin_id`, `manager_id`) VALUES
('550e8400-e29b-41d4-a716-446655440060', 'Test Manager KO', 'en_attente', 2, '2026-01-01', NULL, '550e8400-e29b-41d4-a716-446655440009', '550e8400-e29b-41d4-a716-446655440000', '550e8400-e29b-41d4-a716-446655440000');

-- manager dans manager_id update -> passe
UPDATE `contrat` SET `manager_id` = '550e8400-e29b-41d4-a716-446655440004'
WHERE `id_contrat` = '550e8400-e29b-41d4-a716-446655440059';

-- admin dans manager_id update -> bloque
UPDATE `contrat` SET `manager_id` = '550e8400-e29b-41d4-a716-446655440000'
WHERE `id_contrat` = '550e8400-e29b-41d4-a716-446655440059';


-- manager dans manager_id affectation insert -> passe
INSERT INTO `affectation` (`id_affectation`, `date_debut`, `date_fin`, `statut_affectation`, `contrat_id`, `agent_id`, `manager_id`) VALUES
('550e8400-e29b-41d4-a716-446655440061', '2026-01-01', NULL, 'active', '550e8400-e29b-41d4-a716-446655440019', '550e8400-e29b-41d4-a716-446655440006', '550e8400-e29b-41d4-a716-446655440003');

-- admin dans manager_id affectation insert -> bloque
INSERT INTO `affectation` (`id_affectation`, `date_debut`, `date_fin`, `statut_affectation`, `contrat_id`, `agent_id`, `manager_id`) VALUES
('550e8400-e29b-41d4-a716-446655440062', '2026-01-01', NULL, 'active', '550e8400-e29b-41d4-a716-446655440019', '550e8400-e29b-41d4-a716-446655440006', '550e8400-e29b-41d4-a716-446655440000');

-- manager dans manager_id affectation update -> passe
UPDATE `affectation` SET `manager_id` = '550e8400-e29b-41d4-a716-446655440004'
WHERE `id_affectation` = '550e8400-e29b-41d4-a716-446655440061';

-- admin dans manager_id affectation update -> bloque
UPDATE `affectation` SET `manager_id` = '550e8400-e29b-41d4-a716-446655440000'
WHERE `id_affectation` = '550e8400-e29b-41d4-a716-446655440061';


-- agent dans agent_id insert -> passe
INSERT INTO `affectation` (`id_affectation`, `date_debut`, `date_fin`, `statut_affectation`, `contrat_id`, `agent_id`, `manager_id`) VALUES
('550e8400-e29b-41d4-a716-446655440063', '2026-01-01', NULL, 'active', '550e8400-e29b-41d4-a716-446655440019', '550e8400-e29b-41d4-a716-446655440006', '550e8400-e29b-41d4-a716-446655440003');

-- admin dans agent_id insert -> bloque
INSERT INTO `affectation` (`id_affectation`, `date_debut`, `date_fin`, `statut_affectation`, `contrat_id`, `agent_id`, `manager_id`) VALUES
('550e8400-e29b-41d4-a716-446655440064', '2026-01-01', NULL, 'active', '550e8400-e29b-41d4-a716-446655440019', '550e8400-e29b-41d4-a716-446655440000', '550e8400-e29b-41d4-a716-446655440003');

-- agent dans agent_id update -> passe
UPDATE `affectation` SET `agent_id` = '550e8400-e29b-41d4-a716-446655440007'
WHERE `id_affectation` = '550e8400-e29b-41d4-a716-446655440063';

-- admin dans agent_id update -> bloque
UPDATE `affectation` SET `agent_id` = '550e8400-e29b-41d4-a716-446655440000'
WHERE `id_affectation` = '550e8400-e29b-41d4-a716-446655440063';