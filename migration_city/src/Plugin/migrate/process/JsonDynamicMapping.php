<?php

namespace Drupal\migration_city\Plugin\migrate\process;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\Row;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Custom process plugin for dynamic JSON field mapping.
 *
 * @MigrateProcessPlugin(
 *   id = "json_dynamic_mapping"
 * )
 */
class JsonDynamicMapping extends ProcessPluginBase implements ContainerFactoryPluginInterface {
  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructs a JsonDynamicMapping object.
   *
   * @param array $configuration
   *   The plugin configuration.
   * @param string $plugin_id
   *   The plugin ID.
   * @param mixed $plugin_definition
   *   The plugin definition.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $config_factory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    // Fetch the config.factory service from the container.
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    $mapping = $this->configFactory->get('migration_city.json_mapping')->getRawData();
    foreach ($mapping as $entity_field => $json_property) {
      if ($json_property === '_none') {
        // If '_none' is selected, set the field to an empty value.
        $row->setDestinationProperty($entity_field, '');
      }
      if (is_string($json_property) && $row->hasSourceProperty($json_property)) {
        $row->setDestinationProperty($entity_field, $row->getSourceProperty($json_property));
      }
    }
  }

}
