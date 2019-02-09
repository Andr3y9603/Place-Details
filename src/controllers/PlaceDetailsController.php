<?php
/**
 * Place Details plugin for Craft CMS 3.x
 *
 * -
 *
 * @link      https://github.com/Andr3y9603/Place-Details
 * @copyright Copyright (c) 2019 Ghiorghiu Andrei
 */

namespace ags\placedetails\controllers;

use ags\placedetails\PlaceDetails;

use Craft;
use craft\web\Controller;

/**
 * PlaceDetails Controller
 *
 * Generally speaking, controllers are the middlemen between the front end of
 * the CP/website and your plugin’s services. They contain action methods which
 * handle individual tasks.
 *
 * A common pattern used throughout Craft involves a controller action gathering
 * post data, saving it on a model, passing the model off to a service, and then
 * responding to the request appropriately depending on the service method’s response.
 *
 * Action methods begin with the prefix “action”, followed by a description of what
 * the method does (for example, actionSaveIngredient()).
 *
 * https://craftcms.com/docs/plugins/controllers
 *
 * @author    Ghiorghiu Andrei
 * @package   PlaceDetails
 * @since     1.0.0
 */
class PlaceDetailsController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['index', 'do-something'];

    // Public Methods
    // =========================================================================

    /**
     * Handle a request going to our plugin's index action URL,
     * e.g.: actions/place-details/place-details
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $result = 'Welcome to the PlaceDetailsController actionIndex() method';

        return $result;
    }

    /**
     * Handle a request going to our plugin's actionDoSomething URL,
     * e.g.: actions/place-details/place-details/do-something
     *
     * @return mixed
     */
    public function actionDoSomething()
    {
        $result = 'Welcome to the PlaceDetailsController actionDoSomething() method';

        return $result;
    }
}
