<?php

namespace VP\VotingBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


use VP\VotingBundle\Entity\Poll;
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
        $results = $em->getRepository('VPVotingBundle:Poll')->SimplePlurality($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Poll entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VPVotingBundle:Poll:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'results' => $results
        ));
    }

    /**
     * Displays a form to edit an existing Poll entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VPVotingBundle:Poll')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Poll entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VPVotingBundle:Poll:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Poll entity.
    *
    * @param Poll $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Poll $entity)
    {
        $form = $this->createForm(new PollType(), $entity, array(
            'action' => $this->generateUrl('poll_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Poll entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VPVotingBundle:Poll')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Poll entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('poll_edit', array('id' => $id)));
        }

        return $this->render('VPVotingBundle:Poll:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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
