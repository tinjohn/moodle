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

namespace core_courseformat;

use section_info;

/**
 * Section delegate base class.
 *
 * Plugins using delegate sections must extend this class into
 * their PLUGINNAME\courseformat\sectiondelegate class.
 *
 * @package    core_courseformat
 * @copyright  2023 Ferran Recio <ferran@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
abstract class sectiondelegate {

    /**
     * Constructor.
     * @param section_info $sectioninfo
     */
    public function __construct(
        protected section_info $sectioninfo
    ) {
    }

    /**
     * Get the section info instance if available.
     *
     * @param section_info $sectioninfo
     * @return section_info|null
     */
    public static function instance(section_info $sectioninfo): ?self {
        if (empty($sectioninfo->component)) {
            return null;
        }
        $classname = $sectioninfo->component . '\courseformat\sectiondelegate';
        if (!class_exists($classname)) {
            return null;
        }
        return new $classname($sectioninfo);
    }
}
