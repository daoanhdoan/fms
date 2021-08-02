<?php

declare(strict_types = 1);

namespace Drupal\fms\Plugin\FieldAutovalue;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\field_autovalue\Plugin\FieldAutovalueBase;

/**
 * Provides a test Field Autovalue plugin.
 *
 * @FieldAutovalue(
 *   id = "field_autovalue_partner",
 *   label = @Translation("Field Autovalue partner"),
 *   field_types = {
 *     "text",
 *     "string"
 *   }
 * )
 */
class PartnerAutovalue extends FieldAutovalueBase {

  /**
   * {@inheritdoc}
   */
  public function setAutovalue(FieldItemListInterface $field): void {
    // There are two boolean condition fields that rule the value generation.
    // If condition 1 is checked, we set the value: "Condition 1 met"
    // regardless.
    // If condition 2 is checked for the first time, we append
    // "and Condition 2 met.". This will only stay there until the next edit
    // but we can prove that we can inspect changing values.
    $entity = $this->getEntity($field);
    $original = $this->getEntity($field, TRUE);
    if (!$entity->get('field_id')->value) {
      $bundle = $entity->bundle();
      $string = strtoupper($bundle) . "[current-date:custom:ym][auto:increment:{$bundle}:%'04s]";
      $id = \Drupal::token()->replace($string);
      $field->setValue($id);
    }
  }

}
