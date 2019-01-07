<?php

require_once 'moretokens.civix.php';
use CRM_Moretokens_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function moretokens_civicrm_config(&$config) {
  _moretokens_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function moretokens_civicrm_xmlMenu(&$files) {
  _moretokens_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function moretokens_civicrm_install() {
  _moretokens_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function moretokens_civicrm_postInstall() {
  _moretokens_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function moretokens_civicrm_uninstall() {
  _moretokens_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function moretokens_civicrm_enable() {
  _moretokens_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function moretokens_civicrm_disable() {
  _moretokens_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function moretokens_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _moretokens_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function moretokens_civicrm_managed(&$entities) {
  _moretokens_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function moretokens_civicrm_caseTypes(&$caseTypes) {
  _moretokens_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function moretokens_civicrm_angularModules(&$angularModules) {
  _moretokens_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function moretokens_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _moretokens_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_entityTypes
 */
function moretokens_civicrm_entityTypes(&$entityTypes) {
  _moretokens_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_tokens().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_tokens
 */
function moretokens_civicrm_tokens(&$tokens) {
  $customTokens = getAllMembershipCustomFieldTokens();
  foreach ($customTokens as $customToken) {
    $tokens['membership'][$customToken['key']] = $customToken['label'];
  }
}

/**
 * Find membership custom fields token.
 *
 * @return array
 * @throws CiviCRM_API3_Exception
 */
function getAllMembershipCustomFieldTokens() {
  $tokens = array();

  $membershipCustomFieldsGroups = civicrm_api3('CustomGroup', 'get', [
    'sequential' => 1,
    'return' => ['id', 'title'],
    'extends' => "Membership",
  ]);

  $membershipCustomFieldsGroups = $membershipCustomFieldsGroups['values'];

  foreach ($membershipCustomFieldsGroups as $membershipCustomFieldsGroup) {
    $customFields = civicrm_api3('CustomField', 'get', [
      'sequential'      => "1",
      'custom_group_id' => $membershipCustomFieldsGroup['id'],
    ]);
    $customFields = $customFields['values'];

    foreach ($customFields as $customField) {
      $tokens[] = array(
        'custom_field_id' => 'custom_' . $customField['id'],
        'key'             => 'membership.' . strtolower($customField['name']),
        'label'           => $customField['label'] . ' :: ' . $membershipCustomFieldsGroup['title'],
      );
    }
  }

  return $tokens;
}

/**
 * Implements hook_civicrm_tokenValues().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_tokenValues
 */
function moretokens_civicrm_tokenValues(&$values, $cids, $job = NULL, $tokens = array(), $context = NULL) {
  $customTokens = getAllMembershipCustomFieldTokens();
  if (is_array($cids)) {
    foreach ($cids as $cid) {
      foreach ($customTokens as $customToken) {
        $values[$cid][$customToken['key']] = "[" . $customToken['key'] . "]";
      }
    }
  }
  else {
    foreach ($customTokens as $customToken) {
      $values[$customToken['key']] = "[" . $customToken['key'] . "]";
    }
  }
}

/**
 * Implements hook_civicrm_alterMailParams().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterMailParams
 */
function moretokens_civicrm_alterMailParams(&$params, $context) {
  if (isset($params['token_params'])) {
    $tokenParams = $params['token_params'];
    // Replace membership custom field values
    if ($tokenParams['entityTable'] == 'civicrm_membership') {
      $membershipId = $tokenParams['id'];
      $customTokens = getAllMembershipCustomFieldTokens();
      $customFieldIds = array_column($customTokens, 'custom_field_id');

      $customFieldValues = civicrm_api3('Membership', 'get', [
        'sequential' => 1,
        'return'     => $customFieldIds,
        'id'         => $membershipId,
      ]);
      $customFieldValues = $customFieldValues['values'];
      if (count($customFieldValues) > 0) {
        $customFieldValues = $customFieldValues[0];
      }
      $tokenValues = array();

      foreach ($customTokens as $customToken) {
        $key = $customToken['key'];
        $fieldId = $customToken['custom_field_id'];

        if (isset($customFieldValues[$fieldId])) {
          $tokenValues['[' . $key . ']'] = $customFieldValues[$fieldId];
        }
      }

      foreach ($tokenValues as $tokenKey => $tokenValue) {
        $params['html'] = str_replace($tokenKey, $tokenValue, $params['html']);
        $params['subject'] = str_replace($tokenKey, $tokenValue, $params['subject']);
        $params['text'] = str_replace($tokenKey, $tokenValue, $params['text']);
      }
    }
  }
}
