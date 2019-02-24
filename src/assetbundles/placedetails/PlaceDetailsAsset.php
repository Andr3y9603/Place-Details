<?php
/**
 * Place Details plugin for Craft CMS 3.x
 *
 * -
 *
 * @link      https://github.com/Andr3y9603/Place-Details
 * @copyright Copyright (c) 2019 Ghiorghiu Andrei
 */

namespace ags\placedetails\assetbundles\PlaceDetails;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * PlaceDetailsAsset AssetBundle
 *
 * AssetBundle represents a collection of asset files, such as CSS, JS, images.
 *
 * @author    Ghiorghiu Andrei
 * @package   PlaceDetails
 * @since     1.0.0
 */
class PlaceDetailsAsset extends AssetBundle {

	/**
	 * Initializes the bundle.
	 */
	public function init() {
		// define the path that your publishable resources live
		$this->sourcePath = "@ags/placedetails/assetbundles/placedetails/dist";

		// define the dependencies
		$this->depends = [
			CpAsset::class,
		];

		// define the relative path to CSS/JS files that should be registered with the page
		// when this asset bundle is registered
		$this->js = [
			'js/PlaceDetails.js',
		];

		$this->css = [
			'css/PlaceDetails.css',
		];

		parent::init();
	}
}
