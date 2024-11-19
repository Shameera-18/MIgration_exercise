## INTRODUCTION

The migration_city module is to migrate a JSON content data into a custom entity named migration_city. The JSON file is stored in the location of modules/custom/migration_city/files/cities.json

The primary use case for this module is:

- Created a Migration yml for migration JSON to Custom entity
- Built a admin interface to map the JSON with entity fields dynamically.
- Created a custom process to plugin to help dynamic mapping during migrate import.

## REQUIREMENTS

This module requires the following modules:

- [Migrate](https://www.drupal.org/project/migrate)
- [Migrate Plus](https://www.drupal.org/project/migrate_plus)
- [Geofield](https://www.drupal.org/project/geofield)


## Installation

Install as you would normally install a contributed Drupal module. For further
information, see
[Installing Drupal Modules](https://www.drupal.org/docs/extending-drupal/installing-drupal-modules).

## Configuration

1. Navigate to
   ```sh
   /admin/config/migration-mapping
   ```
   page for configuring the entity fields dynamically with JSON properties.

2.  Run the below command to migrate contents from JSON to custom entity.
   ```sh
   drush migrate:import migration_city_import
   ```
3. Run the below command to re-run the migration if there is any changes in JSON file or mapping fields.
   ```sh
   drush migrate:import migration_city_import --update
   ```
