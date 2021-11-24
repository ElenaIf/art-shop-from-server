<?php

namespace Drupal\membership\Plugin;

use Drupal\Core\Plugin\PluginFormInterface;
use Drupal\search_api\Plugin\ConfigurablePluginBase;

/**
 * Base class for Membership provider plugins.
 */
abstract class MembershipProviderBase extends ConfigurablePluginBase implements MembershipProviderInterface, PluginFormInterface {

}
