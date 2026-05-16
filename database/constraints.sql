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