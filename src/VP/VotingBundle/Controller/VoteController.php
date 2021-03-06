<?php

namespace VP\VotingBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use VP\VotingBundle\Entity\Vote;
use VP\VotingBundle\Form\VoteType;
use VP\VotingBundle\Entity\Preference;

/**
 * Vote controller.
 */
class VoteController extends Controller
{

    /**
     * Lists all Vote entities.
     *
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('VPVotingBundle:Vote')->findByUser($this->getUser());

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Vote entity.
     *
     * @Method( {"GET", "POST"} )
     * @Template("VPVotingBundle:Vote:new.html.twig")
     */
    public function createAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $poll = $em->getRepository('VPVotingBundle:Poll')->find($id);
        if (!$poll) {
            throw $this->createNotFoundException('Unable to find Poll entity.');
        }

        $em = $this->getDoctrine()->getManager();
        $checkVoted = $em->getRepository('VPVotingBundle:Vote')->findOneBy(array(
            'user' => $this->getUser(),
            'poll' => $poll
        )); 
        if ($checkVoted){
            return $this->redirect($this->generateUrl('poll_show', array('id' => $poll->getId())));
        }//daj session i flashbag
        $entity = new Vote();
        $entity->setUser($this->getUser());
        $entity->setDate(new \datetime);
        $entity->setPoll($poll);
        $answers = $poll->getAnswers();
        $rank = 1;
        foreach ($answers as $answer){
            $preference = new Preference();
            $preference->setVote($entity);
            $preference->setRank($rank);
            $rank++;
            $entity->getPreferences()->add($preference);
        }
        $form = $this->createCreateForm($entity,$id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('vote_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'poll' => $poll,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Vote entity.
     *
     * @param Vote $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Vote $entity, $id)
    {
        $form = $this->createForm(new VoteType(), $entity, array(
            'action' => $this->generateUrl('vote_create', ["id" => $id]),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Vote entity.
     *
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Vote();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Vote entity.
     *
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VPVotingBundle:Vote')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vote entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }

}
