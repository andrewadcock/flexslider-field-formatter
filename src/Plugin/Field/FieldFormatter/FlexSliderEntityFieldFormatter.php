<?php

namespace Drupal\flexslider_field_formatter\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceEntityFormatter;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'flexslider_field_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "flexslider_field_formatter",
 *   label = @Translation("Rendered entity as FlexSlider"),
 *   field_types = {
 *     "entity_reference",
 *     "entity_reference_revisions"
 *   }
 * )
 */
class FlexSliderEntityFieldFormatter extends EntityReferenceEntityFormatter {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'item_width' => '250',
      'show_carousel' => TRUE,
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $settingsForm = parent::settingsForm($form, $form_state);
    $settingsForm['item_width'] = [
      '#default_value' => $this->getSetting('item_width'),
      '#required' => TRUE,
      '#size' => 6,
      '#title' => $this->t('Item Width'),
      '#type' => 'number',
    ];
    $settingsForm['show_carousel'] = [
      '#default_value' => $this->getSetting('show_carousel'),
      '#required' => FALSE,
      '#title' => $this->t('Show Carousel'),
      '#type' => 'checkbox',
    ];

    return $settingsForm;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = parent::viewElements($items, $langcode);

    $elements['#attached']['library'][] = 'flexslider_field_formatter/flexslider';
    $elements['#attached']['drupalSettings']['flexslider_field_formatter']['0']['itemWidth'] = $this->getSetting(
      'item_width'
    );
    $elements['#attached']['drupalSettings']['flexslider_field_formatter']['0']['show_carousel'] = $this->getSetting(
      'show_carousel'
    );

    $elements['#show_carousel'] = $this->getSetting('show_carousel');
    $elements['#theme'] = 'flexslider_field_formatter';

    return $elements;
  }

}
