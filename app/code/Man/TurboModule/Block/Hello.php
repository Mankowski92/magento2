<?php

namespace Man\TurboModule\Block;

class Hello extends \Magento\Framework\View\Element\Template
{
    public function getHelloWorldTxt(): string
    {
        return 'Hello world!';
    }

    public function getTest(): string
    {
//        $array = ['Marcin', 'Ewa', 'Ania', 'Piecho'];
//
//        $return = '<ul>';
//        foreach ($array as $item) {
//            $return .= '<li>' . $item . '</li>';
//        }
//        return $return . '</ul>';
        return "<h3>Message printed from TurboModule</h3>";
    }
}
