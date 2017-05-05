<?php
//
//namespace Drupal\flexslider_field_formatter\Controller;
//
//use Drupal\Core\Controller\ControllerBase;
//use Drupal\Core\Entity\EntityTypeManager;
//use Symfony\Component\DependencyInjection\ContainerInterface;
//
//class FlexSliderFieldFormatterClass extends ControllerBase
//{
//
//  /**
//   * Drupal\Core\Entity\EntityTypeManager definition.
//   *
//   * @var \Drupal\Core\Entity\EntityTypeManager
//   */
//  protected $entity_type_manager;
//
//  /**
//   * {@inheritdoc}
//   */
//  public function __construct(EntityTypeManager $entity_type_manager) {
//    $this->entity_type_manager = $entity_type_manager;
//  }
//
//  /**
//   * {@inheritdoc}
//   */
//  public static function create(ContainerInterface $container) {
//    return new static(
//      $container->get('entity_type.manager')
//    );
//  }
//
//
//  /**
//   * FieldItems.
//   *
//   * @return string
//   *   Return Hello string.
//   */
//  public function fieldItems() {
//    $build = array();
//
//    // Load all FAQ nodes.
//    $nodes = $this->entity_type_manager->getStorage('node')->loadByProperties(array('type' => 'faq'));
//
//    $items = array();
//    foreach ($nodes as $node) {
//      // Add title and body to the list of items.
//      $items[$node->id()] = array(
//        'title' => $node->get('title')->value,
//        'body' => $node->get('body')->value,
//      );
//    }
//
//    // Render the 'faq' theme.
//    $build['faq'] = array(
//      '#theme' => 'faq',
//      '#items' => $items,
//    );
//
//    return $build;
//  }
//
//}