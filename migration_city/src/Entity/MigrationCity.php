<?php

namespace Drupal\migration_city\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the migration city entity class.
 *
 * @ContentEntityType(
 *   id = "migration_city",
 *   label = @Translation("Migration city"),
 *   handlers = {
 *     "list_builder" = "Drupal\migration_city\MigrationCityListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "access" = "Drupal\migration_city\MigrationCityAccessControlHandler",
 *     "form" = {
 *       "add" = "Drupal\migration_city\Form\MigrationCityForm",
 *       "edit" = "Drupal\migration_city\Form\MigrationCityForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "migration_city",
 *   admin_permission = "administer migration_city",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "title",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "collection" = "/admin/content/migration-city",
 *     "add-form" = "/admin/content/migration-city/add",
 *     "canonical" = "/admin/content/migration-city/{migration_city}",
 *     "edit-form" = "/admin/content/migration-city/{migration_city}/edit",
 *     "delete-form" = "/admin/content/migration-city/{migration_city}/delete",
 *   },
 * )
 */
class MigrationCity extends ContentEntityBase implements ContentEntityInterface {

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions(entity_type: $entity_type);
    $fields['title'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Title'))
      ->setSetting('max_length', 255)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('form', TRUE);

    $fields['_id'] = BaseFieldDefinition::create('string')
      ->setLabel(t('ID'))
      ->setSetting('max_length', 255)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE);

    $fields['city'] = BaseFieldDefinition::create('string')
      ->setLabel(t('City'))
      ->setSetting('max_length', 255)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -3,
      ])
      ->setDisplayConfigurable('form', TRUE);

    $fields['loc'] = BaseFieldDefinition::create('geofield')
      ->setLabel(t('Location'))
      ->setSettings([
        'storage' => 'latlng',
      ])
      ->setDisplayOptions('form', [
        'type' => 'geofield_latlng',
        'weight' => -2,
      ])
      ->setDisplayConfigurable('form', TRUE);

    $fields['pop'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Population'))
      ->setDisplayOptions('form', [
        'type' => 'integer',
        'weight' => -1,
      ])
      ->setDisplayConfigurable('form', TRUE);

    $fields['state'] = BaseFieldDefinition::create('string')
      ->setLabel(t('State'))
      ->setSetting('max_length', 255)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE);

    return $fields;
  }

}
