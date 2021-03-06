<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Message;
use AppBundle\Model\MessageModel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class MessageController extends Controller
{
    public function update(Request $request)
    {
        $modifyAction = $request->request->get('modify');
        $messageIds = $request->request->get('message_id');

        $member = $this->getUser();

        $message = new Message();

        $messages = $message->newQuery()->findMany($messageIds);

        foreach ($messages as $message) {
            if ($modifyAction === 'delete') {
                $this->messageService->deleteMessage($message, $member);
            } elseif ($modifyAction === 'markasspam') {
                $this->messageService->moveMessage($message, Message::FOLDER_SPAM);
            } elseif ($modifyAction === 'nospam') {
                $this->messageService->moveMessage($message, Message::FOLDER_INBOX);
            //} else {
                //throw new \InvalidArgumentException('Invalid message state.');
            }
        }

        return new RedirectResponse($request->getUri());
    }

    public function with(Request $request)
    {
        $page = $request->query->get('page', 1);
        $limit = $request->query->get('limit', 10);
        //$sort = $request->query->get('sort', 'date');
        //$dir = $request->query->get('dir', 'DESC');
        $otherUsername = $request->attributes->get('username');

        $otherMember = $this->memberRepository->getByUsername($otherUsername);

        $member = $this->getUser();

        $message = new Message();

        $q = $message->newQuery();

        // Eager load each sender for each message
        $q->with('sender');

        $q->where(function (Builder $builder) use ($member, $otherMember) {
            $builder->where(function (Builder $builder) use ($member, $otherMember) {
                $builder->where('IdSender', $otherMember->id);
                $builder->where('IdReceiver', $member->id);
                $builder->where('Status', 'Sent');
            });

            $builder->orWhere(function (Builder $builder) use ($member, $otherMember) {
                $builder->where('IdSender', $member->id);
                $builder->where('IdReceiver', $otherMember->id);
            });
        });

        $q->where('DeleteRequest', 'NOT LIKE', '%receiverdeleted%');

        $q->orderByRaw('IF(messages.created > messages.DateSent, messages.created, messages.DateSent) DESC');

        $q->forPage($page, $limit);

        $count = $q->getQuery()->getCountForPagination();

        $messages = $q->get();

        $content = $this->render('@message/message/index.html.twig', [
            'messages' => $messages,
            'folder' => '',
            'filter' => $request->query->all(),
            'page' => $page,
            'pages' => ceil($count / $limit),
        ]);

        return new Response($content);
    }

    public function compose(Request $request)
    {
        $receiverUsername = $request->attributes->get('username');

        $receiver = $this->memberRepository->getByUsername($receiverUsername);

        $content = $this->render('@message/message/compose.html.twig', [
            'receiver' => $receiver,
        ]);

        return new Response($content);
    }

    /**
     * @Route("/messages/{filter}", name="messages",
     *     requirements={ "filter": "inbox|sent|spam|deleted" },
     *     defaults={"filter": "inbox"})
     *
     * @param Request $request
     * @param string $filter
     * @return Response
     */
    public function index(Request $request, $filter)
    {
        $page = $request->query->get('page', 1);
        $limit = $request->query->get('limit', 10);
        $sort = $request->query->get('sort', 'datesent');
        $sortDir = $request->query->get('dir', 'desc');

        if (!in_array($sortDir, ['asc', 'desc'], true)) {
            throw new \InvalidArgumentException();
        }

        $member = $this->getUser();

        $messageModel = new MessageModel($this->getDoctrine());
        $messages = $messageModel->getFilteredMessages($member, $filter, $sort, $sortDir, $page, $limit);

        return $this->render(':message:index.html.twig', [
            'messages' => $messages,
            'subitems' => [
                'MessagesReceived' => ['route' => ['name' => 'messages', 'filter' => 'inbox']],
                'MessagesSent' => ['route' => ['name' => 'messages', 'filter' => 'sent']],
                'MessagesSpam' => ['route' => ['name' => 'messages', 'filter' => 'spam']],
                'MessagesDeleted' => ['route' => ['name' => 'messages', 'filter' => 'deleted']],
            ],
        ]);
    }

    /**
     * @Route("/message/{id}/reply", name="message_reply",
     *     requirements={"id": "\d+"})
     * @Route("/message/{id}", name="message_show",
     *     requirements={"id": "\d+"})
     *
     * @param Message $message
     * @return Response
     * @internal param Request $request
     */
    public function show(Message $message)
    {
        $member = $this->getUser();
        if (($message->getReceiver() !== $member) && ($message->getSender() !== $member)) {
            throw new AccessDeniedException();
        }

        if ($message->isUnread() && $member === $message->getReceiver()) {
            // Only mark as read when the receiver reads the message, not when
            // the message is presented to the Sender with url /messages/77/sent
            $message->setWhenfirstread(date());
        }

        return $this->render(':message:view.html.twig', [
            'message' => $message,
        ]);
    }
}
