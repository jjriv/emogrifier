<?php

namespace Pelago\Emogrifier\HtmlProcessor;

use Pelago\Emogrifier\Utilities\ArrayIntersector;

/**
 * This class can remove things from HTML.
 *
 * @author Oliver Klee <github@oliverklee.de>
 * @author Jake Hotson <jake.github@qzdesign.co.uk>
 */
class HtmlPruner extends AbstractHtmlProcessor
{
    /**
     * We need to look for display:none, but we need to do a case-insensitive search. Since DOMDocument only
     * supports XPath 1.0, lower-case() isn't available to us. We've thus far only set attributes to lowercase,
     * not attribute values. Consequently, we need to translate() the letters that would be in 'NONE' ("NOE")
     * to lowercase.
     *
     * @var string
     */
    const DISPLAY_NONE_MATCHER = '//*[contains(translate(translate(@style," ",""),"NOE","noe"),"display:none")]';

    /**
     * Removes elements that have a "display: none;" style.
     *
     * @return self fluent interface
     */
    public function removeElementsWithDisplayNone()
    {
        $elementsWithStyleDisplayNone = $this->xPath->query(self::DISPLAY_NONE_MATCHER);
        if ($elementsWithStyleDisplayNone->length === 0) {
            return $this;
        }

        /** @var \DOMNode $element */
        foreach ($elementsWithStyleDisplayNone as $element) {
            $parentNode = $element->parentNode;
            if ($parentNode !== null) {
                $parentNode->removeChild($element);
            }
        }

        return $this;
    }

    /**
     * Removes classes that are no longer required (e.g. because there are no longer any CSS rules that reference them)
     * from `class` attributes.
     *
     * Note that this does not inspect the CSS, but expects to be provided with a list of classes that are still in use.
     *
     * This method also has the (presumably beneficial) side-effect of minifying (removing superfluous whitespace from)
     * `class` attributes.
     *
     * @param string[] $classesToKeep names of classes that should not be removed
     *
     * @return self fluent interface
     */
    public function removeRedundantClasses(array $classesToKeep = [])
    {
        $elementsWithClassAttribute = $this->xPath->query('//*[@class]');

        if ($classesToKeep !== []) {
            $this->removeClassesFromElements($elementsWithClassAttribute, $classesToKeep);
        } else {
            // Avoid unnecessary processing if there are no classes to keep.
            $this->removeClassAttributeFromElements($elementsWithClassAttribute);
        }

        return $this;
    }

    /**
     * Removes classes from the `class` attribute of each element in `$elements`, except any in `$classesToKeep`,
     * removing the `class` attribute itself if the resultant list is empty.
     *
     * @param \DOMNodeList $elements
     * @param string[] $classesToKeep
     *
     * @return void
     */
    private function removeClassesFromElements(\DOMNodeList $elements, array $classesToKeep)
    {
        $classesToKeepIntersector = new ArrayIntersector($classesToKeep);

        foreach ($elements as $element) {
            $elementClasses = \preg_split('/\\s++/', \trim($element->getAttribute('class')));
            $elementClassesToKeep = $classesToKeepIntersector->intersectWith($elementClasses);
            if ($elementClassesToKeep !== []) {
                $element->setAttribute('class', \implode(' ', $elementClassesToKeep));
            } else {
                $element->removeAttribute('class');
            }
        }
    }

    /**
     * Removes the `class` attribute from each element in `$elements`.
     *
     * @param \DOMNodeList $elements
     *
     * @return void
     */
    private function removeClassAttributeFromElements(\DOMNodeList $elements)
    {
        foreach ($elements as $element) {
            $element->removeAttribute('class');
        }
    }
}
