<?php

namespace Drupal\flexslider_field_formatter\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceEntityFormatter;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;

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

    foreach ($items as $delta => $item) {
      $elements['#items'][$delta] = $this->viewElement($item);
    }

    return $elements;
  }

  public function viewElement($item) {
    $itemValue = $item->getValue();
    $target_id = $itemValue['target_id'];

    $file = File::load($target_id);

    $imageSettings = [
      'style_name' => 'original',
      'uri' => $file->getFileUri(),
    ];

    // Use image.factory to retrieve image information.
    $image = \Drupal::service('image.factory')->get($file->getFileUri());
    if ($image->isValid()) {
      $imageSettings['width'] = $image->getWidth();
      $imageSettings['height'] = $image->getHeight();
    }
    else {
      $imageSettings['width'] = $imageSettings['height'] = NULL;
    }

    $imageRenderArray = [
      '#theme' => 'image_style',
      '#width' => $imageSettings['width'],
      '#height' => $imageSettings['height'],
      '#style_name' => $imageSettings['style_name'],
      '#uri' => $imageSettings['uri'],
    ];

    // Add the file entity to the cache dependencies.
    // This will clear our cache when this entity updates.
    $renderer = \Drupal::service('renderer');
    $renderer->addCacheableDependency($imageRenderArray, $file);

    return $imageRenderArray;
  }

}
