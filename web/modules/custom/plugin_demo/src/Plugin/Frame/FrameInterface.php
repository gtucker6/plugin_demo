<?php

declare(strict_types=1);

namespace Drupal\plugin_demo\Plugin\Frame;

use Drupal\Component\Plugin\ConfigurableInterface;
use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\Core\Plugin\PluginFormInterface;

/**
 * Interface for frame plugins.
 */
interface FrameInterface extends PluginInspectionInterface, PluginFormInterface, ConfigurableInterface {

  /**
   * Returns the translated plugin label.
   */
  public function label(): string;

  /**
   * Returns a render array.
   */
  public function build(): array;

}
