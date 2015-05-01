<?php

namespace VP\VotingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PreferenceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        //$id =8; //jakos podac id? i tak nie działa
        $builder
          /*   ->add('answer', 'entity',  array(
            'class' => 'VP\VotingBundle\Entity\Answer',
            'property' => 'line',
            'query_builder' => function (EntityRepository $er) use ($id)
            {
      return $er
        ->createQueryBuilder('a')
        ->where('a.poll = :id')
        ->setParameter('id', $id);
}
))*/
            ->add('answer')
            ->add('approved', 'choice', array(
                'choices'  => array( 1 => 'approved',  0 => 'not approved'),
                'required' => false
                )
            )
            ->add('negative', 'choice', array(
        'choices'  => array(-1 => 'negative vote', 1 => 'positive vote', 0 => 'neutral vote'),
        'required' => false,
        'label' => 'Negative voting option:'
));
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VP\VotingBundle\Entity\Preference'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'vp_votingbundle_preference';
    }
}
