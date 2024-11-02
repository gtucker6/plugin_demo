<?php

declare(strict_types=1);

namespace Drupal\plugin_demo\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\SubformState;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\plugin_demo\Plugin\Derivative\FrameBlockDeriver;
use Drupal\plugin_demo\Plugin\Frame\FrameInterface;
use Drupal\plugin_demo\Service\FramePluginManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a frame block block.
 */
#[Block(
  id: 'plugin_demo_frame',
  admin_label: new TranslatableMarkup('Frame Block'),
  category: new TranslatableMarkup('Custom'),
  deriver: FrameBlockDeriver::class,
)]
final class FrameBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Constructs the plugin instance.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    private readonly FramePluginManager $framePluginManager,
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): self {
    return new self(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('plugin.manager.frame'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration(): array {
    return [
      'frame' => [],
    ];
  }

  /**
   * Helper method to get a Frame plugin.
   */
  public function getFrame(): FrameInterface {
    $frame_id = $this->pluginDefinition['frame_id'];
    $frame = $this->framePluginManager->createInstance(
      $frame_id,
      $this->configuration['frame']
    );
    return $frame;
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state): array {
    /** @var \Drupal\plugin_demo\Plugin\Frame\FrameInterface $frame */
    $frame = $this->getFrame();
    $form['frame'] = [];
    $subform_state = SubformState::createForSubform($form['frame'], $form, $form_state);
    $form['frame'] = $frame->buildConfigurationForm([], $subform_state);
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state): void {
    $this->configuration['frame'] = $form_state->getValue('frame');
  }

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $build['frame'] = $this->getFrame()->build();
    return $build;
  }

}
