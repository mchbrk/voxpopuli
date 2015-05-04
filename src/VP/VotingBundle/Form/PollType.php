<?php

namespace VP\VotingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class PollType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $timestamp = time();
        $builder
            ->add('name')
            ->add('question', 'textarea', array(

                'attr' => array('style' =>'resize: none')
                ))
            ->add('dateEnd', 'collot_datetime', array( 'pickerOptions' =>
            array('format' => 'yyyy-mm-dd hh:ii',
                'weekStart' => 1,
                'startDate' => date("Y-m-d H:i"),
                'endDate' => date("Y-m-d H:i", strtotime('+1 year', $timestamp) ),
                'daysOfWeekDisabled' => null,//example
                'autoclose' => true,
                'startView' => 'month',
                'minView' => 'hour',
                'maxView' => 'decade',
                'todayBtn' => false,
                'todayHighlight' => true,
                'keyboardNavigation' => true,
                'language' => 'en',
                'forceParse' => true,
                'minuteStep' => 5,
                'pickerReferer ' => 'default', //deprecated
                'pickerPosition' => 'bottom-right',
                'viewSelect' => 'hour',
                'showMeridian' => false,
                )))
                 ;  

        $builder->add('answers', 'collection', array(
        'type'         => new AnswerType(),
        'allow_add'    => true,
        'by_reference' => false,
        //workaraounds for ugly label
        'label' => ' ' , 
        'label_attr' => array('style' => 'margin-top: -110px'),
    ));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VP\VotingBundle\Entity\Poll'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'vp_votingbundle_poll';
    }
}
