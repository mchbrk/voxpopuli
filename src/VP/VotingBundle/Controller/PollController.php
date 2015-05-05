<?php

namespace VP\VotingBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ob\HighchartsBundle\Highcharts\Highchart;


use VP\VotingBundle\Entity\Poll;
use VP\VotingBundle\Entity\Answer;
use VP\VotingBundle\Form\PollType;

/**
 * Poll controller.
 *
 */
class PollController extends Controller
{

    /**
     * Lists all Poll entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('VPVotingBundle:Poll')->findAll();

        return $this->render('VPVotingBundle:Poll:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Poll entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Poll();
        $entity->setUser($this->getUser());
        $entity->setDateStart(new \datetime);
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            foreach ($entity->getAnswers() as $answer){
                $answer->setPoll($entity);
            }

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('poll_show', array('id' => $entity->getId())));
        }

        return $this->render('VPVotingBundle:Poll:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Poll entity.
     *
     * @param Poll $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Poll $entity)
    {
        $form = $this->createForm(new PollType(), $entity, array(
            'action' => $this->generateUrl('poll_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Poll entity.
     *
     */
    public function newAction()
    {
        $entity = new Poll();

        $form   = $this->createCreateForm($entity);

        return $this->render('VPVotingBundle:Poll:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Poll entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VPVotingBundle:Poll')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Poll entity.');
        }
        if ($entity->getDateEnd() < new \DateTime()){
            return $this->redirect($this->generateUrl('poll_showResults', array('id' => $id)));
        }
        $deleteForm = $this->createDeleteForm($id);

        if ($entity->getUser() == $this->getUser()){
            $candelete = true;
        }else {
            $candelete = false;
        }

        return $this->render('VPVotingBundle:Poll:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'candelete' => $candelete,
        ));
    }


    public function showResultsAction($id){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('VPVotingBundle:Poll')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Poll entity.');
        }
        $plurality = $em->getRepository('VPVotingBundle:Poll')->SimplePlurality($id);
        $pluralityWithRunoff = $em->getRepository('VPVotingBundle:Poll')->PluralityWithRunoff($id);
        $randomBallot = $em->getRepository('VPVotingBundle:Poll')->RandomBallot($id);
        $bordaCount = $em->getRepository('VPVotingBundle:Poll')->BordaCount($id);
        $pl_series = array();
        $pl_series['data']=array();
        foreach ($plurality as $option => $votes){
            $pl_categories[] =(string) $entity->getAnswers()->filter(function (Answer $e) use ($option) {
                return $e->getId() ==$option ? true:false;
            })->first();
            $pl_series['data'][] = (int) $votes;

        } 
        $pl_series = array($pl_series);
        $chartPlurality = new Highchart();
        $chartPlurality->chart->type('column');
        $chartPlurality->chart->renderTo('chartPlurality');  // The #id of the div where to render the chart
        $chartPlurality->title->text('Simple Plurality');
        $chartPlurality->xAxis->title(array('text'  => ""));
        $chartPlurality->yAxis->title(array('text'  => "Number of votes"));
        $chartPlurality->xAxis->categories($pl_categories);
        $chartPlurality->series($pl_series);

        if ($pluralityWithRunoff){

        $ro_series = array();
        $ro_series['data']=array();

        foreach ($pluralityWithRunoff as $option => $votes){
            $ro_categories[] =(string) $entity->getAnswers()->filter(function (Answer $e) use ($option) {
                return $e->getId() ==$option ? true:false;
            })->first();
            $ro_series['data'][] = (int) $votes;

        } 
        $ro_series = array($ro_series);

        $runoff = new Highchart();
        $runoff->chart->type('column');
        $runoff->chart->renderTo('runoff');  // The #id of the div where to render the chart
        $runoff->title->text('Runoff');
        $runoff->xAxis->title(array('text'  => ""));
        $runoff->yAxis->title(array('text'  => "Number of votes"));
        $runoff->xAxis->categories($ro_categories);
        $runoff->series($ro_series);
            
        }

    return $this->render('VPVotingBundle:Poll:results.html.twig', array(
        'plurality' => $chartPlurality,
         'entity'      => $entity,
         'runoff' => $runoff
    ));
}

    /**
     * Deletes a Poll entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {

        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VPVotingBundle:Poll')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Poll entity.');
            }

            if ($this->getUser() != $entity->getUser){
                return false; //cannot delete if you are not the author of poll
            }
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('poll'));
    }

    /**
     * Creates a form to delete a Poll entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('poll_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
