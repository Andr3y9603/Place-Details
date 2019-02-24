<?php
/**
 * Place Details plugin for Craft CMS 3.x
 *
 * -
 *
 * @link      https://github.com/Andr3y9603/Place-Details
 * @copyright Copyright (c) 2019 Ghiorghiu Andrei
 */

namespace ags\placedetails\services;

use ags\placedetails\PlaceDetails;
use Craft;
use craft\base\Component;

/**
 * PlaceDetailsService Service
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    Ghiorghiu Andrei
 * @package   PlaceDetailsService
 * @since     1.0.0
 */
class PlaceDetailsService extends Component {
	// Public Methods
	// =========================================================================

	/**
	 * This function can literally be anything you want, and you can have as many service
	 * functions as you want
	 *
	 * From any other plugin file, call it like this:
	 *
	 *     PlaceDetails::$plugin->placeDetailsService->getTemplateSettings()
	 *
	 * @return mixed
	 */
	public function getTemplateSettings() {

		$placeDetails = Craft::$app->getSession()->get('google_places_data');
		if (empty($placeDetails)) {
			return false;
		}
		$weekdays = $placeDetails->opening_hours->weekday_text;

		$output = [];
		$translations = [];

		if (!empty($weekdays)) {
			foreach ($weekdays as $index => $program) {
				$day = '';
				$open = '';
				$close = '';

				preg_match('/[A-Z]+[a-z]{4,8}/', $program, $dayMatch);
				preg_match_all('/\d{2}:\d{2}+ +[A-Z]{2}/', $program, $hours);

				if (!empty($dayMatch)) {
					$day = $dayMatch[0];
					$translations[$day] = '';
				}

				$open = $hours[0][0];
				$close = $hours[0][1];
				if (!empty($hours) && !empty(PlaceDetails::$plugin->settings->format24)) {
					$open = date("H:i", strtotime($open));
					$close = date("H:i", strtotime($close));
				}

				$dayTranslate = empty(PlaceDetails::$plugin->settings->translations[$day]) ? $day : PlaceDetails::$plugin->settings->translations[$day];

				$format = str_replace(['%day%', '%open%', '%close%'], [$dayTranslate, $open, $close], PlaceDetails::$plugin->settings->placeProgramFormat);

				array_push($output, $format);
			}
		}

		if (empty(PlaceDetails::$plugin->settings->translations)) {
			if (!empty($weekdays)) {
				foreach ($weekdays as $index => $program) {
					$day = '';

					preg_match('/[A-Z]+[a-z]{4,8}/', $program, $dayMatch);

					if (!empty($dayMatch)) {
						$translations[$day] = '';
					}
					Craft::$app->getProjectConfig()->set('plugins.place-details.settings.translations', $translations);
				}
			}
		}

		$city = array_filter($placeDetails->address_components, function ($address, $key) {
			return array_search('locality', $address->types) !== false;
		}, ARRAY_FILTER_USE_BOTH);

		$city = $city[key($city)];

		$coutry = array_filter($placeDetails->address_components, function ($address, $key) {
			return array_search('country', $address->types) !== false;
		}, ARRAY_FILTER_USE_BOTH);

		$coutry = $coutry[key($coutry)];

		$postal_code = array_filter($placeDetails->address_components, function ($address, $key) {
			return array_search('postal_code', $address->types) !== false;
		}, ARRAY_FILTER_USE_BOTH);

		$postal_code = $postal_code[key($postal_code)];

		$sublocality = array_filter($placeDetails->address_components, function ($address, $key) {
			return array_search('sublocality', $address->types) !== false;
		}, ARRAY_FILTER_USE_BOTH);

		$sublocality = $sublocality[key($sublocality)];
		return [
			'city' => $city->long_name,
			'sublocality' => $city->long_name,
			'country' => $coutry->long_name,
			'foramtted_address' => $placeDetails->formatted_address,
			'phone' => $placeDetails->formatted_phone_number,
			'postal_code' => $postal_code->long_name,
			'open_now' => intval($placeDetails->opening_hours->open_now) === 1 ? 'yes' : 'no',
			'opening_hours' => $output,
		];
	}
}
