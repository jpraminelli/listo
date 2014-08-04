<?php

class EasyBib_Form_SubFormDecorator extends EasyBib_Form_Decorator
{

    /**
     * Form Element Decorator
     *
     * @staticvar array
     */
    protected static $_FormDecorator = array(
        'table' => array(
            'FormElements',
        ),
        'div' => array(
            'FormElements',
        ),
        'bootstrap' => array(
            'FormElements',
        )
    );

    /**
     * Set the subform decorators by the given string format or by the default div style
     *
     * @param object $objSubForm        Zend_Form_SubForm pointer-reference
     * @param string $constFormat    Project_Plugin_FormDecoratorDefinition constants
     * @return NULL
     */
    public static function setSubFormDecorator(Zend_Form_SubForm $form, $format = self::BOOTSTRAP, $submit_str = 'submit', $cancel_str = 'cancel')
    {
        parent::setFormDecorator($form, $format, $submit_str, $cancel_str);
        $form->setDecorators(self::$_FormDecorator[$format]);
    }

}
