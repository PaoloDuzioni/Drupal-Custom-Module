<?php

namespace Drupal\beprime_map\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "beprime_maps_block",
 *   admin_label = @Translation("BePrime Google Maps "),
 *   category = @Translation("Maps"),
 * )
 */
class MapBlock extends BlockBase implements BlockPluginInterface {

    /**
     * CONFIGUARTIONS FORM
     */
    
    // CONFIG DEFAULT VALUES
    public function defaultConfiguration() {
      $default_config = \Drupal::config('beprime_map.settings');
      return [
        'maps_block_latitude' => $default_config->get('map.lat'),
        'maps_block_longitude' => $default_config->get('map.lon'),
        'maps_block_infotitle' => $default_config->get('map.title'),
        'maps_block_address' => $default_config->get('map.address'),
      ];
    }

    // DEFINE FORM FIELDS
    public function blockForm($form, FormStateInterface $form_state) {
      $form = parent::blockForm($form, $form_state);

      $config = $this->getConfiguration();

      $form['maps_block_latitude'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Latitudine'),
        '#description' => $this->t('Latitudine da usare nella mappa'),
        '#default_value' => isset($config['maps_block_latitude']) ? $config['maps_block_latitude'] : '',
      ];
      $form['maps_block_longitude'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Longitudine'),
        '#description' => $this->t('Longitudine da usare nella mappa'),
        '#default_value' => isset($config['maps_block_longitude']) ? $config['maps_block_longitude'] : '',
      ];
      $form['maps_block_infotitle'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Titolo info window'),
        '#description' => $this->t('Titolo visualizzato dalla info window'),
        '#default_value' => isset($config['maps_block_infotitle']) ? $config['maps_block_infotitle'] : '',
      ];
      $form['maps_block_address'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Indirizzo info window'),
        '#description' => $this->t('Indirizzo da usare nella mappa'),
        '#default_value' => isset($config['maps_block_address']) ? $config['maps_block_address'] : '',
      ];

      return $form;
    }

    // SAVE DATA ON THE FORM
    public function blockSubmit($form, FormStateInterface $form_state) {
      parent::blockSubmit($form, $form_state);
      $values = $form_state->getValues();
      $this->configuration['maps_block_latitude'] = $values['maps_block_latitude'];
      $this->configuration['maps_block_longitude'] = $values['maps_block_longitude'];
      $this->configuration['maps_block_infotitle'] = $values['maps_block_infotitle'];
      $this->configuration['maps_block_address'] = $values['maps_block_address'];
    }



  /**
   * DISPLAY VIEW 
   */
  public function build() {

    // Get values from backend
    $config = $this->getConfiguration();
    $lat = $config['maps_block_latitude'];
    $lon = $config['maps_block_longitude'];
    $title = $config['maps_block_infotitle'];
    $address = $config['maps_block_address'];

    return array(
      '#theme' => 'beprime_map',
      '#lat' => $lat,
      '#lon' => $lon,
      '#title' => $title,
      '#address' => $address,
    );
  }

}