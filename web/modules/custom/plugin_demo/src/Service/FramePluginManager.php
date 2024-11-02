<?php

declare(strict_types=1);

namespace Drupal\plugin_demo\Service;

use Drupal\plugin_demo\Attribute\Frame;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\plugin_demo\Plugin\Frame\FrameInterface;

/**
 * Frame plugin manager.
 */
final class FramePluginManager extends DefaultPluginManager {

  /**
   * Constructs the object.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct(
      'Plugin/Frame',
      $namespaces,
      $module_handler,
      FrameInterface::class,
      Frame::class
    );
    $this->alterInfo('frame_info');
    $this->setCacheBackend($cache_backend, 'frame_plugins');
  }

}
