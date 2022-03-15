<?php

namespace Man\AwesomeLevel\Model\Attribute\Backend;

use Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend;

class Level extends AbstractBackend
{
    public function validate($object)
    {
        $object->getData($this->getAttribute()->getAttributeCode());

        return true;
    }
}

