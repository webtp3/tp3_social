<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "tp3_social".
 *
 * Auto generated 23-03-2018 20:49
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
  'title' => 'tp3 social',
  'description' => 'Share Icons & Facebook integration',
  'category' => 'plugin',
  'author' => 'Thomas Ruta',
  'author_email' => 'email@thomasruta.de',
  'state' => 'beta',
  'uploadfolder' => false,
  'createDirs' => '',
  'clearCacheOnLoad' => 0,
  'version' => '1.0.8',
  'author_company' => 'tp3',
  'constraints' => 
  array (
    'depends' => 
    array (
      'typo3' => '8.7.0-9.0.99',
    ),
    'conflicts' => 
    array (
    ),
    'suggests' => 
    array (
    ),
  ),
  'autoload' => 
  array (
    'psr-4' => 
    array (
      'Tp3\\Tp3Social\\' => 'Classes',
    ),
  ),
  'clearcacheonload' => false,
);

