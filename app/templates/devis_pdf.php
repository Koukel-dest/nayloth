<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <style>
    body { font-family: Arial, sans-serif; font-size: 13px; color: #222; margin: 40px; }
    h1 { font-size: 22px; margin-bottom: 4px; }
    .subtitle { color: #666; font-size: 13px; margin-bottom: 32px; }
    .section { margin-bottom: 24px; }
    .section-title { font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #888; border-bottom: 1px solid #ddd; padding-bottom: 4px; margin-bottom: 12px; }
    table { width: 100%; border-collapse: collapse; }
    td { padding: 8px 0; vertical-align: top; }
    td:first-child { color: #666; width: 40%; }
    .total-table { margin-top: 24px; }
    .total-table td { border-top: 1px solid #ddd; padding: 10px 0; }
    .total-table .ttc { font-weight: bold; font-size: 15px; }
    .badge { display: inline-block; padding: 3px 10px; border-radius: 4px; font-size: 11px; background: #eee; }
    .footer { margin-top: 60px; font-size: 11px; color: #aaa; text-align: center; }
  </style>
</head>
<body>

  <h1>Devis</h1>
  <div class="subtitle">Référence : <?= htmlspecialchars($devis['id_devis']) ?></div>

  <div class="section">
    <div class="section-title">Contrat lié</div>
    <table>
      <tr><td>Titre</td><td><?= htmlspecialchars($contrat['titre']) ?></td></tr>
      <tr><td>Client</td><td><?= htmlspecialchars($client['nom']) ?></td></tr>
      <tr><td>Date de début</td><td><?= htmlspecialchars($contrat['date_debut']) ?></td></tr>
    </table>
  </div>

  <div class="section">
    <div class="section-title">Détail du devis</div>
    <table>
      <tr><td>Date de création</td><td><?= htmlspecialchars($devis['cree_le']) ?></td></tr>
      <tr><td>Statut</td><td><span class="badge"><?= htmlspecialchars($devis['statut_devis']) ?></span></td></tr>
    </table>
  </div>

  <div class="section">
    <div class="section-title">Montants</div>
    <table class="total-table">
      <tr><td>Montant HT</td><td><?= number_format($devis['montant_ht'], 2, ',', ' ') ?> €</td></tr>
      <tr><td>TVA (20%)</td><td><?= number_format($devis['montant_ht'] * 0.20, 2, ',', ' ') ?> €</td></tr>
      <tr><td class="ttc">Montant TTC</td><td class="ttc"><?= number_format($devis['montant_ht'] * 1.20, 2, ',', ' ') ?> €</td></tr>
    </table>
  </div>

  <div class="footer">Document généré automatiquement par NAYLOTH</div>

</body>
</html>
