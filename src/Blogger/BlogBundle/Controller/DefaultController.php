<?php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Blogger\BlogBundle\Entity\Enquiry;
use Blogger\BlogBundle\Form\EnquiryType;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
    
    /**
     * @Route("/about")
     * @Template()
     */
    public function aboutAction()
    {
        return array();
    }
    
    /**
     * @Route("/contact")
     * @Template()
     */
    public function contactAction(Request $request)
    {
        $enquiry = new Enquiry();
        $form = $this->createForm(new EnquiryType(), $enquiry);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $message = \Swift_Message::newInstance()
                ->setSubject($this->container->getParameter('blogger_blog.contact.subject'))
                ->setFrom($this->container->getParameter('blogger_blog.contact.from'))
                ->setTo($data->getEmail())
                ->setBcc($this->container->getParameter('blogger_blog.contact.to'))
                ->setBody($this->renderView('BloggerBlogBundle:Default:contactEmail.txt.twig', array('enquiry' => $enquiry)));
            $this->get('mailer')->send($message);
            $this->get('session')->getFlashBag()->add('blogger-notice', 'Your contact enquiry was successfully sent. Thank you!');
            
            return $this->redirect($this->generateUrl('blogger_blog_default_contact'));
        }

        return array('form' => $form->createView());
    }
}
