<?php
namespace AppBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ChoiceDescriptionExtension extends AbstractTypeExtension
{
    /**
     * Returns the name of the type being extended.
     *
     * @return string The name of the type being extended
     */
    public function getExtendedType()
    {
        return 'choice';
    }

    /**
     * Add the image_path option
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(array('desc'));
    }

    /**
     * Pass the desc to the view
     *
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if ($options !== null) {
            if (array_key_exists('desc', $options)) {
                if ($options['desc'] !== null) {
                    //$parentData = $form->getParent()->getData();
                    //if (null !== $parentData) {
                        //$accessor = PropertyAccess::createPropertyAccessor();
                        //$desc = $accessor->getValue($parentData, $options['desc']);
                        //$desc = $options['desc'];
                    //} else {
                    //    $desc = null;
                    //}
                    $view->vars['desc'] = $options['desc'];
                }
            }
        }
    }

}