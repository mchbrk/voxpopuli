<?php

namespace VP\VotingBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use VP\VotingBundle\Entity\Preference;
use VP\VotingBundle\Form\PreferenceType;

/**
 * Preference controller.
 *
 */
class PreferenceController extends Controller
{

    /**
     * Lists all Preference entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('VPVotingBundle:Preference')->findAll();

        return $this->render('VPVotingBundle:Preference:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Preference entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Preference();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('preference_show', array('id' => $entity->getId())));
        }

        return $this->render('VPVotingBundle:Preference:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Preference entity.
     *
     * @param Preference $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Preference $entity)
    {
        $form = $this->createForm(new PreferenceType(), $entity, array(
            'action' => $this->generateUrl('preference_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Preference entity.
     *
     */
    public function newAction()
    {
        $entity = new Preference();
        $form   = $this->createCreateForm($entity);

        return $this->render('VPVotingBundle:Preference:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Preference entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VPVotingBundle:Preference')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Preference entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VPVotingBundle:Preference:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Preference entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VPVotingBundle:Preference')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Preference entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VPVotingBundle:Preference:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Preference entity.
    *
    * @param Preference $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Preference $entity)
    {
        $form = $this->createForm(new PreferenceType(), $entity, array(
            'action' => $this->generateUrl('preference_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Preference entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VPVotingBundle:Preference')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Preference entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('preference_edit', array('id' => $id)));
        }

        return $this->render('VPVotingBundle:Preference:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Preference entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VPVotingBundle:Preference')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Preference entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('preference'));
    }

    /**
     * Creates a form to delete a Preference entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('preference_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
