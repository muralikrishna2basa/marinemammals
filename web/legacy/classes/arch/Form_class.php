<?php
/**
 *    Class Form v1.0.0
 *  Author: De Winter Johan
 *  Last Modified:23/12/2009
 *
 */
require_once QuickForm2.'QuickForm2.php';

class Form extends HTML_QuickForm2
{
    /**
     * Each item is placed in the footer as valid html fragment
     *
     * @var unknown_type
     */
    protected $footers = array();

    public $onlyupdate = false;

    public $cms = true;

    public $isAdd = true;

    public function addFooter($footer)
    {
        $this->footers[] = $footer;
    }

    public function __toString()
    {
        echo '<form' . $this->getAttributes(true) . ">\n";

        foreach ($this as $element) {
            $this->output_element($element);
        }

        $this->output_footer();

    }

    private function output_footer()
    {

        if (count($this->footers) > 0) {
            $footers = implode("", $this->footers);
        } else {
            $footers = "";
        }

        if ($this->cms == true) {
            if ($this->onlyupdate == false) {
                echo '<div class="footer">' .
                    '<button type="submit" name="submit" class="submit_form" value="Add"' . ($this->isAdd ? '' : 'style="display:none;"') . '>Submit</button>' .
                    '<button type="submit" name="submit" class="submit_form" value="Update"' . ($this->isAdd ? 'style="display:none;"' : '') . '>Update</button>' .
                    '<button type="submit" name="submit" class="submit_form" value="Delete"' . ($this->isAdd ? 'style="display:none;"' : '') . '>Delete</button>' .
                    $footers .
                    '</div></form>';
            } else {
                echo '<div class="footer">' .
                    '<button type="submit" name="submit" class="submit_form" value="Update">Update</button>' .
                    $footers .
                    '</div></form>';
            }
        } else {
            echo '<div class="footer">' . $footers . '</div></form>';
        }

    }

    private function output_element($element)
    {


        if ('fieldset' == $element->getType()) {
            $this->output_fieldset($element);
        } elseif ('hidden' == $element->getType()) {
            echo '<div style="display: none;">' . $element->__toString() . "</div>\n";
        } elseif ($element->getName() == 'pk') {

            echo $element->__toString();
        } else {
            if ($this->isAdd == true || $element->getAttribute('isadd') != 'false') {
                echo '<div class="qfrow"><label class="qflabel" for="' . $element->getId() .
                    '">' . ($element->isRequired() ? '<span class="required">*</span>' : '') . $element->getLabel() .
                    '</label> <div class="qfelement' . (strlen($element->getError()) ? ' error' : '') . '">' .
                    (strlen($element->getError()) ? '<span class="error">' . $element->getError() . '</span>' : '') .
                    $element->__toString() . "</div></div>\n";
            }
        }
    }

    private function output_fieldset($fieldset)
    {
        echo '<fieldset' . $fieldset->getAttributes(true) . ">\n<legend>" .
            $fieldset->getLabel() . "</legend>\n";
        foreach ($fieldset as $element) {
            $this->output_element($element);
        }
        echo "</fieldset>\n";
    }


}

?>