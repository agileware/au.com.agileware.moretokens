# More Tokens (au.com.agileware.moretokens)

This is a [CiviCRM](https://civicrm.org) extension which adds extra tokens for use in Schedule
Reminders and other CiviCRM messages. It solves the problem of Membership Custom Fields not being
available as tokens by default, letting you insert those values directly into Scheduled Reminder
emails (and, via a core patch, into Case-related messages).

The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Usage

Once installed, the extension automatically makes every custom field belonging to a custom field
group that extends **Membership** available as a token, with no further configuration required.

* Tokens are named `{membership.<custom_field_name>}`, where `<custom_field_name>` is the
  lowercased machine name of the custom field.
* In the Token selector (e.g. when editing a Scheduled Reminder or a message template), each token
  is labelled `<Field Label> :: <Custom Field Group Title>` so you can identify which custom group
  it belongs to.
* When a message is sent for a Membership (for example via **Administer > Communications >
  Schedule Reminders**, where **Used For** is set to Membership), the token is replaced with the
  actual value of that custom field on the Membership record being processed.

New custom fields added to Membership-extending custom groups become available as tokens
automatically; there is no need to register them manually.

## Special configuration requirements

No settings page or credentials are required for this extension to provide Membership custom
field tokens in Scheduled Reminders. Simply install and enable the extension.

If you need these tokens to also work in **Case**-related messages, this requires a one-time
patch to CiviCRM core, since CiviCRM does not otherwise pass the token context data this extension
needs to resolve custom field values for those message types:

1. Download and apply [civicirm-core-case-tokens.patch](civicirm-core-case-tokens.patch) to your
   CiviCRM core codebase.
2. Re-apply the patch after upgrading CiviCRM core, as it may need to be adjusted for a newer
   core version.

## Requirements

* CiviCRM 6.5+

## Installation (Web UI)

Learn more about installing CiviCRM extensions in the [CiviCRM Sysadmin
Guide](https://docs.civicrm.org/sysadmin/en/latest/customize/extensions/).

## Installation (CLI, Git)

Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git) repo for this
extension and install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/agileware/au.com.agileware.moretokens.git
cv en moretokens
```

# About the Authors

This CiviCRM extension was developed by the team at
[Agileware](https://agileware.com.au).

[Agileware](https://agileware.com.au) provide a range of CiviCRM
services including:

* CiviCRM migration
* CiviCRM integration
* CiviCRM extension development
* CiviCRM support
* CiviCRM hosting
* CiviCRM remote training services

Support your Australian [CiviCRM](https://civicrm.org) developers,
[contact Agileware](https://agileware.com.au/contact) today!

![Agileware](logo/agileware-logo.png)
