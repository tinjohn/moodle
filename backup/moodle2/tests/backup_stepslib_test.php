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

namespace core_backup;

/**
 * Tests for Moodle 2 steplib classes.
 *
 * @package core_backup
 * @copyright 2023 Ferran Recio <ferran@moodle.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class backup_stepslib_test extends \advanced_testcase {
    /**
     * Setup to include all libraries.
     */
    public static function setUpBeforeClass(): void {
        global $CFG;
        require_once($CFG->dirroot . '/backup/util/includes/backup_includes.php');
        require_once($CFG->dirroot . '/backup/util/includes/restore_includes.php');
        require_once($CFG->dirroot . '/backup/moodle2/backup_stepslib.php');
    }

    /**
     * Test for the section structure step included elements.
     *
     * @covers \backup_section_structure_step::define_structure
     */
    public function test_backup_section_structure_step(): void {
        $this->resetAfterTest();
        $course = $this->getDataGenerator()->create_course(['numsections' => 3, 'format' => 'topics']);
        $this->setAdminUser();

        $step = new \backup_section_structure_step('section_commons', 'section.xml');

        $reflection = new \ReflectionClass($step);
        $method = $reflection->getMethod('define_structure');
        $method->setAccessible(true);
        $structure = $method->invoke($step);

        $elements = $structure->get_final_elements();
        $this->assertArrayHasKey('number', $elements);
        $this->assertArrayHasKey('name', $elements);
        $this->assertArrayHasKey('summary', $elements);
        $this->assertArrayHasKey('summaryformat', $elements);
        $this->assertArrayHasKey('sequence', $elements);
        $this->assertArrayHasKey('visible', $elements);
        $this->assertArrayHasKey('availabilityjson', $elements);
        $this->assertArrayHasKey('component', $elements);
        $this->assertArrayHasKey('itemid', $elements);
        $this->assertArrayHasKey('timemodified', $elements);
    }
}
