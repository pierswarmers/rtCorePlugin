<?php

class rtNotFoundSubscriber
{
    /**
     * @var sfEvent
     */
    private $event;

    /**
     * @var sfFrontWebController
     */
    private $subject;

    static public function handle(sfEvent $event)
    {
        $handler = new rtNotFoundSubscriber();

        $handler->run($event);
    }

    private function run(sfEvent $event)
    {
        $rtView = rtViewToolkit::getInstance();

        if(!$rtView->getSite() || '' == trim($rtView->getSite()->getRedirects())) {
            return;
        }

        $this->subject = $event->getSubject();
        $this->event = $event;

        try {
            foreach(sfYaml::load($rtView->getSite()->getRedirects()) as $redirect) {
                if($redirect[0] == $rtView->getUri()) {
                    $this->getSubject()->redirect($redirect[1], isset($redirect[2]) ? $redirect[2] : '302');
                }
            }
        } catch (Exception $e) {

        }
    }

    /**
     * @return sfFrontWebController
     */
    private function getSubject()
    {
        return $this->subject;
    }
}