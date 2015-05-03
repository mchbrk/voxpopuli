<?php

namespace VP\VotingBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use VP\VotingBundle\Entity\Result;
use VP\VotingBundle\Form\ResultType;

/**
 * Result controller.
 *
 * @Route("/result")
 */
class ResultController extends Controller
{

    /**
     * Lists all Result entities.
     *
     * @Route("/", name="result")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('VPVotingBundle:Result')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Result entity.
     *
     * @Route("/", name="result_create")
     * @Method("POST")
     * @Template("VPVotingBundle:Result:new.html.twig")
     */
    public function createAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $poll = $em->getRepository('VPVotingBundle:Poll')->find($id);
        if (!$poll) {
            throw $this->createNotFoundException('Unable to find Poll entity.');
        }
        $entity = new Result();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('result_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Result entity.
     *
     * @param Result $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Result $entity)
    {
        $form = $this->createForm(new ResultType(), $entity, array(
            'action' => $this->generateUrl('result_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Result entity.
     *
     * @Route("/new", name="result_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Result();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Result entity.
     *
     * @Route("/{id}", name="result_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VPVotingBundle:Result')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Result entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Result entity.
     *
     * @Route("/{id}/edit", name="result_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VPVotingBundle:Result')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Result entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Result entity.
    *
    * @param Result $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Result $entity)
    {
        $form = $this->createForm(new ResultType(), $entity, array(
            'action' => $this->generateUrl('result_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Result entity.
     *
     * @Route("/{id}", name="result_update")
     * @Method("PUT")
     * @Template("VPVotingBundle:Result:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VPVotingBundle:Result')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Result entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('result_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Result entity.
     *
     * @Route("/{id}", name="result_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VPVotingBundle:Result')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Result entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('result'));
    }

    /**
     * Creates a form to delete a Result entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('result_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
