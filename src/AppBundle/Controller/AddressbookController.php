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

            $addressbook = $form->getData();

            $pictureFile = $form['picture']->getData();

            if ($pictureFile) {
                $newFilename = $fileUploader->upload($pictureFile);
                $addressbook->setPicture($newFilename);
            }

            $em = $this->getDoctrine()->getManager();

            $em->persist($addressbook);

            $em->flush();

            $this->addFlash('notice','Address Book Record Added !');

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

            $addressbook = $form->getData();

            $pictureFile = $form['picture']->getData();

            if ($pictureFile) {
                $newFilename = $fileUploader->upload($pictureFile);
                $addressbook->setPicture($newFilename);
            }else{
               $addressbook->setPicture($file);
            }

            $em = $this->getDoctrine()->getManager();
            $addressbook = $em->getRepository('AppBundle:AddressBook')->find($id);

            $em->flush();

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
        $em = $this->getDoctrine()->getManager();
        $addressbook = $em->getRepository('AppBundle:AddressBook')->find($id);

        $em->remove($addressbook);
        $em->flush();

        $this->addFlash('notice','Address Book Record Removed');
        return $this->redirectToRoute('addressbook_list');
    }

}
