<?php

namespace Academy\AwesomeLevel\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    private $eavSetupFactory;

    public function __construct(\Magento\Eav\Setup\EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create();
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'awesome_level',
            [
                'group' => 'General',
                'type' => 'varchar',
                'label' => 'Awesome level',
                'input' => 'select',
                'source' => 'Academy\AwesomeLevel\Model\Attribute\Source\Level',
                'frontend' => 'Academy\AwesomeLevel\Model\Attribute\Frontend\Level',
                'backend' => 'Academy\AwesomeLevel\Model\Attribute\Backend\Level',
                'required' => false,
                'sort_order' => 50,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'is_used_in_grid' => true,
                'is_visible_in_grid' => true,
                'is_filterable_in_grid' => false,
                'visible' => true,
                'is_html_allowed_on_front' => true,
                'visible_on_front' => true,
                //additional parameters
                'user_defined' => true
            ]
        );
    }
}
