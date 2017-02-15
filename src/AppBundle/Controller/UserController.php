<?php

namespace AppBundle\Controller;

use AppBundle\Presenter\CommentCollectionPresenter;
use AppBundle\Presenter\UserDTOCollectionPresenter;
use AppBundle\Service\UserService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\InvalidOptionsException;
use Symfony\Component\Validator\Exception\MissingOptionsException;
use Utils\TypedCollection\TypedCollectionException;

/**
 * Class UsersController
 * @package AppBundle\Controller
 */
class UserController extends Controller
{

    /**
     * @Route("/user", name="user")
     * @param Request $request
     * @return RedirectResponse
     */
    public function indexAction(Request $request)
    {
        return $this->redirectToRoute('users_list');
    }

    /**
     * @Route("/user/list", name="users_list")
     * @param Request $request
     * @return Response
     * @throws TypedCollectionException
     * @throws MissingOptionsException
     * @throws InvalidOptionsException
     * @throws ConstraintDefinitionException
     */
    public function listAction(Request $request)
    {
        /** @var UserService $userService */
        $userService = $this->get('user.service');

        $users = $userService->getUsers();
        $usersList = (new UserDTOCollectionPresenter())->presentAsArray($users);

        return $this->render('default/user/list.html.twig', [
            'users' => $usersList
        ]);
    }

    /**
     * @Route("/user/add", name="add_new_user")
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws ORMInvalidArgumentException
     * @throws OptimisticLockException
     * @throws \OutOfBoundsException
     */
    public function addAction(Request $request)
    {
        /** @var UserService $userService */
        $userService = $this->get('user.service');

        $operationSucceded = false;
        $errors = [];

        $formBuilder = $this->createFormBuilder();

        $formBuilder
            ->add('name')
            ->add('email')
            ->add('save', SubmitType::class);

        $form = $formBuilder->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $errors = $userService->addUser($formData['name'], $formData['email']);

            $operationSucceded = empty($errors);
        }

        if (true === $operationSucceded) {
            return $this->redirectToRoute('users_list');
        } else {
            return $this->render('default/user/add.html.twig', [
                'form' => $form->createView(),
                'errors' => $errors
            ]);
        }

    }

    /**
     * @Route("/user/comments/{userId}", requirements={"userId" = "\d+"}, name="show_user_comments")
     * @param int $userId
     * @param Request $request
     * @return Response
     * @throws MissingOptionsException
     * @throws InvalidOptionsException
     * @throws ConstraintDefinitionException
     */
    public function commentsAction($userId, Request $request)
    {
        /** @var UserService $userService */
        $userService = $this->get('user.service');

        $user = $userService->getUser($userId);

        if (null === $user) {
            return $this->redirectToRoute('users_list');
        }

        $commentsList = (new CommentCollectionPresenter())->presentAsArray($user->getComments());

        return $this->render('default/comment/list.html.twig', [
            'userName' => $user->getName(),
            'userId' => $userId,
            'comments' => $commentsList
        ]);
    }
}
