<?php
/**
 * Place Details plugin for Craft CMS 3.x
 *
 * -
 *
 * @link      https://github.com/Andr3y9603/Place-Details
 * @copyright Copyright (c) 2019 Ghiorghiu Andrei
 */

namespace ags\placedetails\models;

use ags\placedetails\PlaceDetails;
use Craft;
use craft\base\Model;

/**
 * PlaceDetails Settings Model
 *
 * This is a model used to define the plugin's settings.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    Ghiorghiu Andrei
 * @package   PlaceDetails
 * @since     1.0.0
 */
class Settings extends Model {

	/**
	 * Some field model attribute
	 *
	 * @var string
	 */
	public $apiKey = '';
	public $placeId = '';
	public $placeProgramFormat = '%day%: %open% - %close%';
	public $format24 = false;
	public $translations = '';

	/**
	 * Returns the validation rules for attributes.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			[['apiKey', 'placeId', 'placeProgramFormat'], 'string'],
			['format24', 'boolean'],
		];
	}
}
