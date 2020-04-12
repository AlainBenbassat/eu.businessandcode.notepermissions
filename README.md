# eu.businessandcode.notepermissions

Control who can see which contact notes.

## Introduction

By default there are 2 privacy levels for contact notes:
 * None (i.e. visible to all users)
 * Author only

This extension will create a CMS permission for every additional Privacy level you create.

By giving users that particular permission, you can give them access to contact notes of that privacy level.

Users without that CMS permission will not see contact notes of that privacy level.

Please note that users with the permission "view all notes" will always see all notes.

## Setting the Note Privacy Level

You can create additional note privacy levels in two ways:
 * Administer > System Settings > Option Groups, then search for note_privacy
 * add a note to a contact, and click on the wrench icon next to "Privacy"

On creation (or modification) of a contact note, select the privacy level that is appropriate in your situation.

## Assign Permissions

For each additional privacy level you have created in CiviCRM, a corresponding CMS permission will be created automatically.
Search for "CiviCRM: access notes with privacy type".

Check you CMS (Drupal, Wordpress, Joomla) for more information about assigning permissions.

## Requirements

* PHP v7.0+
* CiviCRM 5+
