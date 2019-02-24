<?php
/**
 * Place Details plugin for Craft CMS 3.x
 *
 * -
 *
 * @link      https://github.com/Andr3y9603/Place-Details
 * @copyright Copyright (c) 2019 Ghiorghiu Andrei
 */

namespace ags\placedetails\assetbundles\placedetailscpsection;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * PlaceDetailsCPSectionAsset AssetBundle
 *
 * AssetBundle represents a collection of asset files, such as CSS, JS, images.
 *
 * http://www.yiiframework.com/doc-2.0/guide-structure-assets.html
 *
 * @author    Ghiorghiu Andrei
 * @package   PlaceDetails
 * @since     1.0.0
 */
class PlaceDetailsCPSectionAsset extends AssetBundle {

	/**
	 * Initializes the bundle.
	 */
	public function init() {
		// define the path that your publishable resources live
		$this->sourcePath = "@ags/placedetails/assetbundles/placedetailscpsection/dist";

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
