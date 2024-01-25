<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

namespace core\hook\output;

use core\hook\described_hook;
use core\hook\deprecated_callback_replacement;

/**
 * Allows plugins to add any elements to the page <head> html tag
 *
 * @package    core
 * @copyright  2023 Marina Glancy
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class standard_head_html_prepend implements described_hook, deprecated_callback_replacement {
    /** @var string $output Stores results from callbacks */
    private $output = '';

    /**
     * Describes the hook purpose.
     *
     * @return string
     */
    public static function get_hook_description(): string {
        return 'Allows plugins to add any elements to the page &lt;head&gt; html tag.';
    }

    /**
     * List of tags that describe this hook.
     *
     * @return string[]
     */
    public static function get_hook_tags(): array {
        return ['output'];
    }

    /**
     * Returns list of lib.php plugin callbacks that were deprecated by the hook.
     *
     * @return array
     */
    public static function get_deprecated_plugin_callbacks(): array {
        return ['before_standard_html_head'];
    }

    /**
     * Plugins implementing callback can add any HTML to the page.
     *
     * Must be a string containing valid html head content
     *
     * @param string $output
     */
    public function add_html(string $output): void {
        $this->output .= $output;
    }

    /**
     * Returns all HTML added by the plugins
     *
     * @return string
     */
    public function get_output(): string {
        return $this->output;
    }

    /**
     * Process legacy callbacks.
     *
     * Legacy callback 'before_standard_html_head' is deprecated since Moodle 4.4
     */
    public function process_legacy_callbacks(): void {
        $pluginswithfunction = get_plugins_with_function('before_standard_html_head', 'lib.php', true, true);
        foreach ($pluginswithfunction as $plugins) {
            foreach ($plugins as $function) {
                $output = $function();
                $this->add_html((string)$output);
            }
        }
    }
}
