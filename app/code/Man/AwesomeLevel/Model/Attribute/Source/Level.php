<?php

namespace Man\AwesomeLevel\Model\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class Level extends AbstractSource
{

    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->_options = [
                ['label' => __('Average'), 'value' => 'average'],
                ['label' => __('Cool'), 'value' => 'cool'],
                ['label' => __('Super'), 'value' => 'super'],
                ['label' => __('Mega'), 'value' => 'mega'],
                ['label' => __('Hyper'), 'value' => 'hyper'],
                ['label' => __('Extreme'), 'value' => 'extreme'],
                ['label' => __('Insane'), 'value' => 'insane'],
            ];
        }
        return $this->_options;
    }
}
