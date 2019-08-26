<?php

namespace AppBundle\Repository;

use AppBundle\Form\AddressBookType;
use AppBundle\Entity\AddressBook;
use AppBundle\Service\FileUploader;

/**
 * AddressBookRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AddressBookRepository extends \Doctrine\ORM\EntityRepository
{


	public function save(AddressBook $addressbook, FileUploader $fileUploader){

        $pictureFile = $addressbook->getPicture();
        if ($pictureFile) {
            $newFilename = $fileUploader->upload($pictureFile);
            $addressbook->setPicture($newFilename);
        }

        $em = $this->getEntityManager();
        $em->persist($addressbook);
        return $em->flush();

	}

	public function update(AddressBook $addressbook, FileUploader $fileUploader, string $file){

        $pictureFile = $addressbook->getPicture();
        if ($pictureFile) {
            $newFilename = $fileUploader->upload($pictureFile);
            $addressbook->setPicture($newFilename);
        }else{
            $addressbook->setPicture($file);        	
        }

        $em = $this->getEntityManager();
        $em->persist($addressbook);
        return $em->flush();

	}


	public function delete(int $id){

        $em = $this->getEntityManager();
        $addressbook = $em->getRepository('AppBundle:AddressBook')->find($id);
        $em->remove($addressbook);
        $em->flush();

	}
}
