<?php
	/**
	 * Mageplaza
	 *
	 * NOTICE OF LICENSE
	 *
	 * This source file is subject to the Mageplaza.com license that is
	 * available through the world-wide-web at this URL:
	 * https://www.mageplaza.com/LICENSE.txt
	 *
	 * DISCLAIMER
	 *
	 * Do not edit or add to this file if you wish to upgrade this extension to newer
	 * version in the future.
	 *
	 * @category    Mageplaza
	 * @package     Mageplaza_Blog
	 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
	 * @license     https://www.mageplaza.com/LICENSE.txt
	 */
	
	namespace Mageplaza\Blog\Model\ResourceModel;
	
	use Magento\Framework\Exception\LocalizedException;
	use Magento\Framework\Model\AbstractModel;
	use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
	use Magento\Framework\Model\ResourceModel\Db\Context;
	use Mageplaza\Blog\Helper\Data;
	use Magento\Framework\Stdlib\DateTime\DateTime;
	
	/**
	 * Class Author
	 * @package Mageplaza\Blog\Model\ResourceModel
	 */
	class Author extends AbstractDb
	{
		/**
		 * @var Data
		 */
		public $helperData;
		
		/**
		 * @var DateTime
		 */
		public $dateTime;
		
		/**
		 * @inheritdoc
		 */
		protected $_isPkAutoIncrement = false;
		
		/**
		 * Author constructor.
		 *
		 * @param Context $context
		 * @param Data $helperData
		 * @param DateTime $dateTime
		 */
		public function __construct(
			Context $context,
			Data $helperData,
			DateTime $dateTime
		)
		{
			$this->helperData = $helperData;
			$this->dateTime = $dateTime;
			
			parent::__construct($context);
		}
		
		/**
		 * @inheritdoc
		 */
		protected function _construct()
		{
			$this->_init('mageplaza_blog_author', 'user_id');
		}
		
		/**
		 * @inheritdoc
		 * @throws LocalizedException
		 */
		protected function _beforeSave(AbstractModel $object)
		{
			$object->setUrlKey(
				$this->helperData->generateUrlKey($this, $object, $object->getUrlKey() ?: $object->getName())
			);
			
			if (!$object->isObjectNew()) {
				/** @var DateTime $date */
				$date = $this->helperData->getObject('Magento\Framework\Stdlib\DateTime\DateTime');
//				$timeStamp = $this->dateTime->gmtDate();
				$timeStamp = $date->gmtDate();
				$object->setUpdatedAt($timeStamp);
			}
			
			return $this;
		}
	}