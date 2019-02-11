<?php
/**
 * Place Details plugin for Craft CMS 3.x
 *
 * -
 *
 * @link      https://github.com/Andr3y9603/Place-Details
 * @copyright Copyright (c) 2019 Ghiorghiu Andrei
 */

namespace ags\placedetails;

use ags\placedetails\models\Settings;
use ags\placedetails\services\PlaceDetailsService;
use ags\placedetails\twigextensions\PlaceDetailsTwigExtension;
use ags\placedetails\variables\PlaceDetailsVariable;
use Craft;
use craft\base\Plugin;
use craft\events\PluginEvent;
use craft\events\RegisterUrlRulesEvent;
use craft\events\TemplateEvent;
use craft\services\Plugins;
use craft\web\twig\variables\CraftVariable;
use craft\web\UrlManager;
use craft\web\View;
use yii\base\Event;

/**
 * Craft plugins are very much like little applications in and of themselves. We’ve made
 * it as simple as we can, but the training wheels are off. A little prior knowledge is
 * going to be required to write a plugin.
 *
 * For the purposes of the plugin docs, we’re going to assume that you know PHP and SQL,
 * as well as some semi-advanced concepts like object-oriented programming and PHP namespaces.
 *
 * https://craftcms.com/docs/plugins/introduction
 *
 * @author    Ghiorghiu Andrei
 * @package   PlaceDetails
 * @since     1.0.0
 *
 * @property  PlaceDetailsService $placeDetails
 * @property  Settings $settings
 * @method    Settings getSettings()
 */
class PlaceDetails extends Plugin {
	// Static Properties
	// =========================================================================

	/**
	 * Static property that is an instance of this plugin class so that it can be accessed via
	 * PlaceDetails::$plugin
	 *
	 * @var PlaceDetails
	 */
	public static $plugin;

	// Public Properties
	// =========================================================================

	/**
	 * To execute your plugin’s migrations, you’ll need to increase its schema version.
	 *
	 * @var string
	 */
	public $schemaVersion = '1.0.0';

	// Public Methods
	// =========================================================================

	/**
	 * Set our $plugin static property to this class so that it can be accessed via
	 * PlaceDetails::$plugin
	 *
	 * Called after the plugin class is instantiated; do any one-time initialization
	 * here such as hooks and events.
	 *
	 * If you have a '/vendor/autoload.php' file, it will be loaded for you automatically;
	 * you do not need to load it in your init() method.
	 *
	 */
	public function init() {
		parent::init();
		self::$plugin = $this;

		$pluginOptions = $this->getSettings();
		$placeDetails = Craft::$app->getSession()->get('google_places_data');

		if (!$placeDetails) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://maps.googleapis.com/maps/api/place/details/json?key=' . $pluginOptions->apiKey . '&placeid=' . $pluginOptions->placeId);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = json_decode(curl_exec($ch));
			curl_close($ch);

			Craft::$app->getSession()->set('google_places_data', $output->result);
		}

		// Add in our Twig extensions
		Craft::$app->view->registerTwigExtension(new PlaceDetailsTwigExtension());

		// Register our site routes
		Event::on(
			UrlManager::class,
			UrlManager::EVENT_REGISTER_SITE_URL_RULES,
			function (RegisterUrlRulesEvent $event) {
				$event->rules['siteActionTrigger1'] = 'place-details/place-details';
			}
		);

		// Register our CP routes
		Event::on(
			UrlManager::class,
			UrlManager::EVENT_REGISTER_CP_URL_RULES,
			function (RegisterUrlRulesEvent $event) {
				$event->rules['cpActionTrigger1'] = 'place-details/place-details/do-something';
			}
		);

		// Register our variables
		Event::on(
			CraftVariable::class,
			CraftVariable::EVENT_INIT,
			function (Event $event) {
				/** @var CraftVariable $variable */
				$variable = $event->sender;
				$variable->set('placeDetails', PlaceDetailsVariable::class);
			}
		);

		// Do something after we're installed
		Event::on(
			Plugins::class,
			Plugins::EVENT_AFTER_INSTALL_PLUGIN,
			function (PluginEvent $event) {
				if ($event->plugin === $this) {
					// We were just installed
				}
			}
		);

		Event::on(
			View::class,
			View::EVENT_BEFORE_RENDER_TEMPLATE,
			function (TemplateEvent $event) {
				$templateSettings = PlaceDetailsService::instance()->getTemplateSettings();

				$event->variables += [
					'placeDetails' => $templateSettings,
				];
			}
		);

		Craft::info(
			Craft::t(
				'place-details',
				'{name} plugin loaded',
				['name' => $this->name]
			),
			__METHOD__
		);
	}

	// Protected Methods
	// =========================================================================

	/**
	 * Creates and returns the model used to store the plugin’s settings.
	 *
	 * @return \craft\base\Model|null
	 */
	protected function createSettingsModel() {
		return new Settings();
	}

	/**
	 * Returns the rendered settings HTML, which will be inserted into the content
	 * block on the settings page.
	 *
	 * @return string The rendered settings HTML
	 */
	protected function settingsHtml(): string {

		return Craft::$app->view->renderTemplate(
			'place-details/settings',
			[
				'translations' => $this->settings->translations,
				'settings' => $this->getSettings(),
			]
		);
	}
}
