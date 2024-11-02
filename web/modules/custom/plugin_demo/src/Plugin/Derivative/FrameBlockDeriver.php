<?php

namespace Drupal\plugin_demo\Plugin\Derivative;

use Drupal\Component\Plugin\Derivative\DeriverBase;
use Drupal\Core\Plugin\Discovery\ContainerDeriverInterface;
use Drupal\plugin_demo\Service\FramePluginManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides frames for blocks.
 */
class FrameBlockDeriver extends DeriverBase implements ContainerDeriverInterface {

  /**
   * Constructs a Frame Deriver for blocks.
   */
  public function __construct(private readonly FramePluginManager $framePluginManager) {
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, $base_plugin_id) {
    return new static(
      $container->get('plugin.manager.frame')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinitions($base_plugin_definition) {

    foreach ($this->framePluginManager->getDefinitions() as $frame_id => $definition) {
      $this->derivatives[$frame_id] = $base_plugin_definition;
      $this->derivatives[$frame_id]['frame_id'] = $frame_id;
      $this->derivatives[$frame_id]['admin_label'] = 'Frame Block: ' . $definition['label'];
    }
    return $this->derivatives;
  }

}
