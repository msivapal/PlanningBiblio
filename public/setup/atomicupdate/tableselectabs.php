$sql[] = "INSERT IGNORE INTO `{$dbprefix}config` (`nom`, `type`, `valeur`, `commentaires`, `categorie`, `valeurs`, `extra`, `ordre`) VALUES ('AbsencesCumuleeAutorisee-TousLesMotifs', 'boolean', '0', 'Autoriser l\'enregistrement d\'absences cumulées pour tous les motifs. Si ce n\'est pas le cas, vous pouvez personnaliser les absences que vous souhaitez cumuler dans l\'onglet Ajouter une absence (Liste des motifs d\'absences).', 'Absences', '', NULL, '12');";
$sql[] = "ALTER TABLE `{$dbprefix}select_abs` ADD COLUMN IF NOT EXISTS `absence_cumulee` INT(1) NOT NULL DEFAULT '0' AFTER `teleworking`;";
