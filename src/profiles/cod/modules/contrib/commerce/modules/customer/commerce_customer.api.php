<?php

/**
 * @file
 * Hooks provided by the Customer module.
 */


/**
 * Defines customer profile types used to collect customer information during
 * checkout and order administration.
 *
 * Each type is represented as a new bundle of the customer information profile
 * entity and will have a corresponding checkout pane defined for it that may be
 * used in the checkout form to collect information from the customer like name,
 * address, tax information, etc. Each bundle can have a default address field
 * added by the Customer module itself with additional fields added as necessary
 * through modules defining the types or the UI.
 *
 * The Customer module defines a single customer information profile type in its
 * own implementation of this hook,
 * commerce_customer_commerce_commerce_customer_profile_type_info():
 * - Billing information: used to collect a billing name and address from the
 *   customer for use in processing payments.
 *
 * The full list of properties for a profile type is as follows:
 * - type: machine-name identifying the profile type using lowercase
 *   alphanumeric characters, -, and _
 * - name: the translatable name of the profile type, used as the title of the
 *   corresponding checkout pane
 * - description: a translatable description of the intended use of data
 *   contained in this type of customer information profile
 * - help: a translatable help message to be displayed at the top of the
 *   administrative add / edit form for profiles of this type
 * - addressfield: boolean indicating whether or not the profile type should
 *   have a default address field; defaults to TRUE
 * - label_callback: name of the function to use to determine the label of
 *   customer profiles of this type; defaults to commerce_customer_profile_default_label
 * - module: the name of the module that defined the profile type; should not be
 *   set by the hook but will be populated automatically when the pane is loaded
 *
 * @return
 *   An array of profile type arrays keyed by type.
 */
function hook_commerce_customer_profile_type_info() {
  $profile_types = array();

  $profile_types['billing'] = array(
    'type' => 'billing',
    'name' => t('Billing information'),
    'description' => t('The profile used to collect billing information on the checkout and order forms.'),
  );

  return $profile_types;
}

/**
 * Allows modules to alter customer profile types defined by other modules.
 *
 * @param $profile_types
 *   The array of customer profile types defined by enabled modules.
 *
 * @see hook_commerce_customer_profile_type_info()
 */
function hook_commerce_customer_profile_type_info_alter(&$profile_types){
  $profile_types['billing']['description'] = t('New description for billing profile type');
}

/**
 * Allows modules to specify a uri for a customer profile.
 *
 * When this hook is invoked, the first returned uri will be used for the
 * customer profile. Thus to override the default value provided by the Customer
 * UI module, you would need to adjust the order of hook invocation via
 * hook_module_implements_alter() or your module weight values.
 *
 * @param $profile
 *   The customer profile object whose uri is being determined.
 *
 * @return
 *  The uri elements of an entity as expected to be returned by entity_uri()
 *  matching the signature of url().
 *
 * @see commerce_customer_profile_uri()
 * @see hook_module_implements_alter()
 * @see entity_uri()
 * @see url()
 */
function hook_commerce_customer_profile_uri($order) {
  // No example.
}

/**
 * Allows you to prepare customer profile data before it is saved.
 *
 * @param $profile
 *   The customer profile object to be saved.
 *
 * @see rules_invoke_all()
 */
function hook_commerce_customer_profile_presave($profile) {
  // No example.
}

/**
 * Determines whether or not a given customer profile can be deleted.
 *
 * Customer profiles store essential data for past orders, so they should not be
 * easily deletable to prevent critical data loss. This hook lets modules tell
 * the Customer module that a given customer profile should not be deletable.
 * The Order module uses this hook to prevent the deletion of customer profiles
 * attached to orders outside of the context of a single order that references
 * the profile.
 *
 * @param $profile
 *   The customer profile object to be deleted.
 *
 * @return
 *   Implementations of this hook need only return FALSE if the given customer
 *   profile cannot be deleted for some reason.
 *
 * @see commerce_order_commerce_customer_profile_can_delete()
 */
function hook_commerce_customer_profile_can_delete($profile) {
  // No example.
}
