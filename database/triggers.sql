DELIMITER $$

-- contrat -> date_fin : avant d'entrer la date de fin il faut verifier que le contrat est clos (v)
DROP TRIGGER`tg_contrat_1`;
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

-- devis -> status_devis : si le devis est accepter alors on passe le status du contrat en actif (a)
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

-- affectation -> date_fin : pour insert il faut obligatoirement qu'elle soit terminee (v)
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

-- affectation -> date_debut : pour insert il faut que la date soit la meme ou posterieur a la date de creation du contrat associe (v)
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

-- facture -> id_facture : creation d'une facture uniquement si le contrat est clos (v)
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

-- facture -> date_echeance : obligatoirement superieur a la date de fin du contrat associer (v)
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

-- contrat -> admin_id : verifier que le user est admin (v)
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

-- contrat -> manager_id : verifier que le user est manager (v)
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

-- affectation -> manager_id : verifier que le user est manager (v)
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

-- affectation -> agent_id : verifier que le user est agent (v)
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