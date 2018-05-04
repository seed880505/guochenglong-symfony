<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ResumeController extends Controller
{
    /**
     * @Route("/{_locale}", name="resume_page", requirements={"_locale"="en|fr|zh"}, defaults={"_locale"="zh"})
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('resume/resume.html.twig', [
            //'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/contact/email", name="contact_email", methods={"POST"})
     * @param Request $request
     * @param \Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function contactEmailAction(Request $request, \Swift_Mailer $mailer)
    {
        $email = $request->request->get('c_y_email');
        $subject = $request->request->get('c_y_subject');
        $message = $request->request->get('c_y_message');
        $cc = $request->request->get('c_y_cc');

        // empty
        if (empty($email) || empty($subject) || empty($message)) {
            throw new \Exception('Content could not be empty.', 500);
        }

        // email
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new \Exception('E-mail is not valid.', 500);
        }

        // send
        $message = (new \Swift_Message($subject))
            ->setFrom($this->getParameter('mailer_user'))
            ->setTo($this->getParameter('my_email'))
            ->setBody($message, 'text/plain');
        if (!empty($cc)) {
            $message->setCc($email);
        }

        if ($mailer->send($message) > 0) {
            $msg = $this->get('translator')->trans('contact.success', [], 'app');
        } else {
            $msg = $this->get('translator')->trans('contact.failure', [], 'app');
        }
        $this->get('session')->getFlashBag()->add('flash_msg', $msg);
        return $this->redirectToRoute('homepage');
    }
}
