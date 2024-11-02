<?php

declare(strict_types=1);

namespace Drupal\plugin_demo\Plugin\Frame;

use Drupal\plugin_demo\Attribute\Frame;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Plugin implementation of the frame.
 */
#[Frame(
  id: 'image',
  label: new TranslatableMarkup('Image Frame'),
  description: new TranslatableMarkup('A frame that provides an image'),
)]
final class ImageFrame extends FramePluginBase {

  /**
   * {@inheritDoc}
   */
  public function build(): array {
    $image_source = $this->getConfiguration()['image_source'];
    return [
      '#type' => 'html_tag',
      '#tag' => 'img',
      '#value' => '',
      '#attributes' => [
        'src' => $image_source,
      ],
    ];
  }

  /**
   * {@inheritDoc}
   */
  public function defaultConfiguration() : array {
    return [
      'image_source' => NULL,
    ];
  }

  /**
   * {@inheritDoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);
    $settings = $this->getConfiguration();
    $form['settings']['image_source'] = [
      '#type' => 'textfield',
      '#title' => 'Image Source',
      '#default_value' => $settings['image_source'],
    ];
    return $form;
  }

}
