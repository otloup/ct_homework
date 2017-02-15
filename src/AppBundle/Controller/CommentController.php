<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Service\CommentService;
use AppBundle\Service\MailService;
use AppBundle\Service\UserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\InvalidOptionsException;
use Symfony\Component\Validator\Exception\MissingOptionsException;

/**
 * Class CommentController
 * @package AppBundle\Controller
 */
class CommentController extends Controller
{
    /**
     * @Route("/comment/list", name="list_all_comments")
     * @param Request $request
     * @return Response
     */
    public function listAction(Request $request)
    {
        return $this->render('default/comment/list.html.twig');
    }

    /**
     * @Route("/comment/add/{userId}", requirements={"userId" = "\d+"}, name="add_new_comment")
     * @param int $userId
     * @param Request $request
     * @return Response
     * @throws MissingOptionsException
     * @throws InvalidOptionsException
     * @throws ConstraintDefinitionException
     */
    public function addAction($userId, Request $request)
    {
        /** @var MailService $mailService */
        $mailService = $this->get('mail.service');
        /** @var UserService $userService */
        $userService = $this->get('user.service');
        /** @var CommentService $commentService */
        $commentService = $this->get('comment.service');

        $operationSucceded = false;
        $errors = [];

        /** @var User $user */
        $user = $userService->getUser($userId);

        $formBuilder = $this->createFormBuilder();

        $formBuilder
            ->add('title')
            ->add('content', TextareaType::class)
            ->add('user', HiddenType::class, [
                'data' => $userId,
                'required' => true
            ])
            ->add('save', SubmitType::class)
            ->addEventListener(FormEvents::POST_SUBMIT, [$mailService, 'sendUserCommentNotification']);

        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            $errors = $commentService->addComment($formData['title'], $formData['content'], $user);

            $operationSucceded = empty($errors);
        }

        if (true === $operationSucceded) {
            return $this->redirectToRoute('show_user_comments', [
                'userId' => $userId
            ]);
        } else {
            return $this->render('default/comment/add.html.twig', [
                'userName' => $user->getName(),
                'form' => $form->createView(),
                'errors' => $errors
            ]);
        }
    }
}
