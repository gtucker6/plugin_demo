<?php

declare(strict_types=1);

namespace Drupal\plugin_demo\Plugin\Frame;

use Drupal\Component\Plugin\PluginBase;
use Drupal\Component\Utility\NestedArray;
use Drupal\Core\Form\FormStateInterface;

/**
 * Base class for frame plugins.
 */
abstract class FramePluginBase extends PluginBase implements FrameInterface {

  /**
   * {@inheritDoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $settings = $configuration['settings'] ?? [];
    $this->setConfiguration($settings);
  }

  /**
   * {@inheritDoc}
   */
  public function label(): string {
    // Cast the label to a string since it is a TranslatableMarkup object.
    return (string) $this->pluginDefinition['label'];
  }

  /**
   * {@inheritDoc}
   */
  abstract public function build(): array;

  /**
   * {@inheritDoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form['settings'] = [
      '#type' => 'container',
    ];
    return $form;
  }

  /**
   * {@inheritDoc}
   */
  public function validateConfigurationForm(array &$form, FormStateInterface $form_state) {

  }

  /**
   * {@inheritDoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $settings = $form_state->getValue('settings', []);
    $this->setConfiguration($settings);
  }

  /**
   * {@inheritDoc}
   */
  public function defaultConfiguration() {
    return [];
  }

  /**
   * {@inheritDoc}
   */
  public function getConfiguration() {
    return $this->configuration['settings'];
  }

  /**
   * {@inheritDoc}
   */
  public function setConfiguration(array $settings) {
    $this->configuration['settings'] = NestedArray::mergeDeep(
      $this->defaultConfiguration(),
      $this->configuration['settings'],
      $settings
    );
  }

}
