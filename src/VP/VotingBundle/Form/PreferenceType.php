<?php

namespace VP\VotingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use VP\VotingBundle\Entity\Poll;
use Doctrine\ORM\EntityRepository;

class PreferenceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    private $poll = null;

    public function __construct(Poll $poll){
        $this->poll = $poll;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        $builder
        ->add('answer', 'entity',  array(
            'class' => 'VP\VotingBundle\Entity\Answer',
            'property' => 'content',
            'query_builder' => function (EntityRepository $er)
            {
            return $er
            ->createQueryBuilder('a')
            ->where('a.poll = :id')
           ->setParameter('id', $this->poll->getId());
            }
            ))
            ->add('approved', 'checkbox', array(
            'label'    => 'Approved',
            'required' => false,
            ))
            ->add('negative', 'choice', array(
        'choices'  => array(-1 => '-1', 0 => ' ', 1 => '+1'),
        'required' => true,
        'label' => ' ',
        'expanded' => true
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
