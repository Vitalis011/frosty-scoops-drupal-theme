<?php

namespace Drupal\palindrome_checker\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Creates a simple palindrome checker form.
 */
class PalindromeCheckerForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'palindrome_checker_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter a word or phrase'),
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Check Palindrome'),
    ];

    if ($result = $form_state->get('palindrome_result')) {
  $form['result'] = [
    '#markup' => '<div><strong>' . $result . '</strong></div>',
  ];
}

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
  $text = $form_state->getValue('text');

  // Remove spaces and punctuation and convert to lowercase.
  $clean_text = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $text));

  if ($clean_text === strrev($clean_text)) {
    $result = $this->t('"%text" is a palindrome!', [
      '%text' => $text,
    ]);
  }
  else {
    $result = $this->t('"%text" is not a palindrome.', [
      '%text' => $text,
    ]);
  }

  $form_state->setRebuild(TRUE);
  $form_state->set('palindrome_result', $result);
}

}