<?php

require_once 'notepermissions.civix.php';
use CRM_Notepermissions_ExtensionUtil as E;

function notepermissions_civicrm_notePrivacy(&$noteValues) {
  // check if the user is allowed to see this note
  // (we skip this ckeck for privacy 0 (none) and 1 (author only)
  if ($noteValues['privacy'] >= 2) {
    // get the corresponding permission key
    list($permissionKey, $permissionName, $permissionDescription) = notepermissions_civicrm_getPermissionNameAndDescription($noteValues['privacy'], '');

    // check if the current user is allowed to see the note
    if (CRM_Core_Permission::check($permissionKey)) {
      // OK, unhide the note
      $noteValues['notePrivacy_hidden'] = FALSE;
    }
  }
}

function notepermissions_civicrm_postProcess($formName, $form) {
  // when a note privacy is added or edited, we clean up the permissions (will trigger our hook: notepermissions_civicrm_permission)
  if ($formName == 'CRM_Admin_Form_Options' && $form->getVar('_gName') == 'note_privacy') {
    $config = CRM_Core_Config::singleton();
    $config->cleanupPermissions();
  }
}

function notepermissions_civicrm_permission(&$permissions) {
  // get all options in the option group "note_privacy"
  $result = civicrm_api3('OptionValue', 'get', [
    'sequential' => 1,
    'option_group_id' => "note_privacy",
  ]);

  // skip the first two (i.e. None, Author only)
  for ($i = 2; $i < $result['count']; $i++) {
    // get key, name, and description based on the id and label
    list($permissionKey, $permissionName, $permissionDescription) = notepermissions_civicrm_getPermissionNameAndDescription($result['values'][$i]['value'], $result['values'][$i]['label']);

    // check if the permission exists
    if (!array_key_exists($permissionName, $permissions)) {
      // permission does not exist, add it
      $permissions[$permissionKey] = [$permissionName, $permissionDescription];
    }
  }
}

function notepermissions_civicrm_getPermissionNameAndDescription($id, $label) {
  $key = "access_privacy_type_$id";
  $name = ts('CiviCRM: access notes with privacy type ID = ') . ' ' . $id;
  $description = ts("Access notes with privacy type:") . ' ' . ts($label);

  return [$key, $name, $description];
}

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function notepermissions_civicrm_config(&$config) {
  _notepermissions_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function notepermissions_civicrm_install() {
  _notepermissions_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function notepermissions_civicrm_postInstall() {
  _notepermissions_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function notepermissions_civicrm_uninstall() {
  _notepermissions_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function notepermissions_civicrm_enable() {
  _notepermissions_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function notepermissions_civicrm_disable() {
  _notepermissions_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function notepermissions_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _notepermissions_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function notepermissions_civicrm_entityTypes(&$entityTypes) {
  _notepermissions_civix_civicrm_entityTypes($entityTypes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 *

 // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 *
function notepermissions_civicrm_navigationMenu(&$menu) {
  _notepermissions_civix_insert_navigation_menu($menu, 'Mailings', array(
    'label' => E::ts('New subliminal message'),
    'name' => 'mailing_subliminal_message',
    'url' => 'civicrm/mailing/subliminal',
    'permission' => 'access CiviMail',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _notepermissions_civix_navigationMenu($menu);
} // */
