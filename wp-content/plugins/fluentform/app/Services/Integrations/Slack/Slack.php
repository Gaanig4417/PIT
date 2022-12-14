<?php

namespace FluentForm\App\Services\Integrations\Slack;

use FluentForm\App\Modules\Form\FormDataParser;
use FluentForm\App\Modules\Form\FormFieldsParser;
use FluentForm\App\Services\Integrations\LogResponseTrait;
use FluentForm\Framework\Helpers\ArrayHelper;

class Slack
{
    use LogResponseTrait;

    /**
     * The slack integration settings of the form.
     *
     * @var array $settings
     */
    protected $settings = [];

    /**
     * Handle slack notifier.
     *
     * @param $submissionId
     * @param $formData
     * @param $form
     */
    public static function handle($feed, $formData, $form, $entry)
    {
        $settings = $feed['processedValues'];

        $inputs = FormFieldsParser::getEntryInputs($form);

        $labels = FormFieldsParser::getAdminLabels($form, $inputs);

        $labels = apply_filters('fluentform_slack_field_label_selection', $labels ,$settings, $form);

	    foreach ($inputs as $name => $input) {
		    if (empty($formData[$name])) {
			    continue;
		    }
		    if (ArrayHelper::get($input, 'element', '') == 'tabular_grid') {
			    $formData[$name] = static::getTabularGridMarkdownValue($formData[$name], $input);
		    }
	    }
        $formData = FormDataParser::parseData((object)$formData, $inputs, $form->id);

        $slackTitle = ArrayHelper::get($settings, 'textTitle');
      
        if($slackTitle === '') {
             $title = "New submission on " . $form->title;
        }else {
            $title = $slackTitle;
        }

        $fields = [];

        foreach ($formData as $attribute => $value) {    
            $value = str_replace('<br />', "\n", $value);
            $value = str_replace('&', '&amp;', $value);
            $value = str_replace('<', '&lt;', $value);
            $value = str_replace('>', "&gt;", $value);
            if ( ! isset($labels[$attribute]) || empty($value)) {
                continue;
            }
            $fields[] = [
                'title' => $labels[$attribute],
                'value' => $value,
                'short' => false
            ];
        }
        $slackHook = ArrayHelper::get($settings, 'webhook');

        $titleLink = admin_url('admin.php?page=fluent_forms&form_id='
            . $form->id
            . '&route=entries#/entries/'
            . $entry->id
        );

        $body = [
            'payload' => json_encode([
                'attachments' => [
                    [
                        'color'      => '#0078ff',
                        'fallback'   => $title,
                        'title'      => $title,
                        'title_link' => $titleLink,
                        'fields'     => $fields,
                        'footer'     => 'fluentform',
                        'ts'         => round(microtime(true) * 1000)
                    ]
                ]
            ])
        ];

        $result = wp_remote_post($slackHook, [
            'method'      => 'POST',
            'timeout'     => 30,
            'redirection' => 5,
            'httpversion' => '1.0',
            'headers'     => [],
            'body'        => $body,
            'cookies'     => []
        ]);

        if (is_wp_error($result)) {
            $status = 'failed';
            $message = $result->get_error_message();
        } else {
            $message = $result['response'];
            $status = $result['response']['code'] == 200 ? 'success' : 'failed';
        }

        if ($status == 'failed') {
            do_action('ff_integration_action_result', $feed, 'failed', $message);
        } else {
            do_action('ff_integration_action_result', $feed, 'success', 'Submission notification has been successfully delivered to slack channel');
        }

        return array(
            'status'  => $status,
            'message' => $message
        );
    }
    // @todo make helper function for formatting in MarkDown Format
	// make tabular-grid value markdown format
	protected static function getTabularGridMarkdownValue($girdData, $field = [], $rowJoiner = '<br />', $colJoiner = ', ') {
		$girdRows = ArrayHelper::get($field, 'raw.settings.grid_rows', '');
		$girdCols = ArrayHelper::get($field, 'raw.settings.grid_columns', '');
		$value = '';
		foreach ($girdData as $row => $column) {
			if ($girdRows && isset($girdRows[$row])) {
				$row = $girdRows[$row];
			}
			$value .= "- *" . $row . "* :  ";
			if (is_array($column)) {
				foreach ($column as $index => $item) {
					$_colJoiner = $colJoiner;
					if ($girdCols && isset($girdCols[$item])) {
						$item = $girdCols[$item];
					}
					if ($index == (count($column) - 1)) {
						$_colJoiner = '';
					}
					$value .=   $item . $_colJoiner;
				}

			} else {
				if ($girdCols && isset($girdCols[$column])) {
					$column = $girdCols[$column];
				}
				$value .= $column;
			}
			$value .= $rowJoiner;
		}
		return $value;
	}
}
