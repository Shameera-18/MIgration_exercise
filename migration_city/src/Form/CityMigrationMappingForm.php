<?php

namespace Drupal\migration_city\Form;

use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Configuration form for JSON mapping.
 */
class CityMigrationMappingForm extends ConfigFormBase {

  /**
   * The entity Field service.
   *
   * @var \Drupal\Core\Entity\EntityFieldManagerInterface
   */
  protected $entityFieldManager;

  /**
   * Constructs a CityMigrationMappingForm object.
   *
   * @param \Drupal\Core\Entity\EntityFieldManagerInterface $entityFieldManager
   *   The entity field manager service.
   */
  public function __construct(EntityFieldManagerInterface $entityFieldManager) {
    $this->entityFieldManager = $entityFieldManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_field.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['migration_city.json_mapping'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'city_migration_mapping_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('migration_city.json_mapping');
    $entity_fields = $this->getCustomEntityFields('migration_city');

    $form['field_mappings'] = [
      '#type' => 'details',
      '#title' => $this->t('Field Mappings'),
      '#open' => TRUE,
      '#tree' => TRUE,
    ];

    foreach ($entity_fields as $field_name => $field_label) {
      $json_fields = $this->getJsonFields($field_name);
      $form['field_mappings'][$field_name] = [
        '#type' => 'select',
        '#options' => $json_fields,
        '#title' => $this->t('Map any JSON property for the entity field named  %field', ['%field' => $field_label]),
        '#default_value' => $config->get($field_name) ?? '',
        '#description' => $this->t('Enter the JSON property name to map to the %field field.', ['%field' => $field_label]),
      ];
    }

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues()['field_mappings'];
    $this->config('migration_city.json_mapping')
      ->setData($values)
      ->save();
    parent::submitForm($form, $form_state);
  }

  /**
   * Retrieves the fields for a given entity type.
   *
   * @param string $entity_type_id
   *   The ID of the entity type for which to retrieve fields.
   *
   * @return array
   *   An associative array of field names as keys and their labels as values.
   */
  public function getCustomEntityFields($entity_type_id) {
    $fields = $this->entityFieldManager->getFieldDefinitions($entity_type_id, $entity_type_id);
    $entity_fields = [];
    foreach ($fields as $field_name => $field_definition) {
      if (!in_array($field_name, ['id', 'uuid'])) {
        $entity_fields[$field_name] = $field_definition->getLabel();
      }
    }

    return $entity_fields;
  }

  /**
   * Retrieves JSON field options for a given entity field.
   *
   * @param string $field_name
   *   The name of the field for which to retrieve JSON options.
   *
   * @return array
   *   An associative array of JSON field names and their corresponding labels.
   */
  public function getJsonFields(string $field_name) {
    // Define the common JSON fields.
    $json_fields = [
      '_none' => $this->t('_none'),
      '_id' => $this->t('_id'),
      'city' => $this->t('city'),
      'state' => $this->t('state'),
    ];

    // Add the special cases for 'loc' and 'pop' if applicable.
    if ($field_name === 'loc') {
      // Only show 'loc' for 'loc'.
      $json_fields = ['loc' => $this->t('loc')];
    }
    elseif ($field_name === 'pop') {
      // Only show 'pop' for 'pop'.
      $json_fields = [
        '_none' => $this->t('_none'),
        'pop' => $this->t('pop'),
      ];
    }

    return $json_fields;
  }

}
