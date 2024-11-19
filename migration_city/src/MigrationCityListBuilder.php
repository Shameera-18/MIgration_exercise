<?php

namespace Drupal\migration_city;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * Provides a list controller for the migration city entity type.
 */
class MigrationCityListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader(): array {
    $header['id'] = $this->t('ID');
    $header['title'] = $this->t('TITLE');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity): array {
    /** @var  \Drupal\Core\Entity\ContentEntityInterface $entity */
    $row['id'] = $entity->id();
    $row['title'] = $entity->title->value;
    return $row + parent::buildRow($entity);
  }

}
