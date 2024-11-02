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
  id: 'text',
  label: new TranslatableMarkup('Text Frame'),
  description: new TranslatableMarkup('A frame that provides formatted text'),
)]
final class TextFrame extends FramePluginBase {

  /**
   * {@inheritDoc}
   */
  public function build(): array {
    $formatted_text = $this->getConfiguration()['formatted_text'];
    return [
      '#type' => 'processed_text',
      '#text' => $formatted_text['value'],
      '#format' => $formatted_text['format'],
    ];
  }

  /**
   * {@inheritDoc}
   */
  public function defaultConfiguration() : array {
    return [
      'formatted_text' => [
        'value' => '',
        'format' => 'basic_html',
      ],
    ];
  }

  /**
   * {@inheritDoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);
    $settings = $this->getConfiguration();
    $form['settings']['formatted_text'] = [
      '#type' => 'text_format',
      '#title' => 'Formatted Text',
      '#format' => $settings['formatted_text']['format'],
      '#default_value' => $settings['formatted_text']['value'],
    ];
    return $form;
  }

}
