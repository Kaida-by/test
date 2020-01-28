<?php

namespace App\Listener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MyRequestListener
 */
class MyRequestListener
{
    /**
     * @param RequestEvent $event
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        $cookieTest = $event->getRequest()->cookies->get('my_id');
        if (isset($cookieTest) && $cookieTest == 1) {
            $event->setResponse(new Response('<p>Поздравляем, вы отправили нужную куку!</p>'));
        }
        /*
         * Это listener, который слушает определённое событие.
         * Это событие называется kernel.request (класс Symfony\Component\HttpKernel\Event\RequestEvent).
         * Это событие возникает в момент, когда выполнение кода ещё не дошло до контроллера.
         * Когда symfony бросает (начинает выполнять) это событие, объект этого события передаётся по порядку
         *      во все листенеры (включая этот), которые слушают это событие.
         *
         *
         * Для того, чтобы этот listener начал слушать это событие, я зарегистрировал этот listener
         *      в файле config/services.yaml вот таким вот образом:
         *          App\Listener\MyRequestListener:
         *               tags:
         *                  - { name: kernel.event_listener, event: kernel.request }
         * И теперь symfony знает, что этот класс MyRequestListener тоже слушает это событие kernel.request.
         *
         *
         * И тут мы уже можем делать какие-нибудь интересные вещи.
         * К примеру у объекта класса Symfony\Component\HttpKernel\Event\RequestEvent есть метод getRequest(),
         *      который нам вернёт объект текущего запроса (объект класса Symfony\Component\HttpFoundation\Request)
         *      и из этого объекта мы можем узнать всю необходимую информацию:
         *       - ip-адрес пользователя
         *       - http-метод (GET, POST и т. д.)
         *       - какие куки передал пользователь на сервер
         *       - и т. д.
         * И на основе этой информации мы можем предпринять какие-нибудь действия.
         * Самое простое, что можно сделать, это сформировать ответ (response) клиенту прямо в этом листенере.
         * Делается это следующим образом. Нужно у объекта события вызвать метод setResponse и передать туда
         *      объект ответа:
         *      $event->setResponse(new \Symfony\Component\HttpFoundation\Response('<h1>Checking work listener</h1>'));
         * Если так сделать, то после того, как symfony бросит событие, это событие пролетит через все такие
         *      листенеры (как этот). И потом symfony увидит, что у этого события уже есть объект response'а.
         * И если объект response'а уже есть, то symfony НЕ передасть выполнение кода в контроллер,
         *      а сразу вернёт response клиенту.
         *
         *
         * Задание. Нужно сначала поэксперементировать просто с добавлением respons'a в событие (как показано в примере выше)
         *      и посмотреть, что будет.
         * Потом можно усложнить. Если в request'е не передана кука my_id со значением 1, то ни чего не делать.
         *      Если же такая кука передана, то установить response прямо в этом листенере со следуюим текстом:
         *      "<p>Поздравляем, вы отправили нужную куку!</p>".
         */
    }
}
