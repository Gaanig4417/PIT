<?php

/**
 * Declare frontend actions/filters/shortcodes
 */

//if ($app->getEnv() == 'dev') {
//	add_filter('init', function() use ($app) {
//		if ($header = $app->request->header('X-HOOK')) {
//			error_log($header);
//		}
//	});
//}


/*
 * Exclude For WP Rocket Settings
 */
if(defined('WP_ROCKET_VERSION')) {
    add_filter('rocket_excluded_inline_js_content', function ($lines) {
        $lines[] = 'fluent_form_ff_form_instance';
        $lines[] = 'fluentFormVars';
        $lines[] = 'fluentform_payment';
        return $lines;
    });
}
/*
 * Push captcha in all forms when enabled from global settings
 */
add_filter('fluentform_rendering_form', function ($form) {
    $option = get_option('_fluentform_global_form_settings');
    $enabled = \FluentForm\Framework\Helpers\ArrayHelper::get($option, 'misc.autoload_captcha');
    if (!$enabled) {
        return $form;
    }
    $type = \FluentForm\Framework\Helpers\ArrayHelper::get($option, 'misc.captcha_type');
    $reCaptcha = [
        "element"    => "recaptcha",
        "attributes" => [
            "name" => "recaptcha",
        ],
    ];
    $hCaptcha = [
        "element"    => "hcaptcha",
        "attributes" => [
            "name" => "hcaptcha",
        ],
    ];
    $turnstile = [
        "element"    => "turnstile",
        "attributes" => [
            "name" => "turnstile",
        ],
    ];
    
    if ($type == 'recaptcha') {
        $captcha = $reCaptcha;
    } elseif ($type == 'hcaptcha') {
        $captcha = $hCaptcha;
    } elseif ($type == 'turnstile') {
        $captcha = $turnstile;
    }
    
    // place recaptcha below custom submit button
    $hasCustomSubmit = false;
    foreach ($form->fields['fields'] as $index => $field) {
        if ($field['element'] == 'custom_submit_button') {
            $hasCustomSubmit = true;
            array_splice($form->fields['fields'], $index, 0, [$captcha]);
            break;
        }
    }
    if (!$hasCustomSubmit) {
        $form->fields['fields'][] = $captcha;
    }
    
    return $form;
}, 10, 1);
