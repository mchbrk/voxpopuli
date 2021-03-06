<?php

namespace VP\VotingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VoteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $data = $builder->getData();
        $builder->add('preferences', 'collection', 
            array('type' => new PreferenceType($data->getPoll()), 'disabled' => false)
            
            );
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VP\VotingBundle\Entity\Vote'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'vp_votingbundle_vote';
    }
}
