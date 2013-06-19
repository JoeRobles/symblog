<?php

namespace Blogger\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;

class EnquiryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'constraints' => array(
                    new NotBlank(),
                ),
            ))
            ->add('email', 'email', array(
                'constraints' => array(
                    new NotBlank(),
                    new Length(array('min' => 6)),
                    new Email(),
                ),
            ))
            ->add('subject', 'text', array(
                'constraints' => array(
                    new NotBlank(),
                ),
            ))
            ->add('body', 'textarea', array(
                'constraints' => array(
                    new NotBlank(),
                ),
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Blogger\BlogBundle\Entity\Enquiry'
        ));
    }

    public function getName()
    {
        return 'blogger_blogbundle_enquirytype';
    }
}
