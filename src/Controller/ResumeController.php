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
            'base_dir' => $this->generateUrl('resume_page')
        ]);
    }

    /**
     * @Route("/contact/email", name="contact_email", methods={"POST"})
     * @param Request $request
     * @param \Swift_Mailer $mailer
     * @return Response
     * @throws \Exception
     */
    public function contactEmailAction(Request $request, \Swift_Mailer $mailer)
    {
        $emailFrom = $request->request->get('c_y_email');
        $subject = $request->request->get('c_y_subject');
        $message = $request->request->get('c_y_message');
        $cc = $request->request->get('c_y_cc');

        // empty
        if (empty($emailFrom) || empty($subject) || empty($message)) {
            throw new \Exception('Content could not be empty.', 500);
        }

        // email
        if (filter_var($emailFrom, FILTER_VALIDATE_EMAIL) === false) {
            throw new \Exception('E-mail is not valid.', 500);
        }

        // send
        $emailsTo = [$this->getParameter('mailer_to')];

        if (!empty($cc)) {
            $emailsTo[] = $emailFrom;
        }

        $message = (new \Swift_Message($subject))
            ->setFrom($emailFrom)
            ->setTo($emailsTo)
            ->setBody($message, 'text/plain');

        // result
        $sent_result = $mailer->send($message) > 0 ? 1 : 0;

        return $this->render('resume/email-confirm.html.twig', [
            'base_dir' => $this->generateUrl('resume_page'),
            'sent_result' => $sent_result
        ]);
    }
}
