<?php

namespace PrivlinkBundle\Controller;

use MongoDB\BSON\Timestamp;
use PrivlinkBundle\Entity\privlink;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Null;

/**
 * Hidden controller.
 *
 * @Route("hidden")
 */

class hiddenController extends Controller
{
    
    /**
     * Hidden controller.
     *
     * @Route("hidden")
     */
    public function indexAction(Request $request, $hash){

        $text = $this->getObject($hash);
        //get today's datetime
        $nowDate = $this->newDate();
        //get value endDate from database
        $endDate = $text->getEndDate();
        //get value from database
        $configuration = $text->getConfiguration();
        $password = $text->getPassword();

        if ($configuration) {

            if ($password) {
                $form = $this->createForm('PrivlinkBundle\Form\checkPasswordType');
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    //get request from form
                    $entry_password  = $request->request->get('privlinkbundle_privlink')['password'];
                    $entry_password  = md5($entry_password );

                    if ($password == $entry_password ) {
                        $this->actionObject($text);

                        if ($nowDate < $endDate) {
                            $time = $this->timeDifference($nowDate,$endDate);
                            return $this->render('PrivlinkBundle:privlink:hidden_time.html.twig',
                                array('privlink' => $text, 'time' => $time,));

                        } else if ($endDate == NULL) {
                            $this->setConfigNull($hash);
                            return $this->render('PrivlinkBundle:privlink:hidden.html.twig',
                                array('privlink' => $text,));

                        } else {
                            return $this->render('PrivlinkBundle:privlink:empty_page.html.twig');
                        }

                    } else {
                        return $this->render('PrivlinkBundle:privlink:checkPassword.html.twig',
                            array('form' => $form->createView(), 'text' => false,
                        ));
                    }

                }
                return $this->render('PrivlinkBundle:privlink:checkPassword.html.twig',
                    array('form' => $form->createView(), 'text' => true,));
            }

            if (empty($password)) {
                $this->actionObject($text);

                if ($nowDate < $endDate) {
                    $time = $this->timeDifference($nowDate,$endDate);
                    return $this->render('PrivlinkBundle:privlink:hidden_time.html.twig',
                        array('privlink' => $text, 'time' => $time,));

                } else if ($endDate == NULL) {
                    $this->setConfigNull($hash);
                    return $this->render('PrivlinkBundle:privlink:hidden.html.twig',
                        array('privlink' => $text,));

                } else {
                    return $this->render('PrivlinkBundle:privlink:empty_page.html.twig');
                }
            } else {
                return $this->render('PrivlinkBundle:privlink:empty_page.html.twig');
            }
        }else {
            return $this->render('PrivlinkBundle:privlink:empty_page.html.twig');
        }
    }

        //get object from DataBase
    public function getObject($hash){

        $em = $this->getDoctrine()->getManager();

        $note = $em->createQueryBuilder('privlink')
            ->select('privlink')
            ->from('PrivlinkBundle:privlink', 'privlink')
            ->andWhere('privlink.hash IN (:hash)')
            ->setParameter('hash', $hash)
            ->getQuery();
        $text = $note->getSingleResult();

        return $text;

    }

    //set Views Count, LastReviewDate, LastReviewFromIP, send email,
    public function actionObject($text){
            $em = $this->getDoctrine()->getManager();
            //get page views
            $views = $text->getViewsCount();

            if ($views == null) {
                $text->setViewsCount(1);
                $email = $text->getEmail();
                $this->sendMail($email);

            } else if ($views > 0) {
                $count = $views + 1;
                $text->setViewsCount($count);
            }

            //set ip address last review
            $user_ip = $this->get_user_ip();
            $text->setLastReviewFromIp($user_ip);

            $reviewDate = $this->newDate();
            $text->setlastReviewDate($reviewDate);
            $em->flush();
    }

    //set null into row 'Configuration'
    public function setConfigNull($hash){
        $em = $this->getDoctrine()->getManager();
        $em->createQueryBuilder('privlink')
            ->update('PrivlinkBundle:privlink', 'privlink')
            ->set('privlink.configuration', '?1')
            ->setParameter(1, false)
            ->andwhere('privlink.hash IN (:hash)')
            ->setParameter('hash', $hash)
            ->getQuery()->getSingleScalarResult();
    }

    //get difference between two DateTime objects
    public function timeDifference($nowDate, $endDate){
        //difference between two DateTime objects
        $diff = date_diff($nowDate, $endDate);
        //Get Time to remove
        $time = $diff->format("%d днів %h годин %i хвилин %s секунд");
        return $time;
    }

    // Determine the IP address of the user
    public function get_user_ip(){
        $client = @$_SERVER{'HTTP_CLIENT_IP'};
        $forward = @$_SERVER{'HTTP_X_FORWARDER_FOR'};
        $remote = @$_SERVER{'REMOTE_ADDR'};

        if(filter_var($client, FILTER_VALIDATE_IP)){
            $ip_addr = $forward;
        } else {
            $ip_addr = $remote;
        }
        return $ip_addr;
    }

    //get today Date Time
    public function newDate(){
        $date = new \DateTime('now');
        return $date;
    }

    //Email Report reading
    public function sendMail($email){
        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
            ->setUsername('privnoteSoftGroup@gmail.com')
            ->setPassword('privnotesg');

        $mailer = \Swift_Mailer::newInstance($transport);
        $message = \Swift_Message::newInstance('Privnote')
            ->setFrom(array('privnoteSoftGroup@gmail.com' => 'Private Note'))
            ->setTo($email)
            ->setSubject('Записку, яку ви створили, було прочитано')
            ->setBody('<p>Це автоматичне повідомлення було відправлено з метою повідомити, що вашу записку було прочитано.</p> 
                        <a>Бажаете відправити ще одну записку? <a href="http://privnote.host-panel.net">http://privnote.host-panel.net</a></p>','text/html');

        $mailer->send($message);

    }


}



