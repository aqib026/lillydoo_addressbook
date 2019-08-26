<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AddressBook;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;
use AppBundle\Service\FileUploader;

class AddressbookController extends Controller
{
    /**
     * @Route("/address-book", name="addressbook_list")
     */
    public function listAction()
    {
        // replace this example code with whatever you need
        $records = $this->getDoctrine()->getRepository('AppBundle:AddressBook')->findAll();
        return $this->render('addressbook/index.html.twig',array('records' => $records ));
    }


    /**
     * @Route("/address-book/create", name="addressbook_create")
     */
    public function createAction(Request $request, FileUploader $fileUploader)
    {
        $addressbook = new AddressBook;

        $form = $this->createForm('AppBundle\Form\AddressBookType',$addressbook);

        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid()  ) {

            $record = $this->getDoctrine()->getRepository('AppBundle:AddressBook')->save($addressbook,$fileUploader);

            $this->addFlash('notice', 'Address Book Record Added !');                

            return $this->redirectToRoute('addressbook_list');
        }

        return $this->render('addressbook/create.html.twig',array('form' => $form->createView() ));
    }


    /**
     * @Route("/address-book/edit/{id}", name="addressbook_edit")
     */
    public function editAction($id , Request $request, FileUploader $fileUploader)
    {

        $addressbook = $this->getDoctrine()->getRepository('AppBundle:AddressBook')->find($id);

        $file =  $addressbook->getPicture();

        $form = $this->createForm('AppBundle\Form\AddressBookType',$addressbook);

        $form->handleRequest($request);


        if ( $form->isSubmitted() && $form->isValid()  ) {

            $record = $this->getDoctrine()->getRepository('AppBundle:AddressBook')->save($addressbook,$fileUploader,$file);

            $this->addFlash('notice','Address Book Record Updated !');

            return $this->redirectToRoute('addressbook_list');
        }

        return $this->render('addressbook/edit.html.twig',array('form' => $form->createView() ));
    }


    /**
     * @Route("/address-book/{id}", name="addressbook_view")
     */
    public function viewAction($id)
    {
        $record = $this->getDoctrine()->getRepository('AppBundle:AddressBook')->find($id);
        return $this->render('addressbook/view.html.twig',array('record' => $record ));
    }

    /**
     * @Route("/address-book/delete/{id}", name="addressbook_delete")
     */
    public function deleteAction($id)
    {
        $record = $this->getDoctrine()->getRepository('AppBundle:AddressBook')->delete($id);
        $this->addFlash('notice','Address Book Record Removed');
        return $this->redirectToRoute('addressbook_list');
    }

}
