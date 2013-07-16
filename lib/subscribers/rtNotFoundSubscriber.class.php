<?php

class rtNotFoundSubscriber
{
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

        try {
            $conf = sfYaml::load($rtView->getSite()->getRedirects());

            foreach($conf as $redirect) {

                if(count($redirect[0]) < 2) {
                    continue;
                }

                if($redirect[0] == $rtView->getUri()) {
                    $event->getSubject()->redirect(
                        $redirect[1],
                        isset($redirect[2]) ? $redirect[2] : '302'
                    );
                }
            }
        } catch (Exception $e) {

        }
    }
}