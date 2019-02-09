<?php
/**
 * Place Details plugin for Craft CMS 3.x
 *
 * -
 *
 * @link      https://github.com/Andr3y9603/Place-Details
 * @copyright Copyright (c) 2019 Ghiorghiu Andrei
 */

namespace ags\placedetails\variables;

use ags\placedetails\PlaceDetails;

use Craft;

/**
 * Place Details Variable
 *
 * Craft allows plugins to provide their own template variables, accessible from
 * the {{ craft }} global variable (e.g. {{ craft.placeDetails }}).
 *
 * https://craftcms.com/docs/plugins/variables
 *
 * @author    Ghiorghiu Andrei
 * @package   PlaceDetails
 * @since     1.0.0
 */
class PlaceDetailsVariable
{
    // Public Methods
    // =========================================================================

    /**
     * Whatever you want to output to a Twig template can go into a Variable method.
     * You can have as many variable functions as you want.  From any Twig template,
     * call it like this:
     *
     *     {{ craft.placeDetails.exampleVariable }}
     *
     * Or, if your variable requires parameters from Twig:
     *
     *     {{ craft.placeDetails.exampleVariable(twigValue) }}
     *
     * @param null $optional
     * @return string
     */
    public function exampleVariable($optional = null)
    {
        $result = "And away we go to the Twig template...";
        if ($optional) {
            $result = "I'm feeling optional today...";
        }
        return $result;
    }
}
