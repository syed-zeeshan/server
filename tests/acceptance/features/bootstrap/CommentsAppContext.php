<?php
/**
 * @copyright Copyright (c) 2017 Arthur Schiwon <blizzz@arthur-schiwon.de>
 *
 * @author Arthur Schiwon <blizzz@arthur-schiwon.de>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

use Behat\Behat\Context\Context;

class CommentsAppContext implements Context, ActorAwareInterface {
	use ActorAware;

	/**
	 * @return Locator
	 */
	public static function newCommentField() {
		return Locator::forThe()->css("div.newCommentRow .message")->
				descendantOf(FilesAppContext::currentSectionDetailsView())->
				describedAs("New comment field in current section details view in Files app");
	}

	/**
	 * @return Locator
	 */
	public static function submitNewCommentButton() {
		return Locator::forThe()->css("div.newCommentRow .submit")->
				descendantOf(FilesAppContext::currentSectionDetailsView())->
				describedAs("Submit new comment button in current section details view in Files app");
	}

	/**
	 * @return Locator
	 */
	public static function commentList() {
		return Locator::forThe()->css("ul.comments")->
				descendantOf(FilesAppContext::currentSectionDetailsView())->
				describedAs("Comment list in current section details view in Files app");
	}

	/**
	 * @return Locator
	 */
	public static function commentWithText($text) {
		return Locator::forThe()->xpath("//div[normalize-space() = '$text']/ancestor::li")->
				descendantOf(self::commentList())->
				describedAs("Comment with text \"$text\" in current section details view in Files app");
	}

	/**
	 * @When /^I create a new comment with "([^"]*)" as message$/
	 */
	public function iCreateANewCommentWithAsMessage($commentText) {
		$this->actor->find(self::newCommentField(), 10)->setValue($commentText);
		$this->actor->find(self::submitNewCommentButton())->click();
	}

	/**
	 * @Then /^I see a comment with "([^"]*)" as message$/
	 */
	public function iSeeACommentWithAsMessage($commentText) {
		PHPUnit_Framework_Assert::assertTrue(
				$this->actor->find(self::commentWithText($commentText), 10)->isVisible());
	}
}
