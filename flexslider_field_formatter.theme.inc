<?php

/**
 * @file
 * Theme preprocess functions for flexslider_field_formatter.
 */

use Drupal\file\Entity\File;

/**
 * Implements template_preprocess_hook().
 */
function template_preprocess_flexslider_field_formatter(&$variables) {
  $itemList = $variables['items'];
  $items = $itemList->getValue();

  foreach ($items as $delta => $item) {
    $file = File::load($item['target_id']);

    $imageSettings = [
      'style_name' => 'large',
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

    $variables['fleximages'][$delta] = $imageRenderArray;
  }

}
